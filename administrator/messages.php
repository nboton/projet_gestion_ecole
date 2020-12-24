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

    <title><?php echo $lang ['incoming_messages']; ?></title>

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

<?php  if (!isset($_GET['type'])) { ?>

<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>


<div class="container main col-md-10 col-md-offset-1" style="margin-top: 100px; margin-bottom: 150px;">

<br><a class="return" style="color: #c77;" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a> <div class="clear"></div>

<?php 

  $stmt_messages_parent = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND msg_read='0' AND type='parent'");
  $count_messages_parent = $stmt_messages_parent->rowCount();

  $stmt_messages_student = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND msg_read='0' AND type='student'");
  $count_messages_student = $stmt_messages_student->rowCount();

  $stmt_messages_teacher = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND msg_read='0' AND type='teacher'");
  $count_messages_teacher = $stmt_messages_teacher->rowCount();

 ?>

  <div class="col-md-4">
      <a href="messages.php?type=students">
          <div class="link">
            <img src="../images/icons/student.png" width="80px">
            <div class="clear"></div>
<?php 
    if ($count_messages_student > 0) {
    echo '<span class="badge btn-success">'.$count_messages_student.'</span>';
    } 
?> 
            <span><?php echo $lang ['students']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="messages.php?type=teachers">
          <div class="link">
            <img src="../images/icons/1476216712_nerd.png" width="80px">
            <div class="clear"></div>
<?php 
    if ($count_messages_teacher > 0) {
    echo '<span class="badge btn-success">'.$count_messages_teacher.'</span>';
    } 
?> 
      <span><?php echo $lang ['teachers']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-4">
      <a href="messages.php?type=parents">
          <div class="link">
            <img src="../images/icons/1319546208_stock_people.png" width="80px">
            <div class="clear"></div>
<?php 
    if ($count_messages_parent > 0) {
    echo '<span class="badge btn-success">'.$count_messages_parent.'</span>';
    } 
?> 
            <span><?php echo $lang ['parents']; ?></span>
         </div>
      </a>
    </div>

</div>

<?php } if (isset($_GET['type'])) { 

  $token = md5(uniqid(rand()));

?>  

<div class="container mainbg">

<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['incoming_messages']; ?></h1>

<br>
    

    <table class="table table-striped table-bordered">
      <tr class="tr-table">
        <th><?php echo $lang ['date']; ?></th>
        <th><?php echo $lang ['from']; ?></th>
        <th><?php echo $lang ['message']; ?></th>
        
      </tr>
<?php 

if ($_GET['type'] == "parents") {

  if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = htmlspecialchars((int)$_GET['page']);



$records_at_page = 25;
$count_sql = $connect->query ("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='parent'");
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


  $stmt_messages_read = $connect->query("UPDATE users_messages SET msg_read='1' WHERE to_index='$admin_index' AND type='parent'");

  $stmt_messages = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='parent' ORDER BY id DESC LIMIT $start, $end");

    while ($row_messages = $stmt_messages->fetch()) {
    
    $message_id = $row_messages ['id'];
    $message_from = $row_messages ['author_name'];
    $message_subject = $row_messages ['subject'];
    $message_date = $row_messages ['date'];

 ?>
        <tr>
          <td><?php echo $message_date ; ?></td>
          <td><?php echo $message_from ; ?></td>
          <td><a class="message_a" href="message.php?token=<?php echo  $token.'&id='.$message_id; ?>"><?php echo $message_subject; ?> ...</a></td>
        </tr>

<?php } } } 

/*----------------------------------------------*/

if ($_GET['type'] == "students") {

  if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = htmlspecialchars((int)$_GET['page']);



$records_at_page = 25;
$count_sql = $connect->query ("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='student'");
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

  $stmt_messages_read = $connect->query("UPDATE users_messages SET msg_read='1' WHERE to_index='$admin_index' AND type='student'");

  $stmt_messages = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='student' ORDER BY id DESC LIMIT $start, $end");

    while ($row_messages = $stmt_messages->fetch()) {
    
    $message_id = $row_messages ['id'];
    $message_from = $row_messages ['author_name'];
    $message_subject = $row_messages ['subject'];
    $message_date = $row_messages ['date'];

 ?>
        <tr>
          <td><?php echo $message_date ; ?></td>
          <td><?php echo $message_from ; ?></td>
          <td><a class="message_a" href="message.php?token=<?php echo  $token.'&id='.$message_id; ?>"><?php echo $message_subject; ?> ...</a></td>
        </tr>

<?php } } }

/*--------------------------------------------------*/

if ($_GET['type'] == "teachers") {

  if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = htmlspecialchars((int)$_GET['page']);



$records_at_page = 25;
$count_sql = $connect->query ("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='teacher'");
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

  $stmt_messages_read = $connect->query("UPDATE users_messages SET msg_read='1' WHERE to_index='$admin_index' AND type='teacher'");

  $stmt_messages = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND type='teacher' ORDER BY id DESC LIMIT $start, $end ");

    while ($row_messages = $stmt_messages->fetch()) {
    
    $message_id = $row_messages ['id'];
    $message_from = $row_messages ['author_name'];
    $message_subject = $row_messages ['subject'];
    $message_date = $row_messages ['date'];

 ?>
        <tr>
          <td><?php echo $message_date ; ?></td>
          <td><?php echo $message_from ; ?></td>
          <td><a class="message_a" href="message.php?token=<?php echo  $token.'&id='.$message_id; ?>"><?php echo $message_subject; ?> ...</a></td>
        </tr>

<?php } } } ?>

  </table>

<?php 

$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="messages.php?type='.htmlspecialchars($_GET['type']).'&page=' . $next . '" class="btn btn-default p_right">'.htmlspecialchars($lang ['next']).' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="messages.php?type='.htmlspecialchars($_GET['type']).'&page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.htmlspecialchars($lang ['prev']).'</a>' ;
} 



?> 
<br><br><br>
</div>    
 
 <?php }   ?> 
                           
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
