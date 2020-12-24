<?php 
/*======================================================================*\
|| #################################################################### ||
|| #               											                              # ||
|| #              EasySchool v1.1 - School management system          # ||
|| #               											                              # ||
|| # ---------------------------------------------------------------- # ||
|| #         Copyright © 2016 EasySchool. All Rights Reserved.        # ||
|| # 				    	http://www.dabach.net		     		                    # ||
|| #               											                              # ||
|| # ---------------- ------------------------------- --------------- # ||
|| #               											                              # ||
|| #################################################################### ||
\*======================================================================*/

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

    <title><?php echo $lang ['students']; ?></title>

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
          jQuery("#new_student_form").validationEngine();
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['students']; ?></h1>
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

// -------------------------- random_student   ----------------------------//
                $random_student = mt_rand(1,100000); 
                $random_student2 = $random_student * 8888;
                $student_index = substr(($random_student2 ),0,8 );
//---------------------------------------------------------------//

if (isset($_POST['submit_student'])) {

  $student_fullname = htmlspecialchars($_POST['full_name']);
  $student_registration_num = htmlspecialchars($_POST['registration_num']);
  $student_type = htmlspecialchars($_POST['type']);
  $student_guardian = htmlspecialchars($_POST['guardian']);
  $student_class = htmlspecialchars($_POST['class']);
  $student_birthday = htmlspecialchars($_POST['birthday']);
  $student_address = htmlspecialchars($_POST['address']);
  $student_email = htmlspecialchars($_POST['email']);
  $student_phone = htmlspecialchars($_POST['phone']);

  $student_username = htmlspecialchars($_POST['username']);
  $student_password = htmlspecialchars(md5($_POST['password']));
  $student_password_show = htmlspecialchars($_POST['password']);

  /*---------------------------------------------------------------------------------------------*/

    $stmt_check_user = $connect->prepare("SELECT * FROM students_users WHERE username=:username");
    $stmt_check_user->bindParam (':username' , $student_username , PDO::PARAM_STR );
    $stmt_check_user->execute();

if ($stmt_check_user->rowCount() <= 0) {


    if (!empty($_FILES["userImage"]["name"])) {

  $size = 1000 * 1024;
  $target = dirname(__DIR__)."/uploads/students/";
  // an array of allowed extensions
  $allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
  $temp = explode(".", $_FILES["userImage"]["name"]);
  $extension = end($temp);

  if ((($_FILES["userImage"]["type"] == "image/gif")
    || ($_FILES["userImage"]["type"] == "image/jpeg")
    || ($_FILES["userImage"]["type"] == "image/jpg")
    || ($_FILES["userImage"]["type"] == "image/pjpeg")
    || ($_FILES["userImage"]["type"] == "image/x-png")
    || ($_FILES["userImage"]["type"] == "image/png"))
    && ($_FILES["userImage"]["size"] < $size ) && in_array($extension, $allowedExts)) {

      if ($_FILES["userImage"]["error"] > 0) {
        echo "<div class='alert alert-danger'><p class='center'>".$lang ['An_error_in_the_picture']."</p></div>";
      }
      else {
        $student_image = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES["userImage"]["tmp_name"], $target . $student_image);

        $stmt_student = $connect->prepare("INSERT INTO students_users (full_name, registration_num, parent_index, image, student_index, username, password, email, phone, sex, address, birthday, student_class) VALUES (:full_name, :registration_num, :parent_index, '$student_image', '$student_index', :username, :password, :email, :phone, :sex, :address, :birthday, :student_class)");

        $stmt_student->bindParam (':full_name' , $student_fullname , PDO::PARAM_STR );
        $stmt_student->bindParam (':registration_num' , $student_registration_num , PDO::PARAM_STR );
        $stmt_student->bindParam (':parent_index' , $student_guardian , PDO::PARAM_STR );
        $stmt_student->bindParam (':username' , $student_username , PDO::PARAM_STR );
        $stmt_student->bindParam (':password' , $student_password , PDO::PARAM_STR );
        $stmt_student->bindParam (':email' , $student_email , PDO::PARAM_STR );
        $stmt_student->bindParam (':phone' , $student_phone , PDO::PARAM_STR );
        $stmt_student->bindParam (':sex' , $student_type , PDO::PARAM_STR );
        $stmt_student->bindParam (':address' , $student_address , PDO::PARAM_STR );
        $stmt_student->bindParam (':birthday' , $student_birthday , PDO::PARAM_STR );
        $stmt_student->bindParam (':student_class' , $student_class , PDO::PARAM_STR );
        $stmt_student->execute();

      }

    }
     else {
      echo "<div class='alert alert-danger'><p class='center'>".$lang ['An_error_in_the_picture']."</p></div>";
    }

}

else {
  $stmt_student = $connect->prepare("INSERT INTO students_users (full_name, registration_num, parent_index, student_index, username, password, email, phone, sex, address, birthday, student_class) VALUES (:full_name, :registration_num, :parent_index, '$student_index', :username, :password, :email, :phone, :sex, :address, :birthday, :student_class)");
  $stmt_student->bindParam (':full_name' , $student_fullname , PDO::PARAM_STR );
  $stmt_student->bindParam (':registration_num' , $student_registration_num , PDO::PARAM_STR );
  $stmt_student->bindParam (':parent_index' , $student_guardian , PDO::PARAM_STR );
  $stmt_student->bindParam (':username' , $student_username , PDO::PARAM_STR );
  $stmt_student->bindParam (':password' , $student_password , PDO::PARAM_STR );
  $stmt_student->bindParam (':email' , $student_email , PDO::PARAM_STR );
  $stmt_student->bindParam (':phone' , $student_phone , PDO::PARAM_STR );
  $stmt_student->bindParam (':sex' , $student_type , PDO::PARAM_STR );
  $stmt_student->bindParam (':address' , $student_address , PDO::PARAM_STR );
  $stmt_student->bindParam (':birthday' , $student_birthday , PDO::PARAM_STR );
  $stmt_student->bindParam (':student_class' , $student_class , PDO::PARAM_STR );
  $stmt_student->execute();
}

  $stmt_index = $connect->prepare("INSERT INTO index_users (index_num, full_name, type) VALUES ('$student_index', :full_name, 'student')");
  $stmt_index->bindParam (':full_name' , $student_fullname , PDO::PARAM_STR );
  $stmt_index->execute();

  if (isset($stmt_student) && isset($stmt_index)) {     
    echo '<div class="add_success center col-md-8 col-md-offset-2" >
    <span><i class="glyphicon glyphicon-user"></i> '.$lang ['username'].' : '.$student_username.'</span> - <span class="pass"><i class="glyphicon glyphicon-lock"></i> '.$lang ['password'].' : '.$student_password_show.'</span>
 </div><div class="clear"></div><br><br>' ;
 echo "<meta http-equiv='refresh' content='30; url = students.php' />";
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
                    <input style="height:42px; margin-bottom: 10px;" name="findInput" type="text" placeholder="<?php echo $lang ['registration_number_or_name']  ?>" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['findInput'])) ? htmlspecialchars($_POST['findInput']) : ''?>"/>
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
   
  $find_student = htmlspecialchars($_POST['findInput']);


  $stmt_find_student = $connect->prepare("SELECT * FROM students_users WHERE full_name LIKE '%$find_student%' OR registration_num = '$find_student'");
  $stmt_find_student->execute();

