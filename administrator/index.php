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

    <title><?php echo /* $_SERVER['HTTP_HOST'] . ' - ' . */ $lang ['home']; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap theme -->
    <link href="../css/bootstrap-theme.min.css" rel="stylesheet">
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="../js/ie-emulation-modes-warning.js"></script>



    
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

<?php include 'nav.php'; ?> 


<div class="container main" style="margin-top: 100px;">
<?php 

$dir    = '../install/';

if (is_dir($dir))  {
   echo "<div class='alert alert-warning' style='margin: auto;'>
    <h3>Bienvenue dans ISTA MIRLEFT!</h3>
    <p>Nous vous remercions de votre choix :) Vous pouvez maintenant commencer à courir votre établissment..!</p>
    <br>
    <span style='font-size: 14px;'' class='label label-default'> </span>
    <p>Vous le trouverez dans le dossier principal.</p>
    
</div><br><br>";
}

 ?>



<div class="row">

<?php 

  $stmt_count_students = $connect->prepare("SELECT * FROM students_users");
  $stmt_count_students->execute();
  $count_students = $stmt_count_students->rowCount();

  $stmt_count_teachers = $connect->prepare("SELECT * FROM teachers_users");
  $stmt_count_teachers->execute();
  $count_teachers = $stmt_count_teachers->rowCount();

  $stmt_count_parents = $connect->prepare("SELECT * FROM parents_users");
  $stmt_count_parents->execute();
  $count_parents = $stmt_count_parents->rowCount();

  $stmt_count_topics = $connect->prepare("SELECT * FROM topics");
  $stmt_count_topics->execute();
  $count_topics = $stmt_count_topics->rowCount();


   ?>
<div class="col-md-12" id="status">
    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="info-box blue-bg">
            <i class="fa fa-graduation-cap"></i>
            <div class="count"><?php echo $count_students; ?></div>
            <div class="title"><?php echo $lang ['student']; ?></div>           
          </div><!--/.info-box-->     
        </div><!--/.col-->
        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="info-box orange-bg">
            <i class="fa fa-institution"></i>
            <div class="count"><?php echo $count_teachers; ?></div>
            <div class="title"><?php echo $lang ['teacher']; ?></div>            
          </div><!--/.info-box-->     
        </div><!--/.col-->  
        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="info-box red-bg">
            <i class="fa fa-group"></i>
            <div class="count"><?php echo $count_parents; ?></div>
            <div class="title"><?php echo $lang ['guardian']; ?></div>            
          </div><!--/.info-box-->     
        </div><!--/.col-->
        
        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
          <div class="info-box green-bg">
            <i class="fa fa-file-text-o"></i>
            <div class="count"><?php echo $count_topics; ?></div>
            <div class="title"><?php echo $lang ['topic']; ?></div>            
          </div><!--/.info-box-->     
        </div><!--/.col-->

</div>
 <div class="clear"></div><br>


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
      <a href="students.php">
          <div class="link">
            <img src="../images/icons/student.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['students']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="teachers.php">
          <div class="link">
            <img src="../images/icons/1476216712_nerd.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['teachers']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="parents.php">
          <div class="link">
            <img src="../images/icons/1319546208_stock_people.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['parents']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="classes.php">
          <div class="link">
            <img src="../images/icons/class.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['classes']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="subjects.php">
          <div class="link">
            <img src="../images/icons/books.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['subjects']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="transport.php">
          <div class="link">
            <img src="../images/icons/bus.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['transport']; ?></span>
         </div>
      </a>
    </div>

    <div class="col-md-3">
      <a href="absences.php">
          <div class="link">
            <img src="../images/icons/1476216703.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['absences']; ?></span>
         </div>
      </a>
    </div>
<?php 

  $stmt_reports = $connect->query("SELECT * FROM reports WHERE read_report='0'");
  $count_reports = $stmt_reports->rowCount();


 ?>

    <div class="col-md-3">
      <a href="reports.php">
          <div class="link">
            <img src="../images/icons/1476216487_document.png" width="80px">
            <div class="clear"></div>
<?php 
    if ($count_reports > 0) {
    echo '<span class="badge btn-success">'.$count_reports.'</span>';
    } 
?>
            <span><?php echo $lang ['reports']; ?></span>
         </div>
      </a>
    </div>

<?php 

  $stmt_messages = $connect->query("SELECT * FROM users_messages WHERE to_index='$admin_index' AND msg_read='0'");
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
      <a href="control.php">
          <div class="link">
            <img src="../images/icons/1476216425_settings.png" width="80px">
            <div class="clear"></div><span><?php echo $lang ['Settings']; ?></span>
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
