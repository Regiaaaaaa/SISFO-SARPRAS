<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Admin - Sistem Manajemen Sarpras</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #D3D3D3;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 800px;
            display: flex;
            position: relative;
        }

        .login-form {
            width: 50%;
            padding: 40px;
        }

        .login-title {
            color: #333;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .login-subtitle {
            color: #666;
            font-size: 12px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            color: #333;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .password-container {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #666;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: #000;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 600;
            margin-top: 15px;
        }

        .login-button:hover {
            background-color: #333;
        }

        .error-message {
            background-color: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .illustration {
            width: 50%;
            background-color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 20px;
        }

        .illustration svg {
            width: 100%;
            height: 100%;
        }
    </style>
</head>
<body>

<div class="login-container">
    <div class="login-form">
        <h1 class="login-title">Sistem Management Sarpras</h1>
        <h2 class="login-title">Taruna Bhakti</h2>
        <p class="login-subtitle">Login untuk mengakses layanan dan mengontrol barang</p>

        <div id="error-message" class="error-message" style="display: none;"></div>

        <form id="loginForm" method="POST" action="{{ route('login.submit') }}">
            @csrf
            <div class="form-group">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-input" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <div class="password-container">
                    <input type="password" name="password" class="form-input" required>
                    <span class="password-toggle">👁️</span>
                </div>
            </div>

            <button type="submit" class="login-button">Login</button>
        </form>
    </div>

    <div class="illustration">
            <svg viewBox="0 0 400 400" xmlns="http://www.w3.org/2000/svg">
                <circle cx="200" cy="200" r="180" fill="#e6f7ff" />
                <ellipse cx="200" cy="340" rx="150" ry="40" fill="#50b3d4" />
                <rect x="100" y="320" width="200" height="10" rx="5" fill="#ffffff" />
                <rect x="120" y="330" width="160" height="10" rx="5" fill="#333333" />
                <circle cx="140" cy="340" r="10" fill="#666666" />
                <circle cx="260" cy="340" r="10" fill="#666666" />
                <rect x="150" y="180" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="170" y="130" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="190" y="180" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="130" y="230" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="170" y="230" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="210" y="230" width="50" height="50" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <rect x="150" y="280" width="100" height="40" rx="2" fill="#7fccde" stroke="#5db1c5" stroke-width="2" />
                <circle cx="220" cy="120" r="20" fill="#333333" />
                <path d="M215 110 Q220 105, 225 110" stroke="#ffffff" stroke-width="1" fill="none" />
                <rect x="210" y="118" width="20" height="10" rx="5" fill="#4d4d4d" />
                <rect x="210" y="140" width="20" height="40" rx="5" fill="#4aadd2" />
                <rect x="200" y="145" width="10" height="30" rx="5" fill="#4aadd2" />
                <rect x="230" y="145" width="10" height="35" rx="5" fill="#4aadd2" />
                <rect x="210" y="180" width="10" height="40" rx="5" fill="#333333" />
                <rect x="220" y="180" width="10" height="35" rx="5" fill="#333333" />
                <rect x="235" y="160" width="15" height="20" rx="2" fill="#333333" />
            </svg>
        </div>
</div>

<script>
    // Toggle password visibility
    document.querySelector('.password-toggle').addEventListener('click', function () {
        const passwordInput = document.querySelector('input[name="password"]');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            this.textContent = '🙈';
        } else {
            passwordInput.type = 'password';
            this.textContent = '👁️';
        }
    });

    // Handle AJAX form submission
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const formData = new FormData(form);
        const errorDiv = document.getElementById('error-message');

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: formData
        })
        .then(res => res.json())
        .then(data => {
            if (data.token) {
                localStorage.setItem('token', data.token); // Simpan token ke localStorage
                window.location.href = data.redirect;
            } else {
                errorDiv.style.display = 'block';
                errorDiv.textContent = data.message || 'Login gagal.';
            }
        })
        .catch(() => {
            errorDiv.style.display = 'block';
            errorDiv.textContent = 'Terjadi kesalahan saat mengirim data.';
        });
    });
</script>

</body>
</html>
