<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

$bill_id=$_GET['billid'];

	
$result=BillManager::update_bill_as_paid($_SESSION["user_id"], $bill_id);
if ($result){
	$_SESSION["message"] = "Your last bill has been paid";
	BasicHelper::redirect_to("user_bill.php");
}
else {
	$_SESSION["message"] = "The payment for your last bill failed";
	BasicHelper::redirect_to("user_bill.php");
}

	
?>