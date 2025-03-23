<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
   <link rel="stylesheet" href="{{ asset('static/style.css') }}">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>
<body>
<div class="container">
    <div class="form-box register">
        <form action="{{ url('register') }}" method="POST">
            @csrf
            <h1>Registration</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="input-box">
            <input type="text"  placeholder="firstname" name="Firstname" required >
            <i class='bx bx-user'></i>
            </div>
            
            <div class="input-box">
            <input type="text"  placeholder="lastname" name="Lastname" required >
            <i class='bx bx-user'></i>
            </div>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email" required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class= "user_role">
                <select name="role" id="role" required>
                    <option value="" >Select profession </option>
                    <option value="Admin">Admin</option>
                    <option value="Professor">Prof</option>
                    <option value="Student">Etudiant</option>
                </select>
            </div>
            <div class="input-box">
                <input type="password" name="password" placeholder="Mot de passe" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            
            <button type="submit" class="btn">Register</button>
            <p>or register with social network</p>
            <div class="social-icons">
                <a href=" "><i class='bx bxl-google'></i></a>
                <a href=""><i class='bx bxl-facebook'></i></a>
                <a href=""><i class='bx bxl-github'></i></a>
            </div>
        </form>
    </div>
    <div class="toggle-box">
        <div class="toggle-panel toggle-left">
            <h1>Hi, welcome</h1>
            <p>You don't have an account</p>
            <button class="btn register-btn">
             Register
            </button>
        </div>

        
        <div class="toggle-panel toggle-right">
            
        </div>
    </div>
  </div>  
  
  <script >
    const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn'); 
const loginBtn = document.querySelector('.login-btn');  
    registerBtn.addEventListener('click', () => {
        container.classList.add('active');
    });

    loginBtn.addEventListener('click', () => {
        container.classList.remove('active');
    });
 
  </script>
</body>
</html>
