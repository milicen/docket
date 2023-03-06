<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$user_id = $_GET['user_id'];

$dates = Todos::get_distinct_todos_dates($user_id);
$todos = Todos::get_all_todos($user_id);

echo json_encode([
  "success" => 1,
  "message" => "Fetched".$user_id."'s todos.",
  "data" => array(
    "dates" => $dates,
    "todos" => $todos
  )
])

?>