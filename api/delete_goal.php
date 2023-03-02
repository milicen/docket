<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$goal_id = $_POST['goal'];
$user_id = $_POST['user_id'];

$delete_todo_res = Goals::delete_all_todos_in_goal($goal_id, $user_id);
$delete_goal_res = Goals::delete_goal_by_id($goal_id, $user_id);

echo json_encode([
  "success" => 1,
  "message" => "Deleted goal and todos",
  "data" => array(
    "del_todo_res" => $delete_todo_res,
    "del_goal_res" => $delete_goal_res
  )
]);

?>