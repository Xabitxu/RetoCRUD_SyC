<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="styles/login.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    
</head>

<body class="background">
    <div class="glass-container">
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

        <?php if (!empty($_SESSION['flash'])): $flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <script>
                alert(<?php echo json_encode($flash); ?>);
            </script>
        <?php endif; ?>
    <form action="../api/auth.php" method="post">
            <div class="contenedor-input">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" required>
            </div>
            <div class="contenedor-input">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="labels">
                <div class="contenedor-input">
                    <button type="submit" name="accion" value="login" id="login">Login</button>
                </div>
                <div class="contenedor-input">
                    <a href="signUp.php" class="button-link" id="signup-link">Sign Up</a>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="../javaScript/auth.js"></script>
</html>
