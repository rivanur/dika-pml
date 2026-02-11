// Variabel global untuk menyimpan data karakter yang ada
let existingCharacters = [];

// Fungsi untuk mencari manga
async function searchManga() {
    const searchTerm = document.getElementById('searchInput').value.trim();

    if (!searchTerm) {
        alert('Masukkan judul manga yang ingin dicari');
        return;
    }

    try {
        const response = await fetch(`http://localhost/mangup/backend/search_manga.php?query=${encodeURIComponent(searchTerm)}`);
        const results = await response.json();

        displaySearchResults(results);
    } catch (error) {
        console.error('Error:', error);
        alert('Gagal melakukan pencarian');
    }
}

// Fungsi toggle hide/unhide manga
async function toggleHideManga(mangaId, buttonElement) {
    try {
        const response = await fetch('http://localhost/mangup/backend/toggle_hide_manga.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: mangaId })
        });

        const result = await response.json();

        if (result.status === 'success') {
            alert(result.message);
            // Toggle teks tombol
            buttonElement.textContent = buttonElement.textContent === 'Hide' ? 'Unhide' : 'Hide';
            
            // Refresh hasil pencarian
            searchManga();
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal mengupdate status hide: ${error.message}`);
    }
}

// Fungsi delete manga
async function deleteManga(mangaId) {
    if (!confirm('Apakah Anda yakin ingin menghapus manga ini? Tindakan ini tidak dapat dibatalkan.')) {
        return;
    }

    try {
        const response = await fetch('http://localhost/mangup/backend/delete_manga.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: mangaId })
        });

        const result = await response.json();

        if (result.status === 'success') {
            alert('Manga berhasil dihapus!');
            searchManga(); // Refresh hasil pencarian
        } else {
            throw new Error(result.message);
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal menghapus manga: ${error.message}`);
    }
}

// Menampilkan hasil pencarian
function displaySearchResults(mangas) {
    const resultsContainer = document.getElementById('searchResults');
    resultsContainer.innerHTML = '';

    if (mangas.length === 0) {
        resultsContainer.innerHTML = '<p>Tidak ada manga yang ditemukan</p>';
        return;
    }

    mangas.forEach(manga => {
        manga.hidden = manga.title.startsWith('[hide]');
        const mangaElement = document.createElement('div');
        mangaElement.className = 'manga-item';
        mangaElement.innerHTML = `
            <div class="manga-cover">
                <img src="http://localhost/mangup/uploads/cover/${manga.cover}" alt="${manga.title}">
            </div>
            <div class="manga-info">
                <h1>${manga.title}</h1>
                <p>Pengarang: ${manga.author}</p>
                <p>${manga.description.substring(0, 100)}...</p>
                <button onclick="loadMangaForEdit(${manga.id})">Edit Manga</button>
                <button class="btn-hide" onclick="toggleHideManga(${manga.id}, this)">${manga.hidden ? 'Unhide' : 'Hide'}</button>
                <button class="btn-delete" onclick="deleteManga(${manga.id})">Delete</button>
            </div>
        `;

        resultsContainer.appendChild(mangaElement);
    });
}

// Memuat data manga untuk diedit
async function loadMangaForEdit(mangaId) {
    try {
        // Ambil data manga
        const response = await fetch(`http://localhost/mangup/backend/get_manga.php?id=${mangaId}`);
        const mangaData = await response.json();

        console.log("Raw manga data:", mangaData);
        console.log("Release date raw:", mangaData.manga.release_date);

        // Isi form edit
        document.getElementById('editMangaId').value = mangaData.manga.id;
        document.getElementById('editTitle').value = mangaData.manga.title;
        document.getElementById('editAuthor').value = mangaData.manga.author;
        document.getElementById('editDescription').value = mangaData.manga.description;
        document.getElementById('editReleaseDate').value = mangaData.manga.release_date;

        // Tampilkan cover saat ini
        const coverPreview = document.getElementById('currentCoverPreview');
        coverPreview.innerHTML = `<img src="http://localhost/mangup/uploads/cover/${mangaData.manga.cover}" width="150">`;

        // Load genre
        await loadEditGenres(mangaData.manga.id);

        // Load karakter
        existingCharacters = mangaData.characters;
        renderEditCharacters();

        // Tampilkan form edit
        document.getElementById('searchResults').style.display = 'none';
        document.getElementById('editFormContainer').style.display = 'block';

    } catch (error) {
        console.error('Error:', error);
        alert('Gagal memuat data manga');
    }
}

