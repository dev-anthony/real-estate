<?php
include '../Config/db.php';


$result = $conn->query("SELECT * FROM houses");
$houses = $result->fetch_all(MYSQLI_ASSOC);

header('Content-Type: application/json');
echo json_encode($houses);

?>
