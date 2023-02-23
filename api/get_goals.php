<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$user_id = $_GET['user_id'];

$db = new db();
$db->q('SELECT * FROM goals WHERE user = :user_id');
$db->b(':user_id', $user_id);
$res = $db->m();

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Deleted todo",
    "data" => $res
  ]);
}

$db->rc();

?>