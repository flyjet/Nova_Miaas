<?php for($x=0;$x<$arrlength;$x++){
	$send[$x] =false;
	  $receive =false;

	  $showList[$x] ="";
	  $rec_msg_array = array();
	  $rec_msg_body_array =array();
	  $start_time = time();

	  $send_message = $message_array[$x];
	  $sd_msg_array = explode("/",$send_message);  //($userId, $emulator_flag, $hostId, $instanceId, $action)
	  if(empty($send_message)){
	  	//empty message
	  	$_SESSION["message"] = $err_message;
	  } else{ 	
	  	$send[$x] =SQS_message::send_message_to_SQS($send_message); //send message to queue
			if($send[$x]){     //if send success, and wait for message 
				while(true){
					$messagebody= SQS_message::receive_message_from_SQS();   //return message*message_handle*queue_Url
					if(!empty($messagebody)){

						$rec_msg_body_array = explode("*", $messagebody);   
						$rec_message = $rec_msg_body_array[0];			
						$message_handle = $rec_msg_body_array[1];
						$msg_queueUrl = $rec_msg_body_array[2];
						$rec_msg_array = explode("/", $rec_message);  //($hostId, $instanceId, $status, $pass/fail)
						if($sd_msg_array[2] == $rec_msg_array[0] &&  $sd_msg_array[3]==$rec_msg_array[1] && $sd_msg_array[4] == $rec_msg_array[2]){
								$receive = true;
								if($rec_msg_array[3] == "pass"){
									$showlist[$x] = ResourceAllocation::found_mobile_Result_by_instanceId($rec_msg_array[0],$rec_msg_array[1], $action);
									// showlist will be show in html page (device, hostIp,deviceIp,brand/api, stauts,)
								}
								elseif($rec_msg_array[3] == "fail"){
									$_SESSION["message"] = $err_message;	
								}
								//then delete the message							
								SQS_message::delete_message_from_SQS($msg_queueUrl, $message_handle);
								break;
						}
					} else{
						//empty message, loop again  	
						if ((time() - $start_time) > 30){
						$_SESSION["message"] = $err_message;
						$receive =false;
	      				break; // timeout, function took longer than 120 seconds
	    				}
					}//end of else
				} //end of while	
				
			} //end of if send
			else{
				$_SESSION["message"] = $err_message;
			}
	  } //end of else
	  $all_pass = $all_pass && isset($showlist[$x]);
	  $all_fail = $all_fail || isset($showlist[$x]);
	}//end of for loop
?>