<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$goal_id = $_POST['goal'];
$user_id = $_POST['user_id'];

$field;

if (isset($_POST['goal_title'])) {
  $field = ["goal_title" => $_POST['goal_title']];
}
if (isset($_POST['goal_description'])) {
  $field = ["goal_description" => $_POST['goal_description']];
}
if (isset($_POST['due_date'])) {
  $field = ["due_date" => $_POST['due_date']];
}
if (isset($_POST['tag'])) {
  $field = ["tag" => $_POST['tag']];
}

$res = Goals::update_goal($field, $goal_id, $user_id);

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Updated goal",
    "data" => $res
  ]);
}

?>