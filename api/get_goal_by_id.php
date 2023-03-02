<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$goal_id = $_GET['goal_id'];
$user_id = $_GET['user_id'];

// get goal
// $db = new db();
// $db->q('SELECT * FROM goals WHERE goal_id = :goal_id AND user = :user_id');
// $db->b(':goal_id', $goal_id);
// $db->b(':user_id', $user_id);
// $goal = $db->s();
// $db->rc();

$goal = Goals::get_goal_by_id($goal_id, $user_id);
$todos = Goals::get_all_todos_in_goal($goal_id, $user_id);

// get goal todos
// $db = new db();
// $db->q('SELECT * FROM todos WHERE goal = :goal_id AND user = :user_id');
// $db->b(':goal_id', $goal_id);
// $db->b(':user_id', $user_id);
// $todos = $db->m();
// $db->rc();

echo json_encode([
  "success" => 1,
  "message" => "Added new todo",
  "data" => array(
    "goal" => $goal,
    "todos" => $todos
  )
]);


?>