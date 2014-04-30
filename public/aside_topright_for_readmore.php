		        <div class="col-lg-8">
				   	 <div class="row"> 
						<ul class="nav navbar-nav navbar-right">
			            <?php 
			   			    if (isset($_SESSION["first_name"])) { ?>
							<li><a href="user_dashboard.php" >Back to Home </a></li> 
							<li><a href="logout.php" >Sign Out </a></li>
							 </ul> 
						</div>
					    <div class="row"> 
						    <ul class="nav navbar-right">
						    	<li> Welcom, <?php echo $_SESSION["first_name"]; ?></li>
						    </ul>
						</div>
					    <?php } 
							else {?>
					        <li><a href="register.php" >Sign Up </a></li>
					       	<li><a href="login.php" >Sign In </a></li>
							 </ul> 
							<?php }?>
					    
					</div>

			    </div> 
			</header> <!-- end of class row 1-->