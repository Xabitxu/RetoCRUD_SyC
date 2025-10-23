<?php session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="styles/menu.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>

<body class="background">
    <header>
        <h1>WELCOME TO OUR WEB!</h1>
    </header>
    <nav class="texto-centrado">
        <?php if (!empty($_SESSION['user'])): ?>
            <span>Hola, <?php echo htmlspecialchars($_SESSION['user']['username']); ?></span>
            <a href="../api/logout.php" class="hover-text">Logout</a>
            <a href=./modify.html class="hover-text">ModifyUser</a>
            <a href=./delete.html class="hover-text">DeleteUser</a>
    </nav>
    <main class="glass-container">
        <p></p>
    </main>
<?php else: ?>
    <a href="./login.php" class="hover-text">LogIn</a>
    <a href="./signUp.php" class="hover-text">SignUp</a>
<?php endif; ?>
</nav>

</body>

</html>