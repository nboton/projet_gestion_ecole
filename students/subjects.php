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

$stmt_get_my_class = $connect->query("SELECT * FROM students_users WHERE student_index='$my_student_index' ");
$row_get_my_class = $stmt_get_my_class->fetch();
$my_class = $row_get_my_class ['student_class'];

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
        
  </head>
<body>

<?php include 'nav.php'; ?> 


<div class="container mainbg">

<br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>


<h1 class="h1_title"><?php echo $lang ['subjects']; ?> ( <?php echo $my_class; ?> )</h1>
            
            <table class="table table-striped table-bordered">
              <tr class="tr-table2">
                <th><?php echo $lang ['subject']; ?></th>
                <th><?php echo $lang ['teacher']; ?></th>
                <th><?php echo $lang ['note']; ?></th>
              </tr>
<?php 

  $stmt_subjects = $connect->prepare("SELECT * FROM subjects WHERE subject_class='$my_class'");
  $stmt_subjects->execute();

  while ($stmt_subjects_row = $stmt_subjects->fetch()) {
      $fetch_subject_name = $stmt_subjects_row ['subject_name'];
      $fetch_subject_teacher = $stmt_subjects_row ['subject_teacher'];
      $fetch_subject_note = $stmt_subjects_row ['subject_note'];

       $stmt_get_teacher = $connect->query("SELECT * FROM teachers_users WHERE full_name='$fetch_subject_teacher'");
       $get_teacher_row = $stmt_get_teacher->fetch();
       $fetch_teachers_index = $get_teacher_row ['teacher_index'];

?>
                <tr>
                  <td><span class="label label-success"><?php echo $fetch_subject_name; ?></span></td>
                  <td><a href="contact.php?id=<?php echo $fetch_teachers_index; ?>"><span class="label label-primary"><?php echo $fetch_subject_teacher; ?></span></a></td>
				  <td><?php echo $fetch_subject_note; ?></td>
                </tr>
<?php } ?>
            </table>

<div class="clear"></div>

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
