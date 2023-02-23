<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$goal_id = $_POST['goal'];
$user_id = $_POST['user_id'];

$field;

if (isset($_POST['goal_title'])) {
  $field = 'goal_title = "'.$_POST['goal_title'].'"';
}
if (isset($_POST['goal_description'])) {
  $field = 'goal_description = "'.$_POST['goal_description'].'"';
}
if (isset($_POST['due_date'])) {
  $field = 'due_date = "'.$_POST['due_date'].'"';
}
if (isset($_POST['tag'])) {
  $field = 'tag = "'.$_POST['tag'].'"';
}

$db = new db();
$db->q('UPDATE goals SET '.$field.' WHERE goal_id = :goal_id AND user = :user_id');
$db->b(':goal_id', $goal_id);
$db->b(':user_id', $user_id);
$res = $db->x();


if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Updated goal",
    "data" => $res
  ]);
}

$db->rc();

?>