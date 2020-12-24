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

    <title><?php echo $lang ['students']; ?></title>

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
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>
    <h1 class="h1_title"><?php echo $lang ['students']; ?></h1>

    <hr>
    <br>

<div class="row col-md-10 col-md-offset-1">

      <form id="" action="" method="post">

                  <div class="col-md-8 col-md-offset-1">
                    <input style="height:42px; margin-bottom: 10px;" name="findInput" type="text" placeholder="<?php echo $lang ['registration_number_or_name']  ?>" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['findInput'])) ? htmlspecialchars($_POST['findInput']) : ''?>"/>
                  </div>

                  <div class="col-md-2">
                    <button type="submit" name="find_submit" class="mybtn mybtn-default btn-block"><?php echo $lang ['find']; ?></button>
                  </div>

        </form>
      
</div>


<div class="clear"></div><br><br>
     
<?php 

if (isset($_POST['find_submit'])) {
   
  $find_student = htmlspecialchars($_POST['findInput']);


  $stmt_find_student = $connect->prepare("SELECT * FROM students_users WHERE full_name LIKE '%$find_student%' OR registration_num = '$find_student'");
 // $stmt_find_student->bindParam (':full_name' , $find_student , PDO::PARAM_STR );
  $stmt_find_student->execute();

?>
         
    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['registration_number']; ?></th>
            <th><?php echo $lang ['full_name']; ?></th>
            <th><?php echo $lang ['guardian']; ?></th>
            <th><?php echo $lang ['profile']; ?></th>
            <th><?php echo $lang ['contact']; ?></th>
            <th><?php echo $lang ['report']; ?></th>
          </tr>

<?php 
while ($find_student_row = $stmt_find_student->fetch()) {
      $fetch_student_number = $find_student_row ['registration_num'];
      $fetch_student_name = $find_student_row ['full_name'];
      $fetch_student_guardian = $find_student_row ['parent_index'];
      $fetch_student_index = $find_student_row ['student_index'];
?>
            <tr>
              <td><?php echo $fetch_student_number; ?></td>
              <td><?php echo $fetch_student_name; ?></td>
              <td><?php if (!empty($fetch_student_guardian)) {
                echo '<a href="guardian_profile.php?id='.$fetch_student_guardian.'"><i class="glyphicon glyphicon-eye-open large"></i></a>';
              } ?></td>
              <td><a href="student_profile.php?id=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-user large"></i></a></td>
              <td><a href="contact.php?id=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-envelope large"></i></a></td>
              <td><a href="reports.php?student=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-paste large"></i></a></td>
            </tr>

<?php } ?>
            
      </table>

      <br>

<?php } ?>


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
