<?php

if (isset($_POST['cancel'])) {
    header('Location:index.php');
    return;
}

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1'; // Pw is php123

$failure = false;

if (isset($_POST['who']) && isset($_POST['pass'])) {
    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $failure = "User name and password are required";
    } else {
        $check = hash('md5', $salt . $_POST['pass']);
        if ($check == $stored_hash  && (strpos($_POST['who'], '@') != false)) {
            error_log("Login success " . $_POST['who']);
            header("Location: autos.php?name=" . urlencode($_POST['who']));
            return;
        } elseif ($check != $stored_hash) {
            $failure = "incorrect password";
            error_log("Login fail " . $_POST['who'] . " $check");
        } elseif (strpos($_POST['who'], '@') === false) {
            $failure = "Email must have an at-sign (@)";
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
    if ($failure !== false) {
        echo "<p style='color:red;'>" . htmlentities($failure) . "</p>\n";
    }
    ?>
    <form method="POST">
        <label for=email"">User Name:</label>
        <input type="text" name="who" value=""><br>
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