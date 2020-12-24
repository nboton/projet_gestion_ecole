<?php 
	
 
	 $DB_SERVER = "localhost"; 
	 $DB_USER = "root"; 
	 $DB_PASS = ""; 
	 $DB_DATABASE = "gesecole"; 
 
	 try { 
	 $connect =  new PDO("mysql:host=$DB_SERVER; dbname=$DB_DATABASE", $DB_USER,$DB_PASS); 
	 } 
 
	 catch (PDOException $e) { 
	 die("Database Error..!") ; 
	 } 
 
	 $connect->query("set charcter_set_server = 'utf8'"); 
	 $connect->query("set names'utf8' "); 
 
?>