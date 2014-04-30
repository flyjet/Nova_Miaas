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

<input type="date" name='from' size='9' value="" />  


	
<select>
<?php for($i = 0; $i < 24; $i++): ?>
  <option value="<?= $i; ?>"><?= $i % 12 ? $i % 12 : 12 ?>:00 <?= $i >= 12 ? 'pm' : 'am' ?></option>
<?php endfor ?>
</select>

        <form action="test1.php" method="post">
        Name: <input type="text" name="name"><br>
        Number: <input type="text" name="number"> <br>
        <input type="submit" name="submit" value="Create" >
    
    </body>
</html>



<html>
<body>


<?php include("../includes/layouts/footer.php"); ?>