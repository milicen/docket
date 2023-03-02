<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$date = $_POST['date'];
$user_id = $_POST['user_id'];

$res = Todos::delete_all_todos_by_date($date, $user_id);

if ($res > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Deleted todos by date",
    "data" => $res
  ]);
}

?>