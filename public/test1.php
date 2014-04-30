<html lang="en">
    <head>
        <title>Test SNS</title>
    </head>

    <body>

    	 <form action="test1.php" method="post">
		    <select id="test" name="test">
		     <option value="1">Test One</option>
		     <option value="2">Test Two</option>
		     <option value="3">Test Three</option>
		    </select>
	

		<?php $result=$_POST['test'];
    			echo $result;
    	?>

	</form>



        <form action="test1.php" method="post">
        Name: <input type="text" name="name"><br>
        Number: <input type="text" name="number"> <br>
        <input type="submit" name="submit" value="Create" >
    
    </body>
</html>



<html>
<body>

