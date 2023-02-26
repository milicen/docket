<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$date = $_POST['date'];
$user_id = $_POST['user_id'];

$db = new db();
$db->q('DELETE FROM todos WHERE date = :date AND user = :user_id');
$db->b(':date', $date);
$db->b(':user_id', $user_id);
$res = $db->x();

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Deleted todo",
    "data" => $res
  ]);
}

$db->rc();

?>