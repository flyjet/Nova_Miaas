<?php include("../includes/layouts/header.php"); ?>
			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="register.php" >Back</a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<div class="col-lg-offset-1 col-lg-6" >  
		        	<h1orange>Payment Method  </h1orange>
		        	<h4>Please fill the form below for payment information.</h4> <br>	
		        		<div class="form-group">
			        		<label for="cardnumber">Credit Card Number </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="cardnumber" placeholder="Credit Card Number">
			        	</div><br>
		        		<div class="form-group">
			        		<label for="name">Name on Card</label> <br>    		
			        		<input class="col-lg-4 " type="text" name="name" placeholder="Name on Card">
			        	</div><br>

			        	<div class="form-group">
			        		<label for="expire">Expires On</label> <br>    		
			        		<input class="col-lg-4 " type="text" name="expire" placeholder="month / year">

			        	</div><br>

			        	<br>			  
			        	<div class="form-group">
			        		<label for="street">Billing Address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="street" placeholder="street">
			        	</div><br>
			        	<div class="form-group">
			        		<div class="row">
				        		<label class="col-lg-3" for="city">City </label>  
				        		<label class="col-lg-3" for="state">State </label>  	
			        		</div>	
				        		<input class="col-lg-3" type="text" name="city" placeholder="">
				        		<input class="col-lg-3" type="text" name="state" placeholder="">
			        	</div><br>

			        	<div class="form-group">
			        		<div class="row">
				        		<label class="col-lg-3" for="city">Postal Code </label>  
				        		<label class="col-lg-3" for="state">Country </label>  	
			        		</div>	
				        		<input class="col-lg-3" type="text" name="postal" placeholder="">
				        		<input class="col-lg-3" type="text" name="country" placeholder="">
			        	</div><br>

						<div class="form-group">
			        		<label for="phone">Phone Number</label> <br>    		
			        		<input class="col-lg-4 " type="text" name="phone" placeholder="">
			        	</div><br><br>
		        	<a class="btn btn-warning" href="user_dashboard.php">Submit</a>

	         	</div>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->

<?php include("../includes/layouts/footer.php"); ?>