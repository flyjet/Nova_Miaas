<?php include("../includes/layouts/header.php"); ?>
			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="index.php" >Back</a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<div class="col-lg-offset-1 col-lg-6" >  
		        	<h1orange> Create a New Account </h1orange>
		        	<h4>Please fill the form below for payment information.</h4> <br>	
		        		<div class="form-group">
			        		<label for="Method">Payment Method </label> <br>    		
			        		<input class="col-lg-4 " type="text" name="method" placeholder="payment mothod">
			        	</div>
			        	<br>
			        	<div class="form-group">
			        		<label for="cardnumber">Card Number </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="cardnumber" placeholder="Credit Card Number">
			        	</div>
			        	<br>			  
			        	<div class="form-group">
			        		<label for="address">Billing Address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="address" placeholder="Address">
			        	</div>

		        	<br><br>
		        	<a class="btn btn-warning" href="user_dashboard.php">Submit</a>

	         	</div>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->

<?php include("../includes/layouts/footer.php"); ?>