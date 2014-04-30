<?php  //Nova_MIaaS functions, categorized into different class
//class list: BasicHelper, UserManager, BillManager,ResourceAllocation .....

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
	
	public static function find_all_user() {
		global $connection;
				
		$query  = "SELECT * ";
		$query .= "FROM users ";
		$query .= "WHERE admin_authority = 0 ";
		$result_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($result_set);
		$result_array = array();
	    while ($row = mysqli_fetch_array($result_set)) {
	        $result_array[] = $row;
	    }
	    return $result_array;	
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
	
	public static function insert_user($firstname="", $lastname="", $email="",$password=""){
	    global $connection;
		$query  = "insert into users (first_name, last_name, email, password) values ( ";
	    $query .= " '{$firstname}', ";
		$query .= " '{$lastname}', ";
	    $query .= " '{$email}', ";
	    $query .= " '{$password}') ";
		$result = mysqli_query($connection, $query);
		return $result;
		
	
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
	
	public static function insert_paymentinfo(
		$userid, $cardnumber, $name, $expire, $street, $city, $state, $postal, $country,$phone){
	    global $connection;
		$query  = "insert into paymentinfo (user_id, card_number, name_on_card,
		          expire, street, city, state, postcode, country, phone) values ( ";
	    $query .= " {$userid}, ";
		$query .= " '{$cardnumber}', ";
		$query .= " '{$name}', ";
		$query .= " '{$expire}', ";
		$query .= " '{$street}', ";
	    $query .= " '{$city}', ";
	    $query .= " '{$state}', ";
		$query .= " '{$postal}', ";
		$query .= " '{$country}', ";
		$query .= " '{$phone}') ";
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

class BillManager{
	
	public static $HighMediumPriceThreshold=50;
	public static $MediumLowPriceThreshold=100;
	public static $EmulatorHighPrice=0.15;
	public static $EmulatorMediumPrice=0.10;
	public static $EmulatorLowPrice=0.05;
	public static $DeviceHighPrice=0.25;
	public static $DeviceMediumPrice=0.20;
	public static $DeviceLowPrice=0.15;
	
	public static function find_bills_by_userid($user_id,$number_limit=100){
		global $connection;		
		$query  = "SELECT * ";
		$query .= "FROM bills ";
		$query .= "WHERE user_id = {$user_id} ";
		$query .= "ORDER BY bill_end DESC ";
		$query .= "LIMIT {$number_limit} ";
		$result_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($result_set);
		$result_array = array();
	    while ($row = mysqli_fetch_array($result_set)) {
	        $result_array[] = $row;
	    }

	    return $result_array;
				
	}
	
	public static function find_bills_by_userid_and_time($user_id,$start ){
		global $connection;		
		$query  = "SELECT * ";
		$query .= "FROM bills ";
		$query .= "WHERE user_id = {$user_id} ";
		$query .= "AND bill_start = '{$start}' ";
		$query .= "LIMIT 1 ";
		$result = mysqli_query($connection, $query);
	    return $result;
				
	}
	
	public static function insert_bill ($userid, $start, $end, $due, $amount){
	    global $connection;
		$query  = "insert into bills (user_id, bill_start, bill_end, bill_due, amount) values ( ";
	    $query .= " {$userid}, ";
		$query .= " '{$start}', ";
		$query .= " '{$end}', ";
		$query .= " '{$due}', ";
		$query .= " {$amount} ) ";
		$result = mysqli_query($connection, $query);
		return $result;	
		
	}
	
	
	
	public static function buildBillsArray($data_array){ 
		//  $data_array should be array of bills
        //build array for google chart data
	    $output = "['Bill Start Time', 'Bill Amount'], ";
		$i=0;
	    // The data needs to be in a format ['string', decimal]
	   while (!empty($data_array[$i]) ){
	        $output .= "['" . $data_array[$i]['bill_start'] . "', ";
	        $output .= $data_array[$i]['amount'] . " ";  
	        // On the final count do not add a comma
	        if (!empty($data_array[$i+1]) ){
	            $output .= "],\n";
	        } else {
	            $output .= "]\n";
	        }
			$i++;
	    };

	    return $output;
	}
	
	public static function find_payments_by_userid($user_id=0,$number_limit=100){
		global $connection;		
		$query  = "SELECT h.user_id, h.paid_time, b.amount, p.card_number ";
		$query .= "FROM pay_history h, bills b, paymentinfo p ";
		$query .= "WHERE h.user_id = {$user_id} AND h.bill_id=b.id AND h.payinfo_id=p.id ";
		$query .= "ORDER BY h.paid_time DESC ";
		$query .= "LIMIT {$number_limit} ";
		$result_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($result_set);
		$result_array = array();
	    while ($row = mysqli_fetch_array($result_set)) {
	        $result_array[] = $row;
	    }

	    return $result_array;
				
	}

	
	public static function buildPaymentsArray($data_array){   
        //build array for google chart data
	    $output = "['Paid Time', 'Bill Amount', 'Payment Card'], ";
		$i=0;
	    // The data needs to be in a format ['string', decimal, 'string']
	   while (!empty($data_array[$i]) ){
	        $output .= "['" . $data_array[$i]['paid_time'] . "', ";
	        $output .= $data_array[$i]['amount'] . ", "; 
			$output .= $data_array[$i]['card_number'] . " ";   
	        // On the final count do not add a comma
	        if (!empty($data_array[$i+1]) ){
	            $output .= "],\n";
	        } else {
	            $output .= "]\n";
	        }
			$i++;
	    };

	    return $output;
	}
	
	public static function find_usage_records_by_userid ($user_id, $mobile_type="", $bill_start="", $bill_end="",$mobile_id=""){
		//could find usage records of specific user, with specific type (emulator or device or all)
		//with specific start time , end time (optional), with specific mobile_id (optional);
		//$user_id,$mobile_type,$bill_start are necessary
		// issues of this funtion:
		//could not consider the records duration over the start time point, or end time point!!!
		global $connection;		
		$query  = "SELECT um.id, um.user_id, um.mobile_id, um.start_time, um.end_time ";
		$query .= ", m.emulator_flag ";
		$query .= "FROM user_mobile um,  mobiles m ";
		$query .= "WHERE um.mobile_id = m.id AND um.user_id = {$user_id} AND um.start_time > '{$bill_start}' ";
		$query .= "AND um.mobile_id = m.id ";
		if($mobile_type=="EMULATOR"){  //if just ask for emulator
		$query .= "AND m.emulator_flag=0 ";  
	    }
		elseif($mobile_type=="DEVICE") {  ////if just ask for device
		$query .= "AND m.emulator_flag=1 ";	
		}
		if($bill_end!=""){
		$query .= "AND um.end_time < '{$bill_end}' ";
		}
		if($mobile_id!=""){
		$query .= "AND um.mobile_id = {$mobile_id} ";
		}
		$query .= "ORDER BY um.start_time DESC ";
		$result_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($result_set);
	    while ($row = mysqli_fetch_array($result_set)) {
	        $result_array[] = $row;
	    }
	    return $result_array;
		
	}
	
	public static function calculate_total_hour_mobile($user_mobile_records){
		//precondition: $user_mobile_records is the result array contains records of rows of Table user_mobile
		global $connection;	
		$total_hour_mobile=0;
		if ($user_mobile_records!=null){
		foreach( $user_mobile_records as $user_mobile_row){
			//echo " start time is ".$user_mobile_row["start_time"];
			//echo " end time is ".$user_mobile_row["end_time"];
			$time1 = strtotime($user_mobile_row["end_time"]);
			$time2 = strtotime($user_mobile_row["start_time"]);
			$hour_mobile=($time1-$time2)/3600;
			//echo " usage is ".$hour_mobile;
			$total_hour_mobile += $hour_mobile;			
		}
		return $total_hour_mobile;	
		}	
		
	}
	
	public static function calculate_bill_by_type ($hour_mobile, $type="EMULATOR"){
		if($type=="EMULATOR"){
			if($hour_mobile<=static::$HighMediumPriceThreshold) {
				return $hour_mobile*static::$EmulatorHighPrice;
			}
			elseif($hour_mobile<=static::$MediumLowPriceThreshold){
				return ($hour_mobile-static::$HighMediumPriceThreshold)*static::$EmulatorMediumPrice
					    + static::$HighMediumPriceThreshold*static::$EmulatorHighPrice;
			}
			else{
				return ($hour_mobile-static::$MediumLowPriceThreshold)*static::$EmulatorLowPrice 
				        + (static::$MediumLowPriceThreshold - static::$HighMediumPriceThreshold) * static::$EmulatorMediumPrice
					    + static::$HighMediumPriceThreshold* static::$EmulatorHighPrice;
			}			
		}

		if($type=="DEVICE"){
			if($hour_mobile<=static::$HighMediumPriceThreshold) {
				return $hour_mobile*static::$DeviceHighPrice;
			}
			elseif($hour_mobile<=static::$MediumLowPriceThreshold){
				return ($hour_mobile-static::$HighMediumPriceThreshold)*static::$DeviceMediumPrice
					    + static::$HighMediumPriceThreshold*static::$DeviceHighPrice;
			}
			else {
				return ($hour_mobile-static::$MediumLowPriceThreshold)*static::$DeviceLowPrice 
				        + (static::$MediumLowPriceThreshold - static::$HighMediumPriceThreshold) * static::$DeviceMediumPrice
					    + static::$HighMediumPriceThreshold* static::$DeviceHighPrice;			
			}
		}
		
	}
	
    public static function findAndBuildBillArray($user_id=0,$start="",$end=""){
		//could find specifica user's all bill for emulator and device respectively during a specific time
		//Post Condition: return an Array for google chart
		// issues of this funtion:
		//could not consider the records duration over the start time point, or end time point!!!
	    $deviceRecords = BillManager::find_usage_records_by_userid($user_id,"DEVICE", $start, $end);
	    $deviceHourMobile = BillManager::calculate_total_hour_mobile($deviceRecords);
	    $deviceBill =BillManager::calculate_bill_by_type($deviceHourMobile,"DEVICE");
   

	    $emulatorRecords = BillManager::find_usage_records_by_userid($user_id,"EMULATOR", $start,$end);
	    $emulatorHourMobile = BillManager::calculate_total_hour_mobile($emulatorRecords);   
	    $emulatorBill =BillManager::calculate_bill_by_type($emulatorHourMobile,"EMULATOR");
   
	    $userBillTableData = "['Type', 'Used Time(hr*mobile)','Bill Amount($)'], ";
	    $userBillTableData.=  "['Emulator', " . $emulatorHourMobile . ", ";
	    $userBillTableData.=  $emulatorBill."],\n";
	    $userBillTableData.=  "['Device', " . $deviceHourMobile . ", ";
	    $userBillTableData.=  $deviceBill."],\n";  
   
	    return $userBillTableData;
    }
	
    public static function find_and_build_bill_sum($user_id=0,$start="",$end=""){
		//could find specifica user's all bill for emulator and device respectively during a specific time
		//Post Condition: return an Array contain bill sum for total used time, total bill for each user
		// issues of this funtion:
		//could not consider the records duration over the start time point, or end time point!!!
	    $deviceRecords = BillManager::find_usage_records_by_userid($user_id,"DEVICE", $start, $end);
	    $deviceHourMobile = BillManager::calculate_total_hour_mobile($deviceRecords);
	    $deviceBill =BillManager::calculate_bill_by_type($deviceHourMobile,"DEVICE");
   

	    $emulatorRecords = BillManager::find_usage_records_by_userid($user_id,"EMULATOR", $start,$end);
	    $emulatorHourMobile = BillManager::calculate_total_hour_mobile($emulatorRecords);   
	    $emulatorBill =BillManager::calculate_bill_by_type($emulatorHourMobile,"EMULATOR");
   
        $userBillSum['totalTime']=$deviceHourMobile + $emulatorHourMobile;
		$userBillSum['totalBill']=$deviceBill + $emulatorBill;

	    return $userBillSum;
    }
	
	public static function findAndBuildUsersSumArray($users_array=NULL,$start="", $end=""){
		//$users_arry should be users_array contain array of users
		$output = "['User ID','User Name', 'Current Month Total Usage (hour*mobile)','Current Month Bill Amount ($)'], ";
		$i=0;
		while (!empty($users_array[$i]) ){
			$userBillSum =	BillManager::find_and_build_bill_sum($users_array[$i]['id'],$start,$end);
			$output .= "['" . $users_array[$i]['id'] . "', ";
			$output .= " '". $users_array[$i]['first_name'] ." ".$users_array[$i]['last_name']. "', "; 
			$output .= $userBillSum['totalTime'] . ", ";
			$output .= $userBillSum['totalBill'] . ", ";
		     // On the final count do not add a comma
		     if (!empty($users_array[$i+1]) ){
		         $output .= "],\n";
		     } else {
		         $output .= "]\n";
		     }
			$i++;
		 };
		return $output;
	}
	
	
	public static function find_mobiles_by_userid($user_id=0,$start="",$end=""){
				
		// issues of this funtion:
		//could not consider the records duration over the start time point, or end time point!!!
		global $connection;		
		$query  = "SELECT id, emulator_flag, brand, api ";
		$query .= "FROM mobiles ";
		$query .= "WHERE id IN ";
		$query .= "(SELECT DISTINCT mobile_id FROM user_mobile ";
		$query .= "WHERE user_id = {$user_id} ";
		if($start!=""){
		$query .= "AND start_time > '{$start})' ";
		}
		if($end!=""){
		$query .= "AND end_time < '{$end})' ";
		}
		$query .= ")";
		$result_set = mysqli_query($connection, $query);
		BasicHelper::confirm_query($result_set);
		$result_array = array();
	    while ($row = mysqli_fetch_array($result_set)) {
	        $result_array[] = $row;
	    }
	    return $result_array;		
	}
	
	public static function buildMobileUsageReportArray($user_id,$start,$end,$used_mobiles_array){
	//$used_mobiles_array is the result from find_mobiles_by_userid()
	$MobileHourArray= array();	
	if($used_mobiles_array!=null){
		foreach($used_mobiles_array as $used_mobile){
			$used_mobile_id=$used_mobile["id"];
			$usageRecords = BillManager::find_usage_records_by_userid($user_id,"ALL", $start,$end,$used_mobile_id);
			$HourMobile = BillManager::calculate_total_hour_mobile($usageRecords);	
			$MobileHourArray[$used_mobile_id]=$HourMobile;		
		}
	}
	
	$output = "['Type', 'ID', 'Brand', 'API Level', 'Used Time(hr*mobile)'], ";
	$i=0;
    while (!empty($used_mobiles_array[$i]) ){
		if($used_mobiles_array[$i]['emulator_flag']==0){
	        $output .= "['Emulator', ";
		}
		else $output .= "['Device', ";
        $output .= $used_mobiles_array[$i]['id'] . " , "; 
		$output .= " ' ".$used_mobiles_array[$i]['brand'] . "', ";
		$output .= " ' ".$used_mobiles_array[$i]['api'] . "', "; 
		$mobile_id=$used_mobiles_array[$i]['id'];
		$output .= $MobileHourArray[$mobile_id] . " ";      
        // On the final count do not add a comma
        if (!empty($used_mobiles_array[$i+1]) ){
            $output .= "],\n";
        } else {
            $output .= "]\n";
        }
		$i++;
    };
	return $output;
	
   }   
   	
}

	class ResourceAllocation{

		public static $maxMobiles_perHost=5;



		//get all the emulators brand name and API for user to select
		public static function allEmulators(){
			global $connection;	
			$query  = "SELECT DISTINCT brand, api ";
			$query .= "FROM mobiles ";
			$query .= "WHERE emulator_flag = 0 ;";
			$result_set = mysqli_query($connection, $query);
			BasicHelper::confirm_query($result_set);
			
  			while($row = mysqli_fetch_assoc($result_set)) { 
				$emulator ="";
				$emulator .= $row["brand"];
				$emulator .= ", ";
				$emulator .= $row["api"];	
				$emulator .= " ";
				$result_array[] = $emulator;
			}
			return $result_array; 
		}


    //get all devices brand name and API for user to select
		public static function allDevices(){
			global $connection;	
			$query  = "SELECT DISTINCT brand, api ";
			$query .= "FROM mobiles ";
			$query .= "WHERE emulator_flag = 1 ;";
			$result_set = mysqli_query($connection, $query);
			BasicHelper::confirm_query($result_set);

			while ($row = mysqli_fetch_assoc($result_set)){
				$device ="";
				$device .= $row["brand"];
				$device .= ", ";
				$device .= $row["api"];	
				$result_array[] = $device;
			}	
			return $result_array;
		}


	//Order hostid by used_emulator_no, from big number   
		public static function order_HostId_emulator(){
			global $connection;	
			$query  = " SELECT id, used_emulator_no FROM hosts ";
			$query .= " WHERE status=1 ";
			$query .= " ORDER BY used_emulator_no DESC; ";
			$result_set = mysqli_query($connection, $query);
			BasicHelper::confirm_query($result_set);		

			return $result_set;
		}

	//Order hostid by used_device_no  //pass test
		public static function order_HostId_device(){
			global $connection;	
			$query  = " SELECT id, used_device_no  FROM hosts ";
			$query .= " WHERE status=1 ";
			$query .= " ORDER BY used_device_no DESC; ";
			$result_set = mysqli_query($connection, $query);
			BasicHelper::confirm_query($result_set);		

			return $result_set;
		}


	//get free emulator by brand name, host_id, and limit
		public static function found_freeEmulator_by_Brand($emulator, $host_id, $limit){
			$emulatorArray = explode(",", $emulator); //splitting string 
			$emulator_brand = $emulatorArray[0];

			global $connection;	
			$query  = "SELECT * ";
			$query .= "FROM mobiles ";
			$query .= "WHERE emulator_flag = 0 ";
			$query .= "AND status= 0 ";
			$query .= "AND host_id = '{$host_id}' ";
			$query .= "AND brand = '{$emulator_brand}' ";
			$query .= "LIMIT {$limit}; ";
			$result_set = mysqli_query($connection, $query);
			BasicHelper::confirm_query($result_set);
			return $result_set;
		}

	//from emulator_set to message_array
		public static function get_message_array_on($emulator_set,$userId,$emuFlag,$hostId){
			$i =0;
			while($rowEmulator = mysqli_fetch_assoc($emulator_set)){
		  			$emulator_id = $rowEmulator["id"];
		  			$message_array[$i]  = $userId;
		  			$message_array[$i] .= "/";
		  			$message_array[$i] .=$emuFlag;
		  			$message_array[$i] .="/";
		  			$message_array[$i] .= $hostId;
					$message_array[$i] .= "/";
	  				$message_array[$i] .= $emulator_id ;
	  				$message_array[$i] .= "/";
		  			$message_array[$i] .= "on";
		  			echo $message_array[$i] ;
		  			echo "**";
		  			$i++;
		  	}
		  	return $message_array;
		}
	}

?>
