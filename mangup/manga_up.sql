-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 10 Jul 2025 pada 04.29
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `manga_up`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(7, 'hanif', '$2y$10$dqndQxfpQiAKc9FJvLT7jerbVBSjHEuAwhYuAFFXJI/Xa9Yk7lVYG'),
(8, 'hanif123', '$2y$10$9xNfpuLhhnZfiGWu3qpSeOLo8UazHgPqhHzOLXU.3pr3BzXr0QNNe'),
(9, 'halo', '$2y$10$Oay2ysUdQmtcKOtE5wPrx.qhWCgzvUuJ.R8dtPN.6Noe6AuO0QtJm');

-- --------------------------------------------------------

--
-- Struktur dari tabel `genre`
--

CREATE TABLE `genre` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `genre`
--

INSERT INTO `genre` (`id`, `name`) VALUES
(8, 'action'),
(9, 'fantasy'),
(10, 'comedy'),
(14, 'adventure'),
(15, 'drama'),
(16, 'sci-fi'),
(17, 'sport'),
(18, 'romance');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga`
--

CREATE TABLE `manga` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(100) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `cover` varchar(255) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `release_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manga`
--

INSERT INTO `manga` (`id`, `title`, `author`, `description`, `cover`, `update_date`, `release_date`) VALUES
(10, 'Kimetsu no Yaiba', 'Koyoharu Gotouge', 'Kimetsu no Yaiba mengisahkan tentang Tanjiro Kamado, seorang anak yang kehidupannya berubah drastis ketika keluarganya dibantai oleh iblis. Satu-satunya anggota keluarga yang selamat adalah adiknya Nezuko, yang berubah menjadi iblis. Tanjiro kemudian bertekad menjadi pembasmi iblis untuk mencari cara mengembalikan Nezuko menjadi manusia dan membalas dendam keluarganya. Perjalanan Tanjiro membawanya bergabung dengan Korps Pembasmi Iblis, di mana dia menghadapi berbagai macam iblis berbahaya dan menempa keterampilannya dalam menggunakan teknik pernapasan khusus. Dalam perjalanannya, Tanjiro bertemu dengan teman-teman seperjuangan yang juga memiliki kekuatan unik, bersama-sama mereka berjuang melawan ancaman iblis yang semakin kuat dan misterius.', '686e70d8bc675_manga_thumbnail-Komik-Kimetsu-no-Yaiba.jpg', '2025-07-09', '2016-02-04'),
(11, 'Solo Leveling', 'Chugong', 'Di dunia di mana para pemburu bertarung melawan makhluk dari dunia lain melalui portal misterius, Sung Jinwoo adalah pemburu dengan kekuatan yang sangat lemah. Sebagai pemburu kelas terendah, ia sering dianggap tidak berguna dan sering menghadapi bahaya yang mengancam nyawanya dalam setiap misi. Namun, semuanya berubah ketika ia mendapatkan kemampuan khusus yang memungkinkannya untuk naik level secara mandiri dan menjadi semakin kuat tanpa batas. Dengan kekuatannya yang terus berkembang, Jinwoo mulai mengeksplorasi berbagai dungeon berbahaya dan menghadapi monster-monster menakutkan yang bahkan tidak bisa ditaklukkan oleh pemburu lain. Perjalanannya untuk menjadi pemburu terkuat membawa banyak tantangan serta intrik, termasuk menghadapi organisasi rahasia dan ancaman yang lebih besar dari dunia lain. Kisah ini mengeksplorasi perjuangan, pengorbanan, dan perubahan Jinwoo yang luar biasa di dunia penuh ancaman tersebut.', '686e7215ee846_manga_thumbnail-Head-I-Alone-Leveling.jpg', '2025-07-07', '2024-07-11'),
(12, 'One Punch Man', 'ONE', 'One Punch Man mengikuti kisah Saitama, seorang pahlawan yang bisa mengalahkan musuh hanya dengan satu pukulan. Meskipun kekuatannya luar biasa, ia merasa bosan dan kesepian karena tidak ada lawan yang menantang. Petualangannya dimulai saat ia bergabung dengan Asosiasi Pahlawan dan bertemu dengan berbagai pahlawan dan monster yang unik. Dalam perjalanannya, Saitama harus berhadapan dengan ancaman besar yang mengancam dunia. Meskipun sering diremehkan oleh rekan-rekannya, ia terus berusaha melindungi warga dan mencari arti sesungguhnya dari menjadi seorang pahlawan. Cerita ini menyajikan perpaduan antara aksi seru dan humor yang segar.', '686e7343a44fc_manga_thumbnail-Komik-One-Punch-Man.jpg', '2025-07-09', '2009-10-27'),
(13, 'Wind Breaker', 'Nii Satoru', 'Wind Breaker mengikuti kisah Jo Suh-Yoon, seorang siswa SMA yang penuh semangat dan punya semangat tinggi dalam dunia sepeda BMX. Meski awalnya dia bukan bagian dari komunitas sepeda, keinginannya yang kuat untuk mengatasi tantangan di jalan mendorongnya masuk ke dalam dunia balap sepeda yang penuh risiko dan persaingan sengit. Selama perjalanan ini, Suh-Yoon bertemu dengan berbagai teman dan rival yang memperkaya pengalaman serta membangkitkan semangatnya untuk terus maju. Perjalanan Suh-Yoon tidak hanya soal balapan, tetapi juga tentang pertumbuhan pribadi dan persahabatan. Dia belajar arti kerja keras dan ketekunan melalui berbagai rintangan, serta bagaimana menjaga integritas di tengah godaan dan tekanan sosial. Komik ini memberikan gambaran keren tentang dunia sepeda BMX, sekaligus menyuguhkan cerita yang inspiratif tentang mimpi dan keberanian menghadapi tantangan hidup.', '686e742bda4ef_manga_thumbnail-Head-Wind-Breaker-NII-Satoru.jpg', '2025-07-02', '2023-05-25'),
(14, 'Haikyuu', '	Haruichi Furudate', 'Haikyuu!! mengisahkan tentang Shoyo Hinata, seorang siswa SMA yang terinspirasi menjadi pemain voli setelah menyaksikan seorang atlet bertubuh pendek yang hebat dalam turnamen voli nasional. Meskipun tubuhnya tidak tinggi, semangat dan tekad Hinata mendorongnya untuk bergabung dengan klub voli sekolah dan berusaha keras mengasah kemampuan demi mengalahkan rival-rivalnya. Cerita berfokus pada perjalanan Hinata dan timnya menghadapi berbagai lawan tangguh di lapangan voli. Melalui kerja sama, persahabatan, dan latihan yang intens, mereka berjuang untuk mencapai puncak kejuaraan nasional sekaligus membuktikan bahwa ukuran tubuh bukanlah penghalang untuk meraih mimpi besar.', '686e7569a66ca_manga_thumbnail-Manga-Haikyuu.jpg', '2025-07-09', '2012-09-19'),
(15, 'Blue Lock', 'Muneyuki Kaneshiro', 'Blue Lock mengisahkan tentang program unik yang diselenggarakan Jepang untuk menemukan striker terbaik bagi tim nasional sepak bola mereka. Setelah kegagalan di Piala Dunia, ribuan pemain muda dikumpulkan di fasilitas khusus bernama Blue Lock agar mereka bisa bertarung mengasah kemampuan dan mencetak gol yang tak tertandingi. Fokus utama program ini adalah memupuk ego dan semangat individualisme agar pemain bukan hanya sekadar bagian tim, melainkan pencetak gol berdedikasi. Cerita berpusat pada Yoichi Isagi, seorang pemain muda yang bergabung ke Blue Lock dengan harapan bisa menjadi striker terbaik dunia. Di dalam program yang penuh tekanan dan tantangan ini, dia harus menghadapi rival yang mempunyai tujuan sama dan melewati pelatihan keras demi mengukir prestasi tinggi dalam sepak bola. Blue Lock menggambarkan dinamika kompetitif, strategi, dan pengembangan karakter pemain di bawah tekanan yang intens.', '686e76668a798_manga_thumbnail-Manga-Blue-Lock.jpg', '2025-07-09', '2020-02-05'),
(16, 'Jujutsu Kaisen', 'Gege Akutami', 'Jujutsu Kaisen mengikuti kisah Yuji Itadori, seorang siswa SMA yang secara tak sengaja terlibat dalam dunia ilmu kutukan setelah menemukan sebuah jari terkutuk milik sosok jahat yang kuat. Demi melindungi teman-teman dan orang-orang di sekitarnya, Yuji bergabung dengan sekolah Jujutsu Tokyo untuk mempelajari cara melawan dan mengendalikan kutukan yang mengancam umat manusia. Dalam perjalanan ini, Yuji bertemu dengan berbagai karakter unik seperti Megumi Fushiguro dan Nobara Kugisaki yang memiliki kekuatan dan motivasi masing-masing. Bersama-sama, mereka menghadapi ancaman berbahaya dari makhluk kutukan yang semakin besar dan misteri di balik asal mula kekuatan kutukan itu sendiri mulai terungkap seiring mereka semakin mendalami dunia ilmu Jujutsu.', '686e7761e3323_manga_thumbnail-Manhua-Jujutsu-Kaisen.jpg', '2025-07-09', '2018-10-25'),
(17, 'Ao no Hako', 'Takeru Kirishima', 'Ao no Hako mengisahkan perjalanan seorang remaja yang menemukan sebuah kotak misterius berwarna biru di tengah hutan kota. Kotak tersebut menyimpan rahasia yang mengubah cara pandangnya terhadap dunia dan mengajak dirinya menyelami berbagai misteri yang tersembunyi di balik realitas sehari-hari. Dalam petualangannya, sang protagonis bertemu dengan berbagai tokoh yang membantunya memahami kekuatan serta tanggung jawab yang muncul dari penemuan tersebut. Cerita ini berkembang dengan konflik batin yang mendalam dan ketegangan antara keingintahuan serta konsekuensi yang harus dihadapi. Melalui narasi yang kaya dan ilustrasi yang memikat, Ao no Hako berhasil menggambarkan pencarian jati diri dan perenungan tentang makna keberadaan, sekaligus sebuah peringatan terkait dampak pilihan dalam kehidupan.', '686e78b0a245b_manga_thumbnail-Manga-Ao-no-Hako.jpg', '2025-07-08', '2021-06-15'),
(18, 'Please don’t show your son', 'Ant Studio', 'Komik ini mengisahkan sebuah hubungan kompleks antara orang tua dan anak yang dipenuhi dengan rahasia yang mulai terungkap. Konflik dan ketegangan muncul ketika sebuah kejadian tak terduga memaksa mereka untuk menghadapi kenyataan yang selama ini disembunyikan, menguji ikatan keluarga mereka. Di tengah ketegangan tersebut, kisah ini menyelami emosi dan dinamika hubungan yang jarang tereksplorasi dalam kehidupan sehari-hari. Selain drama keluarga, komik ini juga mengangkat tema tentang kepercayaan dan komunikasi yang rusak, serta pentingnya memahami sudut pandang masing-masing pihak. Setiap karakter berkembang menghadapi konflik internal, yang pada akhirnya membawa pembaca pada refleksi tentang arti keluarga dan keterbukaan dalam menghadapi masa lalu.', '686f0da93fa53_manga_thumbnail-Head-Please-dont-show-your-son.jpg', '2025-07-10', '2024-01-15'),
(19, 'Genius Hitter Hits Fastball', 'Hele', 'Cerita ini mengikuti perjalanan seorang pemuda jenius yang memiliki kemampuan luar biasa dalam memukul bola cepat di dunia bisbol. Dengan bakat alaminya dan kerja keras yang tak kenal lelah, dia berjuang untuk membuktikan dirinya di lapangan sekaligus menghadapi berbagai tantangan pribadi dan profesional. Konflik emosional dan persaingan sengit menjadi bagian dari perjalanan yang menguji ketangguhan mental serta fisiknya. Selain itu, dia juga belajar arti penting kerja sama tim dan strategi dalam menghadapi lawan yang semakin kompetitif tiap pertandingan. Keberhasilan dan kegagalannya mengajarkan dia banyak pelajaran hidup tentang kegigihan dan semangat pantang menyerah. Cerita ini tidak hanya menonjolkan aksi dan ketegangan pertandingan, tetapi juga menggali dinamika hubungan antar karakter yang mendukung evolusi sang protagonis menjadi sosok yang bukan hanya unggul secara teknis, tetapi juga matang secara emosional dan mental.', '686f0e0b87282_manga_thumbnail-A2-Genius-Hitter-Hits-Fastball.jpg', '2025-07-07', '2025-01-21'),
(20, 'SSS-level Paladin Who Breaks All Logic', 'Taeha Lee', 'Cerita ini mengikuti perjalanan seorang paladin yang memiliki kekuatan luar biasa di level SSS yang tidak masuk akal oleh logika dunia tempatnya berada. Ia menjalani misi-misi berbahaya dengan kemampuan yang melampaui batas manusia biasa, menghadapi musuh dan tantangan yang bahkan para petualang terbaik pun takut untuk menyelesaikannya. Namun, kehebatan paladin ini sering kali menimbulkan keheranan dan konflik karena metode dan kekuatannya yang unik dan tidak konvensional. Dalam perjalanannya, paladin ini bertemu dengan berbagai karakter yang memperkaya pengalamannya baik dalam pertempuran maupun kehidupan. Ia harus belajar untuk menyeimbangkan kekuatannya dengan kebijaksanaan dan nilai-nilai kemanusiaan agar tidak kehilangan jati dirinya. Konflik dan intrik yang muncul dari dunia fantasi ini memberikan warna unik dalam cerita yang penuh aksi dan drama ini', '686f0eb058717_manga_thumbnail-Head-SSS-level-Paladin-Who-Breaks-All-Logic.jpg', '2025-07-10', '2025-07-01'),
(21, 'Spy X Family', 'Tatsuya Endo', 'Spy X Family mengikuti kisah seorang mata-mata ulung dengan kode nama Twilight yang harus menyelidiki sebuah misi penting demi perdamaian dunia. Untuk menyelesaikan tugasnya, ia harus membangun sebuah keluarga palsu dengan mengadopsi seorang anak perempuan yang memiliki kemampuan telepati dan menikahi seorang pembunuh bayaran rahasia, tanpa mengetahui identitas asli satu sama lain. Seiring mereka menjalani kehidupan keluarga yang unik, berbagai kejadian lucu dan menegangkan pun terjadi. Cerita ini menyuguhkan perpaduan menarik antara aksi, komedi, dan drama keluarga, yang menunjukkan bagaimana setiap anggota keluarga belajar saling memahami dan melindungi satu sama lain meskipun dilatarbelakangi rahasia besar', '686f0f1b99f71_manga_thumbnail-Komik-Spy-X-Family.jpg', '2025-07-10', '2017-05-15'),
(22, 'The Knight King Who Returned with a God', 'Kim Seho', 'Setelah kematiannya di medan perang, seorang ksatria legendaris terbangun kembali di dunia yang sama dengan kekuatan baru yang diberikan oleh seorang dewa. Dengan kemampuan yang melebihi batas manusia biasa, ia bertekad untuk melindungi kerajaannya dari ancaman kegelapan yang mulai menggerogoti perdamaian yang telah lama terjaga. Namun, kebangkitannya ini tidak diterima dengan baik oleh para bangsawan dan rivalnya yang melihatnya sebagai ancaman. Dalam perjuangannya, ksatria ini harus menghadapi intrik politik serta musuh-musuh kuat yang ingin menguasai dunia yang penuh dengan sihir dan misteri itu. Perjalanannya menjadi simbol harapan dan kekuatan bagi rakyat yang tertindas.', '686f0fa4ea02e_manga_thumbnail-Head-The-Knight-King-Who-Returned-with-a-God.jpg', '2025-07-10', '2025-07-01'),
(23, 'Chainsaw Man', 'Tatsuki Fujimoto', 'Chainsaw Man mengisahkan Denji, seorang pemuda yang hidupnya penuh dengan hutang warisan ayahnya dan berjuang untuk bertahan hidup dengan bekerja sebagai pemburu iblis bersama anjing setan peliharaannya yang juga menjadi gergaji mesin. Suatu hari, setelah dikhianati dan dibunuh, Denji berhasil dihidupkan kembali dengan menyatu bersama anjing setan tersebut sehingga ia menjadi manusia setengah iblis dengan kemampuan unik. Dengan kekuatan barunya, Denji direkrut oleh organisasi pemburu iblis pemerintah yang memiliki tujuan untuk memberantas ancaman iblis lain di masyarakat. Sambil menghadapi berbagai musuh mematikan, Denji juga berusaha memahami kehidupan dan keinginannya untuk memiliki kebahagiaan sederhana di tengah dunia yang kejam dan penuh bahaya ini.', '686f1006e4d14_manga_thumbnail-Manga-Chainsaw-Man.jpg', '2025-07-10', '2025-01-10'),
(24, 'One Piece', 'Eiichiro Oda', 'One Piece adalah manga karya Eiichiro Oda yang menceritakan petualangan Monkey D. Luffy dan kru Bajak Laut Topi Jerami dalam mencari harta karun legendaris \"One Piece\" untuk menjadi Raja Bajak Laut. Manga ini dikenal dengan dunia yang luas, karakter yang beragam, dan alur cerita yang penuh petualangan, persahabatan, dan pertempuran. One Piece juga populer karena tema-tema seperti mimpi, perjuangan, dan nilai-nilai moral. ', '686780fd1e3b0_images.jpeg', '2025-07-09', '2025-07-09'),
(25, 'Dragon Ball Z', 'Dika', 'Apaapun', '686783f6e82ca_download.jpeg', '2025-07-05', '2025-07-03'),
(26, 'Lalatai', 'hanif', 'open your eyes', '6867845802a24_download (2).jpeg', '2025-07-06', '2025-07-02'),
(27, 'Attack On Titan', 'Key', 'Sasageyo', '686784b9047d5_download (3).jpeg', '2025-07-05', '2025-07-03'),
(28, 'My Dad Is Too Strong', 'Gresiya Huang', 'Cerita ini berkisah tentang seorang ayah yang memiliki kekuatan luar biasa, membuatnya mampu menghadapi berbagai rintangan demi melindungi keluarganya. Meski kekuatannya luar biasa, ia tetap menunjukkan kasih sayang dan perhatian yang mendalam kepada anaknya, yang terkadang merasa cemas dengan kemampuan ayahnya yang unik. Seiring berjalannya waktu, hubungan antara ayah dan anak semakin erat. Mereka belajar untuk saling memahami dan menghargai perbedaan satu sama lain, sekaligus menghadapi bahaya yang mengancam. Komik ini menggabungkan aksi seru dengan nilai-nilai keluarga yang hangat dan penuh inspirasi.', '68678cb841d22_MDIT.jpeg', '2025-07-04', '2025-07-04'),
(29, 'Hotel Inhuman', 'Reyfre Chiha', 'Hotel kelas atas memiliki persyaratan tertentu. Dibutuhkan \"gourmet terbaik\", \"yang paling dalam kenyamanan\", \"hiburan menarik\"... Dan juga \"untuk memiliki persenjataan terbaru di siap\", \"mampu dengan aman memalsukan identitas tamu\", dan memiliki \"pembuangan lengkap tubuh\"..?! Di hotel ini, para tamu semuanya pembunuh bayaran. Dan petugas yang menyambut mereka sama sekali tidak bisa mengatakan \"tidak\". Apa yang diinginkan oleh para pembunuh bayaran tidak manusiawi yang terus-menerus melewati batas antara hidup dan mati ini? Dan dengan demikian, tirai terbuka di drama hotel yang mematikan ini', '68678dc4044d1_hotel-inhumans-1-285x399.webp', '2025-07-02', '2025-06-30'),
(30, 'My Dress-Up Darling Season 2', 'Freegy Haaoti', 'Ketika Marin Kitagawa dan Wakana Gojo bertemu, mereka semakin dekat dengan kecintaan mereka pada cosplay. Melalui berinteraksi dengan teman sekelas dan membuat teman cosplay baru, dunia Marin dan Wakana terus berkembang. Perkembangan baru muncul karena kecintaan Marin pada Wakana terus dipenuhi dengan kegembiraan yang tak ada habisnya. Di dunia mereka yang terus berkembang, kisah cosplay dan sensasi Marin dan Wakana terus berlanjut!', '68678ed13505e_my-dress-up-darling-season-2-1-285x399.webp', '2025-07-26', '2025-07-25'),
(31, 'Arknights: Rise from Ember', 'Dee Guang', 'Sequel to Arknights: Perish in Frost', '68678f690381c_arknights-rise-from-ember-1-285x399.webp', '2025-07-03', '2025-07-02'),
(32, 'The World\'s End', 'Sagan Akagawa', '\r\nKumpulan cerita pendek ini berisi sebagai berikut: Pangeran Katak menampilkan seorang pemuda bernama Yui Nishino yang memiliki ciri-ciri luar biasa. Namun, ia merasa ketampanannya lebih merupakan kutukan ketimbang berkah karena semua orang yang dekat dengannya iri dengan kecantikannya. Saat bekerja sebagai maskot museum, dia melihat salah satu teman sekelasnya, yang menyukai hewan prasejarah. Akankah dia menjadi orang yang menemukan kecantikan batin Yui? Di The World\'s End, Shin sedang menjalankan misi terraforming dan terus berhubungan dengan Rukiya, seorang insinyur yang ada di Bumi. Shin merasa cukup kesepian di luar angkasa, tapi untungnya baginya, dia memiliki AI yang sangat berkembang untuk menemaninya. Misi Shin baru saja berakhir dan ketika dia dijadwalkan untuk kembali ke Bumi, Rukiya memiliki beberapa berita buruk untuknya.', '686790574fe64_the-worlds-end-1-285x405.webp', '2025-07-02', '2025-06-29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga_characters`
--

