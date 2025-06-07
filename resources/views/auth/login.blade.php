<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
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
            width: 400px;
            padding: 2rem;
            border-radius: 0.5rem;
            background: #ffffff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .btn-primary {Add commentMore actions
            background-color: #5d7010 !important;
            border: none !important;
        }

        .btn-primary:hover {
            background-color: #50610d !important;
            border: none !important;
        }

        .text-primary {
            color: #5d7010 !important;
        }

        .text-primary:hover {
            color: #50610d !important;
        }
    </style>
</head>

<body>
    <div class="login-card shadow-sm">
        <h3 class="mb-5 text-center fw-bold">Login</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-4">
                <label for="email" class="form-label fw-semibold">Email address</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"Add commentMore actions
                    name="email" placeholder="your.email@example.com" value="{{ old('email') }}" required
                    autofocus />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"Add commentMore actions
                    name="password" placeholder="Enter your password" required />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if (session('error'))Add commentMore actions
                <div class="alert alert-danger text-center">{{ session('error') }}</div>
            @endif

            <button type="submit" class="btn btn-primary mt-4 mb-3 w-100 fw-semibold">Login</button>
        </form>
        <p class="text-center mt-4 mb-0">
             Belum punya akun? <a href="{{ route('register') }}"Add commentMore actions
                class="text-primary text-decoration-none fw-semibold">Sign Up</a>
        </p>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
