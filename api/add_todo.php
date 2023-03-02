<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$todo = $_POST['todo'];
$date = $_POST['date'];
$user_id = $_POST['user_id'];
if (isset($_POST['goal'])) {
  $goal_id = $_POST['goal'];
}
else {
  $goal_id = null;
}

$res = Todos::add_todo($todo, $date, $user_id, $goal_id);

if ($res["res"] > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Added new todo",
    "data" => array([
      "todo_id" => $res["todo_id"]
    ])
  ]);
}

?>