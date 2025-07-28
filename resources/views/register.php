<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Viewport para diseño responsivo -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-body-secondary">

    <!-- Contenedor principal -->
    <div class="container">
        <div class="row vh-100 justify-content-center align-items-center">
            <!-- Usamos columnas de Bootstrap para controlar el ancho de forma responsiva -->
            <div class="col-12 col-md-8 col-lg-5">
                <div class="card card-outline card-primary shadow-lg">
                    <div class="card-header text-center">
                        <a href="{{ url('/') }}" class="h1">Register</a>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('register') }}" method="post">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-person"></i></span>
                                <input type="text" name="name" class="form-control" placeholder="Full name" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password" class="form-control" placeholder="Password" required>
                            </div>
                            <div class="input-group mb-4">
                                <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Retype password" required>
                            </div>

                            <!-- Fila responsiva para checkbox y botón -->
                            <div class="row align-items-center">
                                <div class="col-md-7 col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="agreeTerms" name="terms" value="agree" required>
                                        <label class="form-check-label" for="agreeTerms">
                                            I agree to the <a href="#">terms</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-5 col-12 mt-3 mt-md-0">
                                    <button type="submit" class="btn btn-primary w-100">Register</button>
                                </div>
                            </div>
                        </form>

                        <div class="social-auth-links text-center my-4">
                            <p>- OR -</p>
                            <a href="#" class="btn btn-primary w-100 mb-2">
                                <i class="bi bi-facebook me-2"></i> Sign up using Facebook
                            </a>
                            <a href="#" class="btn btn-danger w-100">
                                <i class="bi bi-google me-2"></i> Sign up using Google+
                            </a>
                        </div>

                        <p class="mb-0 text-center">
                            <a href="{{ route('login') }}">I already have a membership</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
