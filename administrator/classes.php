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

    <title><?php echo $lang ['classes']; ?></title>

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
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['classes']; ?></h1>
    <hr> <br>

<?php 
if (isset($_POST['submit'])) {
   
  $class_name = htmlspecialchars($_POST['class_name']);
  $class_numeric = htmlspecialchars($_POST['class_numeric']);
  $class_note = htmlspecialchars($_POST['class_note']);

   $stmt_class = $connect->prepare("INSERT INTO classes (class_name, class_numeric, class_note) VALUES (:class_name, :class_numeric, :class_note)");
  $stmt_class->bindParam (':class_name' , $class_name , PDO::PARAM_STR );
  $stmt_class->bindParam (':class_numeric' , $class_numeric , PDO::PARAM_STR );
  $stmt_class->bindParam (':class_note' , $class_note , PDO::PARAM_STR );
  $stmt_class->execute();

  if (isset($stmt_class)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['class_was_added']."</p></div><br><br>"; 
  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

?>

    <div class="clear"></div>
    <div class="row col-md-10 col-md-offset-1">

      <form id="formID" action="" method="post">
          
              <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-book"></i></span>
                  <input name="class_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['class_name'])) ? htmlspecialchars($_POST['class_name']) : ''?>"/>
              </div><br>

              <label class=""><?php echo $lang ['class_number']; ?> : </label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list-alt"></i></span>
                  <input name="class_numeric" type="text" placeholder="" class="form-control validate[custom[integer]]" value="<?php echo htmlspecialchars(!empty($_POST['class_numeric'])) ? htmlspecialchars($_POST['class_numeric']) : ''?>"/>
              </div><br>

              <label class=""><?php echo $lang ['note']; ?> : </label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                <textarea class="form-control" name="class_note" placeholder=""><?php echo htmlspecialchars(!empty($_POST['class_note'])) ? htmlspecialchars($_POST['class_note']) : ''?></textarea>
              </div><br> 

          <button type="submit" name="submit" class="mybtn mybtn-success"><?php echo $lang ['add_class']; ?></button>     

          <hr id='success'>

      </form>
  
  </div>

<div class="clear"></div>
<?php 
if (isset($_GET['class_delete']) && isset($_GET['token']) ) {

$delete_id = $_GET['class_delete'];

if ($_GET['token'] == $_SESSION['token']) {

  $stmt_delete = $connect->prepare("DELETE FROM classes WHERE id=:id");
  $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo '<script type="text/javascript"> window.location.href += "#success"; </script>';
    echo "<meta http-equiv='refresh' content='5; url = classes.php' />";
  }
  
}

}
 ?>

    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['class_number']; ?></th>
            <th><?php echo $lang ['class']; ?></th>
            <th><?php echo $lang ['note']; ?></th>
            <th><?php echo $lang ['delete']; ?></th>
          </tr>
<?php 

  $stmt_find_class = $connect->prepare("SELECT * FROM classes");
  $stmt_find_class->execute();

  while ($find_class_row = $stmt_find_class->fetch()) {
      $fetch_class_numeric = $find_class_row ['class_numeric'];
      $fetch_class_name = $find_class_row ['class_name'];
      $fetch_class_note = $find_class_row ['class_note'];
      $fetch_class_id = $find_class_row ['id'];



?>
            <tr>
              <td><?php echo $fetch_class_numeric;  ?></td>
              <td><?php echo $fetch_class_name;  ?></td>
              <td><?php echo $fetch_class_note;  ?></td>
              <td><a class="" href="?token=<?php echo $_SESSION ['token']; ?>&class_delete=<?php echo $fetch_class_id;  ?>"><i class="glyphicon glyphicon-trash large" style="font-size:26px"></i></a></td>
            </tr>
<?php } ?>           
      </table>

      <br>
        

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
