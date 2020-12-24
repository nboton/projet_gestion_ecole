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

    <title><?php echo $lang ['new_topic']; ?></title>

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

      <link rel="stylesheet" href="../libs/cleditor/jquery.cleditor.css" />

      <script type="text/javascript" src="../js/jquery-1.11.3.min.js"></script>

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
          jQuery("#articleForm").validationEngine();
        });
 
      </script>
        
  </head>

<body>

<?php include 'nav.php'; ?> 


<div class="container mainbg">

      <br><a class="return" href="articles.php"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

          <h1 class="h1_title"><?php echo $lang ['new_topic']; ?></h1>

          <hr>

<?php 

if (isset($_POST['submit'])) {

  $article_title = htmlspecialchars($_POST['title']);
  $article_content = htmlspecialchars($_POST['article']);
  $article_date = date("d-m-Y");


  if (!empty($_FILES["topic_img"]["name"])) {

  $size = 1000 * 1024;
  $target = dirname(__DIR__)."/uploads/topics/";
  // an array of allowed extensions
  $allowedExts = array("gif", "jpeg", "jpg", "png","GIF","JPEG","JPG","PNG");
  $temp = explode(".", $_FILES["topic_img"]["name"]);
  $extension = end($temp);

  if ((($_FILES["topic_img"]["type"] == "image/gif")
    || ($_FILES["topic_img"]["type"] == "image/jpeg")
    || ($_FILES["topic_img"]["type"] == "image/jpg")
    || ($_FILES["topic_img"]["type"] == "image/pjpeg")
    || ($_FILES["topic_img"]["type"] == "image/x-png")
    || ($_FILES["topic_img"]["type"] == "image/png"))
    && ($_FILES["topic_img"]["size"] < $size ) && in_array($extension, $allowedExts)) {

      if ($_FILES["topic_img"]["error"] > 0) {
        echo "<div class='alert alert-danger'><p class='center'>".$lang ['An_error_in_the_picture']."</p></div>";
      }
      else {
        $topic_img = round(microtime(true)) . '.' . end($temp);
        move_uploaded_file($_FILES["topic_img"]["tmp_name"], $target . $topic_img);

        $stmt_article = $connect->prepare("INSERT INTO topics (title, topic, image, date) VALUES (:title, :topic, '$topic_img', '$article_date')");
        $stmt_article->bindParam (':title' , $article_title , PDO::PARAM_STR );
        $stmt_article->bindParam (':topic' , $article_content , PDO::PARAM_STR );
        $stmt_article->execute();
      }
    }
     else {
      echo "<div class='alert alert-danger'><p class='center'>".$lang ['An_error_in_the_picture']."</p></div>";
    }

}

else {
    $stmt_article = $connect->prepare("INSERT INTO topics (title, topic, date) VALUES (:title, :topic, '$article_date')");
    $stmt_article->bindParam (':title' , $article_title , PDO::PARAM_STR );
    $stmt_article->bindParam (':topic' , $article_content , PDO::PARAM_STR );
    $stmt_article->execute();
}


  if (isset($stmt_article)) {
    header ("location: add_article.php?article=success");   
    echo "<meta http-equiv='refresh' content='0; url = add_article.php?article=error' />";
    
  }

  
}

/**************************************************************/


if (isset($_GET['article']) == "success") {
  echo "<meta http-equiv='refresh' content='2; url = articles.php' />";
  die("<br><br><div class='alert alert-success center' style='width: 90%; margin: auto;'><p>".$lang ['The_article_has_been_added_successfully']."</p></div><br><br>") ;
}



?>

<div class="clear"></div>
        
      <div class="row col-md-10 col-md-offset-1">

        <form id="articleForm" action="" method="post" enctype="multipart/form-data">

                    <label class=""><?php echo $lang ['title']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                    <div class="input-group">
                        <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                        <input name="title" type="text" placeholder="" class="form-control validate[required]" value="<?php echo htmlspecialchars(!empty($_POST['title'])) ? htmlspecialchars($_POST['title']) : ''?>"/>
                    </div><br>

                    <label class=""><?php echo $lang ['picture']; ?> : </label>
                    <input name="topic_img" type="file" class="btn btn-default" />
                    <br>

                   <label class=""><?php echo $lang ['topic']; ?> : <span style="color:red; font-weight: bold; font-family: Arial, sans-serif ;">(*)</span></label>
                <br>
                  <textarea class="form-control validate[required]" id="cleditor" name="article" placeholder=""><?php echo htmlspecialchars(!empty($_POST['article'])) ? htmlspecialchars($_POST['article']) : ''?></textarea>
                <br>

                <hr>

                <button type="submit" name="submit" class="mybtn mybtn-success btn-block"><?php echo $lang ['publish']; ?></button>
  
          </form>

          <br><br>

      </div>

      <div class="clear"></div> 
       
</div>    

</script>
                           
 <?php include 'footer.php'; ?>             

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/docs.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script src="../libs/cleditor/jquery.cleditor.min.js"></script>
    <script>
       $(document).ready(function () { $("#cleditor").cleditor(); });
    </script>

  </body>
</html>
