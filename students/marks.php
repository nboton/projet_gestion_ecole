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
        
  </head>
<body>

<?php include 'nav.php'; ?> 

<div class="container mainbg">

<br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['marks']; ?></h1>

    <table class="table table-striped table-bordered">
      <tr class="tr-table">
        <th><?php echo $lang ['date']; ?></th>
        <th><?php echo $lang ['subject']; ?></th>
        <th><?php echo $lang ['teacher']; ?></th>
        <th><?php echo $lang ['mark']; ?></th>
        <th><?php echo $lang ['note']; ?></th>
      </tr>

<?php 

if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = (int)$_GET['page'];



$records_at_page = 15;
$count_sql = $connect->query ("SELECT * FROM students_marks WHERE student_id='$my_student_index'");
$records_count = $count_sql->rowCount();


$pages_count = (int)ceil($records_count / $records_at_page);

if (($page > $pages_count) || ($page <= 0 )) {
  die();
}

$start = ($page - 1) * $records_at_page ;
$end = $records_at_page ;


/****************************************************************
****************************************************************/
if ($records_count != 0) {

  $stmt_marks = $connect->prepare("SELECT * FROM students_marks WHERE student_id='$my_student_index' ORDER BY id DESC LIMIT $start, $end");
  $stmt_marks->execute();

  while ($stmt_marks_row = $stmt_marks->fetch()) {
      $fetch_mark_date = $stmt_marks_row ['date'];
      $fetch_mark_subject = $stmt_marks_row ['subject'];
      $fetch_mark_teacher = $stmt_marks_row ['teacher_name'];
      $fetch_mark_mark = $stmt_marks_row ['mark'];
      $fetch_mark_note = $stmt_marks_row ['note'];



?>

        <tr>
          <td><?php echo $fetch_mark_date; ?></td>
          <td><?php echo $fetch_mark_subject; ?></td>
          <td><?php echo $fetch_mark_teacher; ?></td>
          <td><span class="label label-warning" style="font-size: 14px;"><?php echo $fetch_mark_mark; ?></span></td>
          <td><span class="label label-default" style="font-size: 13px;"><?php echo $fetch_mark_note; ?></span></td>
        </tr>

<?php } } ?>     

  </table>

  <?php 
$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="marks.php?page=' . $next . '" class="btn btn-default p_right">'.$lang ['next'].' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="marks.php?page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.$lang ['prev'].'</a>' ;
}
 ?>

<br><br><br>

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
