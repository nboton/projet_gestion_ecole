<?php 
 

session_start();

if ($_GET['token'] == $_SESSION['token']) {

	if (isset($_SESSION ["administrator"])) {
		session_destroy();
		header("Location: login.php") ;
		echo "<meta http-equiv='refresh' content='0; url = login.php' />";
	}

	if (isset($_SESSION ["admin_index"])) {
		session_destroy();
	}

	if (!isset($_SESSION ["administrator"])) {
		header("Location: login.php") ;
		echo "<meta http-equiv='refresh' content='0; url = login.php' />";
	}

}

else {
	header("Location: index.php") ;
	echo "<meta http-equiv='refresh' content='0; url = index.php' />";
}


 ?>