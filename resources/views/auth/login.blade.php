<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | E-Tracking Mutasi ASN</title>
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #007bff, #0056b3);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px;
            width: 380px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .login-card .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .login-card img {
            width: 80px;
        }

        .login-card h4 {
            color: #0056b3;
            margin-top: 10px;
        }

        .btn-primary {
            background-color: #0056b3;
            border-color: #004b9a;
        }

        .btn-primary:hover {
            background-color: #004b9a;
        }
    </style>
</head>

<body>
    <div class="login-card">
        <div class="logo">
            <img src="{{ asset('images/logo-bkpp-rohul.png') }}" alt="Logo BKPP">
            <h4 class="fw-bold">E-Tracking Mutasi ASN</h4>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}" required autofocus>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                        name="password" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="remember" id="remember">
                <label class="form-check-label" for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="btn btn-primary w-100">Masuk</button>
        </form>

        <p class="text-center mt-3 mb-0 text-muted" style="font-size: 0.9em;">
            © {{ date('Y') }} BKPP Kabupaten Rokan Hulu
        </p>
    </div>
</body>

</html>
