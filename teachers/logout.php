<?php 
 

session_start();

if ($_GET['token'] == $_SESSION['token']) {

	if (isset($_SESSION ["teacher"])) {
		session_destroy();
		header("Location: ../index.php") ;
		echo "<meta http-equiv='refresh' content='0; url = ../index.php' />";
	}

	if (isset($_SESSION ["teacher_index"])) {
		session_destroy();
	}

	if (!isset($_SESSION ["student"])) {
		header("Location: ../index.php") ;
		echo "<meta http-equiv='refresh' content='0; url = ../index.php' />";
	}

}

else {
	header("Location: ../index.php") ;
	echo "<meta http-equiv='refresh' content='0; url = ../index.php' />";
}

 ?>