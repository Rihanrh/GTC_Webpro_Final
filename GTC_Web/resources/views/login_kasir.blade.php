<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <!-- Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <!--Font Awsome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>
<body>
    
    <div>
        <div class="container-login">
            <div class="heading-text my-5">
                <h2><strong>Selamat Datang, Kasir!</strong></h2>
                <h4>Masukkan Username dan Password kamu. </h4>
            </div>
            <div class="container row">
            @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
            @endif
                <form id="loginForm" action="{{ route('kasir.login') }}" method="post">
                    @csrf
                    <!-- Username Input -->
                        <div>
                            <label for="username" class="label">Username</label>
                            <input class="form-control form-control-lg @error('username_kasir') is-invalid @enderror" 
                            type="username" id="username" name="username_kasir" placeholder="Enter your username">
                            @error('username_kasir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Password Input -->
                        <div class="my-5">
                            <span class="label">Password</span>
                            <input class="form-control form-control-lg @error('password_kasir') is-invalid @enderror" 
                                type="password" id="password" name="password_kasir" placeholder="Enter your password">
                            <i class="fa fa-eye password-toggle"></i> 
                            @error('password_kasir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <!-- Submit Button -->
                        <button type="submit" class="login-button anchor-button">Masuk</button>
                </form>
            </div> 
        </div>
        <div class="image-container">
            <div class="above-image-text">
                <h1><strong>Selamat Datang</strong></h1>
                <h1><strong>kembali!</strong></h1>
            </div>
            <img src="assets/kantin.png" class="img-fluid" alt="Gambar kantin">
        </div>
    </div>
    
    <!-- Bootstrap and JQuery-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <!-- JavaScript Eye Icon-->
    <script>
        $(".password-toggle").click(function () {
            var passwordField = $("#password");
            var icon = $(this); 
    
            var fieldType = passwordField.attr("type");
            if (fieldType === "password") {
                passwordField.attr("type", "text");
                icon.removeClass("fa-eye"); 
                icon.addClass("fa-eye-slash"); 
            } else {
                passwordField.attr("type", "password");
                icon.removeClass("fa-eye-slash"); 
                icon.addClass("fa-eye"); 
            }
        });
    </script>
    
</body>
</html>