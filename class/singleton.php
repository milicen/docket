<?php

class Login {

  static public function user_login($username, $password) {
		try {
			$db = new db();
			$db->q("SELECT * FROM users WHERE user_name = '".$username."' ");
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  
}

class Register {
  static public function get_user_with_email_count($email) {
    try {
			$db = new db();
			$db->q('SELECT COUNT(user_id) as emails FROM users WHERE user_email = :email');
      $db->b(':email', $email);
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret['emails'];
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_user_with_username_count($username) {
    try {
			$db = new db();
			$db->q('SELECT COUNT(user_id) as usernames FROM users WHERE user_name = :username');
      $db->b(':username', $username);
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret['usernames'];
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function create_new_user($username, $email, $password) {
    try {
			$db = new db();
			$db->q('INSERT INTO users (user_name, user_email, user_password) VALUES (:username, :email, :password)');
      $db->b(':username', $username);
      $db->b(':email', $email);
      $db->b(':password', $password);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }
}


class Todos {
  static public function get_distinct_todos_dates($user_id) {
    try {
			$db = new db();
			$db->q('SELECT DISTINCT date FROM todos WHERE user = :user_id ORDER BY date ASC');
      $db->b(':user_id', $user_id);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_all_todos($user_id) {
    try {
			$db = new db();
			$db->q('SELECT todos.*, goals.tag FROM todos LEFT JOIN goals ON goals.goal_id = todos.goal WHERE todos.user = :user_id ORDER BY date ASC');
      $db->b(':user_id', $user_id);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_todos_by_date($date, $user_id) {
    try {
			$db = new db();
			$db->q('SELECT todos.*, goals.tag FROM todos LEFT JOIN goals ON goals.goal_id = todos.goal WHERE todos.user = :user_id AND date = :date');
      $db->b(':user_id', $user_id);
      $db->b(':date', $date);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function add_todo($todo, $date, $user_id, $goal_id) {
    try {
			$db = new db();
			$db->q('INSERT INTO todos (todo, date, user, goal) VALUES (:todo, :date, :user_id, :goal_id)');
      $db->b(':todo', $todo);
      $db->b(':date', $date);
      $db->b(':user_id', $user_id);
      $db->b(':goal_id', $goal_id);
			$ret = $db->x();
      $lid = $db->lid();
			$db->rc();
			$db = null;
			return ["res" => $ret, "todo_id" => $lid];
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function update_todo($field, $todo_id, $user_id) {
    try {
      
      $field_concat = '';
      foreach ($field as $key => $val) {
        $field_concat = $key.' = "'.$val.'"';
      }
      
      
      $db = new db();
			$db->q('UPDATE todos SET '.$field_concat.'WHERE todo_id = :todo_id AND user = :user_id');
      $db->b(':todo_id', $todo_id);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function delete_todo($todo_id, $user_id) {
    try {
      $db = new db();
			$db->q('DELETE FROM todos WHERE todo_id = :todo_id AND user = :user_id');
      $db->b(':todo_id', $todo_id);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function delete_all_todos_by_date($date, $user_id) {
    try {
      $db = new db();
			$db->q('DELETE FROM todos WHERE date = :date AND user = :user_id');
      $db->b(':date', $date);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }
}


class Goals {
  static public function get_todo_count_in_goals($user_id) {
    try {
			$db = new db();
			$db->q('SELECT goals.goal_id, COUNT(*) AS total_todo, SUM(todos.is_finished > 0) AS total_finished FROM goals JOIN todos ON todos.goal = goals.goal_id WHERE goals.user = :user_id GROUP BY goal_id');
      $db->b(':user_id', $user_id);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_all_goals($user_id) {
    try {
			$db = new db();
			$db->q('SELECT * FROM goals WHERE user = :user_id');
      $db->b(':user_id', $user_id);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_goal_by_id($goal_id, $user_id) {
    try {
			$db = new db();
			$db->q('SELECT * FROM goals WHERE goal_id = :goal_id AND user = :user_id');
      $db->b(':goal_id', $goal_id);
      $db->b(':user_id', $user_id);
			$ret = $db->s();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function get_all_todos_in_goal($goal_id, $user_id) {
    try {
			$db = new db();
			$db->q('SELECT * FROM todos WHERE goal = :goal_id AND user = :user_id');
      $db->b(':goal_id', $goal_id);
      $db->b(':user_id', $user_id);
			$ret = $db->m();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function add_goal($user_id) {
    try {
			$db = new db();
			$db->q('INSERT INTO goals SET user = :user_id');
      $db->b(':user_id', $user_id);
			$ret = $db->x();
      $lid = $db->lid();
			$db->rc();
			$db = null;
			return ["res" => $ret, "goal_id" => $lid];
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function update_goal($field, $goal_id, $user_id) {
    try {
      $field_concat = '';
      foreach($field as $key => $val) {
        $field_concat = $key.' = "'.$val.'"';
      }

			$db = new db();
			$db->q('UPDATE goals SET '.$field_concat.' WHERE goal_id = :goal_id AND user = :user_id');
      $db->b(':goal_id', $goal_id);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function delete_all_todos_in_goal($goal_id, $user_id) {
    try {
			$db = new db();
			$db->q('DELETE FROM todos WHERE goal = :goal_id AND user = :user_id');
      $db->b(':goal_id', $goal_id);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }

  static public function delete_goal_by_id($goal_id, $user_id) {
    try {
			$db = new db();
			$db->q('DELETE FROM goals WHERE goal_id = :goal_id AND user = :user_id');
      $db->b(':goal_id', $goal_id);
      $db->b(':user_id', $user_id);
			$ret = $db->x();
			$db->rc();
			$db = null;
			return $ret;
		} catch (PDOException $e) {
	    die();
		}
  }
}
?>