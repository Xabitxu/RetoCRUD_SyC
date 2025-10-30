<?php session_start();
if (empty($_SESSION['user'])) {
    header('Location: ./login.php');
    exit();
}
?>
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
        <span style="border-right:1px solid #000;height:25px">

            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="width: 25px; height: 25px; position: relative; top: 5px; ">
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
            <?php echo htmlspecialchars($_SESSION['user']['username']); ?>
        </span>

        <a href="../api/logout.php" class="hover-text">Logout</a>




    </nav>

    <div class="glass-container">
        <a href="./menu.php" class="hover-text">
            <svg width="20" height="15" viewBox="0 0 24 24">
                <path fill="#000000" d="M4.4 7.4L6.8 4h2.5L7.2 7h6.3a6.5 6.5 0 0 1 0
            13H9l1-2h3.5a4.5 4.5 0 1 0 0-9H7.2l2.1 3H6.8L4.4 8.6L4 8z" />
            </svg> Go back</a>
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