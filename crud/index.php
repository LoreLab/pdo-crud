<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Doffou Naomi-lorenzi</title>
</head>
<body>
    <h1>Welcome to the Automobiles Database</h1>
    <?php
    if (isset($_SESSION['error'])) {
        echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
        unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
        echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
        unset($_SESSION['success']);
    }
    ?>

    <?php

    if (isset($_SESSION['name'])) {

        $checkData = $pdo->query("SELECT * FROM autos");
        $res = $checkData->fetchAll();
        if (count($res) == 0) {
            // pas de résultat
            echo 'No rows found';
            echo "<p><a href='add.php'>Add New Entry </a></p>";
            echo "       ";
            echo "<p><a href= 'logout.php'> Logout </a></p>";

            echo "<p>Note: Your implementation should retain data across multiple logout/login sessions. This sample implementation clears all its data on logout - 
                  which you should not do in your implementation. </p>";
        } else {
            echo "<table border = '1'>" . "\n";
            echo "<tr>";
            echo "<th>Make</th>";
            echo "<th>Model</th>";
            echo "<th>Year</th>";
            echo "<th>Mileage</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            $stmt = $pdo->query("SELECT * FROM autos");

            while ($res = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . htmlentities($res['make']) . "</td>";
                echo "<td>" . htmlentities($res['model']) . "</td>";
                echo "<td>" . htmlentities($res['year']) . "</td>";
                echo "<td>" . htmlentities($res['mileage']) . "</td>";
                echo "<td>";
                echo '<a href="edit.php?autos_id=' . $res['autos_id'] . '">Edit</a> / 
               <a href="delete.php?autos_id=' . $res['autos_id'] . '">Delete</a>';
                echo "</td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<p><a href='add.php'>Add New Entry </a></p>";
            echo "       ";
            echo "<p><a href= 'logout.php'> Logout </a></p>";
            // }
        }
    } else {
        echo " <p><a href='login.php'>Please log in</a></p> ";
        echo "<p>Attempt to <a href='add.php'>add data</a> without logging in </p>";
    }
    ?>

</body>

</html>