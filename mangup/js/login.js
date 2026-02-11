document.getElementById('loginForm').addEventListener('submit', async function (e) {
    e.preventDefault();

    const formData = new FormData(this);
    const message = document.getElementById('message');

    try {
        const response = await fetch('http://localhost/mangup/backend/login.php', {
            method: 'POST',
            body: formData
        });

        const result = await response.json();

        if (result.status === 'success') {
            message.className = 'message';
            message.style.display = 'none';

            // Redirect ke halaman admin setelah login berhasil
            window.location.href = 'admin.html';
        } else {
            message.className = 'message error';
            message.style.display = 'block';
            message.innerHTML = result.message;
        }
    } catch (error) {
        message.className = 'message error';
        message.style.display = 'block';
        message.innerHTML = 'Terjadi kesalahan jaringan. Silakan coba lagi.';
        console.error('Error:', error);
    }
});