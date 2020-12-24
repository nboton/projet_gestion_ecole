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

    <title><?php echo $lang ['exams']; ?></title>

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
        });
 
      </script>


      <script src="../libs/datePicker/js/lang/en.js"></script>
      <script src="../libs/datePicker/js/datepicker.js">{"describedby":"fd-dp-aria-describedby"}</script>
      <link href="../libs/datePicker/css/datepicker.css" rel="stylesheet" type="text/css" />
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">

      <br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>
          <h1 class="h1_title"><?php echo $lang ['new_exam']; ?></h1>

          <hr>
        
      <div class="row col-md-8 col-md-offset-2">

 <?php 



$stmt_get_info = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
$row_get_info = $stmt_get_info->fetch();
$my_name = $row_get_info ['full_name'];

if (isset($_POST['submit'])) {

  $exam_date = htmlspecialchars($_POST['exam_date']);
  $exam_time = htmlspecialchars($_POST['exam_time']);
  $exam_class = htmlspecialchars($_POST['class']);
  $exam_subject = htmlspecialchars($_POST['subject']);
  



  $stmt_exam = $connect->prepare("INSERT INTO exam (class, teacher_name, subject, date, time) VALUES ('$exam_class', '$my_name', '$exam_subject', :date, :time)");
  $stmt_exam->bindParam (':date' , $exam_date , PDO::PARAM_STR );
  $stmt_exam->bindParam (':time' , $exam_time , PDO::PARAM_STR );
  $stmt_exam->execute();

  if (isset($stmt_exam)) {
    header ("location: exams.php?add=success");   
    echo "<meta http-equiv='refresh' content='0; url = exams.php?add=success' />";

  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div>";     
  }
  
}

/**************************************************************/


if (isset($_GET['add']) == "success") {
  echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['add_successfully']."</p></div><br>";

  echo "<meta http-equiv='refresh' content='10; url = exams.php' />";
}


 ?> 

        <form id="formID" action="" method="post">

                    <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
                        <select name="class" class="form-control validate[required]">
                          <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
<?php 
  $stmt_find_class = $connect->query("SELECT * FROM classes");

  while ($find_class_row = $stmt_find_class->fetch()) {
      $fetch_class_name = $find_class_row ['class_name'];

      echo '<option value="'.$fetch_class_name.'">'.$fetch_class_name.'</option>';

  } 
?>
                        </select>
                    </div><br>

                    <label class=""><?php echo $lang ['subject']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
                        <select name="subject" class="form-control validate[required]">
                          <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
<?php 
  $stmt_find_subject = $connect->query("SELECT * FROM subjects ");

  while ($find_subject_row = $stmt_find_subject->fetch()) {
      $fetch_subject_name = $find_subject_row ['subject_name'];

      echo '<option value="'.$fetch_subject_name.'">'.$fetch_subject_name.'</option>';

  } 
?>
                        </select>
                    </div><br>

                    <div class="col-xs-6">
                        <label class=""><?php echo $lang ['date']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                <input id="demo-1" name="exam_date" type="text" placeholder="00/00/0000" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['date'])) ? htmlspecialchars($_POST['date']) : ''?>" />
                            </div><br>
                    </div>

<script>
datePickerController.createDatePicker({
    // Associate the text input to a DD/MM/YYYY date format
    formElements:{"demo-1":"%d/%m/%Y"}
    });
</script>

<style type="text/css">
  a#fd-but-demo-1 {
    position: absolute;
}
</style>

                    <div class="col-xs-4 col-xs-offset-1">
                         <label class=""><?php echo $lang ['time']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                                <input name="exam_time" type="text" placeholder="00:00" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['time'])) ? htmlspecialchars($_POST['time']) : ''?>"/>
                            </div><br>
                    </div>

                      <button type="submit" name="submit" class="mybtn mybtn-success btn-block"><?php echo $lang ['add']; ?></button>
                    


          </form>
        
      </div>




      <div class="clear"></div><br><br><br>

              <h1 class="h1_title"><?php echo $lang ['exams']; ?></h1>
             <hr>
<?php 

if (isset($_GET['delete'])) {

  $exam_delete = (int)$_GET['delete'];

    $delete_stmt = $connect->prepare("DELETE FROM exam where id=:id and teacher_name='$my_name'");
    $delete_stmt->bindParam (':id', $exam_delete , PDO::PARAM_INT);
    $delete_stmt->execute();

    if (isset($delete_stmt)) {
      header("Location: exams.php");
      echo "<meta http-equiv='refresh' content='0; url = exams.php' />";
    }
}

 ?>
            <table class="table table-striped table-bordered">
              <tr class="tr-table2">
                <th><?php echo $lang ['class']; ?></th>
                <th><?php echo $lang ['subject']; ?></th>
                <th><?php echo $lang ['date']; ?></th>  
                <th><?php echo $lang ['time']; ?></th>
                <th><?php echo $lang ['delete']; ?></th>
              </tr>

<?php 
  $stmt_exams = $connect->prepare("SELECT * FROM exam WHERE teacher_name='$my_name' ORDER BY id DESC");
  $stmt_exams->execute();

  while ($stmt_exams_row = $stmt_exams->fetch()) {
      $fetch_exam_class = $stmt_exams_row ['class'];
      $fetch_exam_subject = $stmt_exams_row ['subject'];
      $fetch_exam_date = $stmt_exams_row ['date'];
      $fetch_exam_time = $stmt_exams_row ['time'];
      $fetch_exam_id = $stmt_exams_row ['id'];

 ?>
                <tr>
                  <td><?php echo $fetch_exam_class ?></td>
                  <td><span class="label label-success" style="font-size: 14px;"><?php echo $fetch_exam_subject ?></span></td> 
                  <td><span class="label label-danger" style="font-size: 14px;"><?php echo $fetch_exam_date ?></span></td>  
                  <td><span class="label label-primary" style="font-size: 14px;"><?php echo $fetch_exam_time ?></span></td>
                  <td><a href="exams.php?delete=<?php echo $fetch_exam_id ?>&teacher=<?php echo $my_teacher_index ?>"><i class="glyphicon glyphicon-trash large" style="font-size:26px"></i></a></td>
                </tr>

<?php } ?>
              </table>  

              <br><br>
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
