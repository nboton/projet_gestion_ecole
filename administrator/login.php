<?php 
 

session_start(); 

if (isset($_SESSION ['administrator'])) {
  header("location: index.php") ;
}

require_once '../includes/database_config.php';
include '../includes/display_errors.php';
include '../includes/make_lang.php';



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
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    
     <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
     <link rel="stylesheet" href="../css/Normalize.css" rel="stylesheet">
     
     <?php 
     if (isset($_SESSION['arabic'])) {
      echo '<link rel="stylesheet" href="../css/rtl_fix.css" rel="stylesheet">
      <link href="../css/bootstrap-rtl.min.css" rel="stylesheet">
      <link rel="stylesheet" href="../fonts/ar/droid.css">';
      }

      if (isset($_SESSION['francais']) OR isset($_SESSION['english'])) {
      echo '<link rel="stylesheet" href="../fonts/fr/fonts_css.css">';
      }

      ?>

      <script src="../js/jquery-1.11.3.min.js"></script>

      <link rel="stylesheet" href="../libs/validationEngine/validationEngine.jquery.css" type="text/css"/>
<?php 
if (isset($_SESSION['arabic'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-ar.js" type="text/javascript" charset="utf-8"></script>';
}
if (isset($_SESSION['francais'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-fr.js" type="text/javascript" charset="utf-8"></script>';
}

if (isset($_SESSION['english'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>';
}  
?>
      <script src="../libs/validationEngine/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
      </script>
      <script>
        jQuery(document).ready(function(){
          // binds form submission and fields to the validation engine
          jQuery("#login").validationEngine();
        });
 
      </script>

       

  </head>

  <body>

<div class="navbar navbar-default">
<div class="container">  
  <form id="language" action="" method="post">
   <a href="index.php"><img  width="60" height="60" src="../logo.png" alt=""><big></big></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" name="fr" class="francais" value="francais" />
   
    <input type="submit" name="en" class="english" value="english" />
  </form> 
</div>
</div>

<div class="container main">


<div class="clear"></div>	<br>

<?php 

if (isset($_POST['submit'])) {

  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars(md5($_POST['password']));

  $stmt_login = $connect->prepare("SELECT * FROM administrator WHERE username=:username and password=:password");
  $stmt_login->bindParam (':username' , $username , PDO::PARAM_STR );
  $stmt_login->bindParam (':password' , $password , PDO::PARAM_STR );
  $stmt_login->execute();

  if ($stmt_login->rowCount() == 1) {
    
    $row = $stmt_login->fetch() ;
    $user = $row ['username'];
    $pass = $row ['password'];
    $admin_index = $row ['admin_index'];

    if ($user == $username and $pass == $password) {

      $_SESSION ['administrator'] = $user;
      $_SESSION ['admin_index'] = $admin_index;

      $token_rand = md5(uniqid(rand()));
      $_SESSION ['token'] = $token_rand;

      header ("location: index.php");
      echo "<meta http-equiv='refresh' content='0; url = index.php' />";
      
    }
    
  }

  else {
   header ("location: login.php?login=error");   
   echo "<meta http-equiv='refresh' content='0; url = login.php?login=error' />";      
  }
  
}



 ?>

<div class="clear"></div> <br>

<div class="col-md-6 col-md-offset-3">
  <div class="login">
    <h1><?php echo $lang ['log_in']; ?></h1>

<?php 

if (isset($_GET['login']) == "error") {
  echo "<div class='alert alert-danger center'><p>".$lang ['username_or_password_error']."</p></div>";
}

 ?>

<div class="clear"></div>


      <form id="login" action="" method="post">
        <input type="text" class="validate[required]" name="username" placeholder="<?php echo $lang ['username']; ?> .." />
        <input type="password" class="validate[required]" name="password" placeholder="<?php echo $lang ['password']; ?>" />
        <input type="submit"  name="submit" value="<?php echo $lang ['login']; ?>" />
        
        <a href="PasswordReset.php" style="color: #c66;"><?php  echo $lang ['lost_password']; ?></a>
      </form>

  </div>

</div>

<div class="clear"></div> <br><br>

		  
</div>		
                           
            


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>



  </body>
</html>
