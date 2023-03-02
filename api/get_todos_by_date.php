<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$date = $_GET['date'];
$user_id = $_GET['user_id'];

$res = Todos::get_todos_by_date($date, $user_id);

echo json_encode([
  "success" => 1,
  "message" => "Fetched todos from ".$date.' '.$user_id,
  "data" => $res
])

?>