
<div class="nav">

	<div class="navbar navbar-default navbar-fixed-top">
      
        <div class="container">
          
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">    
                        <span class="sr-only">Toggle navigation</span>      
                        <span class="icon-bar"></span>  
                        <span class="icon-bar"></span>  
                        <span class="icon-bar"></span>          
                </button> 

            <a href="index.php"><img  width="60" height="60" src="../logo.png" alt=""><big></big></a>

           </div>

            <div class="collapse navbar-collapse nav_right">
                                        
				<div class="btn-group">
				  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <?php echo $lang ['language']; ?> <span class="caret"></span>
				  </button>

				  <ul class="dropdown-menu">
				    <form id="language" action="" method="post">
				    
                        <li><input type="submit" name="fr" class="francais" value="francais" /></li>
                        <li><input type="submit" name="en" class="english" value="english" /></li>
					</form>			
				  </ul>

				</div>

				<a class="btn btn-danger" href="logout.php?token=<?php echo $_SESSION ['token']; ?>" style="font-size:12px;"><?php echo $lang ['logout']; if (isset($_SESSION['francais'])) { echo ' <i class="glyphicon glyphicon-share-alt"></i>';} if (isset($_SESSION['arabic'])) { echo ' <i class="glyphicon glyphicon-arrow-left"></i>';} ?>  </a>

             </div>

        </div>

    </div>

</div>

<div class="clear"></div>




