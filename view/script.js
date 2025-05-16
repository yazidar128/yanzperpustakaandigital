document.getElementById("loginForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Mencegah form dikirim secara default

    var username = document.getElementById("username").value;
    var password = document.getElementById("password").value;

    fetch('process_login.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = "../index.php"; // Redirect ke index.php di luar folder view
        } else {
            alert("Login gagal! Periksa kembali username dan password.");
        }
    })
    .catch(error => console.error('Error:', error));
});
