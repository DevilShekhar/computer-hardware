<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - {{ config('app.name', 'Metaverse') }}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/frontend/assets/images/favicon.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        html,
        body {
            width: 100%;
            min-height: 100%;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: #f5f5f5;
            color: #222222;
        }
        .register-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
            position: relative;
            background-image:
                linear-gradient(rgba(4, 12, 24, 0.72), rgba(4, 12, 24, 0.72)),
                url('{{ asset('assets/frontend/assets/images/login-bg.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .register-container {
            width: 100%;
            max-width: 1050px;
            min-height: 620px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            overflow: hidden;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.13);
        }
        .register-left {
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            overflow: hidden;
            background:
                linear-gradient(145deg,
                    #06101d 0%,
                    #0a192c 55%,
                    #103258 100%);
            color: #ffffff;
        }
        .register-left::before {
            content: "";
            position: absolute;
            width: 450px;
            height: 450px;
            border: 1px solid rgba(59, 130, 246, 0.18);
            border-radius: 50%;
            right: -250px;
            top: -200px;
            pointer-events: none;
        }
        .register-left::after {
            content: "";
            position: absolute;
            width: 550px;
            height: 550px;
            border: 1px solid rgba(59, 130, 246, 0.08);
            border-radius: 50%;
            left: -350px;
            bottom: -330px;
            pointer-events: none;
        }
        .tech-grid {
            position: absolute;
            inset: 0;
            opacity: 0.06;
            background-image:
                linear-gradient(rgba(255, 255, 255, 0.5) 1px,
                    transparent 1px),
                linear-gradient(90deg,
                    rgba(255, 255, 255, 0.5) 1px,
                    transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
        }
        .register-brand {
            position: relative;
            z-index: 3;
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 55px;
        }
        .register-brand-icon {
            width: 58px;
            height: 58px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f20d0d;
            color: #ffffff;
            font-size: 24px;
            box-shadow:
                0 8px 25px rgba(242, 13, 13, 0.30);
        }
        .register-brand-name {
            color: #ffffff;
            font-size: 23px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }
        .register-left h1 {
            position: relative;
            z-index: 3;
            margin-bottom: 20px;
            color: #ffffff;
            font-size: 42px;
            line-height: 1.15;
            font-weight: 800;
            letter-spacing: -0.5px;
        }
        .register-left h1 span {
            color: #f20d0d;
        }
        .register-left-description {
            position: relative;
            z-index: 3;
            max-width: 430px;
            margin-bottom: 38px;
            color: #aebed2;
            font-size: 14px;
            line-height: 1.8;
        }
        .register-features {
            position: relative;
            z-index: 3;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 20px;
        }
        .register-feature {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #d8e4f2;
            font-size: 13px;
            font-weight: 500;
        }
        .register-feature-icon {
            width: 34px;
            height: 34px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            background: rgba(242, 13, 13, 0.15);
            color: #ff3b3b;
            font-size: 14px;
        }
        .register-right {
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 20px 20px;
            background: #ffffff;
        }
        .register-logo-wrapper {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 25px;
        }
        .register-logo {
            max-width: 190px;
            width: auto;
            height: auto;
            display: block;
            object-fit: contain;
        }
        .register-heading {
            text-align: center;
        }
        .register-heading h2 {
            margin-bottom: 9px;
            color: #222222;
            font-size: 31px;
            line-height: 1.2;
            font-weight: 700;
        }
        .register-heading p {
            color: #777777;
            font-size: 14px;
            line-height: 1.6;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333333;
            font-size: 13px;
            font-weight: 600;
        }
        .input-wrapper {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #999999;
            font-size: 14px;
            pointer-events: none;
            transition: 0.2s;
        }
        .form-control {
            width: 100%;
            height: 50px;
            padding: 0 45px;
            border: 1px solid #dddddd;
            border-radius: 4px;
            outline: none;
            background: #ffffff;
            color: #222222;
            font-family: inherit;
            font-size: 14px;
            transition: all 0.2s ease;
        }
        .form-control::placeholder {
            color: #aaaaaa;
        }
        .form-control:hover {
            border-color: #cccccc;
        }
        .form-control:focus {
            border-color: #f20d0d;
            box-shadow:
                0 0 0 3px rgba(242, 13, 13, 0.08);
        }
        .form-control.is-invalid {
            border-color: #dc3545;
        }
        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            outline: none;
            background: transparent;
            color: #999999;
            cursor: pointer;
            transition: 0.2s;
        }
        .password-toggle:hover {
            color: #f20d0d;
        }
        .invalid-feedback {
            display: block;
            margin-top: 6px;
            color: #dc3545;
            font-size: 12px;
            line-height: 1.5;
        }
        .register-button {
            width: 100%;
            height: 52px;
            margin-top: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            border-radius: 4px;
            background: #f20d0d;
            color: #ffffff;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            box-shadow:
                0 7px 18px rgba(242, 13, 13, 0.20);
            transition: all 0.25s ease;
        }
        .register-button:hover {
            background: #d90808;
            transform: translateY(-1px);
            box-shadow:
                0 10px 25px rgba(242, 13, 13, 0.28);
        }
        .register-button:active {
            transform: translateY(0);
        }
        .login-link {
            width: 100%;
            height: 48px;
            margin-top: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #f20d0d;
            border-radius: 4px;
            background: #ffffff;
            color: #f20d0d;
            font-family: inherit;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .login-link:hover {
            background: #f20d0d;
            color: #ffffff;
        }
        .register-footer {
            margin-top: 22px;
            padding-top: 18px;
            border-top: 1px solid #eeeeee;
            color: #999999;
            font-size: 12px;
            line-height: 1.6;
            text-align: center;
        }
        .register-footer strong {
            color: #555555;
        }
        .top-theme-line {
            position: fixed;
            z-index: 9999;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: #f20d0d;
        }
        @media (max-width: 900px) {
            .register-container {
                max-width: 650px;
                grid-template-columns: 1fr;
            }
            .register-left {
                min-height: 390px;
                padding: 45px;
            }
            .register-left h1 {
                font-size: 36px;
            }
            .register-right {
                padding: 50px;
            }
        }
        @media (max-width: 576px) {
            .register-page {
                padding: 15px;
            }
            .register-container {
                border-radius: 5px;
            }
            .register-left {
                min-height: auto;
                padding: 35px 25px;
            }
            .register-brand {
                margin-bottom: 35px;
            }
            .register-brand-icon {
                width: 48px;
                height: 48px;
                font-size: 20px;
            }
            .register-brand-name {
                font-size: 19px;
            }
            .register-left h1 {
                font-size: 29px;
                line-height: 1.2;
                margin-bottom: 15px;
            }
            .register-left-description {
                margin-bottom: 25px;
                font-size: 13px;
                line-height: 1.7;
            }
            .register-features {
                grid-template-columns: 1fr;
                gap: 10px;
            }
            .register-feature {
                font-size: 12px;
            }
            .register-feature-icon {
                width: 30px;
                height: 30px;
            }
            .register-right {
                padding: 35px 25px;
            }
            .register-logo {
                max-width: 155px;
                max-height: 55px;
            }
            .register-heading {
                margin-bottom: 25px;
            }
            .register-heading h2 {
                font-size: 27px;
            }
            .register-heading p {
                font-size: 13px;
            }
        }
        @media (max-width: 380px) {
            .register-left {
                padding: 30px 20px;
            }
            .register-right {
                padding: 30px 20px;
            }
            .register-left h1 {
                font-size: 26px;
            }
        }
    </style>
</head>
<body>
    <div class="top-theme-line"></div>
    <main class="register-page">
        <div class="register-container">
            <section class="register-left">
                <div class="tech-grid"></div>
                <div class="register-brand">
                    <div class="register-brand-icon">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div class="register-brand-name">
                        Metaverse
                    </div>
                </div>
                <h1>
                    Create Your
                    <span>Account.</span>
                    <br>
                    Start Shopping.
                </h1>
                <p class="register-left-description">
                    Create your account and explore premium computer hardware, components, accessories and everything you need for your perfect setup.
                </p>
                <div class="register-features">
                    <div class="register-feature">
                        <div class="register-feature-icon">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span>Premium Components</span>
                    </div>
                    <div class="register-feature">
                        <div class="register-feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span>Secure Shopping</span>
                    </div>
                    <div class="register-feature">
                        <div class="register-feature-icon">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span>Fast Delivery</span>
                    </div>
                    <div class="register-feature">
                        <div class="register-feature-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span>Expert Support</span>
                    </div>
                </div>
            </section>
            <section class="register-right">
                <div class="register-logo-wrapper">
                    <img src="{{ asset('assets/frontend/assets/images/menu/logo/logo.png') }}"  alt="{{ config('app.name', 'Metaverse') }}" class="register-logo">
                </div>
                <div class="register-heading">
                    <h2>Register</h2>
                    <p>Create your account to continue.</p>
                </div>
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user input-icon"></i>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name"value="{{ old('name') }}"
                                placeholder="Enter your name"  autocomplete="name"required autofocus >
                        </div>
                        @error('name')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email Address</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="Enter your email address"
                                autocomplete="email"
                                required
                            >
                        </div>
                        @error('email')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                placeholder="Enter your password"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button" class="password-toggle" id="passwordToggle" aria-label="Show password"  >
                                <i class="fa-solid fa-eye" id="passwordEye"></i>
                            </button>
                        </div>
                        @error('password')
                            <span class="invalid-feedback">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">Confirm Password</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input
                                id="password-confirm"
                                type="password"
                                class="form-control"
                                name="password_confirmation"
                                placeholder="Confirm your password"
                                autocomplete="new-password"
                                required
                            >
                            <button type="button"   class="password-toggle"  id="confirmPasswordToggle" aria-label="Show password" >
                                <i class="fa-solid fa-eye" id="confirmPasswordEye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="register-button">
                        <i class="fa-solid fa-user-plus"></i>
                        <span style="margin-left: 8px;">Register</span>
                    </button>
                </form>
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span style="margin-left: 8px;">Already have an account? Login</span>
                </a>
                <div class="register-footer">
                    Secure registration protected by
                    <strong>Metaverse</strong>
                </div>
            </section>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const passwordInput = document.getElementById("password");
            const passwordToggle = document.getElementById("passwordToggle");
            const passwordEye = document.getElementById("passwordEye");
            const confirmPasswordInput = document.getElementById("password-confirm");
            const confirmPasswordToggle = document.getElementById("confirmPasswordToggle");
            const confirmPasswordEye = document.getElementById("confirmPasswordEye");
            if (passwordInput && passwordToggle && passwordEye) {
                passwordToggle.addEventListener("click", function() {
                    if (passwordInput.type === "password") {
                        passwordInput.type = "text";
                        passwordEye.classList.remove("fa-eye");
                        passwordEye.classList.add("fa-eye-slash");
                        passwordToggle.setAttribute("aria-label", "Hide password");
                    } else {
                        passwordInput.type = "password";
                        passwordEye.classList.remove("fa-eye-slash");
                        passwordEye.classList.add("fa-eye");
                        passwordToggle.setAttribute("aria-label", "Show password");
                    }
                });
            }
            if (confirmPasswordInput && confirmPasswordToggle && confirmPasswordEye) {
                confirmPasswordToggle.addEventListener("click", function() {
                    if (confirmPasswordInput.type === "password") {
                        confirmPasswordInput.type = "text";
                        confirmPasswordEye.classList.remove("fa-eye");
                        confirmPasswordEye.classList.add("fa-eye-slash");
                        confirmPasswordToggle.setAttribute("aria-label", "Hide password");
                    } else {
                        confirmPasswordInput.type = "password";
                        confirmPasswordEye.classList.remove("fa-eye-slash");
                        confirmPasswordEye.classList.add("fa-eye");
                        confirmPasswordToggle.setAttribute("aria-label", "Show password");
                    }
                });
            }
        });
    </script>
</body>
</html>