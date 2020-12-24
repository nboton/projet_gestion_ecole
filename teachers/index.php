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

    <title><?php echo $lang ['home']; ?></title>

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

        
  </head>
<body>

<?php 

include 'nav.php';


 ?> 


<div class="container main" style="margin-top: 100px;">



<div class="row">

    <div class="col-md-3">
      <a href="articles.php">
          <div class="link">
            <img src="../images/icons/1476216479_network.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['news']; ?></span>
         </div>
      </a>
    </div>
<div class="col-md-3">
     <a href="teachers_Room.php">
          <div class="link">
            <img src="../images/icons/1476216712_nerd.png" width="80px">
            <img src="../images/icons/1476216712_nerd.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['teachers Room']; ?></span>
         </div>
      </a>
       </div>
    <div class="col-md-3">
      <a href="classes.php">
          <div class="link">
            <img src="../images/icons/book.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['subjects']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="students.php">
          <div class="link">
            <img src="../images/icons/student.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['trainee']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="exams.php">
          <div class="link">
            <img src="../images/icons/exam.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['exams']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="marks.php">
          <div class="link">
            <img src="../images/icons/1476216221_licence.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['marks']; ?></span>
         </div>
      </a>
    </div>


<?php 

  $stmt_messages = $connect->query("SELECT * FROM users_messages WHERE to_index='$my_teacher_index' AND msg_read='0'");
  $count_messages = $stmt_messages->rowCount();


 ?>
    <div class="col-md-3">
      <a href="messages.php">
          <div class="link">
            <img src="../images/icons/new-message64.png" width="80px" >
            <div class="clear"></div>
<?php 
    if ($count_messages > 0) {
    echo '<span class="badge btn-success">'.$count_messages.'</span>';
    } 
?>
            <span><?php echo $lang ['incoming_messages']; ?></span>
         </div>
      </a>
    </div>


    <div class="col-md-3">
      <a href="messages_send.php">
          <div class="link">
            <img src="../images/icons/message-already-read64.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['outgoing_messages']; ?></span>
         </div>
      </a>
    </div>


    <div class="col-md-3">
      <a href="profile.php">
          <div class="link">
            <img src="../images/icons/1476216378_user_info.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['profile']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="lessons.php">
          <div class="link">
            <img src="../images/icons/1476216692_education_course_training.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['lessons']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="absence.php">
          <div class="link">
            <img src="../images/icons/1476216384_document_pencil.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['Registration_of_absence']; ?></span>
         </div>
      </a>
    </div>
    

</div>
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
