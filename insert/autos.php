<?php
if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
   die("Name parameter missing");
}

if (isset($_POST['logout'])) {
   header("Location:index.php");
   return;
}

require_once('pdo.php');

$failure = $success = false;

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
   if (strlen($_POST['make']) < 1) {
      $failure = "Make is required";
   } elseif (is_numeric($_POST['year']) === false || is_numeric($_POST['mileage']) === false) {
      $failure = "Mileage and year must be numeric";
   } else {
      $sql = "INSERT INTO autos (make, year, mileage) 
              VALUES (:make, :year, :mileage)";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
         ':make' => $_POST['make'],
         ':year' => $_POST['year'],
         ':mileage' => $_POST['mileage']
      ));
      $success = "Record inserted";
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
   <h1>Tracking Autos for

      <?php
      if (isset($_REQUEST['name'])) {
         echo "<p>Welcome: ";
         echo htmlentities($_REQUEST['name']);
         echo "</p>\n";
      }
      ?>
   </h1>

   <?php
   if ($failure !== false) {
      echo "<p style='color:red;' >" . htmlentities($failure) . "</p>\n";
   }
   echo "<p style='color:green;' >" . $success . "</p>\n";
   ?>

   <form method="post">
      <label for="">Make:</label>
      <input type="text" name="make" value=""><br><br>

      <label for="">Year:</label>
      <input type=" text" name="year" value=""><br><br>

      <label for="">Mileage:<label>
            <input type=" text" name="mileage" value=""><br><br>

            <input type="submit" value="Add" />
            <input type="submit" name="logout" value="Logout" />
            <p>Automobiles

               <?php
               $stmt = $pdo->query("SELECT make, year, mileage FROM autos");
               $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

               foreach ($rows as $row) {
                  echo "<ul>";
                  echo "<li>" . $row['year'] . " " . htmlentities($row['make']) . " / " . $row['mileage'] . "</li>";
                  echo "</ul>";
               }
               ?>
            </p>
   </form>
</body>

</html>