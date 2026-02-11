document.addEventListener('DOMContentLoaded', () => {
    const comicGrid = document.getElementById('comicGrid');
    const timeSelect = document.getElementById('timeFilter');
    const customYearInput = document.getElementById('customYearInput');
    const yearInput = document.getElementById('yearInput');
    const applyYearBtn = document.getElementById('applyYear');
    const genreFiltersContainer = document.getElementById('genreFiltersContainer');
    let comics = [];

    let currentGenre = 'all';
    let currentTime = 'all';
    let customYear = null;

    // Fungsi untuk memuat genre dari API
    function loadGenres() {
        fetch('http://localhost/mangup/backend/get_all_genre.php')
            .then(response => response.json())
            .then(genres => {
                // Buat tombol untuk setiap genre
                genres.forEach(genre => {
                    const button = document.createElement('button');
                    button.classList.add('filter-btn');
                    button.setAttribute('data-genre', genre.name);
                    button.textContent = genre.name;
                    genreFiltersContainer.appendChild(button);
                });
                
                // Setup event listener setelah tombol dibuat
                setupEventListeners();
            })
            .catch(error => {
                console.error('Error loading genres:', error);
                showError('Gagal memuat genre');
            });
    }

    // Fetch comics data from API
    fetch('http://localhost/mangup/backend/comics_api.php')
        .then(response => response.json())
        .then(data => {
            comics = data.sort((a, b) => b.id - a.id);
            displayComics(comics);
            loadGenres(); // Muat genre setelah komik selesai
        })
        .catch(error => {
            console.error('Error loading comics:', error);
            showError('Gagal memuat data komik');
        });

    // Function to check date range
    function isWithinTimeRange(date, timeRange) {
        if (!date) return false;
        
        const now = new Date();
        const comicDate = new Date(date);
        
        switch(timeRange) {
            case 'today':
                return comicDate.toDateString() === now.toDateString();
            case 'week':
                const weekAgo = new Date();
                weekAgo.setDate(weekAgo.getDate() - 7);
                return comicDate >= weekAgo;
            case 'month':
                const monthAgo = new Date();
                monthAgo.setMonth(monthAgo.getMonth() - 1);
                return comicDate >= monthAgo;
            case 'year':
                const yearAgo = new Date();
                yearAgo.setFullYear(yearAgo.getFullYear() - 1);
                return comicDate >= yearAgo;
            case 'custom':
                return customYear !== null && comicDate.getFullYear() === customYear;
            default:
                return true;
        }
    }

    // Function to filter comics
    function filterComics() {
        const filteredComics = comics.filter(comic => {
            const comicDate = comic.update_date || comic.release_date;
            const genreMatch = currentGenre === 'all' || 
                             (comic.tag && comic.tag.includes(currentGenre));
            const timeMatch = isWithinTimeRange(comicDate, currentTime);
            
            return genreMatch && timeMatch;
        });

        displayComics(filteredComics);
    }

    // Function to display comics
    function displayComics(comicsToShow) {
        comicGrid.innerHTML = '';

        if (comicsToShow.length === 0) {
            comicGrid.innerHTML = '<p class="no-results">Tidak ada komik yang ditemukan</p>';
            return;
        }

        comicsToShow.forEach(comic => {
            const comicCard = document.createElement('div');
            comicCard.classList.add('comic-card');

            comicCard.innerHTML = `
                <a href="info-komik.html?id=${comic.id}">
                    <img src="http://localhost/mangup/uploads/cover/${comic.cover}" alt="${comic.judul}">
                    <div class="comic-title">
                        <span>${comic.judul}</span>
                        <div class="tags">
                            ${comic.tag && comic.tag.length > 0 ? 
                              comic.tag.map(tag => `<small>${tag}</small>`).join(' ') : 
                              '<small>No tags</small>'}
                        </div>
                    </div>
                </a>
            `;

            comicGrid.appendChild(comicCard);
        });
    }

    // Function to setup event listeners
    function setupEventListeners() {
        // Genre filter buttons
        document.querySelectorAll('.filter-btn').forEach(button => {
            button.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(btn => {
                    btn.classList.remove('active');
                });
                button.classList.add('active');
                currentGenre = button.getAttribute('data-genre');
                filterComics();
            });
        });

        // Time filter
        timeSelect.addEventListener('change', () => {
            currentTime = timeSelect.value;
            if (currentTime === 'custom') {
                customYearInput.style.display = 'flex';
            } else {
                customYearInput.style.display = 'none';
                customYear = null;
            }
            filterComics();
        });

        // Custom year filter
        applyYearBtn.addEventListener('click', () => {
            const year = parseInt(yearInput.value);
            if (year >= 2000 && year <= 2025) {
                customYear = year;
                filterComics();
            } else {
                alert('Silakan masukkan tahun antara 2000-2025');
            }
        });

        yearInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                applyYearBtn.click();
            }
        });
    }

    // Error handling
    function showError(message) {
        comicGrid.innerHTML = `<p class="error">${message}</p>`;
    }
});