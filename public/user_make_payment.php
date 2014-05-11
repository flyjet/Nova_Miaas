<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

$bill_id=$_GET['billid'];
$paymentinfo=UserManager::find_paymentinfo_by_userid($_SESSION["user_id"]);
	
$result=BillManager::update_bill_as_paid($_SESSION["user_id"], $bill_id);
if ($result){
	$result2=BillManager::insert_payment ($_SESSION["user_id"], $bill_id, $paymentinfo["id"]);
	if ($result2){
		$_SESSION["message"] = "Your last bill has been paid";
	}
	else {
		$_SESSION["message"] = "Your last bill has been updated, but no payment record created";
	}
	BasicHelper::redirect_to("user_bill.php");
	
}
else {
	$_SESSION["message"] = "The payment for your last bill failed";
	BasicHelper::redirect_to("user_bill.php");
}

	
?>