<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$user_id = $_POST['user_id'];

$db = new db();
$db->q('INSERT INTO goals SET user = :user_id');
$db->b(':user_id', $user_id);
$res = $db->x();

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Added new todo",
    "data" => array(
      "goal_id" => $db->lid()
    )
  ]);
}

$db->rc();

?>