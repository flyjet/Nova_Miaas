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
		        	<h1orange> Sign In </h1orange>
		        	<h4>Please use your existing account to sign in </h4> <br>		        
			        	<div class="form-group">
			        		<label for="email">Email address </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="email" placeholder="Enter email">
			        	</div>
			  
			            <br><br>
			        	<div class="form-group">
			        		<label for="password">Password </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="Password" placeholder="Password">
			        	</div>
			   
		        	<br><br>
		        	<a class="btn btn-warning" href="user_dashboard.php">Sign In</a>
		      
		        	<br><br>
		        	<a href="#">Forgot your password?</a>	
	         	</div>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->


<?php include("../includes/layouts/footer.php"); ?>