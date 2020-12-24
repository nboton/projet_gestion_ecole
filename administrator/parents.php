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

    <title><?php echo $lang ['parents']; ?></title>

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
          jQuery("#formIDg").validationEngine();
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 




<div class="container mainbg">
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['parents']; ?></h1>
    <hr> <br>


    <div class="row col-md-6 col-md-offset-3" style=" margin-bottom: 50px;">
      <div class="col-md-6" style=" margin-bottom: 5px;"><button type="submit" id="btn_addDiv" class="mybtn mybtn-success btn-block"><?php echo $lang ['new']; ?></button></div>
      <div class="col-md-6"><button type="submit" id="btn_findDiv" class="mybtn mybtn-primary btn-block"><?php echo $lang ['find']; ?></button></div>
    </div>
    
    



<script type="text/javascript">

$(document).ready(function(){
    $("#btn_findDiv").click(function(){
        $("#findDiv").slideToggle();
        $("#findDiv").css("display" , "block");
        $("#addDiv").css("display" , "none");

    });

    $("#btn_addDiv").click(function(){
        $("#addDiv").slideToggle();
        $("#addDiv").css("display" , "block");
        $("#findDiv").css("display" , "none");

    });

});

  
</script> 

<div class="clear"></div>

<?php 

// -------------------------- random_parent   ----------------------------//
                $random_parent = mt_rand(1,100000); 
                $random_parent2 = $random_parent * 8888;
                $parent_index = substr(($random_parent2 ),0,8 );
//---------------------------------------------------------------//

if (isset($_POST['submit_parent'])) {

  $parent_fullname = htmlspecialchars($_POST['full_name']);
  $parent_type = htmlspecialchars($_POST['type']);
  $parent_address = htmlspecialchars($_POST['address']);
  $parent_email = htmlspecialchars($_POST['email']);
  $parent_phone = htmlspecialchars($_POST['phone']);

  $parent_username = htmlspecialchars($_POST['username']);
  $parent_password = htmlspecialchars(md5($_POST['password']));
  $parent_password_show = htmlspecialchars($_POST['password']);

  /*---------------------------------------------------------------------------------------------*/

    $stmt_check_user = $connect->prepare("SELECT * FROM parents_users WHERE username=:username");
    $stmt_check_user->bindParam (':username' , $parent_username , PDO::PARAM_STR );
    $stmt_check_user->execute();

if ($stmt_check_user->rowCount() <= 0) {

  $stmt_parent = $connect->prepare("INSERT INTO parents_users (full_name, parent_index, username, password, email, phone, sex, address) VALUES (:full_name, '$parent_index', :username, :password, :email, :phone, :sex, :address)");
  $stmt_parent->bindParam (':full_name' , $parent_fullname , PDO::PARAM_STR );
  $stmt_parent->bindParam (':username' , $parent_username , PDO::PARAM_STR );
  $stmt_parent->bindParam (':password' , $parent_password , PDO::PARAM_STR );
  $stmt_parent->bindParam (':email' , $parent_email , PDO::PARAM_STR );
  $stmt_parent->bindParam (':phone' , $parent_phone , PDO::PARAM_STR );
  $stmt_parent->bindParam (':sex' , $parent_type , PDO::PARAM_STR );
  $stmt_parent->bindParam (':address' , $parent_address , PDO::PARAM_STR );
  $stmt_parent->execute();

  $stmt_index = $connect->prepare("INSERT INTO index_users (index_num, full_name, type) VALUES ('$parent_index', :full_name, 'parent')");
  $stmt_index->bindParam (':full_name' , $parent_fullname , PDO::PARAM_STR );
  $stmt_index->execute();

  if (isset($stmt_parent) && isset($stmt_index)) {
    echo '<div class="add_success center col-md-8 col-md-offset-2" >
    <span><i class="glyphicon glyphicon-user"></i> '.$lang ['username'].' : '.$parent_username.'</span> - <span class="pass"><i class="glyphicon glyphicon-lock"></i> '.$lang ['password'].' : '.$parent_password_show.'</span>
 </div><div class="clear"></div><br><br>' ;
 echo "<meta http-equiv='refresh' content='30; url = parents.php' />";
  }

}

else {
  echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['username_existe']."</p></div><br><br>"; 
}
  
}


?>

<div id="findDiv">

