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
    <main class="glass-container">
        <div style="display: flex; justify-content: space-between; align-items: center;">

            <div class="vertical-info">
                <p><strong>Username:</strong> <?= htmlspecialchars($_SESSION['user']['username'] ?? 'N/A') ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION['user']['email'] ?? 'N/A') ?></p>
                <p><strong>Name:</strong> <?= htmlspecialchars($_SESSION['user']['name'] ?? 'N/A') ?></p>
                <p><strong>Surname:</strong> <?= htmlspecialchars($_SESSION['user']['surname'] ?? 'N/A') ?></p>
                <p><strong>Telephone:</strong> <?= htmlspecialchars($_SESSION['user']['telephone'] ?? 'N/A') ?></p>
            </div>

            <div class="vertical-links" style="text-align: left;">
                <a href="./modify.php" class="hover-text" style="background-color: rgba(95, 95, 255, 1);">Modify User</a>
                <a href="./delete.php" class="hover-text" style="background-color: rgba(255, 95, 95, 1);">Delete User</a>
            </div>


        </div>

    </main>

    </nav>

</body>

</html>