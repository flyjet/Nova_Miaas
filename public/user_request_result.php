<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$reqNumber = $_SESSION["req_number"];
	$message_array = array();
	$begin_array=array();

  	$hostId_set= ResourceAllocation::order_HostId_emulator();   //get host_Id, and used_device_no in assocate array
  		while ($row = mysqli_fetch_assoc($hostId_set)){  //loope each host 
  			$hostId = $row["id"];
  			$freeNum = ResourceAllocation::$maxMobiles_perHost - $row["used_emulator_no"];

  			if($freeNum >= $reqNumber){  //one host is enough
  				$emulator_set = ResourceAllocation::found_freeEmulator_by_brand( $_SESSION["req_Instance"],$hostId,$reqNumber);
				if (!$emulator_set) {
					//not have emulator is ready in server side
					$_SESSION["message"] = "There is some problem to progress your request, please try again. ";
		  		}
		  		else{
		  			$begin_array= ResourceAllocation::get_message_array_on($emulator_set,$_SESSION["user_id"],"0",$hostId);
		  			$message_array=array_merge($message_array, $begin_array);
		  		 	break; 
		  		} //end of else

  			} //if($freeNum >= $reqNumber)
  			else 
  			{
 				$emulator_set = ResourceAllocation::found_freeEmulator_by_brand( $_SESSION["req_Instance"],$hostId,$freeNum);
				if (!$emulator_set) {
					//not have emulator is ready in server side
		  		}
		  		else{
		  			$reqNumber = $reqNumber - $freeNum;
		  			$begin_array= ResourceAllocation::get_message_array_on($emulator_set,$_SESSION["user_id"],"0",$hostId);
		  			$message_array=array_merge($message_array, $begin_array);
		  		}		  		
  			}
  		}
?>
<?php	
	$arrlength=count($message_array);
	for($x=0;$x<$arrlength;$x++) {
		$send =SQS_message::send_message_to_SQS($message_array[$x]);
		if($send){
			echo "send request to SQS  **";
			echo $message_array[$x];
		}
		else{
			echo "something wrong when send request to SQS";
		}
	}
?>
<?php
	//???????????????????????
	//need while loop to check if the Queue has message
	$messagebody= SQS_message::receive_message_from_SQS();
	echo $messagebody;
?>

<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->
			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_request" ?>
				<?php include("aside_bar.php"); ?>
	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Your Result </p>

	         		<?php
	         			$arrlength=count($message_array);

	         			for($x=0;$x<$arrlength;$x++) {
							  echo $message_array[$x];
							  echo "<br>";
						}
	         		?>


	         		<img src="image/loading4.gif"  id="loading-indicator"/>
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>