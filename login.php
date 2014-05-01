<?php

require_once("config.php");

if(isset($_POST['nickname'])){
    $check = checkUser($_POST['nickname'],$_POST['password']);
    if($check) header("Location: index.php");
}

?>

<!DOCTYPE HTML>
<head>
    <title>Raspberry Web Panel</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
    <link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
    <link href='http://fonts.googleapis.com/css?family=Carrois+Gothic+SC' rel='stylesheet' type='text/css'>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/login.js"></script>
    <script type="text/javascript" src="js/Chart.js"></script>
    <script type="text/javascript" src="js/jquery.easing.js"></script>
    <script type="text/javascript" src="js/jquery.ulslide.js"></script>
    <!----Calender -------->
    <link rel="stylesheet" href="css/clndr.css" type="text/css" />
    <script src="js/underscore-min.js"></script>
    <script src= "js/moment-2.2.1.js"></script>
    <script src="js/clndr.js"></script>
    <script src="js/site.js"></script>
    
    
    
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel='stylesheet' href='css/typicons.min.css' />
    <!----End Calender -------->
</head>
<body>	
    <div class="main">  
        <div class="wrap">  		 
            <div class="column_left">
               
                 <div class="profile_picture">
                        <a href="#"><img src="images/Raspberry-Pi-logo.png" alt="" />	</a>		         
                        <div class="profile_picture_name">
                            <h2>Raspberry Web Panel</h2>
                            <p>Developed by Blackswan</p>
                        </div>
                    </div>
                
            </div> 
            
            <div class="column_middle">
               
                <div class="column_middle_grid1">
                     <div class="column_right_grid sign-in">
				 	<div class="sign_in">
				       <h3>Accedi con il tuo account</h3>
					    <form method="post">
					    	<span>
					 	   <input type="text" name="nickname" placeholder="Nome Utente">
					 	    </span>
					 	    <span>
					 	     
					 	     <input type="password" name="password" placeholder="Password">
					 	    </span>
					 		<input type="submit" class="my-button" value="Accedi">
					 	</form>				   
          		       </div>
				   </div>
                </div>
                
                           
                
            </div>
            
            <div class="column_right">
              
               
            </div>
            <div class="clear"></div>
        </div>
    </div>  
</body>
</html>

