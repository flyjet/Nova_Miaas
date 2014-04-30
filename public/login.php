<?php include("../includes/initialize.php"); ?>
<?php
if (Session::logged_in()) BasicHelper::redirect_to("user_dashboard.php");
if (isset($_POST['submit'])) {
  // Process the form
  
  // validations
  $required_fields = array("email", "password");
  ValidationHelper::validate_presences($required_fields);
  
  if (empty(Session::$errors)) {
    // Attempt Login
	$email = $_POST["email"];		
	$password = $_POST["password"];
	$found_user = UserManager::attempt_login($email, $password);
    if ($found_user) {
      // Success
		// Mark user as logged in
		$_SESSION["user_id"] = $found_user["id"];
		$_SESSION["email"] = $found_user["email"];
		$_SESSION["first_name"] = $found_user["first_name"];
		if ($found_user["admin_authority"] == 1 ) BasicHelper::redirect_to("admin_dashboard.php");
		else BasicHelper::redirect_to("calculate_bill_and_store.php");
    } else {
      // Failure
      $_SESSION["message"] = "Email/password not found.";
    }
	
  }
} else {
  // This is probably a GET request 
} // end: if (isset($_POST['submit']))

?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				   		<li><a href="register.php" >Sign Up</a></li>
				        <li><a href="index.php" >Back</a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->


			<!-- row 2 -->
			<div class="row">
				<div class="col-lg-offset-1 col-lg-6" >  
				<form action="login.php" method="post">
		        	<h1orange> Sign In </h1orange>
		        	<h4>Please use your existing account to sign in </h4> <br>
				    <?php echo Session::message(); ?>
				    <?php echo Session::form_errors(Session::$errors); ?>		        
			        	<div class="form-group">
			        		<label for="email">Email address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="email" placeholder="Enter email">
			        	</div>
			  
			            <br><br>
			        	<div class="form-group">
			        		<label for="password">Password </label> <br>    		
			        		<input class="col-lg-6 " type="password" name="password" placeholder="Password">
			        	</div>
			   
		        	<br><br>
		        	<!-- <a class="btn btn-warning" href="user_dashboard.php">Sign In</a> -->
					<input class="btn btn-warning" type="submit" name="submit" value="Sign In" />
		      
		        	<br><br>
		        	<a href="#">Forgot your password?</a>
				</form>	
	         	</div>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->


<?php include("../includes/layouts/footer.php"); ?>