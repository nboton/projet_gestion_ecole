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

    <title><?php echo $lang ['report']; ?></title>

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

    
     <link href="../css/style.css" rel="stylesheet">
      <link href="../css/Normalize.css" rel="stylesheet">
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

      <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>

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
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">

      <br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>
<?php 
if (isset($_GET['student'])) {

  $student_id = htmlspecialchars($_GET['student']);

  $stmt_get_index_name = $connect->prepare("SELECT * FROM index_users WHERE index_num=:index_num ");
  $stmt_get_index_name->bindParam (':index_num' , $student_id , PDO::PARAM_STR );
  $stmt_get_index_name->execute();

  $count = $stmt_get_index_name->rowCount();

  if ($count < 1 ) {
    die("<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br>");
  }

  $row_index_name = $stmt_get_index_name->fetch();
  $to_name = $row_index_name ['full_name'];


 ?>
          <h1 class="h1_title"><?php echo $lang ['report']; ?> [ <?php echo $to_name ; ?> ]</h1>

          <hr>
        
      <div class="row col-md-10 col-md-offset-1">

<?php 



$stmt_get_info = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
$row_get_info = $stmt_get_info->fetch();
$my_name = $row_get_info ['full_name'];

if (isset($_POST['submit'])) {

  $report_title = htmlspecialchars($_POST['title']);
  $report_content = htmlspecialchars($_POST['report']);
  $report_to_parent = htmlspecialchars($_POST['copy_to_parent']);
  $report_date = date("d/m/Y");


  $stmt_report = $connect->prepare("INSERT INTO reports (student_index, to_parents, author, title, report, date, read_report) VALUES (:student_index, '$report_to_parent', '$my_name', :title, :report, '$report_date', '0')");
  $stmt_report->bindParam (':student_index' , $student_id , PDO::PARAM_STR );
  $stmt_report->bindParam (':title' , $report_title , PDO::PARAM_STR );
  $stmt_report->bindParam (':report' , $report_content , PDO::PARAM_STR );
  $stmt_report->execute();

  if (isset($stmt_report)) {
  // fix the "HTTP Response Splitting" vulnerability 
  //  header ("location: reports.php?student=$student_id&send=success");   
    echo "<meta http-equiv='refresh' content='0; url = reports.php?student=$student_id&send=success' />";

  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div>";     
  }
  
}

/**************************************************************/


if (isset($_GET['send']) == "success") {
  echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['send_success']."</p></div><br><br>";
}


 ?>

        <form id="formID" action="" method="post">

                    <label class=""><?php echo $lang ['Send_a_copy_to_the_Guardian']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
                        <select name="copy_to_parent" class="form-control validate[required]">
                          <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                          <option value="1"><?php echo $lang ['yes']; ?></option>
                          <option value="0"><?php echo $lang ['no']; ?></option>
                        </select>
                    </div><br>

                    <label class=""><?php echo $lang ['title']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input name="title" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['title'])) ? htmlspecialchars($_POST['title']) : ''?>"/>
                    </div><br>


                   <label class=""><?php echo $lang ['report']; ?> <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                  <textarea class="form-control validate[required]" name="report" placeholder=""><?php echo htmlspecialchars(!empty($_POST['report'])) ? htmlspecialchars($_POST['report']) : ''?></textarea>
               </div><br>

                      <button type="submit" name="submit" class="mybtn mybtn-success btn-block"><?php echo $lang ['send']; ?></button>
  
          </form>

          <br><br>
        
      </div>

<?php } else {
    echo "<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['non_autorise']."</p></div><br><br>";
  } ?> 
       
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
