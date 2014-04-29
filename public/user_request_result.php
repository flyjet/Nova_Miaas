<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$emulator_set = ResourceAllocation::found_freeEmulator_by_brand( "Samsung Galaxy S3 - 4.1.1");
		if (!$emulator_set) {
			//not have emulator is ready in server side
  		}
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<aside class="col-lg-2" style="border-right: 1px solid #E4E4E4;">  <!-- side navbar -->

		        	<h5> Nova MIaaS Dashboard</h5>
			            <ul class="side-navbar nav nav-pills nav-stacked">
			            	<li style="font-weight: bold;"><a href="user_dashboard">Instances </a></li>
			            	<li  class="active" style="font-size:13px; margin-left:10px;"><a href="user_request.php">>>Lauch Instances</a></li> 
			            	<li style="font-size:13px; margin-left:10px;"><a href="user_reserved.php">>>Reserved Devices</a></li>
			            	<li style="font-weight: bold;"><a href="user_bill.php">Billing & Costs</a></li>
			            	<li style="font-size:13px; margin-left:10px;"><a href="user_bill_bh.php">>>Bill History</a></li>
			            	<li style="font-size:13px; margin-left:10px;"><a href="user_bill_ph.php">>>Payment History</a></li>
			            	<li style="font-size:13px; margin-left:10px;"><a href="user_bill_ur.php">>>Usage Report</a></li>
			                <li style="font-weight: bold;"><a href="user_profile.php">Account Profile</a></li>
			            </ul> 
	         	</aside>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Your Result </p>
	         		<?php 
	         			echo $_SESSION["user_id"];
	         			echo "/";

	         			if (isset($_SESSION["req_number"])){
	         				echo $_SESSION["req_number"];
	         				echo "   ";
	         				}
	         			if (isset($_SESSION['req_Instance'])){
	         				echo $_SESSION['req_Instance'];
	         				}	         			
	         		?>
	         		<br>

	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>