?>
         
    <table class="table table-striped table-bordered">
          <tr class="tr-table">
            <th><?php echo $lang ['registration_number']; ?></th>
            <th><?php echo $lang ['full_name']; ?></th>
            <th><?php echo $lang ['guardian']; ?></th>
            <th><?php echo $lang ['profile']; ?></th>
            <th><?php echo $lang ['contact']; ?></th>
            <th><?php echo $lang ['edit']; ?></th>
          </tr>

<?php 
while ($find_student_row = $stmt_find_student->fetch()) {
      $fetch_student_number = $find_student_row ['registration_num'];
      $fetch_student_name = $find_student_row ['full_name'];
      $fetch_student_guardian = $find_student_row ['parent_index'];
      $fetch_student_index = $find_student_row ['student_index'];
?>
            <tr>
              <td><?php echo $fetch_student_number; ?></td>
              <td><?php echo $fetch_student_name; ?></td>
              <td><?php if (!empty($fetch_student_guardian)) {
                echo '<a href="guardian_profile.php?id='.$fetch_student_guardian.'"><i class="glyphicon glyphicon-eye-open large"></i></a>';
              } ?></td>
              <td><a href="student_profile.php?id=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-user large"></i></a></td>
              <td><a href="contact.php?id=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-envelope large"></i></a></td>
              <td><a href="edit.php?student=<?php echo $fetch_student_index; ?>"><i class="glyphicon glyphicon-pencil large"></i></a></td>
            </tr>

<?php } ?>
            
      </table>

      <br>

