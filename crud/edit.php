<?php
session_start();
require_once('pdo.php');

if (
    isset($_POST['make']) && isset($_POST['year'])
    && isset($_POST['mileage']) && isset($_POST['autos_id'])
) {

    if (
        strlen($_POST['make']) < 1 && strlen($_POST['year']) < 1 &&
        strlen($_POST['model']) < 1 && strlen($_POST['mileage']) < 1
    ) {
        $_SESSION["error"] =  "All fields are required";
        header("Location:edit.php?autos_id=" . $_POST['autos_id']);
        return;
    }
    if (is_numeric($_POST['year']) === false || is_numeric($_POST['mileage']) === false) {
        $_SESSION["error"] =  "Year must be an integer";
        header("Location:edit.php?autos_id=" . $_POST['autos_id']);
        return;
    }
    $sql = "UPDATE autos SET 
               make =:make,
               model =:model,
               year =:year,
               mileage =:mileage
                WHERE autos_id = :autos_id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':autos_id' => $_POST['autos_id'],
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']
    ));
    $_SESSION['success'] = "Record edited";
    header("Location: index.php");
    return;
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Doffou Naomi-lorenzi</title>
</head>

<body>
    <h2>Editing Automobile</h2>

    <?php
    // Guardian: Make sure that user_id is present
    $stmt = $pdo->prepare("SELECT * FROM autos where autos_id = :autos_id");
    $stmt->execute(array(
        ":autos_id" => $_GET['autos_id']
    ));
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {

        $make = htmlentities($row['make']);
        $model = htmlentities($row['model']);
        $year = htmlentities($row['year']);
        $mileage = htmlentities($row['mileage']);
        $autos_id = $row['autos_id'];
    }

    if (isset($_SESSION["error"])) {
        echo "<p style='color:red;' >" . htmlentities($_SESSION["error"]) . "</p>\n";
        unset($_SESSION['error']);
    }

    ?>
    <form method="post">
        <input type="hidden" name="autos_id" value="<?= $autos_id ?>"><br><br>
        <label for="">Make:</label>
        <input type="text" name="make" value="<?= $make ?>"><br><br>
        <label for="">Model:</label>
        <input type=" text" name="model" value="<?= $model ?>"><br><br>
        <label for="">Year:</label>
        <input type=" text" name="year" value="<?= $year ?>"><br><br>
        <label for="">Mileage:<label>
                <input type=" text" name="mileage" value="<?= $mileage ?>"><br><br>
                <input type="submit" value="Save" />
                <a href="index.php">Cancel</a>
    </form>
</body>

</html>