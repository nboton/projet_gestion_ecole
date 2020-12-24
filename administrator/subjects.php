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

    <title><?php echo $lang ['subjects']; ?></title>

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
        
  </head>
<body>

<?php include 'nav.php'; ?> 




<div class="container mainbg">
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['subjects']; ?></h1>
    <hr> <br>

<?php 
if (isset($_POST['submit'])) {
   
  $subject_name = htmlspecialchars($_POST['subject_name']);
  $subject_class = htmlspecialchars($_POST['class']);
  $subject_teacher = htmlspecialchars($_POST['teacher']);
  $subject_note = htmlspecialchars($_POST['subject_note']);

   $stmt_subject = $connect->prepare("INSERT INTO subjects (subject_name, subject_teacher, subject_class, subject_note) VALUES (:subject_name, :subject_teacher, :subject_class, :subject_note)");
  $stmt_subject->bindParam (':subject_name' , $subject_name , PDO::PARAM_STR );
  $stmt_subject->bindParam (':subject_teacher' , $subject_teacher , PDO::PARAM_STR );
  $stmt_subject->bindParam (':subject_class' , $subject_class , PDO::PARAM_STR );
  $stmt_subject->bindParam (':subject_note' , $subject_note , PDO::PARAM_STR );
  $stmt_subject->execute();

  if (isset($stmt_subject)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['subject_was_added']."</p></div><br><br>"; 
  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

?>

    <div class="clear"></div>
    <div class="row col-md-10 col-md-offset-1">

      <form id="formID" action="" method="post">
          
              <label class=""><?php echo $lang ['subject']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                  <input name="subject_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['subject_name'])) ? htmlspecialchars($_POST['subject_name']) : ''?>"/>
              </div><br>

              <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
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

              <label class=""><?php echo $lang ['teacher']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                  <select name="teacher" class="form-control validate[required]">
                    <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
<?php 
  $stmt_find_teacher = $connect->query("SELECT * FROM teachers_users");

  while ($find_teacher_row = $stmt_find_teacher->fetch()) {
      $fetch_teacher_name = $find_teacher_row ['full_name'];

      echo '<option value="'.$fetch_teacher_name.'">'.$fetch_teacher_name.'</option>';

  } 
?>
                  </select>
              </div><br>

              <label class=""><?php echo $lang ['note']; ?> : </label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="subject_note" placeholder=""><?php echo htmlspecialchars(!empty($_POST['subject_note'])) ? htmlspecialchars($_POST['subject_note']) : ''?></textarea>
              </div><br> 

          <button type="submit" name="submit" class="mybtn mybtn-success"><?php echo $lang ['add_subject']; ?></button>     

          <hr id='success'>

      </form>
  
  </div>
  <div class="clear"></div>
  
  <?php 
if (isset($_GET['delete']) && isset($_GET['token'])) {

$delete_id = $_GET['delete'];

if ($_GET['token'] == $_SESSION['token']) {

  $stmt_delete = $connect->prepare("DELETE FROM subjects WHERE id='$delete_id'");
  $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo '<script type="text/javascript"> window.location.href += "#success"; </script>';
    echo "<meta http-equiv='refresh' content='5; url = subjects.php' />";
  }

}

}
 ?>
 
 <div class="clear"></div>
    
    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['subject']; ?></th>
            <th><?php echo $lang ['teacher']; ?></th>
            <th><?php echo $lang ['class']; ?></th>
            <th><?php echo $lang ['note']; ?></th>
			<th><?php echo $lang ['delete']; ?></th>
          </tr>
<?php 

  $stmt_find_subject = $connect->prepare("SELECT * FROM subjects");
  $stmt_find_subject->execute();

  while ($find_subject_row = $stmt_find_subject->fetch()) {
      $fetch_subject_name = $find_subject_row ['subject_name'];
	  $fetch_subject_id = $find_subject_row ['id'];
      $fetch_subject_teacher = $find_subject_row ['subject_teacher'];
      $fetch_subject_class = $find_subject_row ['subject_class'];
      $fetch_subject_note = $find_subject_row ['subject_note'];



?>
            <tr>
              <td><?php echo $fetch_subject_name;  ?></td>
              <td><?php echo $fetch_subject_teacher;  ?></td>
              <td><span class="label label-danger"><?php echo $fetch_subject_class;  ?></span></td>
              <td><?php echo $fetch_subject_note;  ?></td>
			  <td><a href="subjects.php?token=<?php echo $_SESSION ['token']; ?>&delete=<?php echo $fetch_subject_id ?>"><i class="glyphicon glyphicon-trash large"> </i></a></td>
       
            </tr>
<?php } ?>           
      </table>

      <br>
        

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
