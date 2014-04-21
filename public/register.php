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
				<div class="col-lg-offset-1 col-lg-6" >  
		        	<h1orange> Create a New Account </h1orange>
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
			        		<input class="col-lg-6 " type="text" name="Password" placeholder="Password">
			        	</div>

			        	<br>
			        	<div class="form-group">
			        		<label for="password">Type again </label> <br>    		
			        		<input class="col-lg-6 " type="text" name="Password" placeholder="Password">
			        	</div>
			   
		        	<br><br>
		        	<a class="btn btn-warning" href="register_c.php">Continue</a>

	         	</div>

	         	<div class=" col-lg-5">
	         		<img src="image/cloud.png" alt="" >
	         	</div>
       
	    	</div><!-- end of class row 2-->

<?php include("../includes/layouts/footer.php"); ?>