<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$todo_id = $_POST['todo_id'];
$user_id = $_POST['user_id'];

$res = Todos::delete_todo($todo_id, $user_id);

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Deleted todo",
    "data" => $res
  ]);
}

?>