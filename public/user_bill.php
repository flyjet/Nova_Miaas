<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php date_default_timezone_set('America/Los_Angeles'); ?>
<?php
// $currentMonth=date("M");
// $currentYear=date("Y");
$currentBillStart = gmdate("Y-m-d H:i:s", gmmktime(0,0,0,gmdate("m"),1,gmdate("Y")) ); 
//echo $currentBillStart;
$deviceCurrentMonthRecords = BillManager::find_records_by_userid($_SESSION["user_id"],"DEVICE", $currentBillStart);
$deviceCurrentMonthHourMobile = BillManager::calculate_total_hour_mobile($deviceCurrentMonthRecords);
//echo " the device used hour-mobile is ".$deviceCurrentMonthHourMobile;
$deviceCurrentMonthBill =BillManager::calculate_bill_by_type($deviceCurrentMonthHourMobile,"DEVICE");
//echo " the totall bill amount for device is ".$deviceCurrentMonthBill;

$emulatorCurrentMonthRecords = BillManager::find_records_by_userid($_SESSION["user_id"],"EMULATOR", $currentBillStart);
$emulatorCurrentMonthHourMobile = BillManager::calculate_total_hour_mobile($emulatorCurrentMonthRecords);
//echo " the emulator used hour-mobile is ".$emulatorCurrentMonthHourMobile;	
$emulatorCurrentMonthBill =BillManager::calculate_bill_by_type($emulatorCurrentMonthHourMobile,"EMULATOR");
//echo " the totall bill amount for emulator is ".$emulatorCurrentMonthBill;
	
	
	
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="logout.php" >Sign Out </a></li>
				        <li><a href="readmore.php" >About </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_bill" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
		         		<h2orange>Monthly Spend</h2orange>
		         	</div>
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
		         		<p >
							Welcome to the Nova MIaaS Account Billing console.
							Your current monthly balance appears below.  </p>							
		         		<br>
						
						<div id="CurrentMonthBillTable"></div><br>
						<div id="CurrentMonthBillChart"></div>
						
				    </div> 			         								
	         	</article>
				
				<?php 
				$userCurrentMonthBillTableData = "['Type', 'Used Time(hr*mobile)','Bill Amount($)'], ";
				$userCurrentMonthBillTableData.=  "['Emulator', " . $emulatorCurrentMonthHourMobile . ", ";
				$userCurrentMonthBillTableData.=  $emulatorCurrentMonthBill."],\n";
				$userCurrentMonthBillTableData.=  "['Device', " . $deviceCurrentMonthHourMobile . ", ";
				$userCurrentMonthBillTableData.=  $deviceCurrentMonthBill."]\n";
				?> 
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript">
			        google.load("visualization", "1", {packages:["table"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var currentMonthBillData = google.visualization.arrayToDataTable([
			                <?php echo $userCurrentMonthBillTableData ?>
			            ]);
		
			            var options = {
			                fontSize: 11,
							width: 600,
							page: 'enable',
							pageSize : 6,
							pagingSymbols : {prev: 'prev', next: 'next'},
							pagingButtonsConfiguration :'auto'
						
			            };
		
			            var currentMonthBillTable = new google.visualization.Table(document.getElementById('CurrentMonthBillTable'));
			            currentMonthBillTable.draw(currentMonthBillData, options);
					}
				</script>
				<script type="text/javascript">
			        google.load("visualization", "1", {packages:["corechart"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var currentMonthBillData = google.visualization.arrayToDataTable([
			                <?php echo $userCurrentMonthBillTableData ?>
			            ]);
		
			            var options = {
			                title: 'Your Current Month Usage',
							width: 600,
							is3D: true,
							slices: {
								0:{ color: '#FFCBA4' },
							    1:{ color: '#82CAFF' }	          
							},
						
			            };
		
			            var currentMonthBillChart = new google.visualization.PieChart(document.getElementById('CurrentMonthBillChart'));
			            currentMonthBillChart.draw(currentMonthBillData, options);
					}
				</script>
				
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>