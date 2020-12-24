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

    <title><?php echo $lang ['marks']; ?></title>

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
          jQuery("#formID2").validationEngine();
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">

      <br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>
          <h1 class="h1_title"><?php echo $lang ['marks']; ?></h1>

          <hr>
        
      

 <?php 



$stmt_get_info = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
$row_get_info = $stmt_get_info->fetch();
$my_name = $row_get_info ['full_name'];


/**************************************************************/

if (!isset($_GET['class'])) {

  if (isset($_POST['class_subject'])) {
      
      $class_name = htmlspecialchars($_POST['class']);
      $subject_name = htmlspecialchars($_POST['subject']);

    //  fix the "HTTP Response Splitting" vulnerability 
    //   header("location: marks.php?class=$class_name&subject=$subject_name") ;

      echo "<meta http-equiv='refresh' content='0; url = marks.php?class=$class_name&subject=$subject_name' />";

  }
    

?> 
<div class="row col-md-8 col-md-offset-2">
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
  $stmt_find_subject = $connect->query("SELECT * FROM subjects WHERE subject_teacher='$my_name'");

  while ($find_subject_row = $stmt_find_subject->fetch()) {
      $fetch_subject_name = $find_subject_row ['subject_name'];

      echo '<option value="'.$fetch_subject_name.'">'.$fetch_subject_name.'</option>';

  } 

?>
                        </select>
                    </div><br>

                    <button type="submit" name="class_subject" class="mybtn mybtn-success btn-block"><?php echo $lang ['select']; ?></button>

      </form>

</div>


<div class="clear"></div>
<br>

 <h1 class="h1_title"><?php echo $lang ['find_marks_student']; ?></h1>
<hr>

<div class="row col-md-10 col-md-offset-1">

      <form id="" action="" method="post">

                  <div class="col-md-6 col-md-offset-1">
                    <input style="height:42px; margin-bottom: 10px;" name="findInput" type="text" placeholder="<?php echo $lang ['student']  ?>" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['findInput'])) ? htmlspecialchars($_POST['findInput']) : ''?>"/>
                  </div>

                  <div class="col-md-4">
                    <button type="submit" name="find_submit" class="mybtn mybtn-default btn-block"><?php echo $lang ['find']; ?></button>
                  </div>


        </form>
      
</div><br><br>

<div class="clear"></div><br><br>

<?php 

if (isset($_POST['find_submit'])) {
   
  $find_student = htmlspecialchars($_POST['findInput']);

  	$stmt_find_student = $connect->prepare("SELECT * FROM index_users WHERE full_name=:full_name");
  	$stmt_find_student->bindParam (':full_name' , $find_student , PDO::PARAM_STR );
  	$stmt_find_student->execute();

	$fetch_student_index = null;

	while ($find_student_row = $stmt_find_student->fetch()) {
		$fetch_student_index = $find_student_row ['index_num'];
	}
	

	if (empty($fetch_student_index)) {
		echo "<div id='error' class='alert alert-danger center'><p>".$lang ['sorry_There_is_no_user_with_this_name']."</p></div>";

echo '<script type="text/javascript"> 
$(document).ready(function(){
	$("table").css("display" , "none"); });
	window.location.href += "#error";
</script>';
}

	
  $stmt_find_student_mark = $connect->query("SELECT * FROM students_marks WHERE student_id='$fetch_student_index' AND teacher_name='$my_name'");

?>
    
    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['date']; ?></th>
	        <th><?php echo $lang ['student']; ?></th>
	        <th><?php echo $lang ['subject']; ?></th>
	        <th><?php echo $lang ['mark']; ?></th>
	        <th><?php echo $lang ['note']; ?></th>
          </tr>

<?php 
while ($stmt_marks_row = $stmt_find_student_mark->fetch()) {

      $fetch_mark_id = $stmt_marks_row ['id'];
      $fetch_mark_date = $stmt_marks_row ['date'];
      $fetch_mark_subject = $stmt_marks_row ['subject'];
      $fetch_mark_mark = $stmt_marks_row ['mark'];
      $fetch_mark_note = $stmt_marks_row ['note'];
	   
?>
            <tr>
              <td><?php echo $fetch_mark_date; ?></td>
	          <td><?php echo $find_student; ?></td>
	          <td><?php echo $fetch_mark_subject; ?></td>
	          <td><span class="label label-warning" style="font-size: 14px;"><?php echo $fetch_mark_mark; ?></span></td>
	          <td><span class="label label-default"><?php echo $fetch_mark_note; ?></span></td>
            </tr>

<?php } ?>
            
      </table>

      <br>

<?php } ?>



<?php } ?>

<?php 

if (isset($_GET['class']) && isset($_GET['subject'])) {

  $class_name = $_GET['class'];
  $subject_name = $_GET['subject'];

    if (isset($_POST['submit'])) {

    $the_student = htmlspecialchars($_POST['student']);
    $the_mark = htmlspecialchars($_POST['mark']);
    $the_note = htmlspecialchars($_POST['note']);

    $the_date = date("d/m/Y");

    $stmt_mark = $connect->prepare("INSERT INTO students_marks (student_id, date, subject, teacher_name, mark, note) VALUES (:student_id, '$the_date', :subject, '$my_name', :mark, :note)");
    $stmt_mark->bindParam (':student_id' , $the_student , PDO::PARAM_STR );
    $stmt_mark->bindParam (':subject' , $subject_name , PDO::PARAM_STR );
    $stmt_mark->bindParam (':mark' , $the_mark , PDO::PARAM_STR );
    $stmt_mark->bindParam (':note' , $the_note , PDO::PARAM_STR );
    $stmt_mark->execute();

    if (isset($stmt_mark)) {
      echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['add_successfully']."</p></div><br><br>";
      echo "<meta http-equiv='refresh' content='60; url = marks.php' />";

    }

    else {
     echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div>";     
    }
    
  }



 ?>
   <div class="row col-md-8 col-md-offset-2">

       <form id="formID2" action="" method="post">

                    <label class=""><?php echo $lang ['student']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-th-list"></i></span>
                        <select name="student" class="form-control validate[required]">
                          <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
<?php 
  $stmt_find_student = $connect->prepare("SELECT * FROM students_users WHERE student_class=:student_class");
  $stmt_find_student->bindParam (':student_class' , $class_name , PDO::PARAM_STR );
  $stmt_find_student->execute();

  while ($find_student_row = $stmt_find_student->fetch()) {
      $fetch_student_name = $find_student_row ['full_name'];
      $fetch_student_index = $find_student_row ['student_index'];

      echo '<option value="'.$fetch_student_index.'">'.$fetch_student_name.'</option>';

  } 

?>
                        </select>
                    </div><br>

                        <label class=""><?php echo $lang ['mark']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                                <input name="mark" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['mark'])) ? htmlspecialchars($_POST['mark']) : ''?>" />
                            </div><br>

                         <label class=""><?php echo $lang ['note']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                <input name="note" type="text" placeholder="" class="form-control validate[required,maxSize[50]]" value="<?php echo htmlspecialchars(!empty($_POST['note'])) ? htmlspecialchars($_POST['note']) : ''?>"/>
                            </div><br>

                    <div class="clear"></div>

                      <button type="submit" name="submit" class="mybtn mybtn-success btn-block"><?php echo $lang ['add']; ?></button>
                    


          </form>

 </div>

<?php } ?>  

     

      <div class="clear"></div><br><br>

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
