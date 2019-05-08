<?php

session_start();

if (isset($_POST['cancel'])) {
    header('Location:index.php');
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123


if (isset($_POST['email']) && isset($_POST['pass'])) {
    if (strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION["error"]  = "User name and password are required";
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash  && (strpos($_POST['email'], '@') != false)) {
            error_log("Login success " . $_POST['email']);
            // Redirect the browser to view.php
            $_SESSION['name'] = $_POST['email'];
            header("Location: view.php");
            return;
        } elseif ($check != $stored_hash) {
            $_SESSION["error"] = "incorrect password";
            error_log("Login fail " . $_POST['email'] . " $check");
        } elseif (strpos($_POST['email'], '@') === false) {

            $_SESSION["error"] = "Email must have an at-sign (@)";
            header("Location: login.php");
            return;
        }
    }
}
?>

<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>Doffou</title>
</head>
<html>

<body>
    <p>Add A New User</p>

    <?php
    if (isset($_SESSION['error'])) {
        echo ('<p style="color: red;">' . htmlentities($_SESSION['error']) . "</p>\n");
    }
    ?>

    <form method="POST">
        <label for="email">Name:</label>
        <input type="text" name="email" value=""><br>
        <label for="pass">Password:</label>
        <input type="text" name="pass" value=""><br>
        <input type="submit" value="Log In" />
        <input type="submit" name="cancel" value="Cancel" />
        <p>
            For a password hint, view source and find a password hint
            in the HTML comments.
        </p>
    </form>
</body>