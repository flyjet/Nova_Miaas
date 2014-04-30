<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

$currentBillStart = date("Y-m-d H:i:s", mktime(0,0,0,date("m"),1,date("Y")) ); 
$allUsers=UserManager::find_all_user();
$currentMonthAllUsersSumData=BillManager::findAndBuildUsersSumArray($allUsers,$currentBillStart);
//echo $currentMonthAllUsersSumData;
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="logout.php" >Sign Out </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<aside class="col-lg-2" style="border-right: 1px solid #E4E4E4;">  <!-- side navbar -->

		        	<h5> Administrator Dashboard</h5>
			            <ul class="side-navbar nav nav-pills nav-stacked">
			            	<li class="active" style="font-weight: bold;"><a href="admin_dashboard.php">Users</a></li>
			            	<li style="font-weight: bold;"><a href="admin_host.php">Hosts</a></li>
			            </ul> 
	         	</aside>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Management</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Here is the users </p>
					<div id="CurrentMonthAllUsersSumTable"></div>
					
	         		<br>

				
	         	</article>
				
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				<script type="text/javascript">
			        google.load("visualization", "1", {packages:["table"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var currentMonthAllUsersSumData = google.visualization.arrayToDataTable([
			                <?php echo $currentMonthAllUsersSumData?>
			            ]);
		
			            var options = {
			                fontSize: 11,
							width: 600,
							page: 'enable',
							pageSize : 6,
							pagingSymbols : {prev: 'prev', next: 'next'},
							pagingButtonsConfiguration :'auto'
						
			            };
		
			            var currentMonthAllUsersSumTable = new google.visualization.Table(document.getElementById('CurrentMonthAllUsersSumTable'));
			            currentMonthAllUsersSumTable.draw(currentMonthAllUsersSumData, options);
					}
				</script>
				
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>