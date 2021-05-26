<?php
require_once "connexion.php"; // même chose qu'un simple "require" à part que PHP vérifie si le fichier a déjà été inclus, et si c'est le cas, ne l'inclut pas une deuxième fois.
$firstname = $lastname = $birthdate = $email = $login = $password = $confirm_password = ""; // déclaration des variables
$firstname_err = $lastname_err = $birthdate_err = $email_err = $login_err = $password_err = $confirm_password_err = ""; // déclaration des variables erreures
$regex_password = "/(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/";
// $regex_date = "/(0[1-9]|1[0-9]|2[0-9]|3[01]).(0[1-9]|1[012]).[0-9]{4}/";
$regex_date = '/(?:19|20)[0-9]{2}\/(?:(?:0[1-9]|1[0-2])\/(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])\/(?:30))|(?:(?:0[13578]|1[02])\/31))/';
$regex_login = "/^[a-zA-Z][a-zA-Z0-9-_\.]{3,9}$/";
$regex_name = "/^[a-zA-Z][a-zA-Z-' ]{2,44}$/";
$regex_email = '/(?:[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&\'*+\/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/';

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si l'on a une requete avec la méthode post alor :

    // ________________________________ firstname ________________________________
    if (empty(trim($_POST["firstname"]))) { // Vérification si le champ firstname est vide
        $firstname_err = "*Firstname est vide."; // la variable firstname_err deviens "Firstname est vide."
    } else {
        $sql = "SELECT id FROM user WHERE firstname = ?"; // préparation du selecteur

        if ($stmt = mysqli_prepare($conn, $sql)) { // préparation de la requete sql
            mysqli_stmt_bind_param($stmt, "s", $param_firstname); //Lie des variables à une requête MySQL

            $param_firstname = trim($_POST["firstname"]); // déclare la variable param_firstname qui prend de firstname

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée

                mysqli_stmt_store_result($stmt); // Stocke un jeu de résultats depuis une requête préparée

                if (strlen(trim($_POST["firstname"])) > 45) { // Test la taille du firstname si elle est supérieur à 45
                    $firstname_err = "*45 carractères max."; // Si elle l'es retourne une erreur
                } elseif (!preg_match($regex_name, $_POST["firstname"])) {
                    $firstname_err = "*Ceci n'est pas un prénom.";
                } else {
                    $firstname = trim($_POST["firstname"]); // Envoie firstname
                }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }

    // ________________________________ lastname ________________________________
    if (empty(trim($_POST["lastname"]))) { // Vérification si le champ lastname est vide
        $lastname_err = "*Lastname est vide."; // la variable lastname_err deviens "lastname est vide."
    } else {
        $sql = "SELECT id FROM user WHERE lastname = ?"; // préparation du selecteur

        if ($stmt = mysqli_prepare($conn, $sql)) { // préparation de la requete sql
            mysqli_stmt_bind_param($stmt, "s", $param_lastname); //Lie des variables à une requête MySQL

            $param_lastname = trim($_POST["lastname"]); // déclare la variable param_lastname qui prend de lastname

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée

                mysqli_stmt_store_result($stmt); // Stocke un jeu de résultats depuis une requête préparée

                if (strlen(trim($_POST["lastname"])) > 45) { // Test la taille du lastname si elle est supérieur à 45
                    $lastname_err = "*45 carractères max."; // Si elle l'es retourne une erreur
                } elseif (!preg_match($regex_name, $_POST["lastname"])) {
                    $lastname_err = "*Ceci n'est pas un nom.";
                } else {
                    $lastname = trim($_POST["lastname"]); // Envoie last name
                }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }

    // ________________________________ birthdate ________________________________
    if (empty(trim($_POST["birthdate"]))) { // Vérification si le champ birthdate est vide
        $birthdate_err = "*Birthdate est vide."; // la variable birthdate_err deviens "birthdate est vide."
    } else {
        $sql = "SELECT id FROM user WHERE birthdate = ?"; // préparation du selecteur

        if ($stmt = mysqli_prepare($conn, $sql)) { // préparation de la requete sql
            mysqli_stmt_bind_param($stmt, "s", $param_birthdate); //Lie des variables à une requête MySQL

            $param_birthdate = trim($_POST["birthdate"]); // déclare la variable param_birthdate qui prend de birthdate

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée

                mysqli_stmt_store_result($stmt); // Stocke un jeu de résultats depuis une requête préparée

                // if (!preg_match($regex_date, $_POST["birthdate"])) {
                // $birthdate_err = "*Date de naissance invalide. Exemple de date : 02/04/1999";
                // } else {
                $birthdate = trim($_POST["birthdate"]); // Envoie la date de naissance
                // }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }

    // ________________________________ EMAIL ________________________________
    if (empty(trim($_POST["email"]))) { // Vérification si le champ email est vide
        $email_err = "*Email est vide."; // la variable email_err deviens "email est vide."
    } else {
        $sql = "SELECT id FROM user WHERE email = ?"; // préparation du selecteur

        if ($stmt = mysqli_prepare($conn, $sql)) { // préparation de la requete sql
            mysqli_stmt_bind_param($stmt, "s", $param_email); //Lie des variables à une requête MySQL

            $param_email = trim($_POST["email"]); // déclare la variable param_email qui prend de email

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée

                mysqli_stmt_store_result($stmt); // Stocke un jeu de résultats depuis une requête préparée

                if (mysqli_stmt_num_rows($stmt) == 1) { //test si le login est déjà prit
                    $email_err = "*Email est déjà prit.";
                } elseif (strlen(trim($_POST["email"])) > 100) { // Test si l'email fait plus de 100 caractères
                    $email_err = "*100 caractères max."; // Si c'est le cas renvoie l'erreur
                } elseif (!preg_match($regex_email, $_POST["email"])) { // Test le login si il fait plus de 10 caractères
                    $email_err = "*Ceci n'est pas un email."; // Si c'est le cas renvoie l'erreur
                } else {
                    $email = trim($_POST["email"]); // Envoie l'email
                }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }

    // ________________________________ login ________________________________
    if (empty(trim($_POST["login"]))) { // Vérification si le champ login est vide
        $login_err = "*login est vide."; // la variable login_err deviens "login est vide."
    } else {
        $sql = "SELECT id FROM user WHERE login = ?"; // préparation du selecteur

        if ($stmt = mysqli_prepare($conn, $sql)) { // préparation de la requete sql
            mysqli_stmt_bind_param($stmt, "s", $param_login); //Lie des variables à une requête MySQL

            $param_login = trim($_POST["login"]); // déclare la variable param_login qui prend de login

            if (mysqli_stmt_execute($stmt)) { // Exécute une requête préparée

                mysqli_stmt_store_result($stmt); // Stocke un jeu de résultats depuis une requête préparée

                if (mysqli_stmt_num_rows($stmt) == 1) { //test si le login est déjà prit
                    $login_err = "*Ce login est déjà prit.";
                } elseif (!preg_match($regex_login, $_POST["login"])) { // Test le login si il fait plus de 10 caractères
                    $login_err = '*Une taille de 4 à 10 carractères et composé de lettres et de chiffres uniquement ( . - et _ entre autorisé).'; // Si c'est le cas renvoie l'erreur
                } else {
                    $login = trim($_POST["login"]); // Envoie le login
                }
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt); // Termine la requête préparée
        }
    }

    // ________________________________ password _________________________________________
    if (empty(trim($_POST["password"]))) { // test si le mot de passe est vide
        $password_err = "*Mot de passe vide."; // si il est vide place mot de passe vide." dans la variable $password_err
    } elseif (!preg_match($regex_password, $_POST["password"])) {
        $password_err = "*Besoin d'au moins 1 majuscule, 1 minuscule, 1 chiffre/caractère spécial et une taille de 8 carractères minimum.";
    } else {
        $password = trim($_POST["password"]); // Envoie le mot de passe
    }


    // Validate confirm password
    if (empty(trim($_POST["confirm_password"]))) {
        $confirm_password_err = "*Veuillez confirmer le mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "*Les mots de passe ne correspondent pas.";
        }
    }

    // ________________________________ envoie a la bdd ________________________________
    if (empty($firstname_err) && empty($lastname_err) && empty($birthdate_err) && empty($email_err) && empty($login_err) && empty($password_err) && empty($confirm_password_err)) { // Chek si il y a une erreur en regardant toutes les vaiables d'erreures

        $sql = "INSERT INTO user (firstname, lastname, birthdate, email, login, password) VALUES (?, ?, ?, ?, ?, ?)"; // Prépare l'insersion

        if ($stmt = mysqli_prepare($conn, $sql)) {

            mysqli_stmt_bind_param($stmt, "ssssss", $param_firstname, $param_lastname, $param_birthdate, $param_email, $param_login, $param_password);

            // Définir les paramètres
            $param_firstname = $firstname;
            $param_lastname = $lastname;
            $param_birthdate = $birthdate;
            $param_email = $email;
            $param_login = $login;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // hash le mot de passe

            if (mysqli_stmt_execute($stmt)) { //Exécute une requête préparée
                header("location: login.php"); // redirige vers la page login.php
            } else {
                echo "Un problème est survenu. Veuillez réessayer plus tard."; // Si il y a un problème quelconque
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/register.css">
    <title>register</title>
</head>

<body>
    <div class="login-page">
        <div class="form">
            <form method="POST">

                <!-- <h2>Inscription</h2>s -->
                <!-- <p>Veuillez remplir ce formulaire pour créer un compte.</p> -->

                <label>firstname:<span><?php echo "&nbsp", "&nbsp", $firstname_err; ?></span></label>
                <input type="text" name="firstname" value="<?php echo $firstname; ?>" placeholder="Mike">

                <label>lastname:<span><?php echo "&nbsp", "&nbsp", $lastname_err; ?></span></label>
                <input type="text" name="lastname" value="<?php echo $lastname; ?>" placeholder="Silverstre">

                <label>birthdate:<span><?php echo "&nbsp", "&nbsp", $birthdate_err; ?></span></label>
                <input type="text" name="birthdate" value="<?php echo $birthdate; ?>" placeholder="AAAA/MM/JJ">

                <label>email:<span><?php echo "&nbsp", "&nbsp", $email_err; ?></span></label>
                <input type="text" name="email" value="<?php echo $email; ?>" placeholder="mike.silvestre@gmail.com">

                <label>login:<span><?php echo "&nbsp", "&nbsp", $login_err; ?></span></label>
                <input type="text" name="login" value="<?php echo $login; ?>" placeholder="Miky">

                <label>Password:<span><?php echo "&nbsp", "&nbsp", $password_err; ?></span></label>
                <input type="password" name="password" value="<?php echo $password; ?>" placeholder="•••••••••">

                <label>Confirm Password:<span><?php echo "&nbsp", "&nbsp", $confirm_password_err; ?></span></label>
                <input type="password" name="confirm_password" value="<?php echo $confirm_password; ?>" placeholder="•••••••••">

                <button class="btn" type="submit">s'inscrire</button>
                <button class="btn" type="reset">reset</button>
            </form>
            <p class="message">Déjà enregistré ? Connectez-vous ici <a href="./login.php">Se connecter</a></p>
        </div>
    </div>
</body>

</html>