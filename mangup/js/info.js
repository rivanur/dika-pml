// Ambil ID dari URL
const urlParams = new URLSearchParams(window.location.search);
const id = parseInt(urlParams.get('id'));

// Fetch data dari API PHP
fetch(`http://localhost/mangup/backend/get_mangacln.php?id=${id}`)
  .then(response => response.json())
  .then(data => {
    const comic = data.manga;
    const characters = data.characters;
    
    // Tampilkan background cover
    const comicInfo = document.getElementById('background');
    comicInfo.innerHTML = `
      <style>
        body {
          background-image: url('http://localhost/mangup/uploads/cover/${comic.cover}');
          background-size: cover;
          position: sticky;
        }
      </style>
    `;

    // Tampilkan info komik
    const comicInfoSection = document.getElementById('comicInfo');
    comicInfoSection.innerHTML = `
      <section class="comic-info">
        <div class="info-overlay">
          <div class="cover-info">
            <img src="http://localhost/mangup/uploads/cover/${comic.cover}">
          </div>
          <div class="info-content">
            <h1>${comic.title}</h1>
            <p><strong>Author:</strong> ${comic.author}</p>
            <p><strong>Release Date:</strong> ${formatDate(comic.release_date)}</p>
            <p><strong>Last Updated:</strong> ${formatDate(comic.update_date)}</p>
            <p><strong>Genres:</strong> ${data.genres.map(g => g.name).join(', ')}</p>
          </div>
        </div>
      </section>
      <div class="main-content">
        <div class="left-content">
          <div class="character-grid">
            <h2>Karakter</h2>
            <div class="character-scroll">
              ${characters.length > 0 ? characters.map((char, index) => `
                <div class="character-card" data-character-index="${index}">
                  <img src="http://localhost/mangup/uploads/characters/${char.image}" alt="${char.name}">
                  <h3>${char.name}</h3>
                  <p>${char.deskripsi.substring(0, 100)}...</p>
                </div>
              `).join('') : '<p>Belum ada data karakter</p>'}
            </div>
          </div>
          <div class="comic-details">
            <h2>Sinopsis</h2>
            <p>${comic.description}</p>
          </div>
        </div>
        <div class="right-content">
          <div class="character-info">
            <h2>Informasi Karakter</h2>
            <div id="selectedCharacter">
              <p class="placeholder-text">Pilih karakter untuk melihat informasi</p>
            </div>
          </div>
        </div>
      </div>
    `;

    // Tambahkan event listener untuk setiap character card
    if (characters.length > 0) {
      const characterCards = document.querySelectorAll('.character-card');
      characterCards.forEach((card, index) => {
        card.addEventListener('click', () => {
          const character = characters[index];
          showCharacterInfo(character.name, character.image, character.deskripsi);
          
          // Tambahkan class active ke card yang dipilih
          characterCards.forEach(c => c.classList.remove('active'));
          card.classList.add('active');
        });
      });
    }
  })
  .catch(error => {
    console.error('Gagal memuat data komik:', error);
    document.getElementById('comicInfo').innerHTML = "<h2>Gagal memuat data komik</h2>";
  });

// Fungsi untuk menampilkan informasi karakter
function showCharacterInfo(name, image, deskripsi) {
  const characterInfo = document.getElementById('selectedCharacter');
  characterInfo.innerHTML = `
    <div class="selected-character">
      <img src="http://localhost/mangup/uploads/characters/${image}" alt="${name}">
      <h3>${name}</h3>
      <p>${deskripsi}</p>
    </div>
  `;
}

// Function to format date
function formatDate(dateString) {
  if (!dateString) return 'Unknown';
  const options = { year: 'numeric', month: 'long', day: 'numeric' };
  return new Date(dateString).toLocaleDateString('id-ID', options);
}