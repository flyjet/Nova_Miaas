<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$found_emulator_set = ResourceAllocation::allEmulators();
		if (!$found_emulator_set) {
			//not have emulator ready in server side
  		}
?>
<?php

	if (isset($_POST['submit'])) {		
		
		// Process the form
		if (empty(Session::$errors)) {
			$request_number = ($_POST["requesttNumber"]);
			$_SESSION["req_number"] = $request_number;

			$request_emulator = ($_POST["requestInstance"]);
			$_SESSION["req_Instance"] = $request_emulator;

			BasicHelper::redirect_to("user_request_result.php");
		}

	}//end of if (isset($_POST['submit']))
?>
<!--
	<?php echo $_SESSION["first_name"];?>
	<?php echo $_SESSION["user_id"];?>
	<?php echo $_SESSION["email"];?>
-->
<?php include("loading.php"); ?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
			<form action="user_request.php" method="post">
				<?php $activeMenu = "user_request" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">

					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<h2orange>Create Instance</h2orange>
	         		<br>
	         		
		         	<p style="font-size:16px;"> To start using Nova MIaaS you will want to launch a mobile emulator, known as an Nova MIaaS instance. </p>
		         	</div>

		         	<div class="row" style=" margin-left:1em;">	
		         		<h5 style="font-size:18px; margin-left:1em;"> Available mobile emulators</h5>

		         		<div class="col-xs-4">
			         		<select name="requestInstance" class="form-control">
				         	<?php
								foreach($found_emulator_set as $value){
							?>
							<option value="<?php echo $value;?>"><?php echo $value;?></option>
							<?php	
								}
							?>
							</select>
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


	         		<p style=" margin-left:2em;margin-top:2em">
	         			<!--<a href="user_request_result.php" name= "submit" class="btn btn-warning" >Submit Selection</a> -->
	         			 <input class="btn btn-warning" id="loading" type="submit" name="submit" value="Submit Selection" /> 
		      
	         		</p>
	         			         		
	         	</article>
	        </form>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>