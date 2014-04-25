<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $user = UserManager::find_user_by_email($_SESSION["email"]);
  $userpayments = BillManager::find_payments_by_userid($_SESSION["user_id"]);
  $userPaymentGraphData = BillManager::buildPaymentsArray($userpayments);

?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="index.php" >Sign Out </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_bill_ph" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Payment History</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Your payment history </p>
					<div id="PaymentHistoryTable"></div>
	         		<br>
	         	</article>
				
			    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
			    <script type="text/javascript">
			        google.load("visualization", "1", {packages:["table"]});
			        google.setOnLoadCallback(drawTable);
			        function drawTable() {
			            var paymenthistorydata = google.visualization.arrayToDataTable([
			                <?php echo $userPaymentGraphData ?>
			            ]);
			
			            var options = {
			                fontSize: 11,
							width: 600, height: 240,
							page: 'enable',
							pageSize : 5,
							pagingSymbols : {prev: 'prev', next: 'next'},
							pagingButtonsConfiguration :'auto'
							
			            };
			
			            var paymentHistoryTable = new google.visualization.Table(document.getElementById('PaymentHistoryTable'));
			            paymentHistoryTable.draw(paymenthistorydata, options);
					}
				</script>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>