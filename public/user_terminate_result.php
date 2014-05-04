<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $emulatorId =$_GET["id"];  
  $userId = $_SESSION["user_id"];
  $action = "ter";
  $send =false;
  // get the message which need to send to queue
  $message = ResourceAllocation::get_message_string($emulatorId, $userId, $action);
  if(empty($message)){
  	//empty message
  	$_SESSION["message"] = "Your request to terminate the instance is failed, please try again";
  } else{
  	//send message to queue
  	$send =SQS_message::send_message_to_SQS($message);
		if($send){
			//if send success, and wait for message 
			//???????????????????????
		}
		else{
			$_SESSION["message"] = "Your request to terminate the instance is failed, please try again";
		}
  }
?>
<?php
	//receive message from queue
		//???????????????????????   need while loop to check if the Queue has message
	
	$receive =false;
	$list =array();
	$showList ="";
	$rec_msg_array = array();
	$rec_msg_body_array =array();
	$messagebody= SQS_message::receive_message_from_SQS();   //return message*message_handle*queue_Url
	if(empty($messagebody)){
  			//empty message 	
	}
	else{
		$receive =true;		
		$rec_msg_body_array = explode("*", $messagebody);   //($hostId, $instanceId, $status, $pass/fail)
		
		$message_handle = $rec_msg_body_array[1];
		$msg_queueUrl = $rec_msg_body_array[2];

		//$rec_message = $rec_msg_body_array[0];
		$rec_message = "1/2/ter/pass";   	//?????

		$rec_msg_array = explode("/", $rec_message);
		if ($rec_msg_array[2] = "off"){
			if($rec_msg_array[3] = "pass"){
				$showlist = ResourceAllocation::found_mobile_Result_by_instanceId($rec_msg_array[0],$rec_msg_array[1],"ter");
				// showlist will be show in html page (device, hostIp,deviceIp,brand/api, stauts,)
			}
			else{
				$_SESSION["message"] = "Your request to terminate the instance is failed, please try again";			
			}
			//then delete the message
			SQS_message::delete_message_from_SQS($msg_queueUrl, $message_handle);
		}		
	}
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
	         		<p class="bg-info" style="height:3em; margin-left:1em;">
	         			<span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
	         			<h3green>Your instance is terminated.</h3green> <br></p>
	         		<table class="table table-striped" style="margin-left:1em;">
			            <thead>
			                  <tr>
			                    <th>Id</th>
			                    <th>Type</th>
			                    <th>Brand Name</th>
			                    <th>Host IP</th>
			                    <th>Instance IP</th>
			                    <th>Status</th>			                    		
			                    <th></th>	
			                  </tr>
			            </thead>
			            <tbody>							
							<tr>
								<td><?php echo 1; ?></td>
								<td><?php echo $showlist[0]; ?></td>
								<td><?php echo $showlist[1]; ?></td>
								<td><?php echo $showlist[2];?></td>
								<td><?php echo $showlist[3]; ?></td>
								<td><?php echo $showlist[4]; ?></td>				
							</tr>  
			            </tbody>
	              	</table>



					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<br>
	         			<h2orange>Create Instance</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS you will want to launch a mobile emulator, known as an Nova MIaaS instance. </p>
	         		<p style="margin-left:1em;margin-top:2em"><a href="user_request.php" class="btn btn-warning">Launch Instance</a></p>
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>