<?php 


session_start(); 

if (!isset($_SESSION ['administrator']) && !isset($_SESSION ['admin_index'])) {
  header("location: login.php") ;
}

if (isset($_SESSION ['admin_index'])) {
  $admin_index = $_SESSION ['admin_index'];
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

    <title><?php echo $lang ['Settings']; ?></title>

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
          jQuery("#form_email").validationEngine();
          jQuery("#form_pass").validationEngine();
          jQuery("#form2").validationEngine();

        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 


<div class="container" style="margin-top:100px;">

<a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a><br><br>


  <div class="panel panel-info row">

    <div class="panel-heading"><h1><?php echo $lang ['Settings']; ?></h1></div>

    <div class="panel-body">

<?php 



if (isset($_GET['update']) == "success") {
  echo "<br><div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['edit_successfully']."</p></div><br>"; 
  echo "<meta http-equiv='refresh' content='5; url = control.php' />";
}

$stmt_get_allInfo = $connect->query("SELECT * FROM administrator WHERE admin_index='$admin_index' ");

$row_allInfo = $stmt_get_allInfo->fetch();

$my_username = $row_allInfo ['username'];
$my_email = $row_allInfo ['email'];





 ?>


 <div class="clear"></div>


      <h2 class="edit"><?php echo $lang ['edit_my_information'] ?> :</h2>

<?php 

if (isset($_POST['change_pass'])) {

  $old_pass = htmlspecialchars(md5($_POST['old_pass']));
  $new_pass = htmlspecialchars(md5($_POST['new_pass']));


  $stmt_get = $connect->query("SELECT * FROM administrator WHERE admin_index='$admin_index' ");
  $get_rows = $stmt_get->fetch();
  $fetch_pass = $get_rows ['password'];


  if ($old_pass == $fetch_pass) {

      $stmt_update_pass = $connect->prepare("UPDATE administrator SET password=:password WHERE admin_index='$admin_index'");
      $stmt_update_pass->bindParam (':password' , $new_pass , PDO::PARAM_STR );
      $stmt_update_pass->execute();

      if (isset($stmt_update_pass)) {
        header ("location: control.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }
  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['password_error']."</p></div><br><br>";     
  }

}


if (isset($_POST['change_email'])) {

  $old_pass_email = htmlspecialchars(md5($_POST['old_pass_2']));
  $email = htmlspecialchars($_POST['email']);


  $stmt_get = $connect->query("SELECT * FROM administrator WHERE admin_index='$admin_index' ");
  $get_rows = $stmt_get->fetch();
  $fetch_pass = $get_rows ['password'];


  if ($old_pass_email == $fetch_pass) {

      $stmt_update_email = $connect->prepare("UPDATE administrator SET email=:email WHERE admin_index='$admin_index'");
      $stmt_update_email->bindParam (':email' , $email , PDO::PARAM_STR );
      $stmt_update_email->execute();

      if (isset($stmt_update_email)) {
        header ("location: control.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }
  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['password_error']."</p></div><br><br>";     
  }

}


 ?>


      <div class="col-md-4 col-md-offset-1">

      <h3><?php echo $lang ['change_password']; ?> :</h3>

            <form id="form_pass" method="post" action="">

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
                      <input type="password" placeholder="" class="form-control validate[required,equals[password]]" value=""/>
              </div><br>

              <button type="submit" name="change_pass" class="btn btn-info btn-block"><?php echo $lang ['change_password']; ?></button> 
              
            </form><br><br>
        </div>


        <div class="col-md-4 col-md-offset-2">

        <h3><?php echo $lang ['change_email']; ?> :</h3>

            <form id="form_email" method="post" action="">

              <label class=""><?php echo $lang ['old_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                  <input name="old_pass_2" type="password" placeholder="" class="form-control validate[required]" value=""/>
              </div><br>

              <label class=""><?php echo $lang ['email']; ?> :</label>
              <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
                <input name="email" type="text" placeholder="" class="form-control validate[custom[email]]" value="<?php echo $my_email; ?>"/>
              </div><br>

              <button type="submit" name="change_email" class="btn btn-info btn-block"><?php echo $lang ['save']; ?></button> 
              
            </form>
        </div>



<div class="clear"></div>

        
  
  <?php 


$stmt_get = $connect->query("SELECT * FROM control");
$row = $stmt_get->fetch();

$close_site = $row ['close_site'];
$get_pagination = $row ['pagination'];

/**************************************************************/

if (isset($_POST['save_other'])) {

  $pagination = htmlspecialchars($_POST['pagination']);


      $stmt_update_general = $connect->prepare("UPDATE control SET pagination=:pagination");
      $stmt_update_general->bindParam (':pagination' , $pagination , PDO::PARAM_STR );
      $stmt_update_general->execute();

      if (isset($stmt_update_general)) {
  
      echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }


}




 ?>

        <div class="col-md-6">

        <h2 class="edit"><?php echo $lang ['pagination']; ?> :</h2>

            <form id="form2" method="post" action="">


            <div class="col-md-12">
              <label class=""><?php echo $lang ['pagination']; ?> :</label>
              <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-star"></i></span>
                <input name="pagination" type="text" placeholder="" class="form-control validate[custom[integer]]" value="<?php echo $get_pagination; ?>"/>
              </div><br>


              <div class="clear"></div>

              <button type="submit" name="save_other" class="btn btn-info"><?php echo $lang ['save']; ?></button> 
              
            </div>

            
            </form>
        </div>

        
<?php 




if (isset($_POST['save_change'])) {

  $close_message = htmlspecialchars($_POST['word']);

  $stmt = $connect->prepare("UPDATE control SET close_message=:close_message");
  $stmt->bindParam (':close_message' , $close_message , PDO::PARAM_STR );
  $stmt->execute();

  if (isset($stmt)) {
        header ("location: control.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }

}

if (isset($_POST['close_yes'])) {
    $stmt = $connect->query("UPDATE control SET close_site='1'");

    if (isset($stmt)) {
        header ("location: control.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }
    
}

if (isset($_POST['close_no'])) {
    $stmt = $connect->query("UPDATE control SET close_site='0'");

    if (isset($stmt)) {
        header ("location: control.php?update=success");   
        echo "<meta http-equiv='refresh' content='0; url = control.php?update=success' />"; 

      }
}

 ?>


        <div class="col-md-6">

        <h2 class="edit"><?php echo $lang ['Close_Site'] ?> :</h2>

            <form method="post" action="">

              <label class=""><?php echo $lang ['site_mode'] ?> : </label>
              <br>

              
              <?php 
              if ($close_site == 0) {
                echo '<div class="alert alert-info" style="padding: 15px; text-align: center; ">'.$lang ['Site_is_open_Do_you_want_to_close_it'].'  <button type="submit" name="close_yes" class="btn btn-default">'.$lang ['close'].'</button></div>';
               } 
               if ($close_site == 1) {
                 echo '<div class="alert alert-danger" style="padding: 15px; text-align: center;">'.$lang ['Site_Closed_Do_you_want_to_open_it'].'  <button type="submit" name="close_no" class="btn btn-default">'.$lang ['open'].'</button></div>';
               } 

               ?>

               <div class="clear"></div><br>

               <label class=""><?php echo $lang ['close_message']; ?> : </label>
              <textarea class="form-control" style="max-width : 100%;" name="word" placeholder=""><?php echo $row ['close_message'] ?></textarea>

              <br>

              <button type="submit" name="save_change" class="btn btn-info"><?php echo $lang ['save']; ?></button> 

              
            
              
            </form>
        </div>


        <div class="clear"></div> <hr>


        <h2 class="edit"><?php echo $lang ['Backups']; ?> :</h2>



<?php 

if (isset($_POST['import_all_tables'])) {


    $target = dirname(__DIR__)."/uploads/data/";
    // an array of allowed extensions
    $allowedExts = array("sql", "SQL");
    $temp = explode(".", $_FILES["all_tables"]["name"]);
    $extension = end($temp);

    if (($_FILES["all_tables"]["type"] == "text/x-sql" || $_FILES["all_tables"]["type"] == "application/x-sql" ) && in_array($extension, $allowedExts)) {

        if ($_FILES["all_tables"]["error"] > 0) {
        echo "<div class='alert alert-danger'><p class='center'>error</p></div>";
      }
      else {
        $backup_uploaded = round(microtime(true)) . '.' . end($temp);
        if (move_uploaded_file($_FILES["all_tables"]["tmp_name"], $target . $backup_uploaded)) {

              
//      $filename = dirname(__FILE__).'/uploads/data/'.$backup_uploaded;
        $filename = dirname(__DIR__).'/uploads/data/'.basename($backup_uploaded);
        $templine = '';
        $lines = file($filename);

        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '')
            continue;
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
            $tables_imported = $connect->query($templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysql_error() . '<br /><br />');
              // Reset temp variable to empty
              $templine = '';
            }
        }

        if (isset($tables_imported)) {
                echo "<div id='success' class='col-md-8 col-md-offset-2'><div class='alert alert-success center'><p>".$lang ['data_has_been_successfully_imported']."</p></div></div>";
                
                // delete file
                unlink($filename);

                 echo '<script type="text/javascript"> window.location.href += "#success"; </script>';
        }

        }

      }   
      
    }

    else {
      echo "<div id='error' class='col-md-8 col-md-offset-2'><div class='alert alert-danger center'><p>".$lang ['This_is_not_a_SQL_file']."</p></div></div>";

      echo '<script type="text/javascript"> window.location.href += "#error"; </script>';
     
    }


}


if (isset($_POST['export_all_tables'])) {
  require ('../includes/backup_tables.php');
  // backup all tables in db
  backup_tables();

}




?>

<?php


if (!function_exists('fopen') OR !function_exists('fwrite')) {
   echo "<div class='alert alert-warning' style='margin: auto; overflow: hidden;'>
        <h3>Certaines fonctions sont désactivées !</h3>
        <p>Prendre des sauvegardes nécessite les fonctions suivantes : </p>
        <br>
        <span style='font-size: 13px;' class='label label-danger'>fopen</span> <span style='font-size: 13px;' class='label label-danger'>fwrite</span>
        
    </div>";
}


if (function_exists('fopen') OR function_exists('fwrite')) {

?>      

          <form id="myid" action="" method="post" enctype="multipart/form-data">

              <div class="col-md-6 forms_import">
                <input type="file" name="all_tables" class="btn btn-default" style="float : left; max-width: 70%;" />
                <input type="submit" name="import_all_tables" value="<?php echo $lang ['import']; ?>" class="btn btn-info" style="float : right;" /> 
              </div>

              <div class="col-md-4 col-md-offset-1">
                <input type="submit" name="export_all_tables" value="<?php echo $lang ['Export']; ?>" class="btn btn-warning btn-block" style="" />
                <span class="help-block"><?php echo $lang ['backup_all_data_sql']; ?></span>
              </div> 

            </form>
<?php } ?>



<br>



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
