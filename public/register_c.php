<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php

if (isset($_POST['submit'])) {
  // Process the form 
  // validations
  $required_fields = array("cardnumber","name","expire","street","city","state","postal","country","phone");
  ValidationHelper::validate_presences($required_fields); 
  if (empty(Session::$errors)) {   
    // Perform Insert
	$userid=$_SESSION["user_id"];
	$cardnumber = BasicHelper::escape_value($_POST["cardnumber"]);
	$name = BasicHelper::escape_value($_POST["name"]);
	$expire = BasicHelper::escape_value($_POST["expire"]);
	$street = BasicHelper::escape_value($_POST["street"]);
	$city = BasicHelper::escape_value($_POST["city"]);
	$state = BasicHelper::escape_value($_POST["state"]);
	$postal = BasicHelper::escape_value($_POST["postal"]);
	$country = BasicHelper::escape_value($_POST["country"]);
	$phone = BasicHelper::escape_value($_POST["phone"]);
	
	$result = UserManager::insert_paymentinfo($userid, $cardnumber, $name, $expire,$street, $city, $state, $postal, $country,$phone);
	if ($result) {
	// Success
	$_SESSION["message"] = "Your Payment information submitted.";
	BasicHelper::redirect_to("user_dashboard.php");
	} else {
	// Failure
	$_SESSION["message"] = "Your Payment information submition failed.";
	} 
	
  
  }
} 


?>
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
			<form action="register_c.php" method="post">
				<div class="col-lg-offset-1 col-lg-5" >
				    <?php echo Session::message(); ?>
				    <?php echo Session::form_errors(Session::$errors); ?>  
					
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
		        	<input class="btn btn-warning" type="submit" name="submit" value="Submit" />

	         	</div>

	         	<div class=" col-lg-4">
	         		<img src="image/register.png" alt="" >
	         	</div>
            </form> 
	    	</div><!-- end of class row 2-->

<?php include("../includes/layouts/footer.php"); ?>