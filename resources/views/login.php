<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-body-secondary">

    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header text-center">
                        <a href="{{ url('index2') }}" class="h1">Login</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('index3') }}" method="post">
                        
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>

                            <div class="row align-items-center">
                                <div class="col-md-7">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>
                                </div>
                                <div class="col-md-5 mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary w-100">Sign In</button>
                                </div>
                            </div>
                        </form>

                        <div class="social-auth-links text-center my-3">
                            <p>- OR -</p>
                            <a href="#" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-facebook me-2"></i> Sign in using Facebook
                            </a>
                            <a href="#" class="btn btn-danger w-100">
                                <i class="bi bi-google me-2"></i> Sign in using Google+
                            </a>
                        </div>

                        <p class="mb-1">
                            <a href="{{ url('forgot-password') }}">I forgot my password</a>
                        </p>
                        <p class="mb-0">
                            <a href="{{ url('register') }}" class="text-center">Register a new membership</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>