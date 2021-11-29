<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="viewport" content="width = device-width, initial-scale = 2.3, user-scalable = no"/>
    <meta name="viewport" content="width = device-width, initial-scale = 2.3, minimum-scale = 1, maximum-scale = 5"/>
    <link href="./css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/fontawesome.css" rel="stylesheet">
    <link href="./css/main.css" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <title>Where To Eat</title>
</head>
<body>
<?php include 'header.inc'; ?>

<?php

// process the signin form if username and password are filled
// otherwise display the signin form
if (isset($_POST["username"]) && isset($_POST["password"])) {
    define("DB_HOST", "localhost");
    define("DB_NAME", "4ww3");
    define("DB_CHARSET", "utf8");
    define("DB_USER", "root");
    define("DB_PASSWORD", "");

    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";charset=" . DB_CHARSET . ";dbname=" . DB_NAME,
            DB_USER, DB_PASSWORD
        );
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $ex) {
        exit($ex->getMessage());
    }

    $username = $_POST["username"];
    $password = $_POST["password"];
    $is_register = FALSE;
    // if email isn't filled out - login
    if ($_POST["email"] === "") {
        $stmt = $pdo->prepare("SELECT * FROM `user` WHERE `username` = :username AND `password` = :password");
        $stmt->bindValue(':username', $username);
        // sha256 - hash the password before storing into db
        $stmt->bindValue(':password', hash("sha256", $password));
    } else {
        $is_register = TRUE;
        // in the case where email is filled out - this is a registration for new user
        $stmt = $pdo->prepare("INSERT INTO `user` (`username`, `password`, `email`) VALUES (:username, :password, :email)");
        $stmt->bindValue(':username', $username);
        $stmt->bindValue(':password', hash("sha256", $password));
        $stmt->bindValue(':email', $_POST["email"]);
    }

    try {
        $stmt->execute();
    } catch (PDOException $e) {
        $error_message = "Operation failed: " . $e->getMessage();
        echo '<div class="alert alert-danger" role="alert">' . $error_message . '</div>';
        include 'signin_form.inc';
        die();
    }

    if ($is_register) {
        echo '<div class="alert alert-success" role="alert">Successfully registered a new user: ' . $username . ' Please sign in with your credentials.' . '</div>';
        include 'signin_form.inc';
    } else {
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // display the search results fetched from db
        if (count($users) > 0) {
            // logged-in user
            $user = $users[0];
            session_start();
            $_SESSION['loggedIn'] = TRUE;
            // used to quickly get user info
            $_SESSION['username'] = $user["username"];
            echo '<h1>Sign In Successfully</h1>';
            header("Location: search.php");
            die();
        } else {
            // no user matching the input credentials is found
            echo '<div class="alert alert-danger" role="alert"> No user could be found with given credentials. Please try again or register for a new account.</div>';
            include 'signin_form.inc';
        }
    }
} else {
    session_start();
    if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === TRUE) {
        echo '<div class="alert alert-warning" role="alert">You are alreay logged in.</div>';
        include "signout_form.inc";
    }else {
        include 'signin_form.inc';
    }
}
?>

<?php include 'footer.inc'; ?>

<script src="js/registration.js"></script>
</body>
</html>