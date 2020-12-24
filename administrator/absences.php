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

    <title><?php echo $lang ['absences']; ?></title>

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

    <h1 class="h1_title"><?php echo $lang ['absences']; ?></h1>
    <hr> 

<?php 
if (isset($_GET['delete_id']) && isset($_GET['token'])) {

$delete_id = $_GET['delete_id'];

if ($_GET['token'] == $_SESSION['token']) {
  $stmt_delete = $connect->prepare("DELETE FROM absences WHERE id=:id");
  $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo "<meta http-equiv='refresh' content='5; url = absences.php' />";
  }
  
}

}
 ?>

    <table class="table table-striped table-bordered">

      

<?php 

if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = (int)$_GET['page'];



$records_at_page = 20;
$count_sql = $connect->query ("SELECT * FROM absences");
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

  echo '<tr class="tr-table2">
        <th>#</th>
        <th>'.$lang ['full_name'] .'</th>
        <th>'.$lang ['reason'] .'</th>
        <th>'.$lang ['note'] .'</th>
        <th>'.$lang ['date'] .'</th>
        <th>'.$lang ['delete'] .'</th>
        <th>IMPRIMER</th>
      </tr>';

  $stmt_absences = $connect->prepare("SELECT * FROM absences ORDER BY id DESC LIMIT $start, $end");
  $stmt_absences->execute();

  while ($stmt_absences_row = $stmt_absences->fetch()) {
      $fetch_absences_id = $stmt_absences_row ['id'];
      $fetch_absences_type = $stmt_absences_row ['type'];
      $fetch_absences_name = $stmt_absences_row ['full_name'];
      $fetch_absences_reason = $stmt_absences_row ['reason'];
      $fetch_absences_note = $stmt_absences_row ['note'];
      $fetch_absences_date = $stmt_absences_row ['date'];

?>
            <tr>
              <td><span class="label label-default"><?php if ($fetch_absences_type == 'student') {
                echo $lang ['student'];
              } if ($fetch_absences_type == 'teacher') {
                echo $lang ['teacher'];
              }  ?></span></td>
              <td><?php echo $fetch_absences_name;  ?></td>
              <td><?php echo $fetch_absences_reason;  ?></td>
              <td><?php echo $fetch_absences_note;  ?></td>
              <td><?php echo $fetch_absences_date;  ?></td>
              <td><a class="right" href="?token=<?php echo $_SESSION ['token']; ?>&delete_id=<?php echo $fetch_absences_id;  ?>"><i class="glyphicon glyphicon-trash large" style="font-size:26px"></i></a></td>
               <td><a class="right" href="imprimer.php?nom=<?php echo $fetch_absences_name;?>&amp;type=<?php echo $fetch_absences_type;?>&date=<?php echo $fetch_absences_date;?>&note=<?php echo $fetch_absences_note;?>&raison=<?php echo $fetch_absences_reason;?>"><i class="glyphicon glyphicon-print large" style="font-size:26px"></i></a></td>
            </tr>
            
<?php } } ?>


      
  </table>

<?php 
$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="absences.php?page=' . $next . '" class="btn btn-default p_right">'.$lang ['next'].' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="absences.php?page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.$lang ['prev'].'</a>' ;
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
