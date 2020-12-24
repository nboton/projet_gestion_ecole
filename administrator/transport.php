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

      <link rel="stylesheet" href="../libs/validationEngine/validationEngine.jquery.css" type="text/css"/>
<?php 
if (isset($_SESSION['arabic'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-ar.js" type="text/javascript" charset="utf-8">';
}
if (isset($_SESSION['francais'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-fr.js" type="text/javascript" charset="utf-8"></script>';
}

if (isset($_SESSION['english'])) {
    echo '<script src="../libs/validationEngine/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8"></script>';
} 
?>
      </script>
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

    <h1 class="h1_title"><?php echo $lang ['transport']; ?></h1>
    <hr> <br>

<?php 

if (isset($_GET['delete_id']) && isset($_GET['token'])) {

$delete_id = $_GET['delete_id'];

if ($_GET['token'] == $_SESSION['token']) {

  $stmt_delete = $connect->prepare("DELETE FROM transport WHERE id=:id");
  $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['Deleted_successfully']."</p></div><br><br>"; 
    echo "<meta http-equiv='refresh' content='5; url = transport.php' />";
  }

}

}

/*----------------------------------------------------*/

if (isset($_POST['submit'])) {
   
  $transport_day = htmlspecialchars($_POST['day']);
  $transport_class = htmlspecialchars($_POST['class']);
  $transport_start_m = htmlspecialchars($_POST['start_m']);
  $transport_return_m = htmlspecialchars($_POST['return_m']);
  $transport_start_e = htmlspecialchars($_POST['start_e']);
  $transport_return_e = htmlspecialchars($_POST['return_e']);

   $stmt_transport = $connect->prepare("INSERT INTO transport (day, class_name, time_start_m, time_return_m, time_start_e, time_return_e) VALUES ('$transport_day', '$transport_class', :time_start_m, :time_return_m, :time_start_e, :time_return_e)");
  $stmt_transport->bindParam (':time_start_m' , $transport_start_m , PDO::PARAM_STR );
  $stmt_transport->bindParam (':time_return_m' , $transport_return_m , PDO::PARAM_STR );
  $stmt_transport->bindParam (':time_start_e' , $transport_start_e , PDO::PARAM_STR );
  $stmt_transport->bindParam (':time_return_e' , $transport_return_e , PDO::PARAM_STR );
  $stmt_transport->execute();

  if (isset($stmt_transport)) {
    echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['add_successfully']."</p></div><br><br>"; 
  }

  else {
   echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>";     
  }


 } 

?>


    <div class="clear"></div>
    <div class="row col-md-10 col-md-offset-1">

      <form id="formID" action="" method="post">
          
              <label class=""><?php echo $lang ['day']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                  <select name="day" class="form-control validate[required]">
                  <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                  <option value="<?php echo $lang ['Monday']; ?>"><?php echo $lang ['Monday']; ?></option>
                  <option value="<?php echo $lang ['Tuesday']; ?>"><?php echo $lang ['Tuesday']; ?></option>
                  <option value="<?php echo $lang ['Wednesday']; ?>"><?php echo $lang ['Wednesday']; ?></option>
                  <option value="<?php echo $lang ['Thursday']; ?>"><?php echo $lang ['Thursday']; ?></option>
                  <option value="<?php echo $lang ['Friday']; ?>"><?php echo $lang ['Friday']; ?></option>
                  <option value="<?php echo $lang ['Saturday']; ?>"><?php echo $lang ['Saturday']; ?></option>
				  <option value="<?php echo $lang ['Sunday']; ?>"><?php echo $lang ['Sunday']; ?></option>
                  </select>
              </div><br>

              <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                  <select name="class" class="form-control validate[required]">
                  <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
<?php 
  $stmt_find_class = $connect->query("SELECT * FROM classes");

  while ($find_class_row = $stmt_find_class->fetch()) {
      $fetch_class_name = $find_class_row ['class_name'];

      echo '<option value="'.$fetch_class_name.'">'.$fetch_class_name.'</option>';

  } 
?>
                  </select>
              </div><br>

              <div class="col-md-6">
                <label class=""><?php echo $lang ['time_start_morning']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    <input name="start_m" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['start_m'])) ? htmlspecialchars($_POST['start_m']) : ''?>"/>
                </div><br>
              </div>

              <div class="col-md-6">
                <label class=""><?php echo $lang ['time_return_morning']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    <input name="return_m" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['return_m'])) ? htmlspecialchars($_POST['return_m']) : ''?>"/>
                </div><br>
              </div>

              <div class="col-md-6">
                <label class=""><?php echo $lang ['time_start_evening']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    <input name="start_e" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['start_e'])) ? htmlspecialchars($_POST['start_e']) : ''?>"/>
                </div><br>
              </div>

              <div class="col-md-6">
                <label class=""><?php echo $lang ['time_return_evening']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                    <input name="return_e" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['return_e'])) ? htmlspecialchars($_POST['return_e']) : ''?>"/>
                </div><br>
              </div>

               <div class="clear"></div>

          <button type="submit" name="submit" class="mybtn mybtn-success"><?php echo $lang ['add']; ?></button>     

          

      </form>
  
  </div>

  <div class="clear"></div>

    
    <hr><h1 id="times" class="h1_title"><?php echo $lang ['look_for_times_of_transport']; ?></h1>

    <br><br>

    <div class="row col-md-10 col-md-offset-1">

      <form id="" action="" method="post">

                  <div class="col-md-8 col-md-offset-1">
                        <div class="input-group">
                      <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                      <select name="find_list" class="form-control">
                      <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
    <?php 
      $stmt_find_class = $connect->query("SELECT * FROM classes");

      while ($find_class_row = $stmt_find_class->fetch()) {
          $fetch_class_name = $find_class_row ['class_name'];

          echo '<option value="'.$fetch_class_name.'">'.$fetch_class_name.'</option>';

      } 
    ?>
                      </select>
              </div><br>
                  </div>

                  <div class="col-md-2">
                    <button type="submit" name="find_submit" class="btn btn-danger btn-block"><?php echo $lang ['find']; ?></button>
                  </div>

        </form>
      
    </div>

    <div class="clear"></div><br><br>

