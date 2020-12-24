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
<?php 

if (isset($_GET['id'])) {
    $student_index = htmlspecialchars($_GET['id']);

  $stmt_get_allInfo = $connect->prepare("SELECT * FROM students_users WHERE student_index=:student_index ");
  $stmt_get_allInfo->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
  $stmt_get_allInfo->execute();


  if ($stmt_get_allInfo->rowCount() == 1 ) {
        $the_fullname = $stmt_get_allInfo->fetch();

        echo '<title>'.$the_fullname ['full_name'].'</title>';
    }

    else { echo '<title>404</title>'; }

} 

?>

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

<?php include 'nav.php'; ?> 



<div class="container" style="margin-top:100px;">

<?php 

if (!isset($_GET['id'])) {
  die("<div class='mainbg'><br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Nothing_found_404']."</p></div><br><br></div>");
}

if (isset($_GET['id'])) {
    $student_index = htmlspecialchars($_GET['id']);

$stmt_get_allInfo = $connect->prepare("SELECT * FROM students_users WHERE student_index=:student_index ");
$stmt_get_allInfo->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
$stmt_get_allInfo->execute();


if ($stmt_get_allInfo->rowCount() !== 1 ) {
  die("<div class='mainbg'><br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br></div>");
}
$row_allInfo = $stmt_get_allInfo->fetch();

$the_fullname = $row_allInfo ['full_name'];
$the_image = $row_allInfo ['image'];
$the_number = $row_allInfo ['registration_num'];
$the_class = $row_allInfo ['student_class'];
$the_sex = $row_allInfo ['sex'];
$the_birthday = $row_allInfo ['birthday'];
$the_address = $row_allInfo ['address'];
$the_phone = $row_allInfo ['phone'];
$the_email = $row_allInfo ['email'];

$the_guardian = $row_allInfo ['parent_index'];

$stmt_get_parent = $connect->query("SELECT * FROM parents_users WHERE parent_index='$the_guardian' ");

$row_parent_info = $stmt_get_parent->fetch();

$parent_fullname = $row_parent_info ['full_name'];
$parent_address = $row_parent_info ['address'];
$parent_phone = $row_parent_info ['phone'];
$parent_email = $row_parent_info ['email'];

}
 ?>

<a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a><br><br>

  <div class="panel panel-info">
    <div class="panel-heading center">
      <img src="../uploads/students/<?php if (empty($the_image)) {echo 'no_image.png';} else {echo $the_image;}  ?>" class="img-thumbnail" width="150px">
      
      <h2><?php echo $the_fullname; ?> <br> <span><?php echo $lang ['student']; ?></span></h2>

      <a href="contact.php?id=<?php echo $student_index; ?>" class="a_contact btn btn-warning"><i class="glyphicon glyphicon-envelope large" style="font-size:18px"></i> <?php echo $lang ['contact']; ?></a>

    </div>
    <div class="panel-body">

 <div class="clear"></div>

    <h2 class="edit"><?php echo $lang ['personal_information']; ?> :</h2>

    <div class="col-md-6">
      <label><?php echo $lang ['registration_number']; ?>  :</label> <span><?php echo $the_number; ?></span><br><br>
      <label><?php echo $lang ['class']; ?>  :</label> <span><?php echo $the_class; ?></span><br><br>
      <label><?php echo $lang ['gender']; ?>  :</label> <span><?php echo $the_sex; ?></span><br><br>
      <label><?php echo $lang ['birth_date']; ?>  :</label> <span><?php echo $the_birthday; ?></span><br><br>
    </div>
    <div class="col-md-6">
      <label><?php echo $lang ['Address']; ?>  :</label> <span><?php echo $the_address; ?></span><br><br>
      <label><?php echo $lang ['phone']; ?>  :</label> <span><?php echo $the_phone; ?></span><br><br>
      <label><?php echo $lang ['email']; ?>  :</label> <span><?php echo $the_email; ?></span><br><br>
      
    </div>

   <div class="clear"></div>

    <h2 class="edit"><?php echo $lang ['guardian_information']; ?> :</h2>

    <div class="col-md-6">
      <label><?php echo $lang ['Guardian_name']; ?>  :</label> <span><?php echo $parent_fullname; ?></span><br><br>
      <label><?php echo $lang ['phone']; ?>  :</label> <span><?php echo $parent_phone; ?></span><br><br>
    </div>
    <div class="col-md-6">
      <label><?php echo $lang ['Address']; ?>  :</label> <span><?php echo $parent_address; ?></span><br><br>
      <label><?php echo $lang ['email']; ?>  :</label> <span><?php echo $parent_email; ?></span><br><br>
    </div>

    <div class="clear"></div>

    
      
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
