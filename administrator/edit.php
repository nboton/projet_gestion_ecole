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

    <title><?php echo $lang ['edit']; ?></title>

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
          jQuery("#formID2").validationEngine();
        });
 
      </script>
        
  </head>
<body>

<?php include 'nav.php'; ?> 



<div class="container mainbg">
<br><a class="return" href="index.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

    <h1 class="h1_title"><?php echo $lang ['edit']; ?></h1>
    <hr> <br>

<?php 
if (isset($_GET['update']) == "success") {
  echo "<div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['edit_successfully']."</p></div><br><br>"; 
}

if (isset($_GET['error']) == "error") {
  echo "<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Error_retry_again']."</p></div><br><br>"; 
}
 ?>

<div class="clear"></div>

<?php 
if (isset($_GET['student'])) {

$student_index = htmlspecialchars($_GET['student']);

$stmt_get_allInfo = $connect->prepare("SELECT * FROM students_users WHERE student_index=:student_index ");
$stmt_get_allInfo->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
$stmt_get_allInfo->execute();

if ($stmt_get_allInfo->rowCount() !== 1 ) {
  die("<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br>");
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

$the_img = $row_allInfo ['image'];

$the_guardian = $row_allInfo ['parent_index'];

$stmt_get_parent = $connect->query("SELECT * FROM parents_users WHERE parent_index='$the_guardian' ");

$row_parent_info = $stmt_get_parent->fetch();

$parent_fullname = $row_parent_info ['full_name'];
$parent_index = $row_parent_info ['parent_index'];


/* --------------------------------------------------------------------------------*/


if (isset($_POST['updateinfo'])) {

  $student_fullname = htmlspecialchars($_POST['full_name']);
  $student_registration_num = htmlspecialchars($_POST['registration_num']);
  $student_type = htmlspecialchars($_POST['type']);
  $student_guardian = htmlspecialchars($_POST['guardian']);
  $student_class = htmlspecialchars($_POST['class']);
  $student_birthday = htmlspecialchars($_POST['birthday']);
  $student_address = htmlspecialchars($_POST['address']);
  $student_email = htmlspecialchars($_POST['email']);
  $student_phone = htmlspecialchars($_POST['phone']);

  $student_image = "article_img.jpg";


  $stmt_student = $connect->prepare("UPDATE students_users SET full_name=:full_name, registration_num=:registration_num, parent_index=:parent_index, image='$student_image', email=:email, phone=:phone, sex=:sex, address=:address, birthday=:birthday, student_class=:student_class WHERE student_index=:student_index");
  $stmt_student->bindParam (':full_name' , $student_fullname , PDO::PARAM_STR );
  $stmt_student->bindParam (':registration_num' , $student_registration_num , PDO::PARAM_STR );
  $stmt_student->bindParam (':parent_index' , $student_guardian , PDO::PARAM_STR );
  $stmt_student->bindParam (':email' , $student_email , PDO::PARAM_STR );
  $stmt_student->bindParam (':phone' , $student_phone , PDO::PARAM_STR );
  $stmt_student->bindParam (':sex' , $student_type , PDO::PARAM_STR );
  $stmt_student->bindParam (':address' , $student_address , PDO::PARAM_STR );
  $stmt_student->bindParam (':birthday' , $student_birthday , PDO::PARAM_STR );
  $stmt_student->bindParam (':student_class' , $student_class , PDO::PARAM_STR );
  $stmt_student->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
  $stmt_student->execute();



  if (isset($stmt_student)) {
    
    echo "<meta http-equiv='refresh' content='0; url = edit.php?student=$student_index&update=success' />"; 
    
  }

  else {
   //echo "<div class='alert alert-danger center' style='width: 90%; margin: auto; margin-top: 50px'><p>error..!</p></div>";    

      
    echo "<meta http-equiv='refresh' content='0; url = edit.php?student=$student_index&error=error' />"; 
  }
  
}


if (isset($_POST['update_password'])) {
   

  $new_pass = htmlspecialchars(md5($_POST['new_pass']));


      $stmt_update_pass = $connect->prepare("UPDATE students_users SET password=:password WHERE student_index=:student_index");
      $stmt_update_pass->bindParam (':password' , $new_pass , PDO::PARAM_STR );
      $stmt_update_pass->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
      $stmt_update_pass->execute();

      if (isset($stmt_update_pass)) {
      //  header ("location: edit.php?student=$student_index&update=success");   
        echo "<meta http-equiv='refresh' content='0; url = edit.php?student=$student_index&update=success' />"; 

      }

  else {
  // header ("location: edit.php?student=$student_index&error=error");   
    echo "<meta http-equiv='refresh' content='0; url = edit.php?student=$student_index&error=error' />"; 
    
  }


} 

if (isset($_POST['submit_delete'])) {
   
  $stmt_delete = $connect->prepare("DELETE FROM students_users WHERE student_index=:student_index");
  $stmt_delete->bindParam (':student_index' , $student_index , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {


      if (!empty($the_img)) {
        unlink("../uploads/students/".$the_img);
      }

    header ("location: students.php");   
    echo "<meta http-equiv='refresh' content='0; url = students.php' />"; 
  }

} 


?>

    <div class="clear"></div>

    <div class="row col-md-12 col-md-offset-0">

<form id="formID" action="" method="post">

          <div style="background-color:#ddd; padding: 15px; border-radius: 3px;">
            <label class=""><?php echo $lang ['Guardian_name']; ?> : </label>
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
          </div><br>

          <label class=""><?php echo $lang ['full_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input name="full_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $the_fullname; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['registration_number']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input name="registration_num" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $the_number; ?>"/>
          </div><br>

        
          <label class=""><?php echo $lang ['class']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="class" class="form-control validate[required]">
                <option selected="selected" value=""><th><?php echo $lang ['select']; ?></th></option>
<?php 
  $stmt_find_class = $connect->query("SELECT * FROM classes");

  while ($find_class_row = $stmt_find_class->fetch()) {
      $fetch_class_name = $find_class_row ['class_name'];

      echo '<option value="'.$fetch_class_name.'">'.$fetch_class_name.'</option>';

  } 
?>
              </select>
          </div>
          <br>
          <br>

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
              <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
              <input name="birthday" type="text" placeholder="" class="form-control validate[custom[date]] " value="<?php echo $the_birthday; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['Address']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
              <input name="address" type="text" placeholder="" class="form-control" value="<?php echo $the_address; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['email']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input name="email" type="text" placeholder="" class="form-control" value="<?php echo $the_email; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['phone']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
              <input name="phone" type="text" placeholder="" class="form-control" value="<?php echo $the_phone; ?>"/>
          </div><br>      

          <button type="submit" name="updateinfo" class="mybtn mybtn-primary"><?php echo $lang ['save']; ?></button><br><br>
  


 </form>

 <hr>
          <form id="formID2" action="" method="post">

          <div class="info_students"> 
          
              <label class=""><?php echo $lang ['new_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="new_pass" type="password" id="password" class="form-control validate[required]" value=""/>
              </div><br>

              <label class=""><?php echo $lang ['confirm_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password2" type="password" placeholder="" class="form-control validate[required,equals[password]]" value=""/>
              </div>
          </div><br>  

          <button type="submit" name="update_password" class="mybtn mybtn-primary"><?php echo $lang ['change_password']; ?></button><br>

          </form> <br><br>

  <hr>
          <form id="" action="" method="post" class="center"> 

          <button onclick="return confirm('<?php echo $lang ['delete_student']; ?> !')" type="submit" name="submit_delete" class="btn btn-danger"><?php echo $lang ['delete_student']; ?> </button><br>

          </form> <br><br>

  </div>       

<?php } ?> 










<?php 
if (isset($_GET['teacher'])) {

$teacher_index = htmlspecialchars($_GET['teacher']);

$stmt_get_allInfo = $connect->prepare("SELECT * FROM teachers_users WHERE teacher_index=:teacher_index ");
$stmt_get_allInfo->bindParam (':teacher_index' , $teacher_index , PDO::PARAM_STR );
$stmt_get_allInfo->execute();

if ($stmt_get_allInfo->rowCount() !== 1 ) {
  die("<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br>");
}

$row_allInfo = $stmt_get_allInfo->fetch();

$the_fullname = $row_allInfo ['full_name'];
$the_image = $row_allInfo ['image'];
$the_subject = $row_allInfo ['subject'];
$the_sex = $row_allInfo ['sex'];
$the_address = $row_allInfo ['address'];
$the_phone = $row_allInfo ['phone'];
$the_email = $row_allInfo ['email'];
$the_img = $row_allInfo ['image'];

/* --------------------------------------------------------------------------------*/


if (isset($_POST['updateinfo'])) {

  $teacher_fullname = htmlspecialchars($_POST['full_name']);
  $teacher_type = htmlspecialchars($_POST['type']);
  $teacher_subject = htmlspecialchars($_POST['subject']);
  $teacher_address = htmlspecialchars($_POST['address']);
  $teacher_email = htmlspecialchars($_POST['email']);
  $teacher_phone = htmlspecialchars($_POST['phone']);

  $teacher_image = "article_img.jpg";


  $stmt_teacher = $connect->prepare("UPDATE teachers_users SET full_name=:full_name, image='$teacher_image', email=:email, phone=:phone, sex=:sex, address=:address, subject=:subject WHERE teacher_index=:teacher_index");
  $stmt_teacher->bindParam (':full_name' , $teacher_fullname , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':email' , $teacher_email , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':phone' , $teacher_phone , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':sex' , $teacher_type , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':address' , $teacher_address , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':subject' , $teacher_subject , PDO::PARAM_STR );
  $stmt_teacher->bindParam (':teacher_index' , $teacher_index , PDO::PARAM_STR );
  $stmt_teacher->execute();



  if (isset($stmt_teacher)) {
 
    echo "<meta http-equiv='refresh' content='0; url = edit.php?teacher=$teacher_index&update=success' />"; 
    
  }

  else { 

  
    echo "<meta http-equiv='refresh' content='0; url = edit.php?teacher=$teacher_index&error=error' />"; 
  }
  
}


if (isset($_POST['update_password'])) {
   
  $new_pass = htmlspecialchars(md5($_POST['new_pass']));


      $stmt_update_pass = $connect->prepare("UPDATE teachers_users SET password=:password WHERE teacher_index=:teacher_index");
      $stmt_update_pass->bindParam (':password' , $new_pass , PDO::PARAM_STR );
      $stmt_update_pass->bindParam (':teacher_index' , $teacher_index , PDO::PARAM_STR );
      $stmt_update_pass->execute();

      if (isset($stmt_update_pass)) {
          
        echo "<meta http-equiv='refresh' content='0; url = edit.php?teacher=$teacher_index&update=success' />"; 

      }

  else {
      
    echo "<meta http-equiv='refresh' content='0; url = edit.php?teacher=$teacher_index&error=error' />"; 
    
  }

} 


if (isset($_POST['submit_delete'])) {
   
  $stmt_delete = $connect->prepare("DELETE FROM teachers_users WHERE teacher_index=:teacher_index");
  $stmt_delete->bindParam (':teacher_index' , $teacher_index , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {

    if (!empty($the_img)) {
        unlink("../uploads/teachers/".$the_img);
      }

    header ("location: teachers.php");   
    echo "<meta http-equiv='refresh' content='0; url = teachers.php' />"; 
  }

} 


?>

    <div class="clear"></div>

    <div class="row col-md-12 col-md-offset-0">


<form id="formID" action="" method="post">


          <label class=""><?php echo $lang ['full_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input name="full_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $the_fullname; ?>"/>
          </div><br>


        
          <label class=""><?php echo $lang ['subject']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="subject" class="form-control validate[required]">
                <option selected="selected" value=""><th><?php echo $lang ['select']; ?></th></option>
<?php 
  $stmt_find_subject = $connect->query("SELECT * FROM subjects");

  while ($find_subjects_row = $stmt_find_subject->fetch()) {
      $fetch_subject_name = $find_subjects_row ['subject_name'];

      echo '<option value="'.$fetch_subject_name.'">'.$fetch_subject_name.'</option>';

  } 
?>
              </select>
          </div>
          <br>
          <br>

          <label class=""><?php echo $lang ['gender']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-list"></i></span>
              <select name="type" class="form-control validate[required]">
                <option selected="selected" value=""><?php echo $lang ['select']; ?></option>
                <option value="<?php echo $lang ['man']; ?>"><?php echo $lang ['man']; ?></option>
                <option value="<?php echo $lang ['woman']; ?>"><?php echo $lang ['woman']; ?></option>
              </select>
          </div><br>


          <label class=""><?php echo $lang ['Address']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
              <input name="address" type="text" placeholder="" class="form-control" value="<?php echo $the_address; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['email']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input name="email" type="text" placeholder="" class="form-control" value="<?php echo $the_email; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['phone']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
              <input name="phone" type="text" placeholder="" class="form-control" value="<?php echo $the_phone; ?>"/>
          </div><br>      

          <button type="submit" name="updateinfo" class="mybtn mybtn-primary"><?php echo $lang ['save']; ?></button><br><br>
  
  
 </form>

 <hr>

<form id="formID2" action="" method="post">

          <div class="info_teachers"> 
          
              <label class=""><?php echo $lang ['new_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="new_pass" type="password" id="password" class="form-control validate[required]" value=""/>
              </div><br>

              <label class=""><?php echo $lang ['confirm_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password2" type="password" placeholder="" class="form-control validate[required,equals[password]]" value=""/>
              </div>
          </div><br>  

          <button type="submit" name="update_password" class="mybtn mybtn-primary"><?php echo $lang ['change_password']; ?></button><br>

</form>  <br><br>

<hr>
          <form id="" action="" method="post" class="center"> 

          <button type="submit" onclick="return confirm('<?php echo $lang ['delete_teacher']; ?> !')" name="submit_delete" class="btn btn-danger"><?php echo $lang ['delete_teacher']; ?></button><br>

          </form> <br><br>

</div>

<?php } ?> 











<?php 
if (isset($_GET['parent'])) {

$parent_index = htmlspecialchars($_GET['parent']);

$stmt_get_allInfo = $connect->prepare("SELECT * FROM parents_users WHERE parent_index=:parent_index ");
$stmt_get_allInfo->bindParam (':parent_index' , $parent_index , PDO::PARAM_STR );
$stmt_get_allInfo->execute();

if ($stmt_get_allInfo->rowCount() !== 1 ) {
  die("<div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_user_with_this_link']."</p></div><br><br>");
}

$row_allInfo = $stmt_get_allInfo->fetch();

$the_fullname = $row_allInfo ['full_name'];
$the_image = $row_allInfo ['image'];
$the_sex = $row_allInfo ['sex'];
$the_address = $row_allInfo ['address'];
$the_phone = $row_allInfo ['phone'];
$the_email = $row_allInfo ['email'];

/* --------------------------------------------------------------------------------*/


if (isset($_POST['updateinfo'])) {

  $parent_fullname = htmlspecialchars($_POST['full_name']);
  $parent_type = htmlspecialchars($_POST['type']);
  $parent_address = htmlspecialchars($_POST['address']);
  $parent_email = htmlspecialchars($_POST['email']);
  $parent_phone = htmlspecialchars($_POST['phone']);

  $parent_image = "article_img.jpg";


  $stmt_parent = $connect->prepare("UPDATE parents_users SET full_name=:full_name, image='$parent_image', email=:email, phone=:phone, sex=:sex, address=:address WHERE parent_index=:parent_index");
  $stmt_parent->bindParam (':full_name' , $parent_fullname , PDO::PARAM_STR );
  $stmt_parent->bindParam (':email' , $parent_email , PDO::PARAM_STR );
  $stmt_parent->bindParam (':phone' , $parent_phone , PDO::PARAM_STR );
  $stmt_parent->bindParam (':sex' , $parent_type , PDO::PARAM_STR );
  $stmt_parent->bindParam (':address' , $parent_address , PDO::PARAM_STR );
  $stmt_parent->bindParam (':parent_index' , $parent_index , PDO::PARAM_STR );
  $stmt_parent->execute();



  if (isset($stmt_parent)) {
       
    echo "<meta http-equiv='refresh' content='0; url = edit.php?parent=$parent_index&update=success' />"; 
    
  }

  else { 

     
    echo "<meta http-equiv='refresh' content='0; url = edit.php?parent=$parent_index&error=error' />"; 
  }
  
}


if (isset($_POST['update_password'])) {
   
  $new_pass = htmlspecialchars(md5($_POST['new_pass']));


      $stmt_update_pass = $connect->prepare("UPDATE parents_users SET password=:password WHERE parent_index=:parent_index");
      $stmt_update_pass->bindParam (':password' , $new_pass , PDO::PARAM_STR );
      $stmt_update_pass->bindParam (':parent_index' , $parent_index , PDO::PARAM_STR );
      $stmt_update_pass->execute();

      if (isset($stmt_update_pass)) {
           
        echo "<meta http-equiv='refresh' content='0; url = edit.php?parent=$parent_index&update=success' />"; 

      }

  else {
      
    echo "<meta http-equiv='refresh' content='0; url = edit.php?parent=$parent_index&error=error' />"; 
    
  }

}

if (isset($_POST['submit_delete'])) {
   
  $stmt_delete = $connect->prepare("DELETE FROM parents_users WHERE parent_index=:parent_index");
  $stmt_delete->bindParam (':parent_index' , $parent_index , PDO::PARAM_STR );
  $stmt_delete->execute();

  if (isset($stmt_delete)) {
    header ("location: parents.php");   
    echo "<meta http-equiv='refresh' content='0; url = parents.php' />"; 
  }

}  

?>

    <div class="clear"></div>

    <div class="row col-md-12 col-md-offset-0">


<form id="formID" action="" method="post">


          <label class=""><?php echo $lang ['full_name']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
              <input name="full_name" type="text" placeholder="" class="form-control validate[required]" value="<?php echo $the_fullname; ?>"/>
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


          <label class=""><?php echo $lang ['Address']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i></span>
              <input name="address" type="text" placeholder="" class="form-control" value="<?php echo $the_address; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['email']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
              <input name="email" type="text" placeholder="" class="form-control" value="<?php echo $the_email; ?>"/>
          </div><br>

          <label class=""><?php echo $lang ['phone']; ?> : </label>
          <div class="input-group">
              <span class="input-group-addon"><i class="glyphicon glyphicon-phone"></i></span>
              <input name="phone" type="text" placeholder="" class="form-control" value="<?php echo $the_phone; ?>"/>
          </div><br>      

          <button type="submit" name="updateinfo" class="mybtn mybtn-primary"><?php echo $lang ['save']; ?></button><br><br>
  
  
 </form>

 <hr>

<form id="formID2" action="" method="post">

          <div class="info_teachers"> 
          
              <label class=""><?php echo $lang ['new_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="new_pass" type="password" id="password" class="form-control validate[required]" value=""/>
              </div><br>

              <label class=""><?php echo $lang ['confirm_password']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
              <div class="input-group">
                  <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                  <input name="password2" type="password" placeholder="" class="form-control validate[required,equals[password]]" value=""/>
              </div>
          </div><br>  

          <button type="submit" name="update_password" class="mybtn mybtn-primary"><?php echo $lang ['change_password']; ?></button><br>

</form>  <br><br>

<hr>
          <form id="" action="" method="post" class="center"> 

          <button type="submit" onclick="return confirm('<?php echo $lang ['delete_parent']; ?> !')" name="submit_delete" class="btn btn-danger"><?php echo $lang ['delete_parent']; ?></button><br>

          </form> <br><br>

</div>

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
