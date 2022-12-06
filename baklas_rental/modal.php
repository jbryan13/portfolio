<?php
require_once 'config.php';

$id = $_GET['id'];
$movies = $conn->query("SELECT*FROM movies WHERE id = '$id'");
$movie = $movies->fetch_array(MYSQLI_ASSOC);

echo json_encode($movie);
