<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sistem Akademik</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #3a7bd5, #3a6073);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }

        .card-body {
            background-color: #ffffff;
        }

        .card-title {
            font-weight: bold;
            color: #3a6073;
        }

        .form-control:focus {
            border-color: #3a7bd5;
            box-shadow: 0 0 0 0.2rem rgba(58, 123, 213, 0.25);
        }

        .btn-primary {
            background-color: #3a7bd5;
            border: none;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2c5aa0;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 10px;
        }

        .text-danger.small {
            font-size: 0.85rem;
        }

        .card {
            animation: fadeInUp 0.7s ease;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="col-lg-4 col-md-6">
            <div class="card shadow">
                <div class="card-body p-5">
                    <h2 class="card-title text-center mb-4">Login Pengelolaan Makan Bergizi Gratis</h2>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger" role="alert">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form id="loginForm" action="<?= site_url('login') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div id="emailError" class="text-danger small"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <div id="passwordError" class="text-danger small"></div>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const form = document.getElementById("loginForm");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("password");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    form.addEventListener("submit", function(e) {
        let valid = true;

        if (emailInput.value.trim() === "") {
            emailError.textContent = "You must input Email";
            emailInput.classList.add("is-invalid");
            valid = false;
        } else {
            emailError.textContent = "";
            emailInput.classList.remove("is-invalid");
        }

        if (passwordInput.value.trim() === "") {
            passwordError.textContent = "You must input Password";
            passwordInput.classList.add("is-invalid");
            valid = false;
        } else {
            passwordError.textContent = "";
            passwordInput.classList.remove("is-invalid");
        }

        if (!valid) e.preventDefault();
    });
</script>
</body>
</html>
