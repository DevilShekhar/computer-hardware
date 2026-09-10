<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - {{ config('app.name', 'Metaverse') }}</title>
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

    .reset-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        background-image: linear-gradient(rgba(4, 12, 24, 0.72), rgba(4, 12, 24, 0.72)),
        url('{{ asset('assets/frontend/assets/images/login-bg.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }

    .reset-container {
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

    .reset-left {
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

    .reset-left::before {
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

    .reset-left::after {
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
            linear-gradient(rgba(255, 255, 255, 0.5) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255, 255, 255, 0.5) 1px, transparent 1px);
        background-size: 40px 40px;
        pointer-events: none;
    }

    .reset-brand {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 55px;
    }

    .reset-brand-icon {
        width: 58px;
        height: 58px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f20d0d;
        color: #ffffff;
        font-size: 24px;
        box-shadow: 0 8px 25px rgba(242, 13, 13, 0.30);
    }

    .reset-brand-name {
        color: #ffffff;
        font-size: 23px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .reset-left h1 {
        position: relative;
        z-index: 3;
        margin-bottom: 20px;
        color: #ffffff;
        font-size: 42px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .reset-left h1 span {
        color: #f20d0d;
    }

    .reset-left-description {
        position: relative;
        z-index: 3;
        max-width: 430px;
        margin-bottom: 38px;
        color: #aebed2;
        font-size: 14px;
        line-height: 1.8;
    }

    .reset-features {
        position: relative;
        z-index: 3;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 20px;
    }

    .reset-feature {
        display: flex;
        align-items: center;
        gap: 11px;
        color: #d8e4f2;
        font-size: 13px;
        font-weight: 500;
    }

    .reset-feature-icon {
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

    .reset-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px 20px;
        background: #ffffff;
    }

    .reset-logo-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 25px;
    }

    .reset-logo {
        max-width: 190px;
        width: auto;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .reset-heading {
        text-align: center;
        margin-bottom: 30px;
    }

    .reset-heading h2 {
        margin-bottom: 9px;
        color: #222222;
        font-size: 31px;
        line-height: 1.2;
        font-weight: 700;
    }

    .reset-heading p {
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
        box-shadow: 0 0 0 3px rgba(242, 13, 13, 0.08);
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

    .reset-button {
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
        box-shadow: 0 7px 18px rgba(242, 13, 13, 0.20);
        transition: all 0.25s ease;
    }

    .reset-button:hover {
        background: #d90808;
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(242, 13, 13, 0.28);
    }

    .reset-button:active {
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

    .reset-footer {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #eeeeee;
        color: #999999;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
    }

    .reset-footer strong {
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
        .reset-container {
            max-width: 650px;
            grid-template-columns: 1fr;
        }

        .reset-left {
            min-height: 390px;
            padding: 45px;
        }

        .reset-left h1 {
            font-size: 36px;
        }

        .reset-right {
            padding: 50px;
        }
    }

    @media (max-width: 576px) {
        .reset-page {
            padding: 15px;
        }

        .reset-container {
            border-radius: 5px;
        }

        .reset-left {
            min-height: auto;
            padding: 35px 25px;
        }

        .reset-brand {
            margin-bottom: 35px;
        }

        .reset-brand-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .reset-brand-name {
            font-size: 19px;
        }

        .reset-left h1 {
            font-size: 29px;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .reset-left-description {
            margin-bottom: 25px;
            font-size: 13px;
            line-height: 1.7;
        }

        .reset-features {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .reset-feature {
            font-size: 12px;
        }

        .reset-feature-icon {
            width: 30px;
            height: 30px;
        }

        .reset-right {
            padding: 35px 25px;
        }

        .reset-logo {
            max-width: 155px;
            max-height: 55px;
        }

        .reset-heading {
            margin-bottom: 25px;
        }

        .reset-heading h2 {
            font-size: 27px;
        }

        .reset-heading p {
            font-size: 13px;
        }
    }

    @media (max-width: 380px) {
        .reset-left {
            padding: 30px 20px;
        }

        .reset-right {
            padding: 30px 20px;
        }

        .reset-left h1 {
            font-size: 26px;
        }
    }
    </style>
</head>
<body>
    <div class="top-theme-line"></div>
    <main class="reset-page">
        <div class="reset-container">
            <section class="reset-left">
                <div class="tech-grid"></div>
                <div class="reset-brand">
                    <div class="reset-brand-icon">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div class="reset-brand-name">
                        Metaverse
                    </div>
                </div>
                <h1>
                    Reset Your
                    <span>Password.</span>
                    <br>
                    Secure Your Account.
                </h1>
                <p class="reset-left-description">
                    Create a new secure password and get back to your Metaverse
                    account. Keep your account protected and continue shopping
                    for premium computer hardware and accessories.
                </p>
                <div class="reset-features">
                    <div class="reset-feature">
                        <div class="reset-feature-icon">
                            <i class="fa-solid fa-lock"></i>
                        </div>
                        <span>Secure Password</span>
                    </div>
                    <div class="reset-feature">
                        <div class="reset-feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span>Account Protection</span>
                    </div>
                    <div class="reset-feature">
                        <div class="reset-feature-icon">
                            <i class="fa-solid fa-user-check"></i>
                        </div>
                        <span>Easy Account Recovery</span>
                    </div>
                    <div class="reset-feature">
                        <div class="reset-feature-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span>Expert Support</span>
                    </div>
                </div>
            </section>
            <section class="reset-right">
                <div class="reset-logo-wrapper">
                    <img src="{{ asset('assets/frontend/assets/images/menu/logo/logo.png') }}"  alt="{{ config('app.name', 'Metaverse') }}" class="reset-logo">
                </div>
                <div class="reset-heading">
                    <h2>Reset Password</h2>
                    <p>Create a new password for your account.</p>
                </div>
                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group">
                        <label for="email">
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ $email ?? old('email') }}" placeholder="Enter your email address"
                                autocomplete="email" required autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">
                            New Password
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input id="password" type="password"
                                class="form-control @error('password') is-invalid @enderror" name="password"
                                placeholder="Enter your new password" autocomplete="new-password" required>
                            <button type="button" class="password-toggle" id="passwordToggle"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye" id="passwordEye"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password-confirm">
                            Confirm Password
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input id="password-confirm" type="password" class="form-control"
                                name="password_confirmation" placeholder="Confirm your new password"
                                autocomplete="new-password" required>
                            <button type="button" class="password-toggle" id="confirmPasswordToggle"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye" id="confirmPasswordEye"></i>
                            </button>
                        </div>
                    </div>
                    <button type="submit" class="reset-button">
                        <i class="fa-solid fa-key"></i>
                        <span style="margin-left: 8px;">Reset Password</span>
                    </button>
                </form>
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span style="margin-left: 8px;">Back to Login</span>
                </a>
                <div class="reset-footer">
                    Secure password recovery protected by
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