<?php 

session_start(); 

if (isset($_SESSION ['student'])) {
  header("location: students/index.php") ;
}

if (isset($_SESSION ['teacher'])) {
  header("location: teachers/index.php") ;
}

if (isset($_SESSION ['parent'])) {
  header("location: parents/index.php") ;
}

require_once 'includes/database_config.php';
include 'includes/display_errors.php';
include 'includes/make_lang.php';

echo $_SESSION['DatabaseError'];




$stmt = $connect->query("SELECT close_site from control");

$row = $stmt->fetch();
$mode = $row ['close_site'];

if ($mode == 1) {
   header("location: close.php") ;
   die();
}






 ?>

 <!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png" />

    <title><?php echo $lang ['log_in']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
  
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <script src="js/ie-emulation-modes-warning.js"></script>


    
     <link href="css/style.css" rel="stylesheet">
      <link href="css/Normalize.css" rel="stylesheet">
      <?php 
     if (isset($_SESSION['arabic'])) {
      echo '<link rel="stylesheet" href="css/rtl_fix.css" rel="stylesheet">
      <link href="css/bootstrap-rtl.min.css" rel="stylesheet">
      <link rel="stylesheet" href="fonts/ar/droid.css">';
      }

      if (isset($_SESSION['francais'])) {
      echo '<link rel="stylesheet" href="fonts/fr/fonts_css.css">';
      }

      ?>

      <script src="js/jquery-1.11.3.min.js"></script>

      <link rel="stylesheet" href="libs/validationEngine/validationEngine.jquery.css" type="text/css"/>
<?php 
/*if (isset($_SESSION['arabic'])) {
    echo '<script src="libs/validationEngine/languages/jquery.validationEngine-ar.js" type="text/javascript" charset="utf-8"></script>';
}*/
if (isset($_SESSION['francais'])) {
    echo '<script src="libs/validationEngine/languages/jquery.validationEngine-fr.js" type="text/javascript" charset="utf-8"></script>';
}

if (isset($_SESSION['english'])) {
    echo '<script src="libs/validationEngine/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>';
}  
?>
      <script src="libs/validationEngine/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
      </script>
      <script>
        jQuery(document).ready(function(){
          // binds form submission and fields to the validation engine
          jQuery("#login_students").validationEngine();
          jQuery("#login_teachers").validationEngine();
          jQuery("#login_parents").validationEngine();
        });
 
      </script>
        

  </head>

  <body>


<div class="navbar navbar-default">
<div class="container">  
	<form id="language" action="" method="post">
    <left><a href="index.php"><img  width="99" height="70" src="logo.png" alt=""> &nbsp; &nbsp; &nbsp; <big><big>  L3-MIAGE 2020</big> </big></a></left>&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;
		<input type="submit" name="fr" class="francais" value="francais" />
	
    <input type="submit" name="en" class="english" value="english" />

	</form> 
  
</div>
</div>


<div class="container main">


<div class="clear"></div>	<br>

<?php 


if (isset($_POST['submit_students'])) {

  $student_name = htmlspecialchars($_POST['student_name']);
  $student_pass = htmlspecialchars(md5($_POST['student_pass']));

  $stmt_login = $connect->prepare("SELECT * FROM students_users WHERE username=:student_name and password=:student_pass");
  $stmt_login->bindParam (':student_name' , $student_name , PDO::PARAM_STR );
  $stmt_login->bindParam (':student_pass' , $student_pass , PDO::PARAM_STR );
  $stmt_login->execute();

  if ($stmt_login->rowCount() == 1) {
    
    $row = $stmt_login->fetch() ;
    $user = $row ['username'];
    $pass = $row ['password'];
    $student_index = $row ['student_index'];

    if ($user == $student_name and $pass == $student_pass) {

      $_SESSION ['student'] = $user;
      $_SESSION ['student_index'] = $student_index;
	  
	  $token_rand = md5(uniqid(rand()));
	  $_SESSION ['token'] = $token_rand;

      header ("location: students/index.php");
      echo "<meta http-equiv='refresh' content='0; url = students/index.php' />";
      
    }
    
  }

  else {
   header ("location: index.php?login=error");   
   echo "<meta http-equiv='refresh' content='0; url = index.php?login=error' />";      
  }
  
}

/*****************************************************/

if (isset($_POST['submit_teachers'])) {

  $teacher_name = htmlspecialchars($_POST['teacher_name']);
  $teacher_pass = htmlspecialchars(md5($_POST['teacher_pass']));

  $stmt_login = $connect->prepare("SELECT * FROM teachers_users WHERE username=:teacher_name and password=:teacher_pass");
  $stmt_login->bindParam (':teacher_name' , $teacher_name , PDO::PARAM_STR );
  $stmt_login->bindParam (':teacher_pass' , $teacher_pass , PDO::PARAM_STR );
  $stmt_login->execute();

  if ($stmt_login->rowCount() == 1) {
    
    $row = $stmt_login->fetch() ;
    $user = $row ['username'];
    $pass = $row ['password'];
    $teacher_index = $row ['teacher_index'];

    if ($user == $teacher_name and $pass == $teacher_pass) {

      $_SESSION ['teacher'] = $user;
      $_SESSION ['teacher_index'] = $teacher_index;

      $token_rand = md5(uniqid(rand()));
      $_SESSION ['token'] = $token_rand;

      header ("location: teachers/index.php");
      echo "<meta http-equiv='refresh' content='0; url = teachers/index.php' />";
      
    }
    
  }

  else {
   header ("location: index.php?login=error");   
   echo "<meta http-equiv='refresh' content='0; url = index.php?login=error' />";      
  }
  
}

