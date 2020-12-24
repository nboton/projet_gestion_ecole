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




 ?><!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.png" />



  
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



<br><a class="return" href="index.php" style="margin-left:20px;"><i class="glyphicon glyphicon-arrow-left"></i> <?php echo $lang ['return']; ?></a>


<div class="clear"></div>
          <div class="single">

                <div class="single_header">

                  <h2>demande de retirer le diplome du bac</h2>  
                </div>

                   <div class="clear"></div>

                 <br>
                <div class="row">
                  <div class="col-md-12">
                 <div class="alert alert-success center jointe col-md-6 col-md-offset-3">
                    <span class="glyphicon glyphicon glyphicon-open"></span>
       <a href="../uploads/lessons/retirer_dep.doc">telecharger le document</a>
                 </div><div class="clear"></div>
                  
                  
                  

                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <br>





<div class="clear"></div>
          <div class="single">

                <div class="single_header">

                  <h2>demande de certificat de scolarité</h2>  
                </div>

                   <div class="clear"></div>

                 <br>
                <div class="row">
                  <div class="col-md-12">
                 <div class="alert alert-success center jointe col-md-6 col-md-offset-3">
                    <span class="glyphicon glyphicon glyphicon-open"></span>
       <a href="../uploads/lessons/certificat_sco.doc">telecharger le document</a>
                 </div><div class="clear"></div>
                  
                  
                  

                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <br>




<div class="clear"></div>
          <div class="single">

                <div class="single_header">

                  <h2>demande d'autorisation d'abscence</h2>  
                </div>

                   <div class="clear"></div>

                 <br>
                <div class="row">
                  <div class="col-md-12">
                 <div class="alert alert-success center jointe col-md-6 col-md-offset-3">
                    <span class="glyphicon glyphicon glyphicon-open"></span>
       <a href="../uploads/lessons/abscence.doc">telecharger le document</a>
                 </div><div class="clear"></div>
                  
                  
                  

                  </div>
                </div>

                <div class="clear"></div> 

          </div>
          <br>
                           
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
