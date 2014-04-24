<aside class="col-lg-2" style="border-right: 1px solid #E4E4E4;">  <!-- side navbar -->

	<h5> Nova MIaaS Dashboard</h5>
        <ul class="side-navbar nav nav-pills nav-stacked">
        	<li <?php if ($activeMenu == "user_dashboard") { ?> class="active"<?php } ?> 
			style="font-weight: bold;"><a href="user_dashboard">Instances </a></li>
        	<li <?php if ($activeMenu == "user_request") { ?> class="active"<?php } ?> 
			style="font-size:13px; margin-left:10px;"><a href="user_request.php">>>Lauch Instances</a></li> 
        	<li <?php if ($activeMenu == "user_reserved") { ?> class="active"<?php } ?> 
			style="font-size:13px; margin-left:10px;"><a href="user_reserved.php">>>Reserved Devices</a></li>
        	<li <?php if ($activeMenu == "user_bill") { ?> class="active"<?php } ?> 
			style="font-weight: bold;"><a href="user_bill.php">Billing & Costs</a></li>
        	<li <?php if ($activeMenu == "user_bill_bh") { ?> class="active"<?php } ?> 
			style="font-size:13px; margin-left:10px;"><a href="user_bill_bh.php">>>Bill History</a></li>
        	<li <?php if ($activeMenu == "user_bill_ph") { ?> class="active"<?php } ?> 
			style="font-size:13px; margin-left:10px;"><a href="user_bill_ph.php">>>Payment History</a></li>
        	<li <?php if ($activeMenu == "user_bill_ur") { ?> class="active"<?php } ?> 
			style="font-size:13px; margin-left:10px;"><a href="user_bill_ur.php">>>Usage Report</a></li>
            <li <?php if ($activeMenu == "user_profile") { ?> class="active"<?php } ?> 
			style="font-weight: bold;"><a href="user_profile.php">Account Profile</a></li>
        </ul> 
</aside>