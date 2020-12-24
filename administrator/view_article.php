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

  $get_id = htmlspecialchars($_GET['id']);


  $stmt_topics = $connect->prepare("SELECT * FROM topics WHERE id=:id");
  $stmt_topics->bindParam (':id', $get_id , PDO::PARAM_STR);
  $stmt_topics->execute();

  if ($stmt_topics->rowCount() == 1) {
        $topics_row = $stmt_topics->fetch();
        $topic_title = $topics_row ['title'];
        $topic_img = $topics_row ['image'];

        echo '<title>'.$topic_title.'</title>';
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






<div class="container" style="margin-top: 80px;">
  <div class="row">

    <div class="col-md-12 container-1">

<br><a class="return" href="articles.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

<?php 

if (isset($_SESSION ['administrator'])) { ?>

<form action="" method="post">
<button onclick="return confirm('<?php echo $lang ['delete']; ?> !')" type="submit" name="delete_topic" class="btn btn-warning" style="float: right;">
<i class="glyphicon glyphicon-trash"></i> <?php echo $lang ['delete']; ?></button>
</form>

<?php 
  if (isset($_POST['delete_topic'])) {

      $delete_id = $_GET['id'];

      $stmt_delete = $connect->prepare("DELETE FROM topics WHERE id=:id");
      $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
      $stmt_delete->execute();

      if (!empty($topic_img)) {
        unlink("../uploads/topics/".$topic_img);
      }

      if (isset($stmt_delete)) { 
        header ("location: articles.php");
        echo "<meta http-equiv='refresh' content='0; url = articles.php' />";
      }


  } 

}

?>


<div class="clear"></div> 

<?php 

if (!isset($_GET['id'])) {
        die('<br><br><div class="alert alert-danger center" style="width: 90%; margin: auto;"><p>'.$lang ['sorry_There_is_no_topic_with_this_link'].'</p></div><br><br>');
    }

if (isset($_GET['id'])) {

  $get_id = htmlspecialchars($_GET['id']);


  $stmt_topics = $connect->prepare("SELECT * FROM topics WHERE id=:id");
  $stmt_topics->bindParam (':id', $get_id , PDO::PARAM_STR);
  $stmt_topics->execute();

  if ($stmt_topics->rowCount() != 1) {
        die('<br><br><div class="alert alert-danger center" style="width: 90%; margin: auto;"><p>'.$lang ['sorry_There_is_no_topic_with_this_link'].'</p></div><br><br>');
    }


  $topics_row = $stmt_topics->fetch();

  $topic_id = $topics_row ['id'];
  $topic_title = $topics_row ['title'];
  $topic_topic = htmlspecialchars_decode($topics_row ['topic']) ;
  $topic_image = $topics_row ['image'];
  $topic_date = $topics_row ['date'];

 ?>

            <div class="single">

                <div class="single_header">

                  <h2><?php echo $topic_title; ?></h2>  

                  <span><i class="glyphicon glyphicon-time"></i> <?php echo $topic_date; ?></span>
                  
                </div>

                <div class="clear"></div>

                 <br>
                <div class="row">
                  <div class="col-md-12">
                    <p><?php echo $topic_topic; ?></p>
                  </div>
                </div>

                <div class="clear"></div> 

          </div>
<?php 

if (isset($_GET['comment_delete']) && isset($_GET['token']) ) {

  if (isset($_SESSION ['admin_index'])) {

    $delete_id = $_GET['comment_delete'];

    if ($_GET['token'] == $_SESSION['token']) {

      $stmt_delete = $connect->prepare("DELETE FROM comments WHERE id=:id AND article_id=:article_id");
      $stmt_delete->bindParam (':id' , $delete_id , PDO::PARAM_STR );
      $stmt_delete->bindParam (':article_id' , $get_id , PDO::PARAM_STR );
      $stmt_delete->execute();

      if (isset($stmt_delete)) {
        echo "<meta http-equiv='refresh' content='0; url = view_article.php?id=".$get_id."' />";
      }
      
    }

  }

}



/* ------------------------------------------------- */



$stmt_comments = $connect->prepare("SELECT * FROM comments WHERE article_id=:article_id");
$stmt_comments->bindParam (':article_id', $get_id , PDO::PARAM_STR);
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


if ($comment_type == 'admin') {
$stmt_comments_author = $connect->query("SELECT * FROM index_users WHERE index_num='$comment_author'");
$comments_author_row = $stmt_comments_author->fetch();
$comments_author_name = $comments_author_row ['full_name'] ;

$comments_author_img = '../images/icons/school.png';

}

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
        <a href="view_article.php?id=<?php echo $get_id; ?>&comment_delete=<?php echo $comment_id; ?>&token=<?php echo $_SESSION ['token']; ?>" class="btn btn-danger"><?php echo $lang ['delete']; ?></a>  <span class="label label-default"><?php echo $comment_date; ?></span> 
      </div>

</div>



<?php } } ?>

<div class="clear"></div>




<?php 

if (isset($_POST['submit'])) {
   
  $comment = htmlspecialchars($_POST['comment']);

  $comment_date = date("d/m/Y");

  $author = $_SESSION ['admin_index'];


   $stmt_comment = $connect->prepare("INSERT INTO comments (comment, type, author, article_id, comment_date) VALUES (:comment, 'admin', '$author', :article_id, '$comment_date')");
  $stmt_comment->bindParam (':comment' , $comment , PDO::PARAM_STR );
  $stmt_comment->bindParam (':article_id' , $get_id , PDO::PARAM_STR );
  $stmt_comment->execute();

  if (isset($stmt_comment)) {
    echo "<meta http-equiv='refresh' content='1; url = view_article.php?id=".$get_id."' />";

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



<?php } ?><br>

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
