<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$user_id = $_POST['user_id'];

$res = Goals::add_goal($user_id);

if ($res["res"] > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Added new todo",
    "data" => array(
      "goal_id" => $res["goal_id"]
    )
  ]);
}
?>