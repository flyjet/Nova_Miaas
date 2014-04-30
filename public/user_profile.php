<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $user = UserManager::find_user_by_email($_SESSION["email"]); 
  $paymentinfo =UserManager::find_paymentinfo_by_userid($_SESSION["user_id"]); 
?>
<?php

if (isset($_POST['contactsubmit'])) {
  // Process the form 
  // validations
  $required_fields = array("fname","lname","email","password");
  ValidationHelper::validate_presences($required_fields);  
  if (empty(Session::$errors)) {   
    // Perform Update
	$userid=$_SESSION["user_id"];
    $firstname = BasicHelper::escape_value($_POST["fname"]);
	$lastname = BasicHelper::escape_value($_POST["lname"]);
	$email = BasicHelper::escape_value($_POST["email"]);
    $password = BasicHelper::escape_value($_POST["password"]);
    
    $result = UserManager::update_user($userid, $firstname, $lastname, $email,$password);
   
    if ($result) {
      // Success
      $_SESSION["message"] = "Your Contact information Updated.";
      BasicHelper::redirect_to("user_profile.php");
    } else {
      // Failure
      $_SESSION["message"] = "Your Contact information update failed.";
    }
  
  }
} 

else if (isset($_POST['paymentinfosubmit'])) {
    // validations
    $required_fields = array("cardnumber","name","expire","street","city","state","postal","country","phone");
    ValidationHelper::validate_presences($required_fields);
  
    if (empty(Session::$errors)) {   
      // Perform Update
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

		$result2 = UserManager::update_paymentinfo(
		$userid, $cardnumber, $name, $expire,$street, $city, $state, $postal, $country,$phone);
		if ($result2) {
		// Success
		$_SESSION["message"] = "Your Payment information Updated.";
		BasicHelper::redirect_to("user_profile.php");
		} else {
		// Failure
		$_SESSION["message"] = "Your Payment information update failed.";
		}  
    }
	 
  
} // end: if (isset($_POST['submit']))


?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_profile" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">
                <form action="user_profile.php" method="post">
	         		
				    <?php echo Session::message(); ?>
				    <?php echo Session::form_errors(Session::$errors); ?>

					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Contact Information</h2orange>
		        		<div class="form-group">
			        		<label for="fname">First Name </label> <br>    		
			        		<input class="col-lg-4 " type="text" name="fname" 
							value="<?php echo htmlentities($user['first_name']); ?>" >
			        	</div>
			        	<br>

			        	<div class="form-group">
			        		<label for="lname">Last Name </label> <br>    		
			        		<input class="col-lg-4 " type="text" name="lname" 
							value="<?php echo htmlentities($user['last_name']); ?>">
			        	</div>
			        	<br>


			        	<div class="form-group">
			        		<label for="email">Email address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="email" 
							value="<?php echo htmlentities($user['email']); ?>">
			        	</div>			
			            <br>
						
			        	<div class="form-group">
			        		<label for="password">Password </label> <br>    		
			        		<input class="col-lg-6 " type="password" name="password" placeholder="Password">
			        	</div>
						<br>
						<input class="btn btn-warning" type="submit" name="contactsubmit" value="Edit" />
						<br><br>
						
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;">  </p>
	         		<br>

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Payment Information</h2orange>
			        		<div class="form-group">
				        		<label for="cardnumber">Credit Card Number </label> <br>    		
				        		<input class="col-lg-6 " type="text" name="cardnumber" 
								value="<?php echo htmlentities($paymentinfo['card_number']); ?>">
				        	</div><br>
			        		<div class="form-group">
				        		<label for="name">Name on Card</label> <br>    		
				        		<input class="col-lg-4 " type="text" name="name" 
								value="<?php echo htmlentities($paymentinfo['name_on_card']); ?>">
				        	</div><br>

				        	<div class="form-group">
				        		<label for="expire">Expires On</label> <br>    		
				        		<input class="col-lg-4 " type="text" name="expire" 
								value="<?php echo htmlentities($paymentinfo['expire']); ?>">

				        	</div><br>

				        	<br>			  
				        	<div class="form-group">
				        		<label for="street">Billing Address </label> <br>    		
				        		<input class="col-lg-6 " type="text" name="street" 
								value="<?php echo htmlentities($paymentinfo['street']); ?>">
				        	</div><br>
				        	<div class="form-group">
				        		<div class="row">
					        		<label class="col-lg-3" for="city">City </label>  
					        		<label class="col-lg-3" for="state">State </label>  	
				        		</div>	
					        		<input class="col-lg-3" type="text" name="city" 
									value="<?php echo htmlentities($paymentinfo['city']); ?>">
					        		<input class="col-lg-3" type="text" name="state" 
									value="<?php echo htmlentities($paymentinfo['state']); ?>">
				        	</div><br>

				        	<div class="form-group">
				        		<div class="row">
					        		<label class="col-lg-3" for="city">Postal Code </label>  
					        		<label class="col-lg-3" for="state">Country </label>  	
				        		</div>	
					        		<input class="col-lg-3" type="text" name="postal" 
									value="<?php echo htmlentities($paymentinfo['postcode']); ?>">
					        		<input class="col-lg-3" type="text" name="country" 
									value="<?php echo htmlentities($paymentinfo['country']); ?>">
				        	</div><br>

							<div class="form-group">
				        		<label for="phone">Phone Number</label> <br>    		
				        		<input class="col-lg-4 " type="text" name="phone" 
								value="<?php echo htmlentities($paymentinfo['phone']); ?>">
				        	</div><br>
			        	<input class="btn btn-warning" type="submit" name="paymentinfosubmit" value="Edit" />
						<br><br>
						
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;">  </p>
					
				</form> 		
		    </div>


	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>