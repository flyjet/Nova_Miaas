<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php  
	//resource allocaiton
	// message format userID/emulaterFlag/host_id/mobile_id/toDo   (1/1/1/1/on)
	$enough_device =false;
	$reqNumber = $_SESSION["req_number"];
	$reqName = $_SESSION["req_Device"];
	 //echo $_SESSION["req_Device"];
	$message_array = array();
	$begin_array=array();
	$noEnough_message = "Sorry there is not enough device for you to launch now, please try again or reserve first.";
	$err_message = "Your request to launch the device is failed, please try again";
	$hostId_set= ResourceAllocation::order_HostId_device();   //get host_Id, and used_device_no in assocate array
	if(!isset($hostId_set)){
		$_SESSION["message"] = $err_message;
	}
	else{
		while ($row = mysqli_fetch_assoc($hostId_set)){  //loop each host 
  			$hostId = $row["id"];
  			$device_set = ResourceAllocation::found_freeDevice_by_Brand( $_SESSION["req_Device"],$hostId,$reqNumber);
			$count = mysqli_num_rows($device_set);  //found result number

			if($count > 0){   //current host has free device
				if($count >= $reqNumber){
					$begin_array= ResourceAllocation::get_message_array_on($device_set,$_SESSION["user_id"],"1",$hostId);
			  		$message_array=array_merge($message_array, $begin_array);
			  		$reqNumber =0;
			  		break; 
				}else{   //$count <$reqNumber
					$reqNumber = $reqNumber - $count;
					$begin_array= ResourceAllocation::get_message_array_on($device_set,$_SESSION["user_id"],"1",$hostId);
			  		$message_array=array_merge($message_array, $begin_array);
				}
			}
		}//end of while loop
		if($reqNumber >0){   //reqNumber than all free device
			$enough_device =false;
			$_SESSION["message"] = $noEnough_message;		
		}elseif($reqNumber == 0)
		{
			$enough_device =true;
		}
		//print_r($message_array);

	}//end of else
?>
<?php 
	$arrlength = count($message_array);
	$send = array();
	$showlist = array();
	$userId = $_SESSION["user_id"];
  	$action = "on";
  	$all_pass = false;
  	$all_fail = false;    //false means all fail
?>
<?php include("send_rec_device.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		    	<!-- end of class row 1-->
			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_reserved" ?>
				<?php include("aside_bar.php"); ?>
	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
					<p style="font-size:17px; margin-left:1em;"> 
	         			Your request &nbsp &nbsp <?php echo $_SESSION["req_number"]; ?>   &nbsp<?php echo $_SESSION["req_Device"]; ?> 
	         			<br>
	         			<br>
	         		</p>
					<?php //show result
	         			if(($all_pass || $all_fail)){   //have some launch success
	         				 if($all_pass && $enough_device){ ?>
		         				 <p class="bg-info" style="height:3em; margin-left:1em;">
		         					<span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
		         				    <h3green>Your instance is now running.</h3green> <br></p>
	         				 <?php
	         				 	} elseif(!$all_pass && $all_fail && $enough_device){ ?>
		         				<p class="bg-warning" style="height:3em; margin-left:1em;">
		         				<span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
		         				<h3red>The following instance is now running, but other is fail</h3red> <br></p>
	         				 <?php				
	         				 	} elseif(!$enough_device) {?>
	         				 	<p class="bg-warning" style="height:3em; margin-left:1em;">
		         				<span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
		         				<h3red>The following instance is now running, 
		         						but there is not enough device for all your request.</h3red> <br></p>
	         				 <?php
	         				 	} //end of elseif
	         				 ?> 	
	         					<table class="table table-striped" style="margin-left:1em;">
					                <thead>
					                  <tr>
					                    <th>Id</th>
					                    <th>Type</th>
					                    <th>Brand Name</th>
					                    <th>Host Ip </th>
					                    <th>Instance IP</th>
					                    <th>Status</th>					                    
					                  </tr>
					                </thead>
			                		<tbody>
			                			<?php 
			                				$x =1;
											for ($i=0; $i < $arrlength; $i++) { 
												if(isset($showlist[$i])){ ?>
												<tr>
													<td><?php echo $x; ?></td>
													<td><?php echo $showlist[$i][0]; ?></td>
													<td><?php echo $showlist[$i][1]; ?></td>
													<td><?php echo $showlist[$i][2];?></td>
													<td><?php echo $showlist[$i][3]; ?></td>
													<td><?php echo $showlist[$i][4]; ?></td>				
												</tr> 
												<?php 
												$x++;
												}//enf of if isset
											}//end of for loop			
											?>
									</tbody>
	              				</table>
	         				 
	              				<p style="font-size:17px; margin-left:1em;"> 
			              			<h2orange>Connect to your device</h2orange>
			              			<br>For Windows customer
			              			<ol style="font-size:15px;">
				              			<li> Open your PuTTY</li>
				              			<li> In Host Name (or IP address) enter the host IP</li>
				              			<li> Please enter username: thigod</li>
				              			<li> Please enter password: 9769 </li>
				              			<li> Now you can use "adb -s yourDeviceIP" command to control your device</li>
			              			</ol>
			              		</p>
			              		<p style="font-size:17px; margin-left:1em;"> 	
			              			For MacOS/Linux/Unix customer:
			              			<ol style="font-size:15px;">
				              			<li> Open your terminal</li>
				              			<li> Please enter $ssh thigod@hostIP</li>
				              			<li> Please enter password: 9769 </li>
				              			<li> Now you can use "adb -s yourDeviceIP" command to control your device</li>
			              			</ol>      			
	         					</p>
	         				<?php	//end of if all_pass
	         				 }  elseif(!$all_fail){ ?>
	         				 <p class="bg-danger" style="height:3em; margin-left:1em;">
	         				 <span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
	         				 <h3red><?php echo $_SESSION["message"]; ?></h3red> <br></p>		              	
	         				 <?php //end of elseif
	         					}elseif(!$enough_device){ ?>
	         					<p class="bg-danger" style="height:3em; margin-left:1em;">
	         				 <span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
	         				 <h3red><?php echo $noEnough_message ; ?></h3red> <br></p>	
							<?php
	         					}  //end of elseif
	         					?>
				       	         		
	         	</article>

	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>