<?php
require_once 'config.php';

$player_name = $_POST['player_name'];

// echo $player_name;
// exit;

$qq->query("INSERT INTO players(player_name, dateStart, dateEnd, score, duration) VALUES ('$player_name',NOW(),NULL,0,0)");
