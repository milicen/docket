<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$todo_id = $_POST['todo_id'];
$user_id = $_POST['user_id'];

$db = new db();
$db->q('DELETE FROM todos WHERE todo_id = :todo_id AND user = :user_id');
$db->b(':todo_id', $todo_id);
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