<?php include("../includes/initialize.php"); ?>
<?php

if (isset($_POST['submit'])) {
  // Process the form 
  // validations
  $required_fields = array("fname","lname","email","password","repassword");
  ValidationHelper::validate_presences($required_fields);  
  if (empty(Session::$errors)) {   
    // Perform Insert
    $firstname = BasicHelper::escape_value($_POST["fname"]);
	$lastname = BasicHelper::escape_value($_POST["lname"]);
	$email = BasicHelper::escape_value($_POST["email"]);
    $password = BasicHelper::escape_value($_POST["password"]);
	$repassword =BasicHelper::escape_value($_POST["repassword"]);
	
    if($password!=$repassword){
    	$SESSION["message"] = "Your Password doesn't match";
    }
	else{	
	    $result = UserManager::insert_user($firstname, $lastname, $email,$password);
   
	    if ($result) {
			// Success
			$found_user = UserManager::find_user_by_email($email);
			$_SESSION["message"] = "Your account has been created.";
			$_SESSION["user_id"] = $found_user["id"];
			$_SESSION["email"] = $found_user["email"];
			$_SESSION["first_name"] = $found_user["first_name"];
			BasicHelper::redirect_to("register_c.php");
	    } else {
	      // Failure
	      $_SESSION["message"] = "Your contact information update failed.";
	    }
	}
  
  }
} 


?>
<?php include("../includes/layouts/header.php"); ?>
			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="index.php" >Back</a></li>
				        <li><a href="readmore.php" >About </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
			<form action="register.php" method="post">
				<div class="col-lg-offset-1 col-lg-6" >  
		        	<h1orange> Create a New Account </h1orange>
				    <?php echo Session::message(); ?>
				    <?php echo Session::form_errors(Session::$errors); ?>					
		        	<h4>Please use the form below to create login credentials.</h4> <br>	
		        		<div class="form-group">
			        		<label for="fname">First Name </label> <br>    		
			        		<input class="col-lg-4 " type="text" name="fname" placeholder="First Name">
			        	</div>
			        	<br>

			        	<div class="form-group">
			        		<label for="lname">Last Name </label> <br>    		
			        		<input class="col-lg-4 " type="text" name="lname" placeholder="Last Name">
			        	</div>
			        	<br>


			        	<div class="form-group">
			        		<label for="email">Email address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="email" placeholder="Enter email">
			        	</div>
			  
			            <br>
			        	<div class="form-group">
			        		<label for="password">Password </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="password" placeholder="Password">
			        	</div>

			        	<br>
			        	<div class="form-group">
			        		<label for="password">Type again </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="repassword" placeholder="Password">
			        	</div>
			   
		        	<br><br>
		        	<input class="btn btn-warning" type="submit" name="submit" value="Sign Up" />

	         	</div>
			</form>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->

<?php include("../includes/layouts/footer.php"); ?>