<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$goal_id = $_GET['goal_id'];
$user_id = $_GET['user_id'];

$goal = Goals::get_goal_by_id($goal_id, $user_id);
$todos = Goals::get_all_todos_in_goal($goal_id, $user_id);

echo json_encode([
  "success" => 1,
  "message" => "Added new todo",
  "data" => array(
    "goal" => $goal,
    "todos" => $todos
  )
]);


?>