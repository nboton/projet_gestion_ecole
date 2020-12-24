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

    <title><?php echo $lang ['new_lesson']; ?></title>

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

      <br><a class="return" href="lessons.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

          <h1 class="h1_title"><?php echo $lang ['new_lesson']; ?></h1>

          <hr>
        
      <div class="row col-md-10 col-md-offset-1">

<?php 



$stmt_get_info = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
$row_get_info = $stmt_get_info->fetch();
$my_name = $row_get_info ['full_name'];

if (isset($_POST['submit'])) {

  $lesson_title = htmlspecialchars($_POST['title']);
  $lesson_class = htmlspecialchars($_POST['class']);
  $lesson_subject = htmlspecialchars($_POST['subject']);
  $lesson_content = htmlspecialchars($_POST['content']);
  $lesson_date = date("d/m/Y");

if (!empty($_FILES["jointe"]["name"])) {

   $target = ("../uploads/lessons/");
  // an array of allowed extensions
  $allowedExts = array("doc", "docx", "ppt", "pptx","pdf");
  $temp = explode(".", $_FILES["jointe"]["name"]);
  $extension = end($temp);

  if ((($_FILES["jointe"]["type"] == "application/pdf")
    || ($_FILES["jointe"]["type"] == "application/vnd.ms-powerpoint")
    || ($_FILES["jointe"]["type"] == "application/vnd.openxmlformats-officedocument.presentationml.presentation")
    || ($_FILES["jointe"]["type"] == "application/vnd.openxmlformats-officedocument.wordprocessingml.document")
    || ($_FILES["jointe"]["type"] == "application/msword")) && in_array($extension, $allowedExts)) {
    
    if ($_FILES["jointe"]["error"] > 0) {
        echo "<div class='alert alert-danger'><p class='center'>".$lang ['Attached_File_error']."</p></div>";
    }

    else {

        $jointe = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES["jointe"]["tmp_name"], $target . $jointe);

        $stmt_lessons = $connect->prepare("INSERT INTO lessons (title, lesson, author, date, class, subject, jointes) VALUES (:title, :lesson, '$my_name', '$lesson_date', '$lesson_class', '$lesson_subject', '$jointe')");
        $stmt_lessons->bindParam (':title' , $lesson_title , PDO::PARAM_STR );
        $stmt_lessons->bindParam (':lesson' , $lesson_content , PDO::PARAM_STR );
        $stmt_lessons->execute();

    }

  }


}

else {
    $stmt_lessons = $connect->prepare("INSERT INTO lessons (title, lesson, author, date, class, subject) VALUES (:title, :lesson, '$my_name', '$lesson_date', '$lesson_class', '$lesson_subject')");
    $stmt_lessons->bindParam (':title' , $lesson_title , PDO::PARAM_STR );
    $stmt_lessons->bindParam (':lesson' , $lesson_content , PDO::PARAM_STR );
    $stmt_lessons->execute();
}

if (isset($stmt_lessons)) {
    header ("location: new_lesson.php?add=success");   
    echo "<meta http-equiv='refresh' content='0; url = new_lesson.php?add=success' />";

  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Attached_File_error']."</p></div><br><br>";     
  }

}

/**************************************************************/


if (isset($_GET['add']) == "success") {

  echo "<meta http-equiv='refresh' content='2; url = lessons.php' />";
  die("<br><br><div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['add_successfully']."</p></div><br><br>") ;

  
}


 ?>

        <form id="formID" action="" method="post" enctype="multipart/form-data">

                    <label class=""><?php echo $lang ['title']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input name="title" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['title'])) ? htmlspecialchars($_POST['title']) : ''?>"/>
                    </div><br>

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
  $stmt_find_subject = $connect->query("SELECT * FROM subjects");

  while ($find_subject_row = $stmt_find_subject->fetch()) {
      $fetch_subject_name = $find_subject_row ['subject_name'];

      echo '<option value="'.$fetch_subject_name.'">'.$fetch_subject_name.'</option>';

  } 
?>
                        </select>
                    </div><br>


                   <label class=""><?php echo $lang ['lesson']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <br>
                  <textarea class="form-control validate[required]" id="elm1" name="content" placeholder=""><?php echo htmlspecialchars(!empty($_POST['content'])) ? htmlspecialchars($_POST['content']) : ''?></textarea>
                <br>

                <label class=""><?php echo $lang ['Attached_File']; ?> : </label>
                <input name="jointe" type="file" class="btn btn-default" />
                <span class="help-block"><?php echo $lang ['Permitted_files']; ?> : doc, docx, ppt, pptx, pdf</span>

                <hr>

                <button type="submit" name="submit" class="mybtn mybtn-success btn-block"><?php echo $lang ['publish']; ?></button>
  
          </form>
          <br>

      </div>     


      <div class="clear"></div> 
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


	<link rel="stylesheet" href="../libs/cleditor/jquery.cleditor.css" />
    <script src="../libs/cleditor/jquery.cleditor.min.js"></script>
   

<script>
   $(document).ready(function () { $("#elm1").cleditor(); });
</script>


  </body>
</html>
