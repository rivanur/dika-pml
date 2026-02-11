document.addEventListener('DOMContentLoaded', () => {
    const searchResults = document.getElementById('searchResults');
    const searchQuery = document.getElementById('searchQuery');
    const resultCount = document.getElementById('resultCount');
    const noResults = document.getElementById('noResults');
    const filterButtons = document.querySelectorAll('.filter-btn');
    let comics = [];
    let currentFilter = 'all';

    // Get search query from URL
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('q') || '';

    // Fetch comics data from API
    fetch('http://localhost/mangup/backend/comics_api.php')
        .then(response => response.json())
        .then(data => {
            comics = data;
            performSearch(query);
        })
        .catch(error => {
            console.error('Error loading comics:', error);
            showError('Gagal memuat data komik');
        });

    // Add click event listeners to filter buttons
    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            currentFilter = button.getAttribute('data-filter');
            performSearch(query);
        });
    });

    // Function to perform search
    function performSearch(query) {
        if (!searchQuery || !resultCount || !noResults || !searchResults) return;
        
        if (!query) {
            searchQuery.textContent = 'Semua Komik';
            displayResults(comics);
            return;
        }

        searchQuery.textContent = `Hasil pencarian untuk: "${query}"`;
        
        let results = comics.filter(comic => {
            const searchTerm = query.toLowerCase();
            
            // Handle case where comic data might be incomplete
            const title = comic.judul ? comic.judul.toLowerCase() : '';
            const author = comic.author ? comic.author.toLowerCase() : '';
            const tags = comic.tag || [];
            
            switch(currentFilter) {
                case 'judul':
                    return title.includes(searchTerm);
                case 'genre':
                    return tags.some(tag => tag.toLowerCase().includes(searchTerm));
                case 'author':
                    return author.includes(searchTerm);
                default:
                    return title.includes(searchTerm) ||
                           tags.some(tag => tag.toLowerCase().includes(searchTerm)) ||
                           author.includes(searchTerm);
            }
        });

        displayResults(results);
    }

    // Function to display results
    function displayResults(results) {
        searchResults.innerHTML = '';
        resultCount.textContent = `Ditemukan ${results.length} hasil`;

        if (results.length === 0) {
            noResults.style.display = 'block';
            return;
        }

        noResults.style.display = 'none';

        results.forEach(comic => {
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

            searchResults.appendChild(comicCard);
        });
    }

    // Function to show error message
    function showError(message) {
        if (searchResults) {
            searchResults.innerHTML = `<p class="error">${message}</p>`;
        }
    }
});