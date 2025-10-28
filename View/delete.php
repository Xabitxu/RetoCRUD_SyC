<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles/delete.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DeleteUser</title>
</head>

<body class="background">
    <nav class="texto-centrado">
        <a href="./login.php" class="hover-text">LogIn</a>
        <a href="./signUp.php" class="hover-text">SignUp</a>
        <a href="./modify.php" class="hover-text">ModifyUser</a>
        <a href="./delete.php" class="hover-text">DeleteUser</a>
    </nav>
    <div class="glass-container">
    <a href="./menu.php" class="hover-text">Go back</a>
        <h1>DELETE USER</h1>
    <form id="deleteForm" action="../api/delete.php" method="post">
            <div class="contenedor-input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" readonly>
            </div>
            <div class="contenedor-input">
                <label for="username">Username</label>
                <!-- usamos la clave 'username' que guarda auth.php -->
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>" readonly>
            </div>
            <div class="contenedor-input">
                <button type="submit" id="delete" name="accion" value="delete">Delete Account</button>
            </div>
        </form>
    </div>
</body>
<script src="../javaScript/deleteUser.js"></script>
</html>