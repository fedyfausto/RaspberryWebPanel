<?php


//ACTIVE LOG
$logactive=true;
//URL of Log
$today = date("d_m_Y"); 
$logfile = $today."_log.txt"; 
$logurl="../logs_event/".$logfile;
$GLOBALS['logurl']=$logurl;
$GLOBALS['logactive']=$logactive;

//Users
$GLOBALS['users']=$users;
$users[0]['nickname']="root";
$users[0]['password']=""; //INSERT MD5 PASS HERE






function checkUser($nickname,$password){
    $ret = false;
    $arrlength=count($GLOBALS['users']);

    for($x=0;$x<$arrlength;$x++) {
      if($GLOBALS['users'][$x]['nickname']==$nickname && $GLOBALS['users'][$x]['password']==md5($password))
          $ret=true;

    }
    
    
    if($ret){
       session_start();
        $_SESSION['auth']=true;
        $_SESSION['nickname']=$nickname;
        return true;
    }
    else return false;
}



?>