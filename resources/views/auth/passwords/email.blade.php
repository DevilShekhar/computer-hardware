<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - {{ config('app.name', 'Metaverse') }}</title>

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

    .forgot-page {
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

    .forgot-container {
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

    .forgot-left {
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

    .forgot-left::before {
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

    .forgot-left::after {
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

    .forgot-brand {
        position: relative;
        z-index: 3;
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 55px;
    }

    .forgot-brand-icon {
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

    .forgot-brand-name {
        color: #ffffff;
        font-size: 23px;
        font-weight: 700;
        letter-spacing: 0.5px;
    }

    .forgot-left h1 {
        position: relative;
        z-index: 3;
        margin-bottom: 20px;
        color: #ffffff;
        font-size: 42px;
        line-height: 1.15;
        font-weight: 800;
        letter-spacing: -0.5px;
    }

    .forgot-left h1 span {
        color: #f20d0d;
    }

    .forgot-left-description {
        position: relative;
        z-index: 3;
        max-width: 430px;
        margin-bottom: 38px;
        color: #aebed2;
        font-size: 14px;
        line-height: 1.8;
    }

    .forgot-features {
        position: relative;
        z-index: 3;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px 20px;
    }

    .forgot-feature {
        display: flex;
        align-items: center;
        gap: 11px;
        color: #d8e4f2;
        font-size: 13px;
        font-weight: 500;
    }

    .forgot-feature-icon {
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

    .forgot-right {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 20px 20px;
        background: #ffffff;
    }

    .forgot-logo-wrapper {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 25px;
    }

    .forgot-logo {
        max-width: 190px;
        width: auto;
        height: auto;
        display: block;
        object-fit: contain;
    }

    .forgot-heading {
        text-align: center;
        margin-bottom: 30px;
    }

    .forgot-heading h2 {
        margin-bottom: 9px;
        color: #222222;
        font-size: 31px;
        line-height: 1.2;
        font-weight: 700;
    }

    .forgot-heading p {
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

    .invalid-feedback {
        display: block;
        margin-top: 6px;
        color: #dc3545;
        font-size: 12px;
        line-height: 1.5;
    }

    .status-message {
        width: 100%;
        margin-bottom: 18px;
        padding: 11px 14px;
        border: 1px solid #b7e4c7;
        border-radius: 4px;
        background: #d1e7dd;
        color: #0f5132;
        font-size: 13px;
        line-height: 1.5;
    }

    .forgot-button {
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

    .forgot-button:hover {
        background: #d90808;
        transform: translateY(-1px);
        box-shadow: 0 10px 25px rgba(242, 13, 13, 0.28);
    }

    .forgot-button:active {
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

    .forgot-footer {
        margin-top: 22px;
        padding-top: 18px;
        border-top: 1px solid #eeeeee;
        color: #999999;
        font-size: 12px;
        line-height: 1.6;
        text-align: center;
    }

    .forgot-footer strong {
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
        .forgot-container {
            max-width: 650px;
            grid-template-columns: 1fr;
        }

        .forgot-left {
            min-height: 390px;
            padding: 45px;
        }

        .forgot-left h1 {
            font-size: 36px;
        }

        .forgot-right {
            padding: 50px;
        }
    }

    @media (max-width: 576px) {
        .forgot-page {
            padding: 15px;
        }

        .forgot-container {
            border-radius: 5px;
        }

        .forgot-left {
            min-height: auto;
            padding: 35px 25px;
        }

        .forgot-brand {
            margin-bottom: 35px;
        }

        .forgot-brand-icon {
            width: 48px;
            height: 48px;
            font-size: 20px;
        }

        .forgot-brand-name {
            font-size: 19px;
        }

        .forgot-left h1 {
            font-size: 29px;
            line-height: 1.2;
            margin-bottom: 15px;
        }

        .forgot-left-description {
            margin-bottom: 25px;
            font-size: 13px;
            line-height: 1.7;
        }

        .forgot-features {
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .forgot-feature {
            font-size: 12px;
        }

        .forgot-feature-icon {
            width: 30px;
            height: 30px;
        }

        .forgot-right {
            padding: 35px 25px;
        }

        .forgot-logo {
            max-width: 155px;
            max-height: 55px;
        }

        .forgot-heading {
            margin-bottom: 25px;
        }

        .forgot-heading h2 {
            font-size: 27px;
        }

        .forgot-heading p {
            font-size: 13px;
        }
    }

    @media (max-width: 380px) {
        .forgot-left {
            padding: 30px 20px;
        }

        .forgot-right {
            padding: 30px 20px;
        }

        .forgot-left h1 {
            font-size: 26px;
        }
    }
    </style>
</head>
<body>
    <div class="top-theme-line"></div>
    <main class="forgot-page">
        <div class="forgot-container">
            <section class="forgot-left">
                <div class="tech-grid"></div>
                <div class="forgot-brand">
                    <div class="forgot-brand-icon">
                        <i class="fa-solid fa-microchip"></i>
                    </div>
                    <div class="forgot-brand-name">
                        Metaverse
                    </div>
                </div>
                <h1>
                    Forgot Your
                    <span>Password?</span>
                    <br>
                    Recover Your Account.
                </h1>
                <p class="forgot-left-description">
                    Don't worry. Enter your registered email address and we'll
                    send you a secure password reset link so you can quickly
                    get back to your Metaverse account.
                </p>
                <div class="forgot-features">
                    <div class="forgot-feature">
                        <div class="forgot-feature-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <span>Reset Link by Email</span>
                    </div>
                    <div class="forgot-feature">
                        <div class="forgot-feature-icon">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <span>Secure Recovery</span>
                    </div>
                    <div class="forgot-feature">
                        <div class="forgot-feature-icon">
                            <i class="fa-solid fa-key"></i>
                        </div>
                        <span>Easy Password Reset</span>
                    </div>
                    <div class="forgot-feature">
                        <div class="forgot-feature-icon">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <span>Expert Support</span>
                    </div>
                </div>
            </section>
            <section class="forgot-right">
                <div class="forgot-logo-wrapper">
                    <img src="{{ asset('assets/frontend/assets/images/menu/logo/logo.png') }}"
                        alt="{{ config('app.name', 'Metaverse') }}" class="forgot-logo">
                </div>
                <div class="forgot-heading">
                    <h2>Forgot Password</h2>
                    <p>Enter your email to receive a password reset link.</p>
                </div>
                @if (session('status'))
                <div class="status-message" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label for="email">
                            Email Address
                        </label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope input-icon"></i>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                name="email" value="{{ old('email') }}" placeholder="Enter your email address"
                                autocomplete="email" required autofocus>
                        </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <button type="submit" class="forgot-button">
                        <i class="fa-solid fa-paper-plane"></i>
                        <span style="margin-left: 8px;">
                            Send Password Reset Link
                        </span>
                    </button>
                </form>
                <a href="{{ route('login') }}" class="login-link">
                    <i class="fa-solid fa-right-to-bracket"></i>
                    <span style="margin-left: 8px;">
                        Back to Login
                    </span>
                </a>
                <div class="forgot-footer">
                    Secure password recovery protected by
                    <strong>Metaverse</strong>
                </div>
            </section>
        </div>
    </main>
</body>
</html>