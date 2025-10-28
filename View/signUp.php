<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="styles/signUp.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
</head>

<body class="background">
    <div class="glass-container">
        <?php if (!empty($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <script>
                alert(<?php echo json_encode($flash); ?>);
            </script>
        <?php endif; ?>
        <div class="header-icon">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                <g id="SVGRepo_iconCarrier">
                    <path
                        d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z"
                        stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#000000"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </g>
            </svg>
        </div>

    <form action="../api/auth.php" method="post">
            <div class="contenedor-input">
                <input type="email" id="email" name="email" required placeholder="Email">
            </div>
            <div class="contenedor-input">
                <input type="text" id="username" name="username" required placeholder="Username">
            </div>
            <div class="contenedor-input">
                <input type="password" id="password" name="password" required placeholder="Password">
            </div>
            <div class="contenedor-input">
                <input type="password" id="confirm_pass" name="confirm_pass" required placeholder="Confirm Password">
            </div>
            <div class="contenedor-input">
                <input type="text" id="name" name="name" required placeholder="Name">
            </div>
            <div class="contenedor-input">
                <input type="text" id="surname" name="surname" required placeholder="Surname">
            </div>
            <div class="contenedor-input">
                <input type="tel" id="telephone" name="telephone" required placeholder="Telephone">
            </div>
            <div class="contenedor-input">
                <input type="text" id="card" name="card" required placeholder="Card Number">
            </div>
            <div class="contenedor-input">
                <select id="gender" name="gender" required>
                    <option value="" selected hidden>Gender</option>
                    <option value="female">Female</option>
                    <option value="male">Male</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="labels">
                <div class="contenedor-input">
                    <button type="submit" name="accion" value="signup" id="signup">Sign Up</button>
                </div>
                <div class="contenedor-input">
                    <a href="login.php" class="button-link" id="login">Login</a>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="../javaScript/auth.js"></script>
</html>
