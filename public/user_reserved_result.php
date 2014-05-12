<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>


<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
			<?php include("aside_topright.php"); ?>
		         <!-- end of class row 1-->
			<!-- row 2 -->
			<div class="row">
				<?php $activeMenu = "user_reserved" ?>
				<?php include("aside_bar.php"); ?>

	         	<article class="col-lg-10">

	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Result</h2orange>
	         		</div>
	         		<p style="font-size:17px; margin-left:1em;"> 
	         			Your request to reserve &nbsp  <?php echo $_SESSION["req_number"]; ?>   &nbsp<?php echo $_SESSION["req_Device"]; ?> 
	         		</p>
	         		<p class="bg-info" style="height:3em; margin-left:1em;">
		         		<span class="glyphicon glyphicon-ok" style="color: #3EA055;"></span>&nbsp
		         		<h3green>Your device has been reserved.</h3green> <br></p>
    				<table class="table table-striped" style="margin-left:1em;">
					    <thead>
					        <tr>
					            <th>Id</th>
					            <th>Type</th>
					            <th>Brand Name</th>
					            <th>Status</th>	
					            <th>Start Time</th>	
					            <th>End Time</th>					                    
					        </tr>
					    </thead>
			            <tbody>
			            <?php 
			                $x =1;
							for ($i=0; $i < $_SESSION["req_number"]; $i++) { ?>
								
						<tr>
							<td><?php echo $x; ?></td>
							<td>Device</td>
							<td><?php echo $_SESSION["req_Device"]; ?></td>
							<td>Reserved</td>
							<td><?php echo $_SESSION['from'];?></td>
							<td><?php echo $_SESSION['stop']; ?></td>		
						</tr> 
						<?php 
							$x++;
							}//end of for loop			
						?>
						</tbody>
	              	</table>	         		
	         	</article>

	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>