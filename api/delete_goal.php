<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$goal_id = $_POST['goal'];
$user_id = $_POST['user_id'];

$db = new db();
$db->q('DELETE FROM todos WHERE goal = :goal_id AND user = :user_id');
$db->b(':goal_id', $goal_id);
$db->b(':user_id', $user_id);
$delete_todo_res = $db->x();
$db->rc();

$db = new db();
$db->q('DELETE FROM goals WHERE goal_id = :goal_id AND user = :user_id');
$db->b(':goal_id', $goal_id);
$db->b(':user_id', $user_id);
$delete_goal_res = $db->x();
$db->rc();

echo json_encode([
  "success" => 1,
  "message" => "Deleted goal and todos",
  "data" => array(
    "del_todo_res" => $delete_todo_res,
    "del_goal_res" => $delete_goal_res
  )
]);

?>