CREATE TABLE `manga_characters` (
  `id` int(11) NOT NULL,
  `manga_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manga_characters`
--

INSERT INTO `manga_characters` (`id`, `manga_id`, `name`, `image`, `deskripsi`) VALUES
(9, 10, 'Tanjiro Kamada', '686e70d8be069_Tanjiro_Anime_Profile.webp', 'Main Protagonis'),
(10, 10, 'Kanao Tsuyuri', '686e70d8be512_Kanao_Anime_Profile.webp', 'Supporting Character'),
(11, 11, 'Sung Jinwoo', '686e7215ef4ab_Jinwoo4.webp', 'Main protagonis'),
(12, 11, 'Cha Hae In', '686e7215ef719_Cha_Hae-In.webp', 'Korean S-Rank Hunter and the Vice-Guild Master of the Hunters Guild'),
(13, 12, 'Saitama', '686e7343a7a43_Saitama_Icon.webp', 'Main Protagonis'),
(14, 12, 'Genos', '686e7343a80d4_Genos_Manga_Icon.webp', 'deuteragonist of One-Punch Man'),
(15, 13, 'Jahyeon Jo', '686e742bde70d_Jayjo.webp', 'Main Character'),
(16, 13, 'Noah', '686e742bde905_Noah_austinnn.webp', 'Support character'),
(17, 14, 'Shoyo Hinata', '686e7569a70b2_Shoyo_Hinata.webp', 'Main Protagonis'),
(18, 14, 'Kei Tsukishima', '686e7569a79e6_Tsukishima_1.webp', 'He plays as one of the starting middle blockers on the boys\' volleyball team.'),
(19, 15, 'Asahi Naruhaya', '686e76668f425_Asahi_Naruhaya.webp', 'Main Character'),
(20, 15, 'Gin Gamaru', '686e76668f6b1_Gin_Gagamaru.webp', 'Goalkeeper for Germany\'s Bastard München during the Neo Egoist League'),
(21, 16, 'Satoru Gojo', '686e7761e4273_GojoP.webp', 'Main Protagonis'),
(22, 16, 'Megumi Fushiguro', '686e7761e47e7_MegumiP.webp', 'Deuteragonist of the Jujutsu Kaisen series'),
(23, 17, 'Taiki Inomata', '686e78b0a7346_Inomata_Taiki_Anime.webp', 'Main Character'),
(24, 17, 'Chinatsu Kano', '686e78b0a7995_Kano_Chinatsu_Anime.webp', 'Main Character'),
(25, 24, 'Luffy', '686780fd1f236_images (1).jpeg', 'Monkey D. Luffy, atau yang lebih dikenal sebagai Luffy si Topi Jerami, adalah tokoh utama dalam seri anime dan manga One Piece. Ia adalah kapten dari Bajak Laut Topi Jerami dan bercita-cita menjadi Raja Bajak Laut. Luffy memiliki kekuatan buah iblis Gomu Gomu no Mi yang membuatnya memiliki tubuh karet, serta kepribadian yang ceria, bersemangat, dan pantang menyerah. '),
(26, 25, 'Goku', '686783f6e89fe_download (1).jpeg', 'Warnahitam'),
(27, 26, 'Eren', '686784b904e59_download (4).jpeg', 'antagonis'),
(28, 27, 'Dojun Lee', '68678cb84253f_dojun-lee-my-dad-is-too-strong-1-275x386.webp', 'Ayah'),
(29, 28, 'Ao Tajima', '68678dc4052b3_ao-tajima-1-285x399.webp', 'Ao TAJIMA is best known for being the author & artist of Hotel Inhumans.'),
(30, 29, 'Marin Kitagawa', '68678ed1360a5_marin-kitagawa-1-285x400.webp', 'Main Character'),
(31, 30, 'Amiya', '68678f69043d3_amiya-arknights-comic-anthology-1-285x398.webp', 'Character from Arknight');

-- --------------------------------------------------------

--
-- Struktur dari tabel `manga_genre`
--

CREATE TABLE `manga_genre` (
  `manga_id` int(11) NOT NULL,
  `genre_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `manga_genre`
--

INSERT INTO `manga_genre` (`manga_id`, `genre_id`) VALUES
(10, 8),
(10, 9),
(10, 14),
(10, 15),
(11, 8),
(11, 9),
(11, 14),
(11, 15),
(12, 8),
(12, 10),
(12, 16),
(13, 8),
(13, 10),
(14, 10),
(14, 15),
(14, 17),
(15, 8),
(15, 15),
(15, 17),
(16, 8),
(16, 9),
(17, 17),
(17, 18),
(18, 8),
(18, 9),
(18, 14),
(19, 15),
(19, 17),
(19, 18),
(20, 8),
(20, 9),
(20, 14),
(21, 8),
(21, 10),
(21, 18),
(22, 8),
(22, 9),
(22, 14),
(23, 8),
(23, 10),
(23, 15),
(24, 9),
(24, 10),
(25, 9),
(25, 10),
(26, 9),
(26, 10),
(27, 9),
(28, 9),
(28, 10),
(29, 9),
(30, 10),
(31, 9),
(32, 15);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `manga`
--
ALTER TABLE `manga`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `manga_characters`
--
ALTER TABLE `manga_characters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `manga_id` (`manga_id`);

--
-- Indeks untuk tabel `manga_genre`
--
ALTER TABLE `manga_genre`
  ADD PRIMARY KEY (`manga_id`,`genre_id`),
  ADD KEY `genre_id` (`genre_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `genre`
--
ALTER TABLE `genre`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `manga`
--
ALTER TABLE `manga`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `manga_characters`
--
ALTER TABLE `manga_characters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `manga_characters`
--
ALTER TABLE `manga_characters`
  ADD CONSTRAINT `manga_characters_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `manga_genre`
--
ALTER TABLE `manga_genre`
  ADD CONSTRAINT `manga_genre_ibfk_1` FOREIGN KEY (`manga_id`) REFERENCES `manga` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `manga_genre_ibfk_2` FOREIGN KEY (`genre_id`) REFERENCES `genre` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
