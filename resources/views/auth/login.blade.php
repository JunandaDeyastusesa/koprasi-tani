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
            background: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-card {
            max-width: 400px;
            padding: 2rem;
            border-radius: 0.5rem;
            background: #ffffff;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
        }

        .login-card .form-control:focus {
            box-shadow: 0 0 0 0.2rem #0d6efd99;
            border-color: #0d6efd;
        }
    </style>
</head>

<body>
    <div class="login-card shadow-sm">
        <h3 class="mb-4 text-center fw-bold">Sign In</h3>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">Email address</label>
                <input type="email" class="form-control" id="email" name="email"
                    placeholder="your.email@example.com" required autofocus />
            </div>
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">Password</label>
                <input type="password" class="form-control" id="password" name="password"
                    placeholder="Enter your password" required />
            </div>
            <button type="submit" class="btn btn-primary w-100 fw-semibold">Login</button>
        </form>
        <p class="text-center mt-4 mb-0">
            Don't have an account? <a href="/register" class="text-primary text-decoration-none fw-semibold">Sign Up</a>
        </p>
    </div>

    <!-- Bootstrap 5 JS Bundle CDN (Popper + Bootstrap JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