<?php  if (isset($_POST['find_submit'])) {

  echo '<script type="text/javascript"> window.location.href += "#times"; </script>';

  $get_class = htmlspecialchars($_POST['find_list']);

?>

    <table class="table table-striped table-bordered">

      <tr class="tr-table2">
        <th><?php echo $lang ['day']; ?></th>
        <th><?php echo $lang ['class']; ?></th>
        <th><?php echo $lang ['starting']; ?></th>
        <th><?php echo $lang ['return']; ?></th>
        <th><i class="glyphicon glyphicon-adjust large2c"></i></th>
        <th><?php echo $lang ['starting']; ?></th>
        <th><?php echo $lang ['return']; ?></th>
        <th><?php echo $lang ['delete']; ?></th>
      </tr>

<?php 

  $stmt_get_transport = $connect->prepare("SELECT * FROM transport WHERE class_name='$get_class' ");
  $stmt_get_transport->execute();

  while ($get_transport_row = $stmt_get_transport->fetch()) {
      $fetch_transport_id = $get_transport_row ['id'];
      $fetch_transport_day = $get_transport_row ['day'];
      $fetch_transport_class = $get_transport_row ['class_name'];
      $fetch_transport_start_m = $get_transport_row ['time_start_m'];
      $fetch_transport_return_m = $get_transport_row ['time_return_m'];
      $fetch_transport_start_e = $get_transport_row ['time_start_e'];
      $fetch_transport_return_e = $get_transport_row ['time_return_e'];

?>
            <tr>
              <th class="th-table2"><?php echo $fetch_transport_day;  ?></th>
              <td><span class="label label-default"><?php echo $fetch_transport_class;  ?></span></td>
              <td><?php echo $fetch_transport_start_m;  ?></td>
              <td><?php echo $fetch_transport_return_m;  ?></td>
              <td>|</td>
              <td><?php echo $fetch_transport_start_e;  ?></td>
              <td><?php echo $fetch_transport_return_e;  ?></td>
              <td><a class="right" href="?token=<?php echo $_SESSION ['token']; ?>&delete_id=<?php echo $fetch_transport_id;  ?>"><i class="glyphicon glyphicon-trash large" style="font-size:26px"></i></a></td>
            </tr>
<?php } ?> 


      
  </table>

      <br>
        
<?php } ?> 

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
