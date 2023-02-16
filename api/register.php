<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');


$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($username == null || $email == null || $password == null || $confirm_password == null) {
  echo json_encode([
    "success" => 0,
    "message" => "Please fill in all the fields."
  ]);
  exit();
}

if ($password != $confirm_password) {
  echo json_encode([
    "success" => 0,
    "message" => "Passwords must match."
  ]);
  exit();
}

$db = new db();
$db->q('SELECT COUNT(user_id) as emails FROM users WHERE user_email = :email');
$db->b(':email', $email);
$res = $db->s();
$db->rc();
$emails = $res['emails'];

if ($emails > 0) {
  echo json_encode([
    "success" => 0,
    "message" => "Email already exists."
  ]);
  exit();
}

$db = new db();
$db->q('SELECT COUNT(user_id) as usernames FROM users WHERE user_name = :username');
$db->b(':username', $username);
$res = $db->s();
$db->rc();
$usernames = $res['usernames'];

if ($usernames > 0) {
  echo json_encode([
    "success" => 0,
    "message" => "Username already exists."
  ]);
  exit();
}


$hash = password_hash($password, PASSWORD_DEFAULT);

$db = new db();
$db->q('INSERT INTO users (user_name, user_email, user_password) VALUES (:username, :email, :password)');
$db->b(':username', $username);
$db->b(':email', $email);
$db->b(':password', $hash);
$db->rc();

$record = $db->x();

if ($record > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Successfully created an account."
  ]);
}


?>