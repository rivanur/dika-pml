// Variabel global untuk tracking slide
let currentSlide = 0;
let slideCount = 0;

// Konstanta untuk batasan karakter
const MAX_DESCRIPTION_LENGTH = 120;

document.addEventListener('DOMContentLoaded', () => {
    const bannerSlider = document.getElementById('bannerSlider');

    // Fetch comics data
    fetch('http://localhost/mangup/backend/comics_api.php')
        .then(response => response.json())
        .then(data => {
            // Sort comics by ID in descending order and get top 3
            const latestComics = data.sort((a, b) => b.id - a.id).slice(0, 3);
            slideCount = latestComics.length;

            // Clear existing slides
            bannerSlider.innerHTML = '';

            // Create slides for each comic
            latestComics.forEach(comic => {
                const slide = document.createElement('div');
                slide.className = 'slide';
                slide.style.backgroundImage = `url('http://localhost/mangup/uploads/cover/${comic.cover}')`;

                // Tambahkan event listener untuk klik pada slide
                slide.addEventListener('click', () => {
                    window.location.href = `info-komik.html?id=${comic.id}`;
                });

                let shortDescription = comic.deskripsi || '';
                if (shortDescription.length > MAX_DESCRIPTION_LENGTH) {
                    const lastSpaceIndex = shortDescription.lastIndexOf(' ', MAX_DESCRIPTION_LENGTH);
                    const cutIndex = lastSpaceIndex > 0 ? lastSpaceIndex : MAX_DESCRIPTION_LENGTH;
                    shortDescription = shortDescription.substring(0, cutIndex) + '...';
                }

                slide.innerHTML = `
                    <div class="slide-content">
                        <div class="slide-cover">
                            <img src="http://localhost/mangup/uploads/cover/${comic.cover}" alt="${comic.judul}">
                        </div>
                        <div class="slide-info">
                            <div class="tags">
                                ${comic.tag.map(tag => `<span>${tag}</span>`).join('')}
                            </div>
                            <h2>${comic.judul}</h2>
                            <p>${shortDescription}</p>
                            <div class="author">${comic.author}</div>
                        </div>
                    </div>
                `;

                bannerSlider.appendChild(slide);
            });

            // Set initial position
            updateSlidePosition();
        })
        .catch(error => {
            console.error('Error loading comics:', error);
        });
});

// Fungsi untuk mengupdate posisi slide
function updateSlidePosition() {
    const bannerSlider = document.getElementById('bannerSlider');
    if (bannerSlider) {
        bannerSlider.scrollTo({
            left: currentSlide * bannerSlider.offsetWidth,
            behavior: 'smooth'
        });
    }
}

// Fungsi untuk menggeser ke slide sebelumnya
function prevSlide() {
    currentSlide = (currentSlide - 1 + slideCount) % slideCount;
    updateSlidePosition();
}

// Fungsi untuk menggeser ke slide berikutnya
function nextSlide() {
    currentSlide = (currentSlide + 1) % slideCount;
    updateSlidePosition();
}

// Auto slide setiap 10 detik
setInterval(() => {
    if (slideCount > 0) {
        nextSlide();
    }
}, 10000); 