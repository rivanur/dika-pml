document.addEventListener('DOMContentLoaded', function() {
    const adminForm = document.getElementById('adminForm');
    
    adminForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(adminForm);
        
        try {
            const response = await fetch('http://localhost/mangup/backend/add_admin.php', {
                method: 'POST',
                body: formData
            });
            
            const result = await response.json();
            
            if (result.status === 'success') {
                alert(result.message);
                adminForm.reset();
            } else {
                throw new Error(result.message);
            }
        } catch (error) {
            alert('Gagal menambahkan admin: ' + error.message);
            console.error('Error:', error);
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Cek apakah admin sudah login
    fetch('http://localhost/mangup/backend/check_login.php')
        .then(response => response.json())
        .then(data => {
            if (data.logged_in) {
                document.getElementById('adminUsername').textContent = data.username;
            } else {
                window.location.href = 'login.html';
            }
        });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', function () {
        fetch('http://localhost/mangup/backend/logout.php')
            .then(() => {
                window.location.href = 'login.html';
            });
    });
});