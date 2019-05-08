<?php
session_start();

if (!isset($_SESSION['name'])) {
   die("ACCESS DENIED");
}

if (isset($_POST['cancel'])) {
   header('Location:index.php');
   return;
}

require_once('pdo.php');

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
   if (strlen($_POST['make']) < 1 && strlen($_POST['year']) < 1 && strlen($_POST['model']) < 1 && strlen($_POST['mileage']) < 1) {
      $_SESSION["error"] =  "All fields are required";
      header("Location: add.php");
      return;
   } elseif (is_numeric($_POST['year']) === false || is_numeric($_POST['mileage']) === false) {
      $_SESSION["error"] =  "Year must be an integer";
      header("Location: add.php");
      return;
   } else {
      $sql = "INSERT INTO autos (make, model, year, mileage) 
              VALUES (:make,  :model, :year, :mileage)";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
         ':make' => $_POST['make'],
         ':model' => $_POST['model'],
         ':year' => $_POST['year'],
         ':mileage' => $_POST['mileage']
      ));

      $_SESSION['success'] = "Record added";
      header("Location: index.php");
      return;
   }
}

?>

<!doctype html>
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

   <?php

   if (isset($_SESSION["error"])) {
      echo "<p style='color:red;' >" . htmlentities($_SESSION["error"]) . "</p>\n";
      unset($_SESSION['error']);
   }

   ?>

   <form method="post">
      <label for="">Make:</label>
      <input type="text" name="make" value=""><br><br>
      <label for="">Model:</label>
      <input type=" text" name="model" value=""><br><br>
      <label for="">Year:</label>
      <input type=" text" name="year" value=""><br><br>
      <label for="">Mileage:<label>
            <input type=" text" name="mileage" value=""><br><br>

            <input type="submit" name="Add" value="Add" />
            <input type="submit" name="cancel" value="Cancel" />
   </form>
</body>

</html>