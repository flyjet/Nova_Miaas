<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php
	//find user used emulators and devices;   (Id, type, Brand Name, Host Ip, Instance Ip, Status, Action)
	$instance_list = ResourceAllocation::found_all_usedMobiles_by_userId($_SESSION["user_id"]);
	if(!$instance_list){
		//did not find used instiance for this user
	}

?>
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
	         			<h2orange>Resources</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> You are using the following Nova MIaaS resources: </p>
	         		<br>
	         		<table class="table table-striped" style="margin-left:1em;">
			                <thead>
			                  <tr>
			                    <th>Id</th>
			                    <th>Type</th>
			                    <th>Brand Name</th>
			                    <th>Host IP</th>
			                    <th>Instance IP</th>
			                    <th>Status</th>
			                    <th>Action</th>		
			                    <th></th>	
			                  </tr>
			                </thead>
			                <tbody>
							<?php 
								$arrlength=count($instance_list);
								for ($i=0; $i < $arrlength; $i++) { 									
							?>
							<tr>
							<td><?php echo $instance_list[$i][0]; ?></td>
							<td><?php echo $instance_list[$i][1]; ?></td>
							<td><?php echo $instance_list[$i][2];
									  echo " / ";
									  echo $instance_list[$i][3]; ?></td>
							<td><?php echo $instance_list[$i][4]; ?></td>
							<td><?php echo $instance_list[$i][5]; ?></td>
							<td><?php echo $instance_list[$i][6]; ?></td>
							<td><input class="btn btn-warning" style=" height: 4ex;" type="submit" 
								name= <?php echo $instance_list[$i][7]; ?>  value=<?php echo $instance_list[$i][7]; ?> />
							<td><input class="btn btn-warning" style=" height: 4ex;" type="submit" 
								name=<?php echo $instance_list[$i][8]; ?> value=<?php echo $instance_list[$i][8]; ?> /> </td>
							</tr>  

							<?php 
								}
							?>
			                </tbody>
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