let characterCount = 0;

// Fungsi untuk menambahkan karakter baru
function addCharacter() {
    characterCount++;
    const container = document.getElementById('characterContainer');

    const characterDiv = document.createElement('div');
    characterDiv.className = 'character';
    characterDiv.innerHTML = `
        <div class="form-group">
            <label>Nama Karakter ${characterCount}</label>
            <input type="text" name="character_names[]" required>
        </div>
        <div class="form-group">
            <label>Deskripsi Karakter ${characterCount}</label>
            <textarea name="character_descriptions[]" rows="3" required></textarea>
        </div>
        <div class="form-group">
            <label>Gambar Karakter ${characterCount}</label>
            <input type="file" name="character_images[]" accept="image/*" required>
        </div>
        <button type="button" class="btn-remove" onclick="removeCharacter(this)">Hapus</button>
    `;

    container.appendChild(characterDiv);
}

// Fungsi untuk menghapus karakter
function removeCharacter(button) {
    const characterDiv = button.parentElement;
    characterDiv.remove();
    characterCount--;
}

// Fungsi untuk memuat genre dari database
async function loadGenres() {
    try {
        const response = await fetch('http://localhost/mangup/backend/get_all_genre.php');
        const genres = await response.json();

        const container = document.getElementById('genreContainer');
        container.innerHTML = '';

        genres.forEach(genre => {
            const genreItem = document.createElement('div');
            genreItem.className = 'genre-item';
            genreItem.dataset.id = genre.id;
            genreItem.innerHTML = `
                ${genre.name}
                <span class="remove" onclick="removeGenre(event, ${genre.id})">×</span>
            `;

            genreItem.addEventListener('click', function (e) {
                if (!e.target.classList.contains('remove')) {
                    this.classList.toggle('selected');
                    updateSelectedGenres();
                }
            });

            container.appendChild(genreItem);
        });
    } catch (error) {
        console.error('Gagal memuat genre:', error);
    }
}

// Fungsi untuk menambahkan genre baru
async function addNewGenre() {
    const input = document.querySelector('[name="new_genre_name"]');
    const genreName = input.value.trim();


    if (!genreName) {
        alert('Nama genre tidak boleh kosong');
        return;
    }

    try {
        const formData = new FormData();
        formData.append('name', genreName);

        const response = await fetch('http://localhost/mangup/backend/add_genre.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            // Tambahkan genre baru ke UI
            const container = document.getElementById('genreContainer');
            const genreItem = document.createElement('div');
            genreItem.className = 'genre-item selected';
            genreItem.dataset.id = result.genre_id;
            genreItem.innerHTML = `
                ${genreName}
                <span class="remove" onclick="removeGenre(event, ${result.genre_id})">×</span>
            `;

            genreItem.addEventListener('click', function (e) {
                if (!e.target.classList.contains('remove')) {
                    this.classList.toggle('selected');
                    updateSelectedGenres();
                }
            });

            container.appendChild(genreItem);
            input.value = '';
            updateSelectedGenres();
        } else {
            throw new Error(result.message || 'Gagal menambahkan genre');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal menambahkan genre: ${error.message}`);
    }
}

// Fungsi untuk menghapus genre
async function removeGenre(event, genreId) {
    event.stopPropagation();

    if (!confirm('Apakah Anda yakin ingin menghapus genre ini?')) {
        return;
    }

    try {
        const formData = new FormData();
        formData.append('id', genreId);

        const response = await fetch('http://localhost/mangup/backend/remove_genre.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            // Hapus genre dari UI
            const item = document.querySelector(`.genre-item[data-id="${genreId}"]`);
            if (item) item.remove();
            updateSelectedGenres();
        } else {
            throw new Error(result.message || 'Gagal menghapus genre');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(`Gagal menghapus genre: ${error.message}`);
    }
}

// Perbarui input tersembunyi dengan genre yang dipilih
function updateSelectedGenres() {
    const selected = [];
    document.querySelectorAll('.genre-item.selected').forEach(item => {
        selected.push(item.dataset.id);
    });

    document.getElementById('selectedGenres').value = selected.join(',');
}

// Muat genre saat halaman dimuat
document.addEventListener('DOMContentLoaded', function () {
    loadGenres();

    // Event listener untuk form
    document.getElementById('mangaForm').addEventListener('submit', async (e) => {
        e.preventDefault();

        // Pastikan ada genre yang dipilih
        updateSelectedGenres();
        if (!document.getElementById('selectedGenres').value) {
            alert('Pilih minimal satu genre');
            return;
        }

        const formData = new FormData(e.target);

        try {
            const response = await fetch('http://localhost/mangup/backend/upload_manga.php', {
                method: 'POST',
                body: formData
            });

            const result = await response.json();

            if (result.status === 'success') {
                alert('Manga berhasil diupload!');
                e.target.reset();
                document.getElementById('characterContainer').innerHTML = '';
                characterCount = 0;

                // Reset genre selection
                document.querySelectorAll('.genre-item').forEach(item => {
                    item.classList.remove('selected');
                });
                updateSelectedGenres();
            } else {
                throw new Error(result.message || 'Error uploading manga');
            }
        } catch (error) {
            console.error('Error:', error);
            alert(`Gagal mengupload manga: ${error.message}`);
        }
    });
});

// Tampilkan username admin
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