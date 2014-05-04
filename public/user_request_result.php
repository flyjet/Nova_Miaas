<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php  
	//resource allocaiton
	// message format userID/emulaterFlag/host_id/mobile_id/toDo   (1/0/1/1/on)


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
	$send =false;
	//send message from SNS to SQS
	$arrlength=count($message_array);
	for($x=0;$x<$arrlength;$x++) {
		$send =SQS_message::send_message_to_SQS($message_array[$x]);
		if($send){
			//if send success, and wait for message 
			//???????????????????????

		}
		else{
			echo "something wrong when send request to SQS";
		}
	}
?>
<?php
	//???????????????????????
	//need while loop to check if the Queue has message
	$receive =false;
	$messagebody= SQS_message::receive_message_from_SQS();  
	if($messagebody){
		$receive =true;
	}
				//return message*message_handle*queue_Url

	$msg_array = explode("*", $messagebody);
	$message_handle = $msg_array[1];
	$msg_queueUrl = $msg_array[2];

	//do something, 

	//then delete the message
	if($messagebody){
		SQS_message::delete_message_from_SQS($msg_queueUrl, $message_handle);
	}

?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->
			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_request" ?>
				<?php include("aside_bar.php"); ?>
	         	<article class="col-lg-10" >
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em; ">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<!--loading-->
	         		<?php 
	         			if(!$send ||!$receive){
	         		?>
	         			<p style="font-size:16px; margin-left:1em;"> Please Wait </p>
	         			<img id="myimg" src="image/loading4.gif"  id="loading-indicator" style="margin-left:1em;" />
	         		<?php
	         			}
	         		?>
	         			<p style="font-size:17px; margin-left:1em;"> 
	         				Your request &nbsp &nbsp <?php echo $_SESSION["req_number"]; ?> &nbsp <?php echo $_SESSION["req_Instance"]; ?> 
	         				<br>
	         				<br>
	         				<p class="bg-info" style="height:3em; margin-left:1em;">
	         					<span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
	         					<h3green>Your instance is now launching</h3green> <br></p>

	         			</p>

		         		<table class="table table-striped" style="margin-left:1em;">
			                <thead>
			                  <tr>
			                    <th>Id</th>
			                    <th>Host Ip </th>
			                    <th>Emulator IP</th>	
			                    <th>Emulator Name</th>
			                    <th>Status</th>
			                    
			                  </tr>
			                </thead>
			                <tbody>
			                  <tr>
			                  	<td>1</td>
			                    <td><?php echo ResourceAllocation::found_hostIp_by_hostId(1);?></td>
			                    <td><?php echo ResourceAllocation::found_emulatorName_by_emuId(1);?></td>
			                    <td>running <td>
			                  </tr>
			                  <tr>
			                  	<td>2</td>
			                    <td><?php echo ResourceAllocation::found_hostIp_by_hostId(1);?></td>
			                    <td><?php echo ResourceAllocation::found_emulatorName_by_emuId(1);?></td>
			                    <td>running <td>
			                  </tr>
			                </tbody>
	              		</table>

	              		<p style="font-size:17px; margin-left:1em;"> 
	              			<h2orange>Connect to your instance</h2orange>
	              			<ol style="font-size:15px;">
		              			<li> Open an SSH client.</li>
		              			<li> Connect to your instance using its Host Ip</li>
		              			<li> Example:</li>
	              			</ol>
	              	
	         				<br>
	         				<br>
	         			</p>

              <?php
	         			$arrlength=count($message_array);
	         			for($x=0;$x<$arrlength;$x++) {
							  echo $message_array[$x];
							  echo "<br>";
						}
	         		?>

	         		
					
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>