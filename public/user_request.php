<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="index.php" >Sign Out </a></li>
				        <li><a href="readmore.php" >About </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<aside class="col-lg-2" style="border-right: 1px solid #E4E4E4;">  <!-- side navbar -->

		        	<h5> Nova MIaaS Dashboard</h5>
			            <ul class="side-navbar nav nav-pills nav-stacked">
			            	<li><a href="user_dashboard">Instances </a></li>
			            	
			            	<li class="active"><a href="user_request.php">>>Lauch Instances</a></li> 
			            	<li><a href="user_reserved.php">>>Reserved Devices</a></li>
			            	
			            	<li><a href="user_bill.php">Billing Management</a></li>
			                <li><a href="user_profile.php">Account Profile</a></li>
			            </ul> 
	         	</aside>

	         	<article class="col-lg-10">

					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<h2orange>Create Instance</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS you will want to launch a mobile emulator, known as an Nova MIaaS instance. </p>

	         		<p style="margin-left:1em;margin-top:2em"><a href="user_request_result.php" class="btn btn-warning">Submit</a></p>
		    </div>


	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>