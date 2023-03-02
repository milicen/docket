<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$todo_id = $_POST['todo_id'];
// $todo = $_POST['todo'];
// $todo_finished = $_POST['todo_finished'];
$user_id = $_POST['user_id'];

$field;

if (isset($_POST['todo'])) {
  // $field = 'todo = "'.$_POST['todo'].'"';
  $field = ["todo" => $_POST['todo']];
}
if (isset($_POST['date'])) {
  // $field = 'date = "'.$_POST['date'].'"';
  $field = ["date" => $_POST['date']];
}
if (isset($_POST['todo_finished'])) {
  // $field = 'is_finished = "'.$_POST['todo_finished'].'"';
  $field = ["is_finished" => $_POST['todo_finished']];
}

$res = Todos::update_todo($field, $todo_id, $user_id);

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Updated todo",
    "data" => $res
  ]);
}

?>