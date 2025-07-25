<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Login & Register | Social Media</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            position: relative;
            overflow: hidden;
            width: 1300px;
            max-width: 98vw;
            min-height: 800px;
            padding: 30px 0;
        }

        .container p {
            font-size: 14px;
            line-height: 20px;
            letter-spacing: 0.3px;
            margin: 20px 0;
            color: #666;
        }

        .container span {
            font-size: 13px;
            color: #666;
        }

        .container a {
            color: #667eea;
            font-size: 13px;
            text-decoration: none;
            margin: 15px 0 10px;
            transition: color 0.3s ease;
        }

        .container a:hover {
            color: #764ba2;
        }

        .container button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            font-size: 13px;
            padding: 12px 45px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-top: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .container button.hidden {
            background: transparent;
            border: 2px solid #fff;
        }

        .container form {
            background-color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            height: 100%;
        }

        .container input {
            background-color: #f5f5f5;
            border: none;
            margin: 8px 0;
            padding: 12px 18px;
            font-size: 14px;
            border-radius: 50px;
            width: 100%;
            outline: none;
            transition: all 0.3s ease;
            color: #333;
        }

        .container input::placeholder {
            color: #999;
        }

        .container input:focus {
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.4);
            background-color: #fff;
            border: 1px solid #667eea;
        }

        .form-container {
            position: absolute;
            top: 0;
            height: 100%;
            transition: all 0.6s ease-in-out;
            padding: 0;
        }

        .sign-in {
            left: 0;
            width: 50%;
            z-index: 2;
        }

        .container.active .sign-in {
            transform: translateX(100%);
        }

        .sign-up {
            left: 0;
            width: 50%;
            opacity: 0;
            z-index: 1;
        }

        .container.active .sign-up {
            transform: translateX(100%);
            opacity: 1;
            z-index: 5;
            animation: move 0.6s;
        }

        @keyframes move {
            0%, 49.99% {
                opacity: 0;
                z-index: 1;
            }
            50%, 100% {
                opacity: 1;
                z-index: 5;
            }
        }

        .social-icons {
            margin: 20px 0;
            display: flex;
            gap: 15px;
        }

        .social-icons a {
            border: 1px solid #ddd;
            border-radius: 50%;
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 45px;
            height: 45px;
            transition: all 0.3s ease;
        }

        .social-icons a:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .icon i {
            font-size: 20px;
        }

        .icon .fa-google {
            color: #DB4437;
        }

        .icon .fa-facebook {
            color: #4267B2;
        }

        .icon .fa-github {
            color: #333;
        }

        .icon .fa-linkedin {
            color: #0077B5;
        }

        .toggle-container {
            position: absolute;
            top: 0;
            left: 50%;
            width: 50%;
            height: 100%;
            overflow: hidden;
            transition: all 0.6s ease-in-out;
            border-radius: 150px 0 0 100px;
            z-index: 1000;
        }

        .container.active .toggle-container {
            transform: translateX(-100%);
            border-radius: 0 150px 100px 0;
        }

        .toggle {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100%;
            color: #fff;
            position: relative;
            left: -100%;
            height: 100%;
            width: 200%;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .container.active .toggle {
            transform: translateX(50%);
        }

        .toggle-panel {
            position: absolute;
            width: 50%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            padding: 0 40px;
            text-align: center;
            top: 0;
            transform: translateX(0);
            transition: all 0.6s ease-in-out;
        }

        .toggle-left {
            transform: translateX(-200%);
        }

        .container.active .toggle-left {
            transform: translateX(0);
        }

        .toggle-right {
            right: 0;
            transform: translateX(0);
        }

        .container.active .toggle-right {
            transform: translateX(200%);
        }

        .image-upload-container {
            width: 100%;
            max-width: 350px;
            margin: 15px auto;
            text-align: center;
        }

        .image-upload-label {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            background-color: #f5f5f5;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 8px 0;
            min-height: 48px;
        }

        .image-upload-label:hover {
            background-color: #eee;
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .image-upload-label i {
            font-size: 20px;
            color: #667eea;
            margin-right: 10px;
            margin-bottom: 0;
            transition: all 0.3s ease;
        }

        .image-upload-label:hover i {
            transform: scale(1.05);
        }

        .image-upload-label p {
            margin: 0;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }

        .image-upload-label.image-selected {
            background-color: #e6ffe6;
            border: 1px solid #4CAF50;
            color: #4CAF50;
        }

        .image-upload-label.image-selected i {
            color: #4CAF50;
        }

        .image-upload-label.image-selected p {
            color: #4CAF50;
        }

        .image-upload-label:hover.image-selected {
            background-color: #d9ffd9;
            box-shadow: 0 3px 8px rgba(76, 175, 80, 0.2);
        }

        .image-upload-input {
            display: none;
        }

        h1 {
            font-weight: 600;
            margin: 0;
            color: #333;
            font-size: 28px;
        }

        .toggle-panel h1 {
            color: #fff;
            font-size: 32px;
            margin-bottom: 15px;
        }

        .toggle-panel p {
            color: #fff;
            font-size: 15px;
            line-height: 1.5;
            margin: 20px 0 30px;
        }

        .error-message {
            color: #ff4757;
            font-size: 12px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .container {
                min-height: 800px;
            }
            
            .form-container {
                width: 100%;
            }
            
            .toggle-container {
                display: none;
            }
            
            .sign-up {
                transform: translateX(100%);
            }
            
            .container.active .sign-up {
                transform: translateX(0);
            }
            
            .container.active .sign-in {
                transform: translateX(-100%);
            }
        }

        .input-group {
            position: relative;
            width: 100%;
            margin-bottom: 10px;
        }
        .input-icon {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #667eea;
            font-size: 16px;
            z-index: 2;
        }
        .input-group input {
            padding-left: 45px !important;
        }
    </style>
</head>

<body>
    <div class="container" id="container">
        <div class="form-container sign-up">
            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if ($errors->has('general'))
                    <div class="error-message" style="color: #ff4757; margin-bottom: 10px;">
                        {{ $errors->first('general') }}
                    </div>
                @endif
                <h1>Create Account</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fab fa-github"></i></a>
                    <a href="#" class="icon"><i class="fab fa-linkedin"></i></a>
                </div>
                <span>or use your email for registration</span>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-user"></i></span>
                    <input type="text" name="name" placeholder="Name" required />
                </div>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-envelope"></i></span>
                    <input type="email" name="email" placeholder="Email" required />
                </div>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-phone"></i></span>
                    <input type="tel" name="phone_number" placeholder="Phone Number" required />
                </div>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password" placeholder="Password" required />
                </div>
                <div class="input-group">
                    <span class="input-icon"><i class="fa fa-lock"></i></span>
                    <input type="password" name="password_confirmation" placeholder="Confirm Password" required />
                </div>
                <div class="image-upload-container">
                    <input type="file" id="profile_picture" name="image" accept="image/*" class="image-upload-input" />
                    <label for="profile_picture" class="image-upload-label" id="uploadLabel">
                        <i class="fas fa-cloud-upload-alt" id="uploadIcon"></i>
                        <span id="uploadText">Upload Profile Picture (Optional)</span>
                    </label>
                </div>
                <button type="submit">Sign Up</button>
            </form>
        </div>

        <div class="form-container sign-in">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h1>Sign In</h1>
                <div class="social-icons">
                    <a href="#" class="icon"><i class="fab fa-google"></i></a>
                    <a href="#" class="icon"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="icon"><i class="fab fa-github"></i></a>
                    <a href="#" class="icon"><i class="fab fa-linkedin"></i></a>
                </div>
                <span>or use your email for login</span>
                
                <input id="email" type="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus autocomplete="username">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />

                <input id="password" type="password" name="password" placeholder="Password" required autocomplete="current-password">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />

                <a href="{{ route('password.request') }}">Forgot Your Password?</a>
                <button type="submit">Sign In</button>
            </form>
        </div>

        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-left">
                    <h1>Welcome Back!</h1>
                    <p>Enter your personal details to use all of site features</p>
                    <button class="hidden" id="login">Sign In</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Hello, Friend!</h1>
                    <p>Register with your personal details to use all of site features</p>
                    <button class="hidden" id="register">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const container = document.getElementById('container');
        const registerBtn = document.getElementById('register');
        const loginBtn = document.getElementById('login');
        const imageInput = document.getElementById('profile_picture');
        const uploadLabel = document.getElementById('uploadLabel');
        const uploadIcon = document.getElementById('uploadIcon');
        const uploadText = document.getElementById('uploadText');

        registerBtn.addEventListener('click', () => {
            container.classList.add("active");
        });

        loginBtn.addEventListener('click', () => {
            container.classList.remove("active");
        });

        // Handle image selection
        if (imageInput) {
            imageInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    uploadLabel.classList.add('image-selected');
                    uploadIcon.classList.remove('fa-cloud-upload-alt');
                    uploadIcon.classList.add('fa-check-circle');
                    uploadText.textContent = 'Image Selected (Click to change)';
                } else {
                    uploadLabel.classList.remove('image-selected');
                    uploadIcon.classList.remove('fa-check-circle');
                    uploadIcon.classList.add('fa-cloud-upload-alt');
                    uploadText.textContent = 'Upload Profile Picture (Optional)';
                }
            });
        }
    </script>
</body>
</html>
