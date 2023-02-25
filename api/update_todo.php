<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$todo_id = $_POST['todo_id'];
// $todo = $_POST['todo'];
// $todo_finished = $_POST['todo_finished'];
$user_id = $_POST['user_id'];

$field;

if (isset($_POST['todo'])) {
  $field = 'todo = "'.$_POST['todo'].'"';
}
if (isset($_POST['date'])) {
  $field = 'date = "'.$_POST['date'].'"';
}
if (isset($_POST['todo_finished'])) {
  $field = 'is_finished = "'.$_POST['todo_finished'].'"';
}


$db = new db();
$db->q('UPDATE todos SET '.$field.'WHERE todo_id = :todo_id AND user = :user_id');
// $db->b(':todo', $todo);
// $db->b(':todo_finished', $todo_finished);
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