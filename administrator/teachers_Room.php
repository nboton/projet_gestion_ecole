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

    <title><?php echo $lang ['teachers Room']; ?></title>

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
     <link rel="stylesheet" href="../fonts/arabic/droid.css">

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




<div class="container content" style="margin-top:130px;">

<br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>

<a href="add_article_formateurs.php" class="btn btn-success new_lesson"><i class="glyphicon glyphicon-pencil"></i> <?php echo $lang ['new_topic']; ?></a>

<div class="clear"></div>

    <h1 class="h1_title"><?php echo $lang ['teachers Room']; ?></h1>
    <hr>

  <div class="row">
    <div class="col-md-12">


<?php 

if (!isset($_GET ['page'])) {
  $page = 1 ;
}

else 
  $page = (int)$_GET['page'];


$stmt_get = $connect->query("SELECT * FROM control");
$row = $stmt_get->fetch();

$records_at_page = $row ['pagination'];

$count_sql = $connect->query ("SELECT * FROM topics_formateurs");
$records_count = $count_sql->rowCount();


$pages_count = (int)ceil($records_count / $records_at_page);

if (($page > $pages_count) || ($page <= 0 )) {
  die('<br><br><br><div class="alert alert-info center" style="width: 90%; margin: auto"><p class="ar-font">'.$lang ['Nothing_found_404_articles'].'</p></div><br><br><br>') ;
}

$start = ($page - 1) * $records_at_page ;
$end = $records_at_page ;




/****************************************************************
****************************************************************/
if ($records_count != 0) {

      $stmt_topics = $connect->prepare("SELECT * FROM topics_formateurs ORDER BY id DESC LIMIT $start, $end");
      $stmt_topics->execute();


      while ($topics_row = $stmt_topics->fetch()) {
        $topic_id = $topics_row ['id'];
        $topic_title = $topics_row ['title'];
        $topic_topic = htmlspecialchars_decode($topics_row ['topic']);
        $topic_image = $topics_row ['image'];
        $topic_date = $topics_row ['date'];

       ?>
          <div class="single">

                <div class="single_header">

                  <h2><a href="view_article_formateurs.php?id=<?php echo $topic_id; ?>"><?php echo $topic_title; ?></a></h2>  

                  <span><i class="glyphicon glyphicon-time"></i> <?php echo $topic_date; ?></span>
                  

                </div>

                <div class="clear"></div>

                 <br>
                <div class="row">
                    <div class="col-md-2">
                      <a href="view_article_formateurs.php?id=<?php echo $topic_id; ?>">
                         <?php 

                         if (!empty($topic_image)) {
                          echo '<img src="../uploads/topics/'.$topic_image.'" alt="..." class="thumbnail" height="" width="100%">';
                        }

                        if (empty($topic_image)) {
                         echo '<img src="../uploads/topics/article_img.jpg" alt="..." class="thumbnail" height="100%" width="100%">'; 
                        } 

                        ?> 
                      </a>
                  </div>

                  <div class="col-md-10">
                    <p class="p_substr"><?php echo substr(strip_tags($topic_topic), 0, 400); ?> </p>
                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <div class="clear"></div>

      <?php } 
} ?>

<br>
<div class="container">
<?php 
$next = $page + 1 ;
$prev = $page - 1 ;

if ($next <= $pages_count) {
  echo '<a href="articles.php?page=' . $next . '" class="btn btn-default p_right">'.$lang ['next'].' <i class="glyphicon glyphicon-arrow-right"></i></a>' ;
}

if ($prev > 0) {
  echo '<a href="articles.php?page=' . $prev . '" class="btn btn-default p_left"><i class="glyphicon glyphicon-arrow-left"></i> '.$lang ['prev'].'</a>' ;
}
 ?>
</div>
<br>


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
