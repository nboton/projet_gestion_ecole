<?php 



session_start(); 

if (!isset($_SESSION ['student']) && !isset($_SESSION ['student_index']) ) {
  header("location: ../index.php");
  exit();
}

if (isset($_SESSION ['student_index'])) {
  $my_student_index = $_SESSION ['student_index'];
}

require '../includes/database_config.php';
include '../includes/display_errors.php';
include '../includes/make_lang.php';

$stmt_get_allInfo = $connect->query("SELECT * FROM students_users WHERE student_index='$my_student_index' ");

$row_allInfo = $stmt_get_allInfo->fetch();

$my_fullname = $row_allInfo ['full_name'];

 ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png" />

    <title><?php echo $lang ['Registration_of_absence']; ?></title>

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

          <h1 class="h1_title"><?php echo $lang ['Registration_of_absence']; ?></h1>

          <hr>

      <div class="col-md-10 col-md-offset-1">

<?php 

if (isset($_GET['send']) == "success") {
  echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['send_success']."</p></div><br><br>"; 
}

/****************************************************************/

if (isset($_POST['submit'])) {
   
  $absence_user = htmlspecialchars($_POST['name']);
  $absence_reason = htmlspecialchars($_POST['reason']);
  $absence_note = htmlspecialchars($_POST['note']);
  $absence_type = htmlspecialchars($_POST['type']);

  $absence_date = date("d/m/Y");


   $stmt_absence = $connect->prepare("INSERT INTO absences (type, full_name, reason, note, date) VALUES (:type, :full_name, :reason, :note, '$absence_date')");
  $stmt_absence->bindParam (':type' , $absence_type , PDO::PARAM_STR );
  $stmt_absence->bindParam (':full_name' , $absence_user , PDO::PARAM_STR );
  $stmt_absence->bindParam (':reason' , $absence_reason , PDO::PARAM_STR );
  $stmt_absence->bindParam (':note' , $absence_note , PDO::PARAM_STR );
  $stmt_absence->execute();

  if (isset($stmt_absence)) {
    header ("location: absence.php?send=success");   
    echo "<meta http-equiv='refresh' absence='0; url = absence.php?send=success' />"; 

  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

  ?>

            <form id="formID" method="post" action="">

                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                    <select name="type" class="form-control">
                      <option selected="selected" value="student"><?php echo $lang ['student']; ?></option>
                    </select>
                </div><br>

                <label class=""><?php echo $lang ['you_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input name="name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $my_fullname; ?>"/>
                </div><br>


                <label class=""><?php echo $lang ['reason_of_absence']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>

                    <select name="reason" class="form-control validate[required]">
                      <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                      <option value="<?php echo $lang ['malady']; ?>"><?php echo $lang ['malady']; ?></option>
                      <option value="<?php echo $lang ['family_reason']; ?>"><?php echo $lang ['family_reason']; ?></option>
					             <option value="<?php echo $lang ['other']; ?>"><?php echo $lang ['other']; ?></option>
                    </select>
                </div><br>


                <label class=""><?php echo $lang ['comment']; ?> <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                  <textarea class="form-control validate[required]" name="note" placeholder=""><?php echo htmlspecialchars(!empty($_POST['note'])) ? htmlspecialchars($_POST['note']) : ''?></textarea>
                </div><br>

                <div class="clear"></div>
                      
                <button type="submit" name="submit" class="mybtn mybtn-success btn-block "><?php echo $lang ['send']; ?></button> 

                <br><br>

            </form>
  
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
