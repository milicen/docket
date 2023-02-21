<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

$todo = $_POST['todo'];
$date = $_POST['date'];
$user_id = $_POST['user_id'];

$db = new db();
$db->q('INSERT INTO todos (todo, date, user) VALUES (:todo, :date, :user_id)');
$db->b(':todo', $todo);
$db->b(':date', $date);
$db->b(':user_id', $user_id);
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