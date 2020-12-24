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

    <title><?php echo $lang ['reports']; ?></title>

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

    <h1 class="h1_title"><?php echo $lang ['reports']; ?></h1>

<hr> 

<?php 
if (isset($_GET['delete_id']) && isset($_GET['token'])) {

$delete_id = $_GET['delete_id'];

if ($_GET['token'] == $_SESSION['token']) {

  $stmt_delete = $connect->prepare("UPDATE reports SET hide_report='1' WHERE report_id=:report_id");
  $stmt_delete->bindParam (':report_id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo "<meta http-equiv='refresh' content='5; url = reports.php' />";
  }

}

}
 ?>


    

<?php 

if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = (int)$_GET['page'];



$records_at_page = 10;
$count_sql = $connect->query ("SELECT * FROM reports WHERE hide_report='0'");
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

  echo '<table class="table table-striped table-bordered">
      <tr class="tr-table">
        <th>'.$lang ['teacher'].'</th>
        <th>'.$lang ['student'].'</th>
        <th>'.$lang ['title'].'</th>
        <th>'.$lang ['report'].'</th>
        <th>'.$lang ['date'].'</th>
        <th>'.$lang ['delete'].'</th>
      </tr>';


  $stmt_reports_read = $connect->query("UPDATE reports SET read_report='1'");


  $stmt_reports = $connect->prepare("SELECT * FROM reports WHERE hide_report='0' ORDER BY report_id DESC LIMIT $start, $end");
  $stmt_reports->execute();

  while ($stmt_reports_row = $stmt_reports->fetch()) {
      $fetch_reports_id = $stmt_reports_row ['report_id'];
      $fetch_reports_teacher = $stmt_reports_row ['author'];
      $fetch_reports_student = $stmt_reports_row ['student_index'];
      $fetch_reports_title = $stmt_reports_row ['title'];
      $fetch_reports_report = $stmt_reports_row ['report'];
      $fetch_reports_date = $stmt_reports_row ['date'];

      $stmt_student_name = $connect->query("SELECT * FROM students_users WHERE student_index='$fetch_reports_student'");
      $stmt_student_name_row = $stmt_student_name->fetch();
      $fetch_reports_student_name = $stmt_student_name_row ['full_name'];

?>

        <tr>
          <td><span class="label label-success"><?php echo $fetch_reports_teacher; ?></span></td>
          <td><span class="label label-danger"><?php echo $fetch_reports_student_name; ?></span></td>
          <td><?php echo $fetch_reports_title; ?></td>
          <td><?php echo $fetch_reports_report; ?></td>
          <td><?php echo $fetch_reports_date; ?></td>
          <td><a class="right" href="?token=<?php echo $_SESSION ['token']; ?>&delete_id=<?php echo $fetch_reports_id;  ?>"><i class="glyphicon glyphicon-trash large" style="font-size:26px"></i></a></td>
        </tr>

 <?php } }  ?>     
  </table>

<?php 
$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="reports.php?page=' . $next . '" class="btn btn-default p_right">'.$lang ['next'].' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="reports.php?page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.$lang ['prev'].'</a>' ;
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
