<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles/delete.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ModifyUser</title>
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
        <h1>MODIFY USER</h1>
    <form id="modifyForm" action="../api/modify.php" method="post">
            <div class="contenedor-input">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($_SESSION['user']['email'] ?? '') ?>" readonly required>
            </div>
            <div class="contenedor-input">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" value="<?= htmlspecialchars($_SESSION['user']['username'] ?? '') ?>" readonly>
            </div>
            <div class="contenedor-input">
                <label for="telephone">Telephone</label>
                <input type="text" id="telephone" name="telephone" value="<?= htmlspecialchars($_SESSION['user']['telephone'] ?? '') ?>" required>
            </div>
            <div class="contenedor-input">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password">
            </div>

            <div class="contenedor-input">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" id="confirm_password" name="confirm_password">
            </div>

            <div class="labels">
                <div class="contenedor-input">
                    <button type="submit" id="modify" name="accion" value="modify">Save changes</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="../javaScript/modifyUser.js"></script>
</html>