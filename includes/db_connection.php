<?php
<<<<<<< HEAD
	//define("DB_SERVER", "54.200.72.126");
  define("DB_SERVER", "127.0.0.1");
=======
	//define("DB_SERVER", "127.0.0.1");
	define("DB_SERVER", "54.200.72.126");
>>>>>>> f54567b5836bdf888f0f4834f54a69dfa81ce3cc
	define("DB_USER", "group6");
	define("DB_PASS", "sjsugroup6");
	define("DB_NAME", "nova_miaas");

  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
  }
?>