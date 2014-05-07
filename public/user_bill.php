<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

$currentBillStart = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),1,date("Y")) ); 

$userCurrentMonthBillTableData=BillManager::findAndBuildBillArray($_SESSION["user_id"],$currentBillStart);
 		
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

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
				<?php if($userCurrentMonthBillTableData) { ?>
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
				<?php }?>
				
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>