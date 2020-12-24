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



<div class="container mainbg">

<br><a class="return" href="messages.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

<?php 

if (isset($_GET['id']) && isset($_GET['token'])) {


  $id =htmlspecialchars(@$_GET['id']) ;


$stmt_messages = $connect->prepare("SELECT * FROM users_messages WHERE to_index='$admin_index' AND id=:id ");
$stmt_messages->bindParam (':id' , $id , PDO::PARAM_STR );
$stmt_messages->execute();

if ($stmt_messages->rowCount() < 1 ) {
  die("<br><br><div class='alert alert-danger center'><p>".$lang ['non_autorise']."</p></div><br>");
}

$row_messages = $stmt_messages->fetch();
    
    $message_id = $row_messages ['id'];
    $message_type = $row_messages ['type'];
    $message_from = $row_messages ['author_name'];
    $message_from_index = $row_messages ['author_index'];
    $message_subject = $row_messages ['subject'];
    $message_content = $row_messages ['message'];
    $message_date = $row_messages ['date'];

?>

    <br><br>


<div class="clear"></div>


      <table class="table table-striped table-bordered">

        <tr class="tr-table">
          <th ><?php 
             if ($message_type == "student") {
              echo '<span class="label label-success">'.$lang ['student'].'</span>';
              }
              if ($message_type == "parent") {
              echo '<span class="label label-danger">'.$lang ['guardian'].'</span>';
              } 
              if ($message_type == "administrator") {
              echo '<span class="label label-warning">'.$lang ['administrator'].'</span>';
              }
          ?></th>
        <th><?php if (empty($message_from)) { echo '-'; } else echo $message_from; ?></th>
        <th><?php echo $message_subject; ?></th>    
        <th><?php echo $message_date; ?></th>
          <th><a class="message_a" style="font-size: 16px;" href="contact.php?id=<?php echo $message_from_index; ?>"><i class="glyphicon glyphicon-envelope" style=""></i> <?php echo $lang ['Reply']; ?> </a></th> 
        </tr>

   
  

    </table>


    <div class="clear"></div>

    <p class="message_p"><?php echo $message_content; ?></p>

     <br>
       

  

<?php } 

else { 
  echo "<br><br><div class='alert alert-danger center'><p>".$lang ['Nothing_found_404']."</p></div><br>" ;
} 
 ?>





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
