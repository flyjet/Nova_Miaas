<?php include("../includes/initialize.php"); ?>
<?php UserManager::confirm_logged_in();?>
<?php include("../includes/layouts/header.php"); ?>

			<!-- row 1 start in header -->
		        <div class="col-lg-8">
				   	<ul class="nav navbar-nav navbar-right">
				        <li><a href="logout.php" >Sign Out </a></li>
				    </ul>  
			    </div> 
			</header> <!-- end of class row 1-->
			<!-- row 2 -->
			<div class="row">
				<aside class="col-lg-2" style="border-right: 1px solid #E4E4E4;">  <!-- side navbar -->
		        	<h5> Administrator Dashboard</h5>
			            <ul class="side-navbar nav nav-pills nav-stacked">
			            	<li style="font-weight: bold;"><a href="admin_dashboard.php">Users</a></li>
			            	<li class="active" style="font-weight: bold;"><a href="admin_instance.php">Instances</a></li>
			            	<li style="font-weight: bold;"><a href="admin_host.php">Hosts</a></li>
			            </ul> 
	         	</aside>
	         	<article class="col-lg-10">
	         		<div class="row" style="border-bottom: 1px solid #E4E4E4; margin-left:1em;">
	         			<h2orange>Instance Management</h2orange>
	         		</div>
	         		<p style="font-size:16px; margin-left:1em;"> Here is instances information </p>

	         		<table class="table table-striped" style="margin-left:1em;">
					    <thead>
					        <tr>
					            <th>Id</th>
					            <th>Type</th>
					            <th>Brand Name</th>
					            <th>Host Ip </th>
					            <th>Instance IP</th>
					            <th>Status</th>					                    
					        </tr>
					    </thead>
			            <tbody>
			            <?php 
			            $result = Admin::found_all_mobiles();
			            while($instance = mysqli_fetch_assoc($result)){ ?>
								<tr>
									<td><?php echo $instance["id"]; ?></td>
									<td><?php if($instance["emulator_flag"]==0){
										echo "Emulator";
									}elseif($instance["emulator_flag"]==1){
										echo "Device";
									}?></td>
									<td><?php echo $instance["brand"];?> &nbsp / &nbsp <?php echo $instance["api"];?></td>
									<td><?php echo $instance["host_ip"];?></td>
									<td><?php echo $instance["ip"]; ?></td>
									<td><?php if($instance["status"]== 0){
											echo "Free";
										}elseif ($instance["status"]== 1) {
											echo "Running";
										} elseif ($instance["status"]== 2) {
											echo "Stop";
										} elseif ($instance["status"]== 3) {
											echo "Reserved";
										}  ?></td>				
								</tr> 
							<?php }//end of for while
							?>
							</tbody> 
	              		</table>
				
	         	</article>
	    	</div><!-- end of class row 2-->


			<!-- row 3 -->

			<!-- row 4 in footer -->

<?php include("../includes/layouts/footer.php"); ?>