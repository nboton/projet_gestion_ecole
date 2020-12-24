<?php 
 

session_start(); 

if (isset($_SESSION ['administrator'])) {
  header("location: index.php") ;
}



require '../includes/database_config.php';
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

    <title><?php echo $lang ['PasswordReset']; ?></title>

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
          jQuery("#PasswordReset").validationEngine();
        });
 
      </script>

       

  </head>

  <body>

<div class="navbar navbar-default">
<div class="container">  
  <form id="language" action="" method="post">
    <input type="submit" name="fr" class="francais" value="francais" />
  <input type="submit" name="en" class="english" value="english" />
  </form> 
</div>
</div>

<div class="container main">

<div class="clear"></div> <br>

<div class="col-md-8 col-md-offset-2">

  <div class="login">

<?php if (isset($_GET['reset'])) {


  $reset =htmlspecialchars(@$_GET['reset']) ;

    $reset_stmt = $connect->prepare("SELECT * FROM reset_pass WHERE reset_code=:reset_code");
    $reset_stmt->bindParam (':reset_code' , $reset , PDO::PARAM_STR );
    $reset_stmt->execute();

    while ( $rows = $reset_stmt->fetch()) {
      $reset_email=$rows['email'];
      $get_reset_code = $rows['reset_code'];
    }


    if (empty($get_reset_code)) { 
      die('<br /><div class="alert alert-danger center"><p>'.$lang ['reset_code_error'].'</a></p></div>');
    }

    if ($reset == $get_reset_code) {

      echo '<h1>'.$lang ['PasswordReset'].'</h1>';

          if (isset($_POST['subReset'])) {
        
              $new_password = htmlspecialchars(md5($_POST ['password']));

              $update_stmt = $connect->prepare("UPDATE administrator SET password=:password WHERE email='$reset_email'");
              $update_stmt->bindParam (':password' , $new_password , PDO::PARAM_STR );
              $update_stmt->execute();

               
               if (isset($update_stmt)){

                $delete_stmt = $connect->query("DELETE FROM reset_pass WHERE email = '$reset_email'");
                echo "<meta http-equiv='refresh' content='5; url = login.php' />" ;
                die('<div class="alert alert-success center"><p>'.$lang ['reset_success'].'</p></div>');
               }

          }

    }


?>

<div class="clear"></div>


      <form id="PasswordReset" action="" method="post">
        <input type="password" class="validate[required]" name="password" id="password" placeholder="<?php echo $lang ['password']; ?> .." />
        <input type="password" class="validate[required,equals[password]]" placeholder="<?php echo $lang ['confirm_password']; ?> .." />
        <input type="submit" name="subReset" value="<?php echo $lang ['save']; ?>" />
        
      </form>

<?php } else { ?>

    <h1><?php echo $lang ['insert_email']; ?></h1>

<?php 

if (isset($_POST['submit_email'])) {

  $reset_code=md5(uniqid(rand()));
  $email = htmlspecialchars($_POST['email']);

  $stmt = $connect->prepare("SELECT * FROM administrator WHERE email=:email");
  $stmt->bindParam (':email' , $email , PDO::PARAM_STR );
  $stmt->execute();


  if ($stmt->rowCount() == 1) {

    $insert = $connect->prepare("INSERT INTO  reset_pass (email, reset_code) values (:email, '$reset_code')");
    $insert->bindParam (':email' , $email , PDO::PARAM_STR );
    $insert->execute();
  }

  if(isset($insert)){

    echo '<div class="alert alert-success center"><p>'.$lang ['reset_code_send'].'</p></div>';
   
      echo "<meta http-equiv='refresh' content='15; url = index.php' />" ;

      
        require_once('../includes/phpMailer/class.phpmailer.php');
        $mail = new PHPMailer();

        $mail->From = 'no-reply@'.$_SERVER['HTTP_HOST'].'';
        $mail->FromName = $_SERVER['HTTP_HOST'];
        $mail->Subject = 'Password reset request';
        $mail->AddAddress($email);
        $mail->IsHTML(true);
        $mail->Body = 'We received a request to reset your password.<br/><br/> If you made this request, you can confirm it by clicking this link : <br/><br/> http://'.$_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'].'?reset='.$reset_code.'<br/><br/><br/>If you didn t request this password reset, its ok to ignore this mail.';

        $mail->Send();

  }

  else {
    echo "<div class='alert alert-danger center'><p>".$lang ['no_user_with_this_email']." ".$email."</p></div>";
     
    }

// close connection
$connect = null;
  
  
}

 ?>

<div class="clear"></div>


      <form id="PasswordReset" action="" method="post">
      
        <input type="text" class="validate[required,custom[email]]" name="email" placeholder="<?php echo $lang ['email']; ?> .." value="<?php echo htmlspecialchars(!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''?>" />

        <input type="submit" name="submit_email" value="<?php echo $lang ['PasswordReset']; ?>" />
        
        <a href="login.php" style="color: #c66;"><?php echo $lang ['log_in']; ?></a>
      </form>

<?php } ?>

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
