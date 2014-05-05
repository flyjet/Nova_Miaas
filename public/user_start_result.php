<?php include("../includes/initialize.php"); ?>
<?php include("../includes/SQS.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
  $emulatorId =$_GET["id"];  
  $userId = $_SESSION["user_id"];
  $action = "on";
  $err_message = " Your request to start the instance is failed, please try again";
?>
<?php include("send_rec_message.php"); ?>  
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->

			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_dashboard" ?>
				<?php include("aside_bar.php"); ?>
	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<?php if(isset($showlist)){ ?>
	         		<p class="bg-info" style="height:3em; margin-left:1em;">
	         			<span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
	         			<h3green>Your instance is running.</h3green> <br></p>
	         		
	         		<table class="table table-striped" style="margin-left:1em;">
			            <thead>
			                  <tr>
			                    <th>Id</th>
			                    <th>Type</th>
			                    <th>Brand Name</th>
			                    <th>Host IP</th>
			                    <th>Instance IP</th>
			                    <th>Status</th>			                    		
			                    <th></th>	
			                  </tr>
			                </thead>
			                <tbody>							
							<tr>
							<td><?php echo 1; ?></td>
							<td><?php echo $showlist[0]; ?></td>
							<td><?php echo $showlist[1]; ?></td>
							<td><?php echo $showlist[2];?></td>
							<td><?php echo $showlist[3]; ?></td>
							<td><?php echo $showlist[4]; ?></td>				
							</tr>  
			                </tbody>
			 			    <?php
			                } else{
			              	?>
			              	<p class="bg-danger" style="height:3em; margin-left:1em;">
	         				<span class="glyphicon glyphicon-remove" style="color: #ff3232;"></span>&nbsp
	         				<h3red><?php echo $err_message; ?></h3red> <br></p>
			              	<?php 
			                }
			                ?>
			 
	              		</table>

					<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Create Instance</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> To start using Nova MIaaS you will want to launch a mobile emulator, known as an Nova MIaaS instance. </p>
	         		<p style="margin-left:1em;margin-top:2em"><a href="user_request.php" class="btn btn-warning">Launch Instance</a></p>
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>