<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    @include('admin.header')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> <!-- Link to external CSS file -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: 100%;
            background-color: #B0BEC5;
            background-repeat: no-repeat;
        }
        
        .card0 {
            box-shadow: 0px 4px 8px 0px #757575;
            border-radius: 0px;
        }
        
        .card2 {
            margin: 0px 40px;
        }
        
        .welcome-message {
            font-size:34px; /* Larger font size */
            font-weight: bold;
            font-family: 'Arial Black', Arial, sans-serif;
            color: #3366FF; /* Example color: Deep Orange */
            text-align: center;
            margin-bottom: 40px;
            margin-top: 30px;   
        }
        .image {
             width: 650px;
             height: auto px;
        }
        
        
        .border-line {
            border-right: 1px solid #EEEEEE;
        }

       
        .line {
            height: 1px;
            width: 45%;
            background-color: #E0E0E0;
            margin-top: 10px;
        }
       
        .text-sm {
            font-size: 14px !important;
        }
        
        ::placeholder {
            color: #BDBDBD;
            opacity: 1;
            font-weight: 300;
        }
        
        :-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300;
        }
        
        ::-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300;
        }
        
        input, textarea, select {
            padding: 10px 12px;
    border: 1px solid lightgrey;
    border-radius: 2px;
    margin-bottom: 15px; /* Jarak antar form elemen */
    width: 100%;
    box-sizing: border-box;
    color: #2C3E50;
    font-size: 14px;
    letter-spacing: 1px;
        }
        
        input:focus, textarea:focus {
            box-shadow: none;
            border: 1px solid #304FFE;
            outline-width: 0;
        }
        
        button:focus {
            box-shadow: none;
            outline-width: 0;
        }
        
        a {
            color: inherit;
            cursor: pointer;
        }
        
        .btn-blue {
            background-color: #3399ff;
            width: 150px;
            color: #fff;
            border-radius: 2px;
        }
        
        .btn-blue:hover {
            background-color: #000; /* Updated hover color */
            cursor: pointer;
        }
        
        .bg-blue {
            color: #fff;
            background-color: #3399ff;
        }
        
        @media screen and (max-width: 991px) {
        
            .border-line {
                border-right: none;
            }
        
            .card2 {
                border-top: 1px solid #EEEEEE !important;
                margin: 0px 15px;
            }
        }

    </style>

</head>
<body>
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/home" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
    <img src="img/logo.png" alt="" style="width: 100px; height: auto;;">
        <h2 class="m-0 text-primary ms-0">DISKOMINFO</h2>
    </a>
    </nav>
     <form method="POST" action="{{ route('login.post') }}">
      @csrf
        <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
        <x-validation-errors class="mb-4" />
            <div class="card card0 border-0">
                <div class="row d-flex">
                    <div class="col-lg-6">
                        <div class="card1 pb-5">
                        <div class="row">
                        <img src="" class="logo">
                    </div>
                            <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                             <div class="welcome-message">Login now !</div>
                           
                                <img src="img/log.jpg" alt="Logo" class="image">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card2 card border-0 px-4 py-5">
                            <div class="row mb-4 px-3">
                                <h6 class="mb-0 mr-8 mt-6">Sign In</h6>
                                
                            </div>
                            <div class="row px-3">
                                <label class="mb-1"><h6 class="mb-0 text-sm">Email Address</h6></label>
                                <input class="mb-4" type="email" name="email" placeholder="Enter a valid email address" required autofocus autocomplete="username">
                            </div>

                            <div class="row px-3">
                                <label class="mb-1"><h6 class="mb-0 text-sm">Password</h6></label>
                                <input type="password" name="password" placeholder="Enter password" required autocomplete="current-password">
                            </div>

                            <!-- Captcha -->
                            <div class="mb-3">
                                <img id="captcha-image" src="{{ captcha_src() }}" alt="Captcha Image">
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" name="captcha" class="form-control" placeholder="Enter Captcha" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" onclick="refreshCaptcha()">Refresh</button>
                                </div>
                            </div>

                            <div class="row px-3 mb-4">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input id="chk1" type="checkbox" name="chk" class="custom-control-input">
                                    <label for="chk1" class="custom-control-label text-sm">Remember me</label>
                                </div>
                                <a href="{{ route('password.request') }}" class="ml-auto mb-0 text-sm">Forgot Password ?</a>
                            </div>
                            <div class="row mb-3 px-3">
                                <button type="submit" class="btn btn-blue text-center">Login</button>
                            </div>
                            <div class="row mb-4 px-3">
                                <small class="font-weight-bold">Don't have an account ? <a class="text-danger" href="{{ route('register') }}">Register</a></small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-blue py-4">
                <div class="container text-center">
                    <div class="row justify-content-center align-items-center">
                        <small class="ml-4 ml-sm-5 mb-2">Copyright &copy; 2024. All rights reserved.</small>  
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

<script>
        function refreshCaptcha() {
            var captchaImage = document.getElementById('captcha-image');
            captchaImage.src = '{{ captcha_src() }}?' + new Date().getTime();
        }
        $(document).ready(function() {
            @if ($errors->has('captcha'))
                $('#captcha-error').text('{{ $errors->first('captcha') }}').show();
            @endif
        });
    </script>
</html>
