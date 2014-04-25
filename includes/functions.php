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

	public static function escape_value($string) {
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
	
	public static function password_check($password, $existing_password) {
		if ($password === $existing_password) {
			return true;
		} else {
			return false;
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
		
		$safe_user_email = BasicHelper::escape_value($user_email);
		
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


	public static function find_paymentinfo_by_userid( $user_id=0 ) {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM paymentinfo ";
		$query .= "WHERE user_id = {$user_id} ";
		$query .= "LIMIT 1";
		$info_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($info_set);
		if($paymentinfo = mysqli_fetch_assoc($info_set)) {
			return $paymentinfo;
		} else {
			return null;
		}
		
	}
	
	public static function update_user($userid=0, $firstname="", $lastname="", $email="",$password=""){
		global $connection;
		$query  = "UPDATE users SET ";
	    $query .= "first_name = '{$firstname}', ";
		$query .= "last_name = '{$lastname}', ";
	    $query .= "email = '{$email}', ";
	    $query .= "password = '{$password}' ";
	    $query .= "WHERE id = {$userid} ";
	    $query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		return $result;
		
	}
	
	public static function update_paymentinfo(
		$userid, $cardnumber, $name, $expire,$street, $city, $state, $postal, $country,$phone){
		global $connection;
		$query  = "UPDATE paymentinfo SET ";
		$query .= "card_number = '{$cardnumber}', ";
	    $query .= "name_on_card = '{$name}', ";
		$query .= "expire = '{$expire}', ";
	    $query .= "street= '{$street}', ";
	    $query .= "city = '{$city}', ";
		$query .= "state = '{$state}', ";
		$query .= "postcode = '{$postal}', ";
		$query .= "country = '{$country}', ";
		$query .= "phone = '{$phone}' ";
	    $query .= "WHERE user_id = {$userid} ";
	    $query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);
		return $result;	
			
		}
		
			
}






?>
