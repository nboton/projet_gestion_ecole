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

    <title><?php echo $lang ['outgoing_messages']; ?></title>

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

<?php 
if (isset($_GET['id']) && isset($_GET['token'])) { 

  echo '<div class="container mainbg">

<br><a class="return" href="messages_send.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> '. $lang ['return'].'</a>

<br><br>';

$id =htmlspecialchars(@$_GET['id']) ;


$stmt_messages = $connect->prepare("SELECT * FROM users_messages WHERE author_index='$admin_index' AND id=:id ");
$stmt_messages->bindParam (':id' , $id , PDO::PARAM_STR );
$stmt_messages->execute();

if ($stmt_messages->rowCount() < 1 ) {
  die("<br><div class='alert alert-danger center'><p>".$lang ['non_autorise']."</p></div><br>");
}

$row_messages = $stmt_messages->fetch();
    
    $message_to = $row_messages ['to_index'];
    $message_subject = $row_messages ['subject'];
    $message_content = $row_messages ['message'];
    $message_date = $row_messages ['date'];

    $stmt_to_index = $connect->query("SELECT * FROM index_users WHERE index_num='$message_to' ");

    $row_indexs = $stmt_to_index->fetch();

    $fullname = $row_indexs ['full_name'];



 ?>


<div class="clear"></div>


      <table class="table table-striped table-bordered">

        <tr class="tr-table">
          
        <th><?php if ($fullname == "administrator") { echo $lang ['administrator']; } else echo $fullname; ?></th>
        <th><?php echo $message_subject; ?></th>    
        <th><?php echo $message_date; ?></th>
        </tr>


    </table>


    <div class="clear"></div>

    <p class="message_p"><?php echo $message_content; ?></p>

     <br>

</div>



<?php } else  { 

if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = (int)$_GET['page'];



$records_at_page = 20;
$count_sql = $connect->query ("SELECT * FROM users_messages WHERE author_index='$admin_index' AND hide_msg='0'");
$records_count = $count_sql->rowCount();


$pages_count = (int)ceil($records_count / $records_at_page);

if (($page > $pages_count) || ($page <= 0 )) {
  die('<div class="container mainbg"><br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> '. $lang ['return'].'</a> <br><br><div class="alert alert-info center"><p>'.$lang ["no_outgoing_messages"].'</p></div><br></div>');
}

$start = ($page - 1) * $records_at_page ;
$end = $records_at_page ;


/****************************************************************
****************************************************************/
if ($records_count != 0) {

 ?>

<div class="container mainbg">

<br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['outgoing_messages']; ?></h1>
<hr> 

<?php 
if (isset($_GET['delete']) && isset($_GET['token'])) {

$delete_id = $_GET['delete'];

if ($_GET['token'] == $_SESSION['token']) {

  $stmt_delete = $connect->prepare("UPDATE users_messages SET hide_msg='1' WHERE id=:id AND author_index='$admin_index'");
  $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo "<meta http-equiv='refresh' content='3; url = messages_send.php' />";
  }

}

}
 ?>

    <table class="table table-striped table-bordered">
      <tr class="tr-table">
        <th><?php echo $lang ['to']; ?></th>
        <th><?php echo $lang ['message']; ?></th>
        <th><?php echo $lang ['date']; ?></th>
        <th><?php echo $lang ['delete']; ?></th>
      </tr>
<?php 
$token = md5(uniqid(rand()));

$stmt_messages = $connect->query("SELECT * FROM users_messages WHERE author_index='$admin_index' AND hide_msg='0' ORDER BY id DESC LIMIT $start, $end");

while ($row_messages = $stmt_messages->fetch()) {
    
    $message_id = $row_messages ['id'];
    $message_to = $row_messages ['to_index'];
    $message_subject = $row_messages ['subject'];
    $message_content = $row_messages ['message'];
    $message_date = $row_messages ['date'];

    $stmt_to_index = $connect->query("SELECT * FROM index_users WHERE index_num='$message_to' ");

    $row_indexs = $stmt_to_index->fetch();

    $fullname = $row_indexs ['full_name'];


 ?>
        <tr>
          <td><?php if ($fullname == "administrator") {
              echo '<span class="label label-warning">'.$lang ['administrator'].'</span>';
              } else {echo $fullname ;} ?></td>
          <td><a class="message_a" href="messages_send.php?token=<?php echo  $token.'&id='.$message_id; ?>"><?php echo $message_subject ; ?> </a></td>
          <td><?php echo $message_date ; ?></td>
          <td><a href="messages_send.php?token=<?php echo $_SESSION ['token']; ?>&delete=<?php echo $message_id ?>"><i class="glyphicon glyphicon-trash large" </i></a></td>
        </tr>


<?php } ?>    

  </table>

<?php 
$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="messages_send.php?page=' . $next . '" class="btn btn-default p_right">'.$lang ['next'].' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="messages_send.php?page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.$lang ['prev'].'</a>' ;
}

?> 
<br><br><br>
</div>	

<?php }




} ?>	
                           
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
