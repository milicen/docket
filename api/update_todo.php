<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$todo = $_POST['todo'];
$todo_id = $_POST['todo_id'];
$todo_finished = $_POST['todo_finished'];
$user_id = $_POST['user_id'];

$db = new db();
$db->q('UPDATE todos SET todo = :todo, is_finished = :todo_finished WHERE todo_id = :todo_id AND user = :user_id');
$db->b(':todo', $todo);
$db->b(':todo_finished', $todo_finished);
$db->b(':todo_id', $todo_id);
$db->b(':user_id', $user_id);
$res = $db->x();

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Updated todo",
    "data" => $res
  ]);
}

$db->rc();

?>