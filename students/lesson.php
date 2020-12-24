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

<?php 

if (isset($_GET['id'])) {
    $lesson_id = $_GET['id'];


    $stmt_lessons = $connect->prepare("SELECT * FROM lessons WHERE lesson_id='$lesson_id'");
    $stmt_lessons->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
    $stmt_lessons->execute();

  if ($stmt_lessons->rowCount() == 1 ) {

    $stmt_lessons_row = $stmt_lessons->fetch();

        echo '<title>'.$stmt_lessons_row ['title'].'</title>';
    }

    else { echo '<title>404</title>'; }

} 

?>

  
<link href="../css/bootstrap.min.css" rel="stylesheet"> 
<link href="../css/bootstrap-theme.min.css" rel="stylesheet">
<link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">
<script src="../js/ie-emulation-modes-warning.js"></script>
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

    $stmt_lessons = $connect->prepare("SELECT * FROM lessons WHERE lesson_id='$lesson_id' AND class='$my_class'");
    $stmt_lessons->bindParam (':lesson_id' , $lesson_id , PDO::PARAM_STR );
    $stmt_lessons->execute();
    $stmt_lessons_row = $stmt_lessons->fetch();

    if ($stmt_lessons->rowCount() == 1) {

      $fetch_lesson_id = $stmt_lessons_row ['lesson_id'];
      $fetch_lesson_title = $stmt_lessons_row ['title'];
      $fetch_lesson_content = htmlspecialchars_decode($stmt_lessons_row ['lesson']);
      $fetch_lesson_author = $stmt_lessons_row ['author'];
      $fetch_lesson_subject = $stmt_lessons_row ['subject'];
      $fetch_lesson_date = $stmt_lessons_row ['date'];
      $fetch_lesson_jointe = $stmt_lessons_row ['jointes'];
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
                    <p><?php echo $fetch_lesson_content; ?></p>

                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <br>






<?php 




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
        <span class="label label-default"><?php echo $comment_date; ?></span> 
      </div>

</div>



<?php } } ?>

<div class="clear"></div>




<?php 

if (isset($_POST['submit'])) {
   
  $comment = htmlspecialchars($_POST['comment']);

  $comment_date = date("d/m/Y");

  $author = $_SESSION ['student_index'];


   $stmt_comment = $connect->prepare("INSERT INTO comments_lessons (comment, type, author, lesson_id, comment_date) VALUES (:comment, 'student', '$author', :lesson_id, '$comment_date')");
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
        echo "<br><br><div class='alert alert-danger center' style='width: 90%; margin: auto;'><p>".$lang ['sorry_There_is_no_topic_with_this_link']."</p></div><br><br>";
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
