<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$user_id = $_GET['user_id'];

$db = new db();
$db->q('SELECT DISTINCT date FROM todos WHERE user = :user_id ORDER BY date ASC');
$db->b(':user_id', $user_id);
$dates = $db->m();
$db->rc();

$db = new db();
$db->q('SELECT todo_id, todo, is_finished, date FROM todos WHERE user = :user_id ORDER BY date ASC');
$db->b(':user_id', $user_id);
$todos = $db->m();
$db->rc();

echo json_encode([
  "success" => 1,
  "message" => "Fetched".$user_id."'s todos.",
  "data" => array(
    "dates" => $dates,
    "todos" => $todos
  )
])

?>