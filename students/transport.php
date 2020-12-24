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

    <title><?php echo $lang ['transport']; ?></title>

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

    <h1 class="h1_title"><?php echo $lang ['transport']; ?></h1>

    <hr>

    <table class="table table-striped table-bordered">
      <tr class="tr-table2">
        <th><?php echo $lang ['day']; ?></th>
        <th><?php echo $lang ['time_start_morning']; ?></th>
        <th><?php echo $lang ['time_return_morning']; ?></th>
        <th><i class="glyphicon glyphicon-adjust large2c"></i></th>
        <th><?php echo $lang ['time_start_evening']; ?></th>
        <th><?php echo $lang ['time_return_evening']; ?></th>
      </tr>

<?php 

  $stmt_transport = $connect->prepare("SELECT * FROM transport WHERE class_name='$my_class'");
  $stmt_transport->execute();

  while ($stmt_transport_row = $stmt_transport->fetch()) {
      $fetch_transport_day = $stmt_transport_row ['day'];
      $fetch_transport_start_m = $stmt_transport_row ['time_start_m'];
      $fetch_transport_return_m = $stmt_transport_row ['time_return_m'];
      $fetch_transport_start_e = $stmt_transport_row ['time_start_e'];
      $fetch_transport_return_e = $stmt_transport_row ['time_return_e'];

?>
        <tr>
          <th class="th-table2"><?php echo $fetch_transport_day; ?></th>
          <td><?php echo $fetch_transport_start_m; ?></td>
          <td><?php echo $fetch_transport_return_m; ?></td>
          <td>|</td>
          <td><?php echo $fetch_transport_start_e; ?></td>
          <td><?php echo $fetch_transport_return_e; ?></td>
        </tr>

<?php } ?>

      
  </table>


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
