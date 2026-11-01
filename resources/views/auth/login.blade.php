<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Absensi Sekolah</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="login-page">

    <div class="login-box">
        <div class="login-header">
            <i class="fas fa-fingerprint fa-3x"></i>
            <h1>ABSENSI PRO</h1>
            <p>Silakan masuk ke akun Anda</p>
        </div>

        @if ($errors->any())
        <div class="alert-error" style="background: #fee2e2; color: #dc2626; padding: 10px 15px; border-radius: 8px; margin-bottom: 15px; font-size: 14px; text-align: left;">
            <ul style="margin: 0; padding-left: 20px;">
                @foreach ($errors->all() as $error)
                <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf <div class="form-group">
                <label><i class="fas fa-user"></i> Username</label>
                <input type="text" name="username" value="{{ old('username') }}" placeholder="Masukkan username" required autofocus autocomplete="off"
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <div class="form-group" style="margin-top: 15px;">
                <label><i class="fas fa-lock"></i> Password</label>
                <input type="password" name="password" placeholder="Masukkan password" required
                    style="width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
            </div>

            <button type="submit" class="btn-login" style="margin-top: 20px; width: 100%;">
                Masuk Sekarang <i class="fas fa-sign-in-alt"></i>
            </button>
        </form>

        <div class="login-footer" style="margin-top: 20px; text-align: center;">
            <p>&copy; 2026 IT Team Pekalongan</p>
        </div>
    </div>

</body>

</html>