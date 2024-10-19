<head>
    <title>User Dashboard | Awareness Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js"></script>
</head>

<body>
<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Awareness Tracker</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register-user') }}">Register</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="login-form">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded">
                    <div class="card-header text-center">
                        <h3>Login</h3>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('login.custom') }}">
                            @csrf
                            <div class="form-group mb-3">
                                <input type="text" placeholder="Email" id="email" class="form-control" name="email"
                                       required autofocus>
                            </div>

                            <div class="form-group mb-3">
                                <input type="password" placeholder="Password" id="password" class="form-control"
                                       name="password" required>
                                @if ($errors->has('emailPassword'))
                                    <span class="text-danger">{{ $errors->first('emailPassword') }}</span>
                                @endif
                            </div>

                            <div class="form-group mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-dark btn-block">Sign In</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="{{ route('register-user') }}">Register here</a></p>
                </div>
            </div>
        </div>
    </div>
</main>
</body>

