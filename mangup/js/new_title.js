fetch('http://localhost/mangup/backend/comics_api.php')
  .then(response => response.json())
  .then(data => {
    if (!data || data.length === 0) {
      console.log('Tidak ada data komik yang tersedia');
      return;
    }

    // Filter manga yang tidak dihide
    const visibleComics = data.filter(comic => !comic.judul.startsWith('[hide]'));

    // Urutkan berdasarkan ID tertinggi ke terendah
    const latestComics = visibleComics.sort((a, b) => b.id - a.id).slice(0, 15);

    const comicGrid = document.getElementById('comicGrid1');
    if (!comicGrid) {
      console.error('Element dengan ID comicGrid1 tidak ditemukan');
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
