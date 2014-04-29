<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	$currentBillStart = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),1,date("Y")) );
	$usedMobiles=BillManager::find_mobiles_by_userid($_SESSION["user_id"],$currentBillStart);	
	$currentMonthUsageTableData=BillManager::buildMobileUsageReportArray($_SESSION["user_id"],$currentBillStart, "", $usedMobiles);
	$currentMonthBillTableData=BillManager::findAndBuildBillArray($_SESSION["user_id"],$currentBillStart);
	
	
	function make_data_for_previous_usage_and_bill($Minus=1){
		global $previousMonthUsageTableData;
		global $previousMonthBillTableData;
		$previousBillEnd = date("Y-m-d H:i:s", mktime(0,0,0,date("m")-$Minus,1,date("Y")) );
		$previousBillEnd = date("Y-m-d H:i:s", mktime(0,0,0,date("m")-$Minus+1,1,date("Y")) );
		$previousUsedMobiles =BillManager::find_mobiles_by_userid($_SESSION["user_id"],$previousBillStart,$previousBillEnd );
		$previousMonthUsageTableData=
			BillManager::buildMobileUsageReportArray($_SESSION["user_id"],$previousBillStart, $previousBillEnd, $previousUsedMobiles);
	    $previousMonthBillTableData=BillManager::findAndBuildBillArray($_SESSION["user_id"],$previousBillStart,$previousBillEnd);
		
	}
    
	//default show the previous one month data
	$Minus=1;
	make_data_for_previous_usage_and_bill(1);
	
	//if selected, show selected month data
	if (isset($_POST['submit'])){
		
		$Minus=$_POST['previous_month'];
		make_data_for_previous_usage_and_bill($Minus);
		
	}
	
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->
		         
			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_bill_ur" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Usage Report Chart</h2orange>
	         		</div>
					
					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<br>
					<p > Your Usage Report For Current Month:  <?php echo date("M");?> </p>
	         		<br>
					<div id="CurrentMonthUsageReportTable"></div><br>
					<div id="CurrentMonthBillTable"></div><br>				
					</div>
					
					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<br>
					<p > Your Usage Report For Previous Month: <?php echo date("M", mktime(0,0,0,date("m")-$Minus) );?> </p>
	         		<br>
					<form action="user_bill_ur.php" method="post">
						<select name="previous_month">
						  <!-- <option value="">Select...</option> -->
						  <option value=1 <?php if($Minus==1)echo 'selected';?> ><?php echo date("M", mktime(0,0,0,date("m")-1) );?></option>
						  <option value=2 <?php if($Minus==2)echo 'selected';?> ><?php echo date("M", mktime(0,0,0,date("m")-2) );?></option>
						  <option value=3 <?php if($Minus==3)echo 'selected';?> ><?php echo date("M", mktime(0,0,0,date("m")-3) );?></option>
						</select>
						<input class="btn btn-warning" type="submit" name="submit" value="Choose" />
					</form>	
					<br>
					<div id="PreviousMonthUsageReportTable"></div><br>
					
					</div>
				
						         	
	         	</article>
									
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript">
			        google.load("visualization", "1", {packages:["table"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var currentMonthUsageReportData = google.visualization.arrayToDataTable([
			                <?php echo $currentMonthUsageTableData ?>
			            ]);
			            var currentMonthBillData = google.visualization.arrayToDataTable([
			                <?php echo $currentMonthBillTableData ?>
			            ]);
		
	
			            var options = {
			                fontSize: 11,
							width: 600,
							page: 'enable',
							pageSize : 6,
							pagingSymbols : {prev: 'prev', next: 'next'},
							pagingButtonsConfiguration :'auto'
					
			            };
	
			            var currentMonthUsageReportTable = new google.visualization.Table(document.getElementById('CurrentMonthUsageReportTable'));
			            currentMonthUsageReportTable.draw(currentMonthUsageReportData , options);
			            var currentMonthBillTable = new google.visualization.Table(document.getElementById('CurrentMonthBillTable'));
			            currentMonthBillTable.draw(currentMonthBillData , options);
						
			            
					}
				</script>
				<script type="text/javascript">
			        google.load("visualization", "1", {packages:["table"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var previousMonthUsageReportData = google.visualization.arrayToDataTable([
			                <?php echo $previousMonthUsageTableData ?>
			            ]);
	
			            var options = {
			                fontSize: 11,
							width: 600,
							page: 'enable',
							pageSize : 6,
							pagingSymbols : {prev: 'prev', next: 'next'},
							pagingButtonsConfiguration :'auto'
					
			            };
						
			            var previousMonthUsageReportTable = new google.visualization.Table(document.getElementById('PreviousMonthUsageReportTable'));
			            previousMonthUsageReportTable.draw(previousMonthUsageReportData , options);
					
					}
				</script>
							

	    	</div><!-- end of class row 2-->

			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>