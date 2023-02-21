<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$date = $_GET['date'];
$user_id = $_GET['user_id'];

$db = new db();
$db->q('SELECT * FROM todos WHERE user = :user_id AND date = :date');
$db->b(':user_id', $user_id);
$db->b(':date', $date);
$res = $db->m();
$db->rc();

echo json_encode([
  "success" => 1,
  "message" => "Fetched todos from ".$date.' '.$user_id,
  "data" => $res
])

?>