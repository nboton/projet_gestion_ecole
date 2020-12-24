<?php 




function make_lang() {

		if (isset($_POST['ar'])) {
			$_SESSION['arabic'] = true;
			unset($_SESSION['francais']);
			unset($_SESSION['english']);
			echo "<meta http-equiv='refresh' content='0' />";
		}
		if (isset($_POST['fr'])) {
			$_SESSION['francais'] = true;
			unset($_SESSION['arabic']);
			unset($_SESSION['english']);
			echo "<meta http-equiv='refresh' content='0' />";
		}

		if (isset($_POST['en'])) {
			$_SESSION['english'] = true;
			unset($_SESSION['arabic']);
			unset($_SESSION['francais']);
			echo "<meta http-equiv='refresh' content='0' />";
		}
} 

function lang_path () {

	if (!isset($_SESSION['arabic']) OR !isset($_SESSION['francais'])) {
		$_SESSION['english'] = true;
	}
	if (isset($_SESSION['english'])) {
		$lang = "english";
	}
	if (isset($_SESSION['arabic'])) {
		$lang = "arabic";
	}
	if (isset($_SESSION['francais'])) {
		$lang = "francais";
	}

	$path = "languages/".$lang.".php";

	return $path;
}

make_lang();
$language_file = lang_path();

include ($language_file);


 ?>