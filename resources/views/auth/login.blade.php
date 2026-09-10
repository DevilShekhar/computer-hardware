<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - {{ config('app.name', 'Metaverse') }}</title>
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
    .login-page {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px 20px;
        position: relative;
        background-image: linear-gradient(rgba(4, 12, 24, 0.72),
            rgba(4, 12, 24, 0.72)),
        url('{{ asset('assets/frontend/assets/images/login-bg.png') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        background-attachment: fixed;
    }
    .login-container {
        width: 100%;
        max-width: 1050px;
        min-height: 620px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        overflow: hidden;
        background: #ffffff;
        border-radius: 8px;
        box-shadow:0 20px 60px rgba(0, 0, 0, 0.13);
    }
    .login-left {
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
    .login-left::before {
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
    .login-left::after {
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
    .login-brand {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 55px;
    }
    .login-brand-icon {
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
    .login-brand-name {
        color: #ffffff;
        font-size: 23px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }
    .login-left h1 {
        position: relative;
        z-index: 3;
        margin-bottom: 20px;
        color: #ffffff;
        font-size: 42px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.5px;
    }
    .login-left h1 span {
        color: #f20d0d;
    }
    .login-left-description {
        position: relative;
        z-index: 3;
        max-width: 430px;
        margin-bottom: 38px;
        color: #aebed2;
        font-size: 14px;
        line-height: 1.8;
    }
    .login-features {
        position: relative;
        z-index: 3;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 20px;
    }
    .login-feature {
        display: flex;
        align-items: center;
        gap: 11px;
        color: #d8e4f2;
        font-size: 13px;
        font-weight: 500;
    }
    .login-feature-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 5px;
        background:
            rgba(242, 13, 13, 0.15);
        color: #ff3b3b;
        font-size: 14px;
    }
    .login-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px 30px;
        background: #ffffff;
    }
    .login-heading {
        margin-bottom: 35px;
    }
    .login-heading h2 {
        margin-bottom: 9px;
        color: #222222;
        font-size: 31px;
        line-height: 1.2;
        font-weight: 700;
    }
    .login-heading p {
        color: #777777;
        font-size: 14px;
        line-height: 1.6;
    }
    .form-group {
        margin-bottom: 22px;
    }
    .form-group label {
        display: block;
        margin-bottom: 9px;
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
        height: 52px;
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
    .form-control:focus+.password-toggle {
        color: #f20d0d;
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
    .login-options {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-top: 5px;
        margin-bottom: 27px;
    }
    .remember-me {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #777777;
        font-size: 13px;
        cursor: pointer;
        user-select: none;
    }
    .remember-me input {
        width: 15px;
        height: 15px;
        margin: 0;
        accent-color: #f20d0d;
        cursor: pointer;
    }
    .forgot-password {
        color: #f20d0d;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        transition: 0.2s;
    }
    .forgot-password:hover {
        color: #c90000;

        text-decoration: underline;
    }
    .login-button {
        width: 100%;
        height: 52px;
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
    .login-button:hover {
        background: #d90808;
        transform: translateY(-1px);
        box-shadow:
            0 10px 25px rgba(242, 13, 13, 0.28);
    }
    .login-button:active {
        transform: translateY(0);
    }
    .login-footer {
        margin-top: 30px;
        padding-top: 22px;
        border-top: 1px solid #eeeeee;
        color: #999999;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
    }
    .login-footer strong {
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
        .login-container {
            max-width: 650px;
            grid-template-columns: 1fr;
        }
        .login-left {
            min-height: 390px;
            padding: 45px;
        }
        .login-left h1 {
            font-size: 36px;
        }
        .login-right {
            padding: 50px;
        }
    }
    @media (max-width: 576px) {
        .login-page {
            padding: 15px;
        }
        .login-container {
            border-radius: 5px;
        }
        .login-left {
            min-height: auto;
            padding: 35px 25px;
        }
        .login-brand {
            margin-bottom: 35px;
        }
        .login-brand-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }
        .login-brand-name {
            font-size: 19px;
        }
        .login-left h1 {
            font-size: 29px;
            line-height: 1.2;
            margin-bottom: 15px;
        }
        .login-left-description {
            margin-bottom: 25px;
            font-size: 13px;
            line-height: 1.7;
        }
        .login-features {
            grid-template-columns: 1fr;
            gap: 10px;
        }
        .login-feature {
            font-size: 12px;
        }
        .login-feature-icon {
            width: 30px;
            height: 30px;
        }
        .login-right {
            padding: 35px 25px;
        }
        .login-heading {
            margin-bottom: 28px;
        }
        .login-heading h2 {
            font-size: 27px;
        }
        .login-heading p {
            font-size: 13px;
        }
        .login-options {
            gap: 10px;
        }
    }
    @media (max-width: 380px) {
        .login-left {
            padding: 30px 20px;
        }
        .login-right {
            padding: 30px 20px;
        }
        .login-left h1 {
            font-size: 26px;
        }
        .login-options {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    .register-button {
        width: 100%;
        height: 52px;
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
        cursor: pointer;
        transition: all 0.25s ease;
    }
    .register-button:hover {
        background: #f20d0d;
        color: #ffffff;
        box-shadow: 0 7px 18px rgba(242, 13, 13, 0.20);
    }
    .login-heading {
        margin-bottom: 35px;
        text-align: center;
    }

    .login-heading .register-logo {
        display: block;
        width: auto;
        max-width: 190px;
        height: auto;
        margin: 0 auto 25px;
        object-fit: contain;
    }

    .login-heading h2 {
        margin-bottom: 9px;
        color: #222222;
        font-size: 31px;
        line-height: 1.2;
        font-weight: 700;
    }

    .login-heading p {
        color: #777777;
        font-size: 14px;
        line-height: 1.6;
    }

    </style>
</head>
<body>
    <div class="top-theme-line"></div>
    <main class="login-page">
        <div class="login-container">
            <section class="login-left">
                <div class="tech-grid"></div>
                <div class="login-brand">
                    <div class="login-brand-icon">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div class="login-brand-name">
                        Metaverse
                    </div>
                </div>
                <h1>
                    Power Your
                    <span>Setup.</span>
                    <br>
                    Build Your Future.
                </h1>
                <p class="login-left-description"> Access your account and explore premium computer  hardware, components, accessories and everything   you need to build the perfect setup. </p>
                <div class="login-features">
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-microchip"></i>
                        </div>
                        <span>
                            Premium Components
                        </span>
                    </div>
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span>
                            Secure Shopping
                        </span>
                    </div>
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-truck-fast"></i>
                        </div>
                        <span>
                           Fast Delivery
                        </span>
                    </div>
                    <div class="login-feature">
                        <div class="login-feature-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span>
                            Expert Support
                        </span>
                    </div>
                </div>
            </section>
            <section class="login-right">
                <div class="login-heading">
                  
                    <img
                        src="{{ asset('assets/frontend/assets/images/menu/logo/logo.png') }}"
                        alt="{{ config('app.name', 'Metaverse') }}"
                        class="register-logo"
                    >
                
                    <h2>Welcome Back  </h2>
                    <p>Sign in to continue to your account.</p>
                </div>
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror"
                                placeholder="Enter your email address" autocomplete="email" required autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">
                            Password
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock input-icon"></i>
                            <input id="password" type="password" name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Enter your password" autocomplete="current-password" required>
                            <button type="button" class="password-toggle" id="passwordToggle"
                                aria-label="Show password">
                                <i class="fa-solid fa-eye" id="passwordEye"></i>
                            </button>
                        </div>
                        @error('password')
                        <span class="invalid-feedback">
                            <strong>
                                {{ $message }}
                            </strong>
                        </span>
                        @enderror
                    </div>
                    <div class="login-options">
                        <label class="remember-me" for="remember">
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <span>
                                Remember Me
                            </span>
                        </label>
                        @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-password">
                            Forgot Password?
                        </a>
                        @endif
                    </div>
                    <button type="submit" class="login-button">
                        <i class="fa-solid fa-right-to-bracket"></i>
                        <span style="margin-left: 8px;">
                            Login
                        </span>
                    </button>
                    @if (Route::has('register')) <a href="{{ route('register') }}" class="register-button"> <i class="fa-solid fa-user-plus"></i> <span style="margin-left: 8px;"> Register </span> </a> @endif
                </form>
                <div class="login-footer">
                    Secure login protected by
                    <strong>
                        Metaverse
                    </strong>
                </div>
            </section>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded",
            function() {
                const passwordInput = document.getElementById("password");
                const passwordToggle =  document.getElementById("passwordToggle");
                const passwordEye =  document.getElementById("passwordEye");
                if ( passwordInput && passwordToggle &&  passwordEye) 
                {
                    passwordToggle.addEventListener("click",
                        function() {
                            if (passwordInput.type === "password") {
                                passwordInput.type = "text";
                                passwordEye.classList.remove("fa-eye");
                                passwordEye.classList.add("fa-eye-slash");
                                passwordToggle.setAttribute("aria-label","Hide password");
                            } else {
                                passwordInput.type = "password";
                                passwordEye.classList.remove("fa-eye-slash");
                                passwordEye.classList.add("fa-eye");
                                passwordToggle.setAttribute("aria-label","Show password");
                            }
                        }
                    );
                }
            }
        );
    </script>
</body>
</html>