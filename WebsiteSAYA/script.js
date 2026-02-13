// script.js

// Smooth Scroll untuk Navigation
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Navbar Background Change on Scroll
window.addEventListener('scroll', function() {
    const nav = document.querySelector('nav');
    if (window.scrollY > 100) {
        nav.style.background = 'rgba(255, 255, 255, 0.98)';
        nav.style.backdropFilter = 'blur(10px)';
    } else {
        nav.style.background = 'rgba(255, 255, 255, 0.95)';
        nav.style.backdropFilter = 'none';
    }
});

// Typing Effect untuk Hero Section
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function typing() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(typing, speed);
        }
    }
    typing();
}

// Initialize typing effect ketika page load
window.addEventListener('load', function() {
    const heroTitle = document.querySelector('.hero h1');
    const originalText = heroTitle.innerHTML;
    typeWriter(heroTitle, originalText);
});

// Project Filter System
const projects = [
    {
        title: "Website Rekomendasi Buku Terbaru",
        category: "web",
        description: "Desain dan development website rekomendasi buku terbaru dengan fitur lengkap sesuai dengan keinginan pengguna",
        tags: ["HTML/CSS", "JavaScript"],
        image: src="assets/images/Bukuku.jpg"
    },
    {
        title: "Poster Kegiatan Pemberdayaan Kemitraan Masyarakat",
        category: "design",
        description: "Desain poster untuk kegiatan pemberdayaan masyarakat",
        tags: ["Canva"],
        image: "assets/images/Poster.jpg"
    },
    {
        title: "Video Editing Channel YouTube Edukasi",
        category: "video",
        description: "Editing video edukasi di channel YouTube 'Nyolo Ilmu' untuk mendongkrak subscriber dan views",
        tags: ["Canva", "Capcut"],
        image: "assets/images/YTsaya.png"
    },
    {
        title: "Materi Technical Meeting Lomba IIT Competition 2024",
        category: "design",
        description: "Membuat materi technical meeting untuk lomba IIT Competition 2024",
        tags: ["Canva"],
        image: "assets/images/TM LOmba.jpg"
    }
];

function filterProjects(category) {
    const projectGrid = document.querySelector('.projects-grid');
    const filteredProjects = category === 'all' ? projects : projects.filter(project => project.category === category);
    
    projectGrid.innerHTML = filteredProjects.map(project => `
        <div class="project-card" data-category="${project.category}">
            <div class="project-image">
                <img src="${project.image}" alt="${project.title}" class="project-img">
            </div>
            <h3>${project.title}</h3>
            <p>${project.description}</p>
            <div class="project-tags">
                ${project.tags.map(tag => `<span>${tag}</span>`).join('')}
            </div>
        </div>
    `).join('');
}

// Contact Form Handler
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Simpan data form
            const formData = {
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                message: document.getElementById('message').value
            };
            
            // Simulasi pengiriman
            alert('Terima kasih, ' + formData.name + '! Pesan Anda telah dikirim. 😊');
            contactForm.reset();
        });
    }
});

// Dark Mode Toggle
function toggleDarkMode() {
    document.body.classList.toggle('dark-mode');
    const isDarkMode = document.body.classList.contains('dark-mode');
    localStorage.setItem('darkMode', isDarkMode);
    
    // Update tombol theme
    const themeToggle = document.querySelector('.theme-toggle');
    if (isDarkMode) {
        themeToggle.textContent = '☀️';
    } else {
        themeToggle.textContent = '🌓';
    }
}
// Check saved theme preference
document.addEventListener('DOMContentLoaded', function() {
    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    const themeToggle = document.querySelector('.theme-toggle');
    
    if (isDarkMode) {
        document.body.classList.add('dark-mode');
        themeToggle.textContent = '☀️';
    } else {
        themeToggle.textContent = '🌓';
    }
});

// Animation on Scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('animate-in');
        }
    });
}, observerOptions);

// Observe semua sections
document.querySelectorAll('section').forEach(section => {
    observer.observe(section);
});