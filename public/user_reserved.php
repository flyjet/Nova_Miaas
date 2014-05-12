<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$found_device_set = ResourceAllocation::allDevices();
		if (!$found_device_set) {
			//not have device ready in server side
  		}
?>
<?php
	if (isset($_POST['launch_now'])) {				
		// Process the form
		if (empty(Session::$errors)) {
			$request_number = ($_POST["requesttNumber"]);
			$_SESSION['req_number'] = $request_number;

			$request_device = ($_POST["requestDevice"]);
			$_SESSION["req_Device"] = $request_device;
			BasicHelper::redirect_to("user_device_result.php");
		}
	}//end of if (isset($_POST['submit']))
?>
<?php
	$timeWrong = false;
	if (isset($_POST['reserve'])) {		
		// Process the form
		if (empty(Session::$errors)) {
			$request_number = ($_POST['requesttNumber']);
			$_SESSION['req_number'] = $request_number;

			$request_device = ($_POST['requestDevice']);
			$_SESSION['req_Device'] = $request_device;

			$fromDate= ($_POST['fromDate']);
			$fromTime= ($_POST['fromTime']);
			$from ="";
			$from = $fromDate;
			$from .= " ";
			$from .=$fromTime;
			$from .=":00";
			$_SESSION['from'] = $from;

			$stopDate= ($_POST['stopDate']);
			$stopTime= ($_POST['stopTime']);
			$stop ="";
			$stop = $stopDate;
			$stop .= " ";
			$stop .=$stopTime;
			$stop .=":00";
			$_SESSION['stop'] = $stop;

			$f =strtotime($from);
			$fromValue = date("Y-m-d h:i:s", $f);

			$s =strtotime($stop);
			$stopValue = date("Y-m-d h:i:s", $s);

			//$today = new Datetime();
			//$todayValue = date("Y-m-d h:i:s",$today);

			$todayValue=date("Y-m-d h:i:s");

			if(($fromValue > $todayValue) && ($stopValue > $fromValue)){
				BasicHelper::redirect_to("user_reserved_result.php");		
			}else{
				$timeWrong= True;		
			}
		}

	}//end of if (isset($_POST['submit']))
?>
<?php include("loading.php"); ?>
<?php include("../includes/layouts/header.php"); ?>
			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		    <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
			<form action="user_reserved.php" method="post">
				<?php $activeMenu = "user_reserved" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">
					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Reserve Devices</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS mobile devices, you can launch now or reserve to use.</p>
	         		<div class="row" style=" margin-left:1em;">	
		         		<h5 style="font-size:18px; margin-left:1em;"> Available mobile devices</h5>
		         		<div class="col-xs-4">
			         		<select name="requestDevice" class="form-control">
				         	<?php
								foreach($found_device_set as $value){
							?>
							<option value="<?php echo $value;?>"><?php echo $value;?></option>
							<?php	
								}
							?>
							</select>
						</div>
					</div>

					<div class="row" style=" margin-left:1em;margin-top:1em;">	
		         		<h5 style="font-size:18px; margin-left:1em;"> Select the numbers</h5>

			         		<div class="col-lg-2">
				         		<select name="requesttNumber" class="form-control" >
								  <option value="1">1</option>
								  <option value="2">2</option>
								  <option value="3">3</option>
								  <option value="4">4</option>
								  <option value="5">5</option>	
								</select>
							</div>
							<div class="col-lg-6">
								<p style="margin-left:20px"> 
			         			<input class="btn btn-warning" id="loading" type="submit" name="launch_now" value="Launch Now" /> 
				      			</p>
				      		</div>
	         		</div> <!-- class row-->

					<div class="row" style=" margin-left:2em;margin-top:2em;">	
		         		<h5 style="font-size:18px; "> Select reserve time and end time </h5>
		         		<div class="row">
			         		<div class="col-xs-2">
			         			<input type="date" name="fromDate" value="" style="height: 32px; width: 155px"/> 
			         		</div>
			         		<div class="col-xs-2">
			         			<input type="time" name="fromTime" value="0:0:0" style="height: 32px; width: 120px"/> 
			         		</div>
							
							<div class="col-xs-2">
								<input type="date" name="stopDate" value="0:0:0" style="height: 32px; width: 155px"/> 
							</div>
							<div class="col-xs-2">
			         			<input type="time" name="stopTime" value="" style="height: 32px; width: 120px" /> 
			         		</div>
		         		</div>
		         	</div>
		         	<p style="margin-left:2em;margin-top:2em">
	         			<!--<a href="user_reserved_result.php" class="btn btn-warning">Submit</a> -->
	         			<input class="btn btn-warning" id="loading2" type="submit" name="reserve" value="Reserve Device" />
		      			<?php if($timeWrong){ ?>
		      			<p class="bg-warning" style="height:3em; margin-left:1em;">
			         		<span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
			         		<h3red><?php echo "Your input the invalid date or time."; ?></h3red> <br></p>
		      		 </p>
		         	<?php }?>
	       
	         	</article>
	        </form>
	    	</div><!-- end of class row 2-->
			<!-- row 3 -->
			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>