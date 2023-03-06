<?php
include('../class/class.global.php');
include('../class/handshake.php');
include('../class/singleton.php');


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

$emails = Register::get_user_with_email_count($email);

if ($emails > 0) {
  echo json_encode([
    "success" => 0,
    "message" => "Email already exists."
  ]);
  exit();
}

$usernames = Register::get_user_with_username_count($username);

if ($usernames > 0) {
  echo json_encode([
    "success" => 0,
    "message" => "Username already exists."
  ]);
  exit();
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$record = Register::create_new_user($username, $email, $hash);

if ($record > 0) {
  echo json_encode([
    "success" => 1,
    "message" => "Successfully created an account."
  ]);
}


?>