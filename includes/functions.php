<?php  //Nova_MIaaS functions, categorized into different class
//class list: BasicHelper, UserManager,...

class BasicHelper{
	public static function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	public static function confirm_query($result_set) {
		if (!$result_set) {
			die("Database query failed.");
		}
	}

	public static function mysql_prep($string) {
		global $connection;		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
}

class UserManager{
	
	public static function confirm_logged_in() {
			if (!Session::logged_in()) {
				BasicHelper::redirect_to("login.php");
			}
	}
	
	public static function attempt_login($user_email, $password) {
		$user = static::find_user_by_email($user_email);
		if ($user) {
			// found player, now check password
			if (static::password_check($password, $user["password"])) {
				// password matches
				return $user;
			} else {
				// password does not match
				return false;
			}
		} else {
			// user not found
			return false;
		}
	}
	
	public static function find_user_by_email($user_email) {
		global $connection;
		
		$safe_user_email = mysqli_real_escape_string($connection, $user_email);
		
		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE email = '{$safe_user_email}' ";
		$query .= "LIMIT 1";
		$user_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($user_set);
		if($user = mysqli_fetch_assoc($user_set)) {
			return $user;
		} else {
			return null;
		}
	}
	
	public static function password_check($password, $existing_password) {
		if ($password === $existing_password) {
			return true;
		} else {
			return false;
		}
	}

	
			
}






?>
