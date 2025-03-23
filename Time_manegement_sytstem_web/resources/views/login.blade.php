<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
<link rel="stylesheet" href="{{ asset('static/style.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
<div class="container">
    <div class="form-box Login">
        <form action="{{ url('admin') }}" method='POST'>
            @csrf
            <h1>Login</h1>
            <div class="input-box">
                <input type="email"  placeholder="Username" name="email" required>
                <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="forgot-link">
                <a href="">forgot password ?</a>
            </div>
            <button type="submit" class="btn">Login</button>
            <p>or login with social network </p>
            <div class="social-icons">
                <a href=" "><i class='bx bxl-google'></i></a>
                <a href=""><i class='bx bxl-facebook'></i></a>
                <a href=""><i class='bx bxl-github'></i></a>
            </div>
        </form>
    </div>
</body>
</html>  
