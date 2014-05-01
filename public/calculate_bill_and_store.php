<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

if (date("d")==1) { //if it's the first day of the month
	$billStart = date("Y-m-d H:i:s", mktime(0,0,0,date("m")-1,1,date("Y")) ); 
	$billEnd = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),1,date("Y")) ); 
	$result=BillManager::find_bills_by_userid_and_time($_SESSION["user_id"], $billStart );

	if (!$result) { //if could not find the records of bill, will creat a bill 
		$userLastMonthBillSum=BillManager::find_and_build_bill_sum($_SESSION["user_id"], $billStart, $billEnd);
		$billDue = date("Y-m-d H:i:s", mktime(0,0,0,date("m")+1,1,date("Y")) );
		$insert_result=BillManager::insert_bill($_SESSION["user_id"], $billStart,$billEnd,$billDue, $userLastMonthBillSum["totalBill"]);
		if ($insert_result){
			//$_SESSION["message"] = "Last month bill created";
			BasicHelper::redirect_to("user_dashboard.php");
		}
	}
	else {
		//echo "find the bill of last month";
		BasicHelper::redirect_to("user_dashboard.php");
	}
		
}
else {
	BasicHelper::redirect_to("user_dashboard.php");
}

	
?>