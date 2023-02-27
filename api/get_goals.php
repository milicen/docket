<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$user_id = $_GET['user_id'];

$db = new db();
$db->q('SELECT goals.goal_id, COUNT(*) AS total_todo, SUM(todos.is_finished > 0) AS total_finished FROM goals JOIN todos ON todos.goal = goals.goal_id GROUP BY goal_id');
$todo_count = $db->m();

$db = new db();
$db->q('SELECT * FROM goals WHERE user = :user_id');
$db->b(':user_id', $user_id);
$goals = $db->m();

// if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Deleted todo",
    "data" => array(
      "goals" => $goals,
      "todo_count" => $todo_count
    )
  ]);
// }

$db->rc();

?>