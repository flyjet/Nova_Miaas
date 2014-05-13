<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $user = UserManager::find_user_by_email($_SESSION["email"]);
  $userRecentBills = BillManager::find_bills_by_userid($_SESSION["user_id"],5);
  
  $userRecentBillGraphData =array();
  if($userRecentBills){
	  $userRecentBillGraphData = BillManager::buildBillsArray($userRecentBills);
	}
  $userBills = BillManager::find_bills_by_userid($_SESSION["user_id"]);
  $userBillTableData=array();
  if($userBills) {
	  $userBillTableData = BillManager::buildBillsWithDetailsArray($userBills);
  }

?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_bill_bh" ?>
				<?php include("aside_bar.php"); ?>
				
	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<h2orange>Bill History</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Your bill history </p>
					<div id="BillHistoryChart"></div><br></br>
					<div id="BillHistoryTable"></div>
	         		<br>
	         	</article>
				
	         <?php if($userRecentBillGraphData) { ?>	
		    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
		    <script type="text/javascript">
		        google.load("visualization", "1", {packages:["corechart"]});
		        google.setOnLoadCallback(drawChart);
		        function drawChart() {
		            var billhistorydata = google.visualization.arrayToDataTable([
		                <?php echo $userRecentBillGraphData ?>
		            ]);
			
		            var options = {
		                title: 'Your monthly bill history' ,
		                fontSize: 11,
						width: 600, height: 240,
		                series: {
		                    0:{ color: 'orange', visibleInLegend: true}          
		                },
		                hAxis: {title: 'Bill Start Time', titleTextStyle:{color: '#03619D'} },
		                vAxis: {title: 'Bill Amount', titleTextStyle:{color: '#03619D'}, minValue: 0 }
		            };
			
		            var billhistorychart = new google.visualization.ColumnChart(document.getElementById('BillHistoryChart'));
		            billhistorychart.draw(billhistorydata, options);
				}
			</script>
			<?php } ?>
			<?php if($userBillTableData ) { ?>
		    <script type="text/javascript">
		        google.load("visualization", "1", {packages:["table"]});
		        google.setOnLoadCallback(drawTable);
		        function drawTable() {
		            var billData = google.visualization.arrayToDataTable([
		                <?php echo $userBillTableData ?>
		            ]);
		
		            var options = {
		                fontSize: 11,
						width: 900, height: 240,
						page: 'enable',
						pageSize : 6,
						pagingSymbols : {prev: 'prev', next: 'next'},
						pagingButtonsConfiguration :'auto'
						
		            };
		
		            var billTable = new google.visualization.Table(document.getElementById('BillHistoryTable'));
		            billTable.draw(billData, options);
				}
			</script>
			<?php } ?>
			
			</div><!-- end of class row 2-->

			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>