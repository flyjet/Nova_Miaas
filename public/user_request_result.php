<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php  
	//resource allocaiton
	// message format userID/emulaterFlag/host_id/mobile_id/toDo   (1/0/1/1/on)

	$reqNumber = $_SESSION["req_number"];
	//echo $_SESSION["req_Instance"];
	$message_array = array();
	$begin_array=array();
	$err_message = " Your request to launch the instance is failed, please try again";

  	$hostId_set= ResourceAllocation::order_HostId_emulator();   //get host_Id, and used_device_no in assocate array
  		while ($row = mysqli_fetch_assoc($hostId_set)){  //loope each host 
  			$hostId = $row["id"];
  			$freeNum = ResourceAllocation::$maxMobiles_perHost - $row["used_emulator_no"];

  			if($freeNum >= $reqNumber){  //one host is enough
  				$emulator_set = ResourceAllocation::found_freeEmulator_by_brand( $_SESSION["req_Instance"],$hostId,$reqNumber);
				if (!isset($emulator_set)) {
					//not have emulator is ready in server side
					$_SESSION["message"] = $err_message;
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
				if (!isset($emulator_set)) {
					$_SESSION["message"] = $err_message;
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
	$arrlength = count($message_array);
	$send = array();
	$showlist = array();
	$userId = $_SESSION["user_id"];
  	$action = "on";
  	$all_pass = true;
  	$all_fail = false;    //false means all fail

?>
<?php include("send_rec_launch.php"); ?>
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

	         			<p style="font-size:17px; margin-left:1em;"> 
	         				Your request &nbsp &nbsp <?php echo $_SESSION["req_number"]; ?> &nbsp <?php echo $_SESSION["req_Instance"]; ?> 
	         				<br>
	         				<br>
	         			</p>
	         				 <?php 
	         				 if($all_pass || $all_fail){ 
	         				 		if($all_pass){ ?>
		         				 		<p class="bg-info" style="height:3em; margin-left:1em;">
		         					    <span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
		         					    <h3green>Your instance is now running.</h3green> <br></p>
	         				 		<?php
	         				 		} elseif(!$all_pass && $all_fail){ ?>
		         				 		<p class="bg-warning" style="height:3em; margin-left:1em;">
		         					    <span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
		         					    <h3red>The following instance is now running, but other is fail</h3red> <br></p>
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
			              			<h2orange>Connect to your instance</h2orange>
			              			<ol style="font-size:15px;">
				              			<li> Open an SSH client.</li>
				              			<li> Connect to your instance using its Host Ip</li>
				              			<li> Example:</li>
			              			</ol>
			              	
			         				<br>
			         				<br>
	         					</p>
	         				 <?php	//end of if all_pass
	         				 }  elseif(!$all_fail){ ?>
	         				 <p class="bg-danger" style="height:3em; margin-left:1em;">
	         				 <span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
	         				 <h3red><?php echo $_SESSION["message"]; ?></h3red> <br></p>		              	
	         				 <?php //end of elseif
	         				}?>
	              							
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>