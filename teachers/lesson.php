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

    <?php 

    if (isset($_GET['id'])) {

  $lesson_id = $_GET['id'];

    $stmt_lessons = $connect->prepare("SELECT * FROM lessons WHERE lesson_id='$lesson_id'");
    $stmt_lessons->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
    $stmt_lessons->execute();
  

      if ($stmt_lessons->rowCount() == 1 ) {
            $title = $stmt_lessons->fetch();

            echo '<title>'.$title ['title'].'</title>';
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

<?php 
if (!isset($_GET['id'])) {
  die("<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Nothing_found_404']."</p></div><br><br>");

}
 ?>

<br><a class="return" href="lessons.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>


<?php 


if (isset($_GET['id'])) {
    $lesson_id = $_GET['id'];
}


$stmt_get_info = $connect->query("SELECT * FROM teachers_users WHERE teacher_index='$my_teacher_index' ");
$row_get_info = $stmt_get_info->fetch();
$my_name = $row_get_info ['full_name'];



    $stmt_lessons = $connect->prepare("SELECT * FROM lessons WHERE lesson_id='$lesson_id' AND author='$my_name'");
    $stmt_lessons->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
    $stmt_lessons->execute();
    $stmt_lessons_row = $stmt_lessons->fetch();

    if ($stmt_lessons->rowCount() == 1) {  ?>

<form action="" method="post">
<button type="submit" onclick="return confirm('<?php echo $lang ['delete']; ?> !')" name="delete_topic" class="btn btn-warning" style="float: right;"><i class="glyphicon glyphicon-trash"></i> <?php echo $lang ['delete'] ?></button>
</form>
<?php

      $fetch_lesson_id = $stmt_lessons_row ['lesson_id'];
      $fetch_lesson_title = $stmt_lessons_row ['title'];
      $fetch_lesson_content = htmlspecialchars_decode($stmt_lessons_row ['lesson']) ;
      $fetch_lesson_author = $stmt_lessons_row ['author'];
      $fetch_lesson_subject = $stmt_lessons_row ['subject'];
      $fetch_lesson_date = $stmt_lessons_row ['date'];
      $fetch_lesson_jointe = $stmt_lessons_row ['jointes'];




/*----------- delete lessons ----------*/

  if (isset($_POST['delete_topic'])) {

      $delete_id = $_GET['id'];

      $stmt_delete = $connect->prepare("DELETE FROM lessons WHERE lesson_id=:lesson_id");
      $stmt_delete->bindParam (':lesson_id' , $delete_id , PDO::PARAM_STR );
      $stmt_delete->execute();

      if (isset($stmt_delete)) { 

        if (!empty($fetch_lesson_jointe)) {
          unlink("../uploads/lessons/".$fetch_lesson_jointe);
        }

        header ("location: lessons.php");
        echo "<meta http-equiv='refresh' content='0; url = lessons.php' />";
      }


  } 


      
?>

          <div class="clear"></div>
          <div class="single">

                <div class="single_header">

                  <h2><?php echo $fetch_lesson_title; ?></h2>  

                  <span><i class="glyphicon glyphicon-book"></i> <?php echo $fetch_lesson_subject; ?></span>
                  <span><i class="glyphicon glyphicon-user"></i> <?php echo $fetch_lesson_author; ?></span>
                  <span><i class="glyphicon glyphicon-time"></i> <?php echo $fetch_lesson_date; ?></span>
                  
                </div>

                <div class="clear"></div>

                 <br>
                <div class="row">
                  <div class="col-md-12">
                  <?php 
                  if (!empty($fetch_lesson_jointe)) {
                    echo '<div class="alert alert-success center jointe col-md-6 col-md-offset-3">
  <span class="glyphicon glyphicon glyphicon-open"></span>
  <a href="../uploads/lessons/'.$fetch_lesson_jointe.'">'. $lang ['Download_the_attached_file'] .'</a>
</div><div class="clear"></div>';
                  } 
                  ?>
                

                    <p class="p_substr" style="padding : 5px;"><?php echo substr(strip_tags($fetch_lesson_content), 0, 400); ?>  </p>
                  
                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <br>



<?php 

if (isset($_GET['comment_delete']) && isset($_GET['token']) ) {

  if (isset($_SESSION ['teacher_index'])) {

    $delete_id = $_GET['comment_delete'];

    if ($_GET['token'] == $_SESSION['token']) {

      $stmt_delete = $connect->prepare("DELETE FROM comments_lessons WHERE id=:id AND lesson_id=:lesson_id");
      $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
      $stmt_delete->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
      $stmt_delete->execute();

      if (isset($stmt_delete)) {
        echo "<meta http-equiv='refresh' content='0; url = lesson.php?id=".$lesson_id."' />";
      }
      
    }

  }

}



/* ------------------------------------------------- */



$stmt_comments = $connect->prepare("SELECT * FROM comments_lessons WHERE lesson_id=:lesson_id");
$stmt_comments->bindParam (':lesson_id', $lesson_id , PDO::PARAM_STR);
$stmt_comments->execute();

$comments_count = $stmt_comments->rowCount();

  if ($comments_count >= 1) {


 ?>

<div class="clear"></div>
<br>
<h1 class="h1_title2" style="width: 100%"><?php echo $lang ['comments']; ?></h1>
<hr>

<?php 

while ($comments_row = $stmt_comments->fetch()) {
   
$comment_id = $comments_row ['id'];
$comment_type = $comments_row ['type'];
$comment_content = $comments_row ['comment'];
$comment_author = $comments_row ['author'];
$comment_date = $comments_row ['comment_date'];



if ($comment_type == 'teacher') {
$stmt_comments_author = $connect->query("SELECT * FROM index_users WHERE index_num='$comment_author'");
$comments_author_row = $stmt_comments_author->fetch();
$comments_author_name = $comments_author_row ['full_name'] ;

$comments_author_img = '../uploads/teachers/no_image.jpg';

}

if ($comment_type == 'student') {
$stmt_comments_author = $connect->query("SELECT * FROM index_users WHERE index_num='$comment_author'");
$comments_author_row = $stmt_comments_author->fetch();
$comments_author_name = $comments_author_row ['full_name'] ;

$comments_author_img = '../images/icons/student.png';

}


 ?>

<div class="media">
      <div class="media-left">
          <img src="<?php echo $comments_author_img; ?>" style="width: 64px; height: 64px;" class="media-object" alt="64x64">
      </div>
      <div class="media-body">
        <h4 class="media-heading"><?php echo $comments_author_name; ?></h4>
        <p><?php echo $comment_content; ?></p>
        <a href="lesson.php?id=<?php echo $lesson_id; ?>&comment_delete=<?php echo $comment_id; ?>&token=<?php echo $_SESSION ['token']; ?>" class="btn btn-danger"><?php echo $lang ['delete']; ?></a>  <span class="label label-default"><?php echo $comment_date; ?></span> 
      </div>

</div>



<?php } } ?>

<div class="clear"></div>




<?php 

if (isset($_POST['submit'])) {
   
  $comment = htmlspecialchars($_POST['comment']);

  $comment_date = date("d/m/Y");

  $author = $_SESSION ['teacher_index'];


   $stmt_comment = $connect->prepare("INSERT INTO comments_lessons (comment, type, author, lesson_id, comment_date) VALUES (:comment, 'teacher', '$author', :lesson_id, '$comment_date')");
  $stmt_comment->bindParam (':comment' , $comment , PDO::PARAM_STR );
  $stmt_comment->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
  $stmt_comment->execute();

  if (isset($stmt_comment)) {
    echo "<meta http-equiv='refresh' content='1; url = lesson.php?id=".$lesson_id."' />";

  }




 }
 ?>


<hr>

<form id="formID" method="post" action="">

     <div class="input-group">
        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
        <textarea class="form-control validate[required]"  rows="5" name="comment" placeholder=""></textarea>
        </div><br>

        <div class="clear"></div>
              
        <button type="submit" name="submit" class="btn btn-warning btn-lg"><?php echo $lang ['comment']; ?></button> 

        <br><br>

    </form>





<?php 
    }
    else {
        echo "<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['Nothing_found_404']."</p></div><br><br>";
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