<?php } ?>



</div>

<div id="addDiv">

    <div class="clear"></div>

    <div class="row col-md-10 col-md-offset-1">

      <form id="new_student_form" action="" method="post" enctype="multipart/form-data">

          <div style="background-color:#F9D735; padding: 15px; border-radius: 3px; clear: both;">
            <label class=""><th><?php echo $lang ['guardian']; ?></th> : </label>
            <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
                <select name="guardian" class="form-control">
                  <option selected="selected" value=""><th><?php echo $lang ['select']; ?></th></option>
<?php 
    $stmt_get_parents = $connect->query("SELECT * FROM parents_users");

    while ($get_parents_row = $stmt_get_parents->fetch()) {
      $fetch_parent_name = $get_parents_row ['full_name'];
      $fetch_parent_index = $get_parents_row ['parent_index'];
    
?>
                  <option value="<?php echo $fetch_parent_index; ?>"><?php echo $fetch_parent_name; ?></option>

<?php } ?>
                </select>
            </div>    
            <br>
            <a href="parents.php" class="btn btn-default"><th><?php echo $lang ['new']; ?></th></a>    
          </div><br>



          <div class="info_students"> 
          
              <label class=""><?php echo $lang ['username']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                  <input name="username" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['username'])) ? htmlspecialchars($_POST['username']) : ''?>"/>
              </div><br>

              <label class=""><?php echo $lang ['password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password" type="password" id="password" placeholder="" class="form-control validate[required]" value=""/>
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

          <label class=""><?php echo $lang ['registration_number']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-barcode"></i></span>
              <input name="registration_num" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['registration_num'])) ? htmlspecialchars($_POST['registration_num']) : ''?>"/>
          </div><br>

        
          <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="class" class="form-control">
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

          <label class=""><?php echo $lang ['gender']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="type" class="form-control validate[required]">
                <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                <option value="<?php echo $lang ['man']; ?>"><?php echo $lang ['man']; ?></option>
                <option value="<?php echo $lang ['woman']; ?>"><?php echo $lang ['woman']; ?></option>
              </select>
          </div><br>

          <label class=""><?php echo $lang ['birth_date']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
              <input name="birthday" type="text" placeholder="" class="form-control" value="<?php echo htmlspecialchars(!empty($_POST['birthday'])) ? htmlspecialchars($_POST['birthday']) : ''?>"/>
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

          <label class=""><?php echo $lang ['picture_p']; ?> : <span style="color:#c9c9c9; ">(400px x 400px)</span></label>
          <div class="input-group">
              <input type="file" name="userImage" class="btn btn-default" />
          </div><br>   

          <button type="submit" name="submit_student" class="mybtn mybtn-primary btn-block"><?php echo $lang ['add']; ?></button><br><br><br>

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
