<?php
session_start();

if (!isset($_SESSION["connected"]) || $_SESSION["connected"] !== true) {
    header("location: login.php");
    exit;
}
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/home.css">
    <title>home</title>
</head>


<body>
    <div class="login-page">
        <div class="form">
            <form class="login-form">
                <h1>Salut<?php echo "&nbsp", htmlspecialchars($_SESSION["login"]); ?> ! Bienvenue sur ta page.</h1>
                <!-- <p><a href="logout.php">Se déconnecter</a></p> -->
                <button class="btn"><a href="logout.php">Se déconnecter</a></button>
            </form>
        </div>
    </div>
</body>
<script src="../js/script.js"></script>

</html>