/*****************************************************/

if (isset($_POST['submit_parents'])) {

  $parent_name = htmlspecialchars($_POST['parent_name']);
  $parent_pass = htmlspecialchars(md5($_POST['parent_pass']));

  $stmt_login = $connect->prepare("SELECT * FROM parents_users WHERE username=:parent_name and password=:parent_pass");
  $stmt_login->bindParam (':parent_name' , $parent_name , PDO::PARAM_STR );
  $stmt_login->bindParam (':parent_pass' , $parent_pass , PDO::PARAM_STR );
  $stmt_login->execute();

  if ($stmt_login->rowCount() == 1) {
    
    $row = $stmt_login->fetch() ;
    $user = $row ['username'];
    $pass = $row ['password'];
    $parent_index = $row ['parent_index'];

    if ($user == $parent_name and $pass == $parent_pass) {

      $_SESSION ['parent'] = $user;
      $_SESSION ['parent_index'] = $parent_index;

      $token_rand = md5(uniqid(rand()));
    $_SESSION ['token'] = $token_rand;

      header ("location: parents/index.php");
      echo "<meta http-equiv='refresh' content='0; url = parents/index.php' />";
    }
    
  }

  else {
   header ("location: index.php?login=error");   
   echo "<meta http-equiv='refresh' content='0; url = index.php?login=error' />";      
  }
  
}

/*****************************************************/



 ?>

<div class="clear"></div> <br>

<div class="col-md-8 col-md-offset-2">

  <div class="login">
    <h1><?php echo $lang ['log_in']; ?></h1>

<?php 

if (isset($_GET['login']) == "error") {
  echo "<div class='alert alert-danger center'><p>".$lang ['username_or_password_error']."</p></div>";
}

 ?>

<div class="clear"></div>


      <form id="login_students" action="" method="post">
        <input type="text" class="validate[required]" name="student_name" placeholder="<?php echo $lang ['username']; ?> .." />
        <input type="password" class="validate[required]" name="student_pass" placeholder="<?php echo $lang ['password']; ?>" />
        <input type="submit"  name="submit_students" value="<?php echo $lang ['login']; ?>" />
        <br>
      </form>

      <form id="login_teachers" action="" method="post">
        <input type="text" class="validate[required]" name="teacher_name" placeholder="<?php echo $lang ['username']; ?> .." />
        <input type="password" class="validate[required]" name="teacher_pass" placeholder="<?php echo $lang ['password']; ?>" />
        <input type="submit"  name="submit_teachers" value="<?php echo $lang ['login']; ?>" />
        <br>
      </form>

     <!-- <form id="login_parents" action="" method="post">
        <input type="text" class="validate[required]" name="parent_name" placeholder="<?php echo $lang ['username']; ?> .." />
        <input type="password" class="validate[required]" name="parent_pass" placeholder="<?php echo $lang ['password']; ?>" />
        <input type="submit"  name="submit_parents" value="<?php echo $lang ['login']; ?>" />
        <br>
      </form> -->

  </div>
</div>

<div class="clear"></div> <br><br>

<div class="col-md-8 col-md-offset-2">


    <div class="col-md-6">
      <a href="#" id="students">
          <div class="link">
            <img src="images/icons/student.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['trainee']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-6">
      <a href="#" id="teachers">
          <div class="link teachers">
            <img src="images/icons/1476216712_nerd.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['trainer']; ?></span>
         </div>
      </a>
    </div>

   <!-- <div class="col-md-4">
      <a href="#">
          <div class="link" id="parents">
            <img src="images/icons/1319546208_stock_people.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['guardian']; ?></span>
         </div>
      </a>
    </div>-->

</div>  

		  
</div>		
                           
            
<script type="text/javascript">

$(document).ready(function(){
    $("#teachers").click(function(){
        $("#login_teachers").slideToggle();
        $("#login_teachers").css("display" , "block");
        $("#login_parents, #login_students").css("display" , "none");
    });

    $("#parents").click(function(){
        $("#login_parents").slideToggle();
        $("#login_parents").css("display" , "block");
        $("#login_teachers, #login_students").css("display" , "none");
    });

    $("#students").click(function(){
        $("#login_students").slideToggle();
        $("#login_students").css("display" , "block");
        $("#login_parents, #login_teachers").css("display" , "none");
    });

});


  
</script>

<?php 
// close connection
$connect = null;
 ?>

 
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>



  </body>
</html>
