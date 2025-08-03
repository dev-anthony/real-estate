<?php
session_start();
// if($_SERVER['REQUEST_METHOD'] !== 'POST'){
//     http_response_code(405);
//     echo json_encode(['error' => 'invalid request']);
//     exit;
// }
session_unset();
session_destroy();
header("Location: /Authentication/Frontend/php/index.php");
exit;

?>