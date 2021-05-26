<?php
session_start();

if (isset($_SESSION["connected"]) && $_SESSION["connected"] === true) {
    header("location: home.php");
    exit;
}

require_once "connexion.php"; // même chose qu'un simple "require" à part que PHP vérifie si le fichier a déjà été inclus, et si c'est le cas, ne l'inclut pas une deuxième fois.

$login = $password = ""; // défini les variables qui vont reçevoir le login et le mdp
$login_err = $password_err = ""; // défini les variables qui vont défi d'erreurs

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si l'on a une requete avec la méthode post alor :

    if (empty(trim($_POST["login"]))) { // On vérifie si le login est vide
        $login_err = "*Identifiant vide."; // Si le login est vide on envoie "login vide." dans la variable $login_err
    } else {
        $login = trim($_POST["login"]); // Sinon on envoie le login
    }

    if (empty(trim($_POST["password"]))) { // On vérifie si le mot de passe est vide
        $password_err = "*Mot de passe vide."; // Si il est vide on envoie dans la variable $password_err -> "password vide."
    } else {
        $password = trim($_POST["password"]); // Sinon on envoie le password
    }


    if (empty($login_err) && empty($password_err)) { // Si il n'y a pas d'erreur de login ou password alors :

        $sql = "SELECT id, login, password FROM user WHERE login = ?"; // Selecteur du login

        if ($stmt = mysqli_prepare($conn, $sql)) { // On prépare une requête SQL pour l'exécution avec les deux variables $conn et $sql

            mysqli_stmt_bind_param($stmt, "s", $param_login); // Lie des variables à une requête MySQL avec

            $param_login = $login; // la variable $param_login prend le contenue de la variable $login

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée avec la variable $stmt

                mysqli_stmt_store_result($stmt); // Stock le résultat de la préparation de la requête

                if (mysqli_stmt_num_rows($stmt) == 1) { // Retourne le nombre de lignes d'un résultat MySQL et si il est égale a 1 alors :

                    mysqli_stmt_bind_result($stmt, $id, $login, $hashed_password); //Lie les variables $stmt, $id, $login et $hashed_password en résultat
                    if (mysqli_stmt_fetch($stmt)) { // Lit des résultats depuis une requête MySQL préparée dans des variables liées
                        if (password_verify($password, $hashed_password)) { // Vérifie le password en le hashan et en le comparant

                            session_start(); // démare la session

                            $_SESSION["connected"] = true; // met la session connected a true
                            $_SESSION["id"] = $id; // Créer une session id contenant l'id du client
                            $_SESSION["login"] = $login; // Créer une session avec le login du client

                            header("location: home.php"); // redirige vers la page homme

                            //_______________________ deuxième partie _________________________
                        } else {
                            $password_err = "*Mot de passe incorrect."; // Si le mot de passe est faux alors retourne l'erreur
                        }
                    }
                } else {
                    $login_err = "*Compte inexistant."; // Si aucun compte trouvé
                }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }
    mysqli_close($conn); //  Ferme la connexion
}
?>



<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/login.css">
    <title>login</title>
</head>

<body>
    <div class="login-page">
        <div class="form">
            <form method="POST" class="login-form">
                <h1>Connexion</h1>
                <p> Veuillez remplir vos identifiants pour vous connecter.</p>

                <label>Login:<span><?php echo "&nbsp", "&nbsp", $login_err; ?></span></label>
                <input type="text" name="login" placeholder="Erwan" value="<?php echo $login; ?>">

                <label>Password:<span><?php echo "&nbsp", "&nbsp", $password_err; ?></span></label>
                <input type="password" name="password" placeholder="•••••••••" value="<?php echo $password; ?>">

                <button class="btn" type="submit">Connexion</button>
                <button class="btn" type="reset">reset</button>
            </form>
            <p class="message">Pas de compte ? <a href="./register.php">Créer un compte</a></p>
        </div>
    </div>
</body>
<script src="../js/script.js"></script>

</html>