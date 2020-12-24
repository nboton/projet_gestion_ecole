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

    <title><?php echo $lang ['contact']; ?></title>

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

    
     <link rel="stylesheet" href="../css/style.css" rel="stylesheet">
     <link rel="stylesheet" href="../css/Normalize.css" rel="stylesheet">
     <link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
     
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


    <br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

<?php 

$stmt_get_allInfo = $connect->query("SELECT * FROM students_users WHERE student_index='$my_student_index' ");
$row_allInfo = $stmt_get_allInfo->fetch();
$my_fullname = $row_allInfo ['full_name'];

if (isset($_GET['id'])) {
 
   $user_id = $_GET['id'];

   $stmt_get_index_name = $connect->prepare("SELECT * FROM index_users WHERE index_num=:index_num ");
  $stmt_get_index_name->bindParam (':index_num' , $user_id , PDO::PARAM_STR );
  $stmt_get_index_name->execute();

  $count = $stmt_get_index_name->rowCount();

  if ($count < 1 ) {
    die("<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br>");
  }

  $row_index_name = $stmt_get_index_name->fetch();
  $to_name = $row_index_name ['full_name'];

 ?>

    <h1 class="h1_title"><?php echo $lang ['contact']; ?> [ <?php if ($to_name == 'administrator') {
    	echo $lang ['administrator'];
    } else {echo $to_name; } ?> ]</h1>

    <hr>


<div class="col-md-10 col-md-offset-1">


<?php 

if (isset($_POST['submit'])) {
   
  $message_from = htmlspecialchars($_POST['from']);
  $author_name = htmlspecialchars($_POST['name']);
  $message_subject = htmlspecialchars($_POST['subject']);
  $message_content = htmlspecialchars($_POST['message']);

  $message_date = date("d/m/Y");

$fff = "111";

   $stmt_messages = $connect->prepare("INSERT INTO users_messages (author_index, author_name, to_index, type, subject, message, date) VALUES ('$my_student_index', :author_name, :to_index, '$message_from', :subject, :message, '$message_date')");
  $stmt_messages->bindParam (':author_name' , $author_name , PDO::PARAM_STR );
  $stmt_messages->bindParam (':to_index' , $user_id , PDO::PARAM_STR );
  $stmt_messages->bindParam (':subject' , $message_subject , PDO::PARAM_STR );
  $stmt_messages->bindParam (':message' , $message_content , PDO::PARAM_STR );
  $stmt_messages->execute();

  if (isset($stmt_messages)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['message_send_success']."</p></div><br><br>";
   }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

 ?>

  <form id="formID" method="post" action="">


              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                  <select name="from" class="form-control">
                  <option selected="selected" value="student"><?php echo $lang ['student']; ?></option>
                  </select>
              </div><br>

        <label class=""><?php echo $lang ['you_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input name="name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $my_fullname; ?>"/>
        </div><br>

        <label class=""><?php echo $lang ['msg_subject']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
        <div class="input-group">
            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
            <input name="subject" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['subject'])) ? htmlspecialchars($_POST['subject']) : ''?>"/>
        </div><br>

        <label class=""><?php echo $lang ['message']; ?> <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                 <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control validate[required]" name="message" placeholder=""><?php echo htmlspecialchars(!empty($_POST['message'])) ? htmlspecialchars($_POST['message']) : ''?></textarea>
        </div><br>

        <div class="clear"></div>
              
        <button type="submit" name="submit" class="mybtn mybtn-success btn-lg btn-block "><?php echo $lang ['send']; ?></button> 

        <br><br>

    </form>
  
</div>
    
<?php } else {
    echo "<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Nothing_found_404']."</p></div><br><br>";
  } ?>  

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
