<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$todo = $_POST['todo'];
$date = $_POST['date'];
$user_id = $_POST['user_id'];
if (isset($_POST['goal'])) {
  $goal_id = $_POST['goal'];
}
else {
  $goal_id = null;
}

$db = new db();
$db->q('INSERT INTO todos (todo, date, user, goal) VALUES (:todo, :date, :user_id, :goal_id)');
$db->b(':todo', $todo);
$db->b(':date', $date);
$db->b(':user_id', $user_id);
$db->b(':goal_id', $goal_id);
$res = $db->x();

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Added new todo",
    "data" => array([
      "todo_id" => $db->lid()
    ])
  ]);
}

$db->rc();

?>