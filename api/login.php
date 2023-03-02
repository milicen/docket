<?php
include('../class/handshake.php');
include('../class/class.global.php');
include('../class/singleton.php');

$username = $_POST['username'];
$password = $_POST['password'];

if ($username == null || $password == null) {
  echo json_encode([
    "success" => 0,
    "message" => "Please fill in all the fields."
  ]);
  exit();
}

$get_user = Login::user_login($username, $password);

if ($get_user == null) {
  echo json_encode([
    "success" => 0,
    "message" => "No account can be found. Register instead."
  ]);
  exit();
}

$compare_pass = password_verify($password, $get_user['user_password']);

if (!$compare_pass) {
  echo json_encode([
    "success" => 0,
    "message" => "Username and password don't match."
  ]);
  exit();
}

echo json_encode([
  "success" => 1,
  "message" => "Login successful.",
  "user" => array([
    "user_id" => $get_user["user_id"],
    "user_name" => $get_user["user_name"]
  ])
]);

?>