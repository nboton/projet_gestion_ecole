<?php 
 

session_start(); 

if (!isset($_SESSION ['teacher']) && !isset($_SESSION ['teacher_index']) ) {
  header("location: ../index.php");
  exit();
}

if (isset($_SESSION ['teacher_index'])) {
  $my_teacher_index = $_SESSION ['teacher_index'];
}

require '../includes/database_config.php';
include '../includes/display_errors.php';
include '../includes/make_lang.php';



 ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png" />

    <title><?php echo $lang ['my_profile']; ?></title>

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
     <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
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
          jQuery("#formID").validationEngine();
          jQuery("#formID2").validationEngine();
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container" style="margin-top:80px;">

<?php 

$stmt_get_allInfo = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");

$row_allInfo = $stmt_get_allInfo->fetch();

$my_fullname = $row_allInfo ['full_name'];
$my_image = $row_allInfo ['image'];
$my_subject = $row_allInfo ['subject'];
$my_gender = $row_allInfo ['sex'];
$my_address = $row_allInfo ['address'];
$my_phone = $row_allInfo ['phone'];
$my_email = $row_allInfo ['email'];


 ?>

<a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a><br><br>

  <div class="panel panel-info">
    <div class="panel-heading center">
      <img src="../uploads/teachers/<?php if (empty($my_image)) {echo 'no_image.jpg';} else {echo $my_image;} ?>" class="img-thumbnail" width="150px">
      
      <h2><?php echo $my_fullname; ?> <br> <span><?php echo $lang ['teacher']; ?></span></h2>

    </div>
    <div class="panel-body">

<?php 
if (isset($_GET['update']) == "success") {
  echo "<br><div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['edit_successfully']."</p></div><br><br>"; 
  echo "<meta http-equiv='refresh' content='3; url = profile.php' />";
}
 ?>
<div class="clear"></div>
    <h2 class="edit"><?php echo $lang ['personal_information']; ?> :</h2>

    <div class="col-md-6">
      <label><?php echo $lang ['subject']; ?>  :</label> <span><?php echo $my_subject; ?></span><br><br>
      <label><?php echo $lang ['gender']; ?>  :</label> <span><?php echo $my_gender; ?></span><br><br>
      <label><?php echo $lang ['email']; ?>  :</label> <span><?php echo $my_email; ?></span><br><br>
    </div>
    <div class="col-md-6">
      <label><?php echo $lang ['Address']; ?>  :</label> <span><?php echo $my_address; ?></span><br><br>
      <label><?php echo $lang ['phone']; ?>  :</label> <span><?php echo $my_phone; ?></span><br><br>
    
    </div>

    <div class="clear"></div>

    <h2 class="edit"><?php echo $lang ['edit_my_information']; ?> :</h2>

    <div class="col-md-10 col-md-offset-1">

<?php 


/****************************************************************/

if (isset($_POST['update_info'])) {
   
  $update_address = htmlspecialchars($_POST['address']);
  $update_phone = htmlspecialchars($_POST['phone']);
  $update_email = htmlspecialchars($_POST['email']);


   $stmt_update_info = $connect->prepare("UPDATE teachers_users SET email=:email, phone=:phone, address=:address WHERE teacher_index='$my_teacher_index'");
  $stmt_update_info->bindParam (':email' , $update_email , PDO::PARAM_STR );
  $stmt_update_info->bindParam (':phone' , $update_phone , PDO::PARAM_STR );
  $stmt_update_info->bindParam (':address' , $update_address , PDO::PARAM_STR );
  $stmt_update_info->execute();

  if (isset($stmt_update_info)) {
    header ("location: profile.php?update=success");   
    echo "<meta http-equiv='refresh' content='0; url = profile.php?update=success' />"; 

  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

  ?>

  <form id="formID" method="post" action="">

        <label class=""><?php echo $lang ['Address']; ?> :</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
            <input name="address" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $my_address; ?>"/>
        </div><br>

        <label class=""><?php echo $lang ['phone']; ?> :</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
            <input name="phone" type="text" placeholder="" class="form-control validate[custom[phone]]" value="<?php echo $my_phone; ?>"/>
        </div><br>

        <label class=""><?php echo $lang ['email']; ?> :</label>
              <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input name="email" type="text" placeholder="" class="form-control validate[required,custom[email]]" value="<?php echo $my_email; ?>"/>
        </div><br>

        <div class="clear"></div>
              
        <button type="submit" name="update_info" class="btn btn-info btn-block "><?php echo $lang ['edit_my_information']; ?></button> 

        <br><br>

    </form>
  
</div>


<div class="clear"></div>

    <h2 class="edit"><?php echo $lang ['change_password']; ?> :</h2>

    <div class="col-md-10 col-md-offset-1">

<?php 

/****************************************************************/

if (isset($_POST['update_passe'])) {
   
  $old_pass = htmlspecialchars(md5($_POST['old_pass']));
  $new_pass = htmlspecialchars(md5($_POST['new_pass']));


  $stmt_get = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
  $get_rows = $stmt_get->fetch();
  $fetch_pass = $get_rows ['password'];


  if ($old_pass == $fetch_pass) {

      $stmt_update_pass = $connect->prepare("UPDATE teachers_users SET password=:password WHERE teacher_index='$my_teacher_index'");
      $stmt_update_pass->bindParam (':password' , $new_pass , PDO::PARAM_STR );
      $stmt_update_pass->execute();

      if (isset($stmt_update_pass)) {
        header ("location: profile.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = profile.php?update=success' />"; 

      }
  }

  else {
   echo "<div id='error' class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['password_error']."</p></div><br><br>";  
   echo '<script type="text/javascript"> window.location.href += "#error"; </script>';     
  }


 } 

  ?>

  <form id="formID2" method="post" action="">

        <label class=""><?php echo $lang ['old_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
            <input name="old_pass" type="password" placeholder="" class="form-control validate[required]" value=""/>
        </div><br>

        <label class=""><?php echo $lang ['new_password']; ?> :</label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
            <input name="new_pass" type="password" id="password" class="form-control validate[required]" value=""/>
        </div><br>

        <label class=""><?php echo $lang ['confirm_password']; ?> :</label>
              <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                <input type="password" placeholder="" class="form-control validate[required,equals[password]] " value=""/>
        </div><br>

        <div class="clear"></div>
              
        <button type="submit" name="update_passe" class="btn btn-info btn-block "><?php echo $lang ['change_password']; ?></button> 

        <br><br>

    </form>
  
</div>

    
      
    </div>
  </div>

</div>    
                           

<?php include 'footer.php'; ?>       

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>



  </body>
</html>