<div class="row col-md-10 col-md-offset-1">

      <form id="" action="" method="post">

                  <div class="col-md-8 col-md-offset-1">
                    <input style="height:42px; margin-bottom: 10px;" name="findInput" type="text" placeholder="<?php echo $lang ['Guardian_name']; ?>" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['findInput'])) ? htmlspecialchars($_POST['findInput']) : ''?>"/>
                  </div>

                  <div class="col-md-2">
                    <button type="submit" name="find_submit" class="mybtn mybtn-default btn-block"><?php echo $lang ['find']; ?></button>
                  </div>

        </form>
      
    </div>


    <div class="clear"></div><br><br>

<?php 

if (isset($_POST['find_submit'])) {

  echo '<style type="text/css">#findDiv { display: block; }</style>';
   
  $find_parent = htmlspecialchars($_POST['findInput']);


  $stmt_find_parent = $connect->prepare("SELECT * FROM parents_users WHERE full_name LIKE '%$find_parent%' ");
  $stmt_find_parent->execute();

?>
         
    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['number_of_children']; ?></th>
            <th><?php echo $lang ['full_name']; ?></th>
            <th><?php echo $lang ['phone']; ?></th>
            <th><?php echo $lang ['profile']; ?></th>
            <th><?php echo $lang ['contact']; ?></th>
            <th><?php echo $lang ['edit']; ?></th>
          </tr>

<?php 
while ($find_parent_row = $stmt_find_parent->fetch()) {
      $fetch_parent_name = $find_parent_row ['full_name'];
      $fetch_parent_phone = $find_parent_row ['phone'];
      $fetch_parent_index = $find_parent_row ['parent_index'];


      $stmt_find_parent2 = $connect->query("SELECT * FROM students_users WHERE parent_index='$fetch_parent_index' ");
      $student_number = $stmt_find_parent2->rowCount();
?>
            <tr>
              <td><?php echo $student_number; ?></td>
              <td><?php echo $fetch_parent_name; ?></td>
              <td><?php echo $fetch_parent_phone; ?></td>
              <td><a href="guardian_profile.php?id=<?php echo $fetch_parent_index; ?>"><i class="glyphicon glyphicon-user large"></i></a></td>
              <td><a href="contact.php?id=<?php echo $fetch_parent_index; ?>"><i class="glyphicon glyphicon-envelope large"></i></a></td>
              <td><a href="edit.php?parent=<?php echo $fetch_parent_index; ?>"><i class="glyphicon glyphicon-pencil large"></i></a></td>
            </tr>

<?php } ?>
            
      </table>

      <br>

<?php } ?>
</div>

<div id="addDiv">

    <div class="clear"></div>

    <div class="row col-md-10 col-md-offset-1">

      <form id="formID" action="" method="post">


          <div class="info_parents"> 
          
              <label class=""><?php echo $lang ['username']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input name="username" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : ''?>"/>
              </div><br>

              <label class=""><?php echo $lang ['password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password" type="password" id="password" class="form-control validate[required]" value=""/>
              </div><br>

              <label class=""><?php echo $lang ['confirm_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password2" type="password" placeholder="" class="form-control validate[required,equals[password]]" value=""/>
              </div>
          </div><br>       

          <hr>

          <label class=""><?php echo $lang ['full_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input name="full_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['full_name'])) ? htmlspecialchars($_POST['full_name']) : ''?>"/>
          </div><br>


          <label class=""><?php echo $lang ['gender']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="type" class="form-control">
                <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                <option value="<?php echo $lang ['man']; ?>"><?php echo $lang ['man']; ?></option>
                <option value="<?php echo $lang ['woman']; ?>"><?php echo $lang ['woman']; ?></option>
              </select>
          </div><br>

          <label class=""><?php echo $lang ['Address']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
              <input name="address" type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['address'])) ? htmlspecialchars($_POST['address']) : ''?>"/>
          </div><br>

          <label class=""><?php echo $lang ['email']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input name="email" type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['email'])) ? htmlspecialchars($_POST['email']) : ''?>"/>
          </div><br>

          <label class=""><?php echo $lang ['phone']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
              <input name="phone" type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['phone'])) ? htmlspecialchars($_POST['phone']) : ''?>"/>
          </div><br>      

          <button type="submit" name="submit_parent" class="mybtn mybtn-primary btn-block"><?php echo $lang ['add']; ?></button><br><br>

      </form>
  
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
