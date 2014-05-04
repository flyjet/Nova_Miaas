<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $emulatorId =$_GET["id"];  
  $userId = $_SESSION["user_id"];
  $action = "on";

    $send =false;
  // get the message which need to send to queue
  $message = ResourceAllocation::get_message_string($emulatorId, $userId, $action);
  if(empty($message)){
  	//empty message
  	$_SESSION["message"] = "Your request to turn on the instance is failed, please try again";
  } else{
  	//send message to queue
  	$send =SQS_message::send_message_to_SQS($message);
		if($send){
			//if send success, and wait for message 
			//???????????????????????
		}
		else{
			$_SESSION["message"] = "Your request to turn on the instance is failed, please try again";
		}
  }

  echo " message ****";
  echo $message;

?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_dashboard" ?>
				<?php include("aside_bar.php"); ?>
	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Your instance is running. </p>



					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Create Instance</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS you will want to launch a mobile emulator, known as an Nova MIaaS instance. </p>
	         		<p style="margin-left:1em;margin-top:2em"><a href="user_request.php" class="btn btn-warning">Launch Instance</a></p>
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>