// Memuat genre untuk form edit
async function loadEditGenres(mangaId) {
    try {
        const response = await fetch('http://localhost/mangup/backend/get_all_genre.php');
        const allGenres = await response.json();

        const mangaResponse = await fetch(`http://localhost/mangup/backend/get_manga_genres.php?id=${mangaId}`);
        const mangaGenres = await mangaResponse.json();

        const container = document.getElementById('editGenreContainer');
        container.innerHTML = '';

        allGenres.forEach(genre => {
            const isSelected = mangaGenres.some(g => g.id === genre.id);

            const genreItem = document.createElement('div');
            genreItem.className = `genre-item ${isSelected ? 'selected' : ''}`;
            genreItem.dataset.id = genre.id;
            genreItem.innerHTML = `
                ${genre.name}
                <span class="remove" onclick="removeEditGenre(event, ${genre.id})">×</span>
            `;

            genreItem.addEventListener('click', function (e) {
                if (!e.target.classList.contains('remove')) {
                    this.classList.toggle('selected');
                    updateEditSelectedGenres();
                }
            });

            container.appendChild(genreItem);
        });

        updateEditSelectedGenres();
    } catch (error) {
        console.error('Error:', error);
    }
}

// Menambahkan karakter baru di form edit
function addEditCharacter() {
    const container = document.getElementById('editCharacterContainer');

    const characterDiv = document.createElement('div');
    characterDiv.className = 'character';
    characterDiv.innerHTML = `
        <div class="form-group">
            <label>Nama Karakter Baru</label>
            <input type="text" name="new_character_names[]" required>
        </div>
        <div class="form-group">
            <label>Deskripsi Karakter Baru</label>
            <textarea name="new_character_descriptions[]" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>Gambar Karakter Baru</label>
            <input type="file" name="new_character_images[]" accept="image/*">
        </div>
        <button type="button" class="btn-remove" onclick="removeEditCharacter(this)">Hapus</button>
    `;

    container.appendChild(characterDiv);
}

// Menampilkan karakter yang sudah ada
function renderEditCharacters() {
    const container = document.getElementById('editCharacterContainer');
    container.innerHTML = '';

    existingCharacters.forEach((character, index) => {
        const characterDiv = document.createElement('div');
        characterDiv.className = 'character';
        characterDiv.innerHTML = `
            <div class="form-group">
                <label>Nama Karakter ${index + 1}</label>
                <input type="text" name="character_names[${character.id}]" value="${character.name}" required>
            </div>
            <div class="form-group">
                <label>Deskripsi Karakter ${index + 1}</label>
                <textarea name="character_descriptions[${character.id}]" rows="3" required>${character.deskripsi || ''}</textarea>
            </div>
            <div class="form-group">
                <label>Gambar Karakter ${index + 1}</label>
                <input type="file" name="character_images[${character.id}]" accept="image/*">
                <div class="current-image">
                    <img src="http://localhost/mangup/uploads/characters/${character.image}" width="100">
                </div>
            </div>
            <div class="form-group">
                <label>
                    <input type="checkbox" name="delete_characters[]" value="${character.id}">
                    Hapus karakter ini
                </label>
            </div>
            <button type="button" class="btn-remove" onclick="removeEditCharacter(this)">Hapus</button>
        `;

        container.appendChild(characterDiv);
    });
}

// Menghapus karakter dari form edit
function removeEditCharacter(button) {
    const characterDiv = button.parentElement;
    characterDiv.remove();
}

// Update genre yang dipilih di form edit
function updateEditSelectedGenres() {
    const selected = [];
    document.querySelectorAll('#editGenreContainer .genre-item.selected').forEach(item => {
        selected.push(item.dataset.id);
    });

    document.getElementById('editSelectedGenres').value = selected.join(',');
}

// Submit form edit
document.getElementById('editMangaForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    formData.append('update', 'true');

    try {
        const response = await fetch('http://localhost/mangup/backend/update_manga.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            alert('Manga berhasil diperbarui!');
            cancelEdit();
            searchManga(); // Refresh hasil pencarian
        } else {
            throw new Error(result.message || 'Gagal memperbarui manga');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal memperbarui manga: ${error.message}`);
    }
});

// Batal edit
function cancelEdit() {
    document.getElementById('editFormContainer').style.display = 'none';
    document.getElementById('searchResults').style.display = 'block';
    document.getElementById('editMangaForm').reset();
    existingCharacters = [];
}

// Event listener untuk input search
document.getElementById('searchInput').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
        searchManga();
    }
});
document.addEventListener('DOMContentLoaded', function () {
    // Cek apakah admin sudah login
    fetch('http://localhost/mangup/backend/check_login.php')
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                document.getElementById('adminUsername').textContent = data.username;
            } else {
                window.location.href = 'login.html';
            }
        });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch('http://localhost/mangup/backend/logout.php')
            .then(() => {
                window.location.href = 'login.html';
            });
    });
});