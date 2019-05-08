<?php

session_start();

if (!isset($_SESSION['name'])) {
    die("Not logged in");
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Doffou Naomi-lorenzi</title>
</head>

<body>
    <h2>Tracking Autos for

        <?php

        if (isset($_SESSION['name'])) {
            echo htmlentities($_SESSION['name']);
            echo "</p>\n";
        }
        ?>
    </h2>
    <h3>Automobiles</h3>
    <?php
    require_once('pdo.php');

    $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        echo "<ul>";
        echo "<li>" . $row['year'] . " " . htmlentities($row['make']) . " / " . $row['mileage'] . "</li>";
        echo "</ul>";
    }

    ?>
    <a href="add.php" name="Add"> Add New </a> | <a href="logout.php" name="logout">Logout</a>

</body>
</html>