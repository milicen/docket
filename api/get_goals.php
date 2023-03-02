<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$user_id = $_GET['user_id'];

$todo_count = Goals::get_todo_count_in_goals($user_id);
$goals = Goals::get_all_goals($user_id);

echo json_encode([
  "success" => 1,
  "message" => "Deleted todo",
  "data" => array(
    "goals" => $goals,
    "todo_count" => $todo_count
  )
]);

?>