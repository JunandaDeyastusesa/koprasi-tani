<!DOCTYPE html>Add commentMore actions
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <title>Register</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background: #dcffdc;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            width: 450px;
            padding: 2rem;
            border-radius: 0.5rem;
            background: #ffffff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .btn-primary {
            background-color: #5d7010 !important;
            border: none !important;
        }

        .btn-primary:hover {
            background-color: #50610d !important;
            border: none !important;
        }

        .text-primary{
            color: #5d7010 !important;
        }

        .text-primary:hover {
            color: #50610d !important;
        }
    </style>
</head>

<body>
    <div class="login-card shadow-sm">
        <h3 class="mb-4 text-center fw-bold">Daftar Anggota</h3>
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-semibold">Nama Lengkap</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                    name="name" placeholder="nama Lengkap" value="{{ old('name') }}" required />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="username" class="form-label fw-semibold">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                    name="username" placeholder="username" value="{{ old('username') }}" required />
                @error('username')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                    name="email" placeholder="your.email@example.com" value="{{ old('email') }}" required />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                    name="password" placeholder="Enter your password" required />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="form-label fw-semibold">Confirm Password</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                    placeholder="Repeat your password" required />
            </div>

            <button type="submit" class="btn btn-primary mt-3 w-100 fw-semibold">Register</button>
        </form>

        <p class="text-center mt-4 mb-0">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-primary text-decoration-none fw-semibold">Login</a>
        </p>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>