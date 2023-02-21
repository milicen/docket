<?php
date_default_timezone_set("Asia/Jakarta");
include('../class/class.global.php');
include('../class/handshake.php');

class login {
  static function user_login($username, $password) {

    // $username = $_POST['username'];
    // $password = $_POST['password'];

    if ($username == null || $password == null) {
      return json_encode([
        "success" => 0,
        "message" => "Please fill in all the fields."
      ]);
      // exit();
    }

    $db = new db();
    $db->q('SELECT * FROM users WHERE user_name = :username');
    $db->b(':username', $username);

    $get_user = $db->s();
    $db->rc();

    if ($get_user == null) {
      return json_encode([
        "success" => 0,
        "message" => "No account can be found. Register instead."
      ]);
      // exit();
    }

    $compare_pass = password_verify($password, $get_user['user_password']);

    if (!$compare_pass) {
      return json_encode([
        "success" => 0,
        "message" => "Username and password don't match."
      ]);
      // exit();
    }

    return json_encode([
      "success" => 1,
      "message" => "Login successful.",
      "user" => array([
        "user_id" => $get_user["user_id"],
        "user_name" => $get_user["user_name"]
      ])
    ]);
  }
}


?>