<?php require_once("../includes/initialize.php"); ?>
<?php 
session_destroy(); 
BasicHelper::redirect_to("index.php");
?>