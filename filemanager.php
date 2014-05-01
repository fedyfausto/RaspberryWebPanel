<?php
require_once("config.php");
session_start();
if(!isset($_SESSION['auth']))
    header("Location: login.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>Raspberry Web Panel</title>
        
        <!-- jQuery and jQuery UI (REQUIRED) -->
        <link rel="stylesheet" type="text/css" media="screen" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css">
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/jquery-ui.min.js"></script>
        
        <!-- elFinder CSS (REQUIRED) -->
        <link href="css/style.css" rel="stylesheet" type="text/css" media="all"/>
        <link href="css/nav.css" rel="stylesheet" type="text/css" media="all"/>
        <link rel="stylesheet" type="text/css" media="screen" href="css/elfinder.min.css">
        <link rel="stylesheet" type="text/css" media="screen" href="css/theme.css">
        <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css">
    <link rel='stylesheet' href='css/typicons.min.css' />
        
        <!-- elFinder JS (REQUIRED) -->
        <script type="text/javascript" src="js/elfinder.min.js"></script>
        
        <!-- elFinder translation (OPTIONAL) -->
        <script type="text/javascript" src="js/i18n/elfinder.ru.js"></script>
        
        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">
            $().ready(function() {
                var elf = $('#elfinder').elfinder({
                    url : 'php/connector.php'  // connector URL (REQUIRED)
                    // lang: 'ru',             // language (OPTIONAL)
                }).elfinder('instance');
            });
        </script>
    </head>
    <body>
        <div class="wrap">	 
            <div class="header">
                <div class="header_top">
                    <div class="menu">
                        <a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
                        <ul class="nav">
                            <li ><a href="index.php" ><i class="fa fa-tachometer"></i> Dashboard</a></li>
                            <li><a href="editorweb.php"><i class="fa fa-pencil"></i> Editor Web</a></li>
                            <!--<li id="resetapache"><a href="#"><i class="typcn typcn-eject"></i> Riavvia Apache</a></li>
<li><a href="#"><i class="typcn typcn-eject-outline"></i> Riavvia Server</a></li>-->
                            <div class="clear"></div>
                        </ul>
                        <script type="text/javascript" src="js/responsive-nav.js"></script>
                    </div>		
                    <div class="clear"></div>				 
                </div>
            </div>	  					     
        </div>
        <div class="clear"></div>
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="elfinder" style="margin:20px;"></div>
        
    </body>
</html>
