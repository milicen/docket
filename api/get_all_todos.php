<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');

$user_id = $_GET['user_id'];

// $db = new db();
// $db->q('SELECT DISTINCT date FROM todos WHERE user = :user_id ORDER BY date ASC');
// $db->b(':user_id', $user_id);
// $dates = $db->m();
// $db->rc();

// $db = new db();
// $db->q('SELECT todos.*, goals.tag FROM todos LEFT JOIN goals ON goals.goal_id = todos.goal WHERE todos.user = :user_id ORDER BY date ASC');
// $db->b(':user_id', $user_id);
// $todos = $db->m();
// $db->rc();

$dates = Todos::get_distinct_todos_dates($user_id);
$todos = Todos::get_all_todos($user_id);

echo json_encode([
  "success" => 1,
  "message" => "Fetched".$user_id."'s todos.",
  "data" => array(
    "dates" => $dates,
    "todos" => $todos
  )
])

?>