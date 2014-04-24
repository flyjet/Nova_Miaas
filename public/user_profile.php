<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $user = UserManager::find_user_by_email($_SESSION["email"]);  
?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->

		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="logout.php" >Sign Out </a></li>
				        <li><a href="readmore.php" >About </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_profile" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         		<h2orange>Account Profile</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> </p>
	         		<br>

					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Contact Information</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;">  </p>
	         		<br>

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Payment Information</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;">  </p>

	         		
		    </div>


	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>