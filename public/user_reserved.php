<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$found_device_set = ResourceAllocation::allDevices();
		if (!$found_device_set) {
			//not have device ready in server side
  		}
?>
<?php

	if (isset($_POST['submit'])) {		
		
		// Process the form
		if (empty(Session::$errors)) {
			$request_number = ($_POST['requesttNumber']);
			$_SESSION['req_number'] = $request_number;

			$request_device = ($_POST['requestDevice']);
			$_SESSION['req_Device'] = $request_device;

			BasicHelper::redirect_to("user_reserved_result.php");
		}

	}//end of if (isset($_POST['submit']))
?>
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
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS mobile devices, you can reserve to use.</p>
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

					<div class="row" style=" margin-left:2em;margin-top:2em;">	
		         		<h5 style="font-size:18px; "> Select reserve time and end time </h5>
		         		<div class="row">
			         		<div class="col-xs-2">
			         			<input type="date" name="from" value="" style="height: 32px; width: 155px"/> 
			         		</div>
			         		<div class="col-xs-2">
				         		<select name="requestDevice" class="form-control" >
									<?php for($i = 0; $i < 24; $i++): ?>
										<option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
									<?php endfor ?>
								</select> 
							</div>
							
							<div class="col-xs-2">
								<input type="date" name="to" value="" style="height: 32px; width: 155px"/> 
							</div>
							<div class="col-xs-2">
								<select name="requestDevice" class="form-control">
									<?php for($i = 0; $i < 24; $i++): ?>
										<option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
									<?php endfor ?>
								</select>
		         			</div>
		         		</div>

		         	</div>

					<div class="row" style=" margin-left:1em;margin-top:2em;">	
		         		<h5 style="font-size:18px; margin-left:1em;"> Select the numbers</h5>
		         		<div class="col-xs-2">
			         		<select name="requesttNumber" class="form-control" >
							  <option value="1">1</option>
							  <option value="2">2</option>
							  <option value="3">3</option>
							  <option value="4">4</option>
							  <option value="5">5</option>
							</select>
						</div>
	         		</div> <!-- class row-->



	         		<p style="margin-left:2em;margin-top:2em">
	         			<!--<a href="user_reserved_result.php" class="btn btn-warning">Submit</a> -->
	         			<input class="btn btn-warning" type="submit" name="submit" value="Submit Selection" /> 
		      		</p>
	         	</article>
	        </form>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>