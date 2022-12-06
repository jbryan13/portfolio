<?php
require_once 'config.php';

$score = $_GET['score'];
$duration = $_GET['duration'];
// $dataEnd = $_GET['dataEnd'];
$lastplayer = $qq->query("SELECT MAX(id) as id FROM players");
$max = $lastplayer->fetch_assoc();
// var_dump($max);
$updateID = (int)$max['id'];
// var_dump($updateID);
$qq->query("UPDATE players SET dateEnd=NOW(),score='$score',duration='$duration' WHERE id = $updateID");
