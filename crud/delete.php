<?php
require_once "pdo.php";
session_start();

if (isset($_POST['delete']) && isset($_GET['autos_id'])) {
    $sql = "DELETE FROM autos WHERE autos_id = :autos_id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':autos_id' => $_GET['autos_id']));

    $_SESSION['success'] = 'Record deleted';
    header('Location: index.php');
    return;
}

$stmt = $pdo->prepare("SELECT make, autos_id FROM autos where autos_id = :autos_id");
$stmt->execute(array(":autos_id" => $_GET['autos_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ($row) {
    echo "<p>Confirm: Deleting " . htmlentities($row['make']) . "</p>";
}

?>

<form method="post">
    <input type="hidden" name="autos_id" value="<?= $row['autos_id'] ?>">
    <input type="submit" value="Delete" name="delete">
    <a href="index.php">Cancel</a>
</form>