<?php

$host = "127.0.0.1";
$dbname = "reserves";
$user = "root";
$password = "";

try {
  $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);

} catch(PDOException) {
  die("PDO Connection Error: " . $e->getMessage());
}
?>
