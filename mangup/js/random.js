// Fungsi untuk mendapatkan komik secara random
function getRandomComic() {
    fetch('http://localhost/mangup/backend/comics_api.php')
        .then(response => response.json())
        .then(comics => {
            // Mendapatkan index random dari array comics
            const randomIndex = Math.floor(Math.random() * comics.length);
            const randomComic = comics[randomIndex];
            
            // Redirect ke halaman info komik dengan ID yang dipilih
            window.location.href = `info-komik.html?id=${randomComic.id}`;
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

// Menambahkan event listener ke link random di navbar
document.addEventListener('DOMContentLoaded', function() {
    const randomLink = document.querySelector('a[href="#"]');
    if (randomLink) {
        randomLink.addEventListener('click', function(e) {
            e.preventDefault();
            getRandomComic();
        });
    }
}); 