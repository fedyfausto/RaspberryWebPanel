<?php
require_once("config.php");
session_start();
if(!isset($_SESSION['auth']))
    header("Location: login.php");
else
     header("Location: editor/");
?>