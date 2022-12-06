<?php
require_once 'config.php';

$available = $_POST['available'];
$fullname = $_POST['name'];
$contact_no = $_POST['contactno'];
$movieID = $_POST['movieID'];

$conn->query("INSERT INTO reservation(fullname, contact_no, movie_id) VALUES ('$fullname','$contact_no','$movieID')");

$conn->query("UPDATE movies SET available = $available - 1 WHERE id = $movieID");
header('Location: index.php');
