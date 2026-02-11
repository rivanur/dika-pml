fetch('http://localhost/mangup/backend/comics_api.php')
  .then(response => response.json())
  .then(data => {
    if (!data || data.length === 0) {
      console.log('Tidak ada data komik yang tersedia');
      return;
    }

    // Urutkan berdasarkan tanggal upload terbaru
    const latestComics = data.sort((a, b) => new Date(b.tanggal_upload) - new Date(a.tanggal_upload)).slice(0, 15);

    const comicGrid = document.getElementById('comicGrid2');
    if (!comicGrid) {
      console.error('Element dengan ID comicGrid2 tidak ditemukan');
      return;
    }

    latestComics.forEach(comic => {
      const comicCard = document.createElement('div');
      comicCard.classList.add('comic-card');

      comicCard.innerHTML = `
        <a href="info-komik.html?id=${comic.id}">
          <img src="http://localhost/mangup/uploads/cover/${comic.cover}" alt="${comic.judul}">
          <div class="comic-title">
            <div class="title-bg"></div>
            <span>${comic.judul}</span>
            <small style="color: #ccc;">${comic.tanggal_upload}</small>
          </div>
        </a>
      `;
      comicGrid.appendChild(comicCard);
    });
  })
  .catch(error => {
    console.error('Gagal memuat data komik:', error);
  }); 