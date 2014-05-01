<?php

require_once("config.php");
session_start();
if(isset($_POST['action']) && isset($_SESSION['auth'])){
    switch($_POST['action']){
        case "nameserver":
        $system;
        $host;
        $kernel;
        list($system, $host, $kernel) = systemInfo();
        echo $host;
        break;
        
        case "description":
        $system;
        $host;
        $kernel;
        list($system, $host, $kernel) = systemInfo();
        echo ($system." ".$kernel);
        break;
        
        case "temp":
        echo (getTemp());
        break;
        
        case "cpuload":
        echo (cpuUsage());
        break;
        case "frequency":
        echo (frequencyCPU());
        break;
        case "uptime":
        echo (getUpTime());
        break;
        
        case "getmemory":
        
        echo json_encode(getMemoryInfo());
        break;
        
        case "getdiskinfo":
        
        echo json_encode(getDiskInfo());
        break;
        
        case "getLog":
        
        echo getLastLog();
        break;
        
        case "resetApache":
        resetApache();
        echo true;
        break;
        
        case "resetServer":
        resetServer();
        echo true;
        break;
        
        case "checkconnect":
        
        echo true;
        break;
        
        case "getLogApache":
        
        echo getApacheLog();
        break;
    }
}
else{
    header("Location: login.php");
}





function getLastLog(){
    if($GLOBALS['logactive'])
        return @file_get_contents($GLOBALS['logurl']);
}
function getApacheLog(){return(exec("cat /var/log/apache2/error.log") );}

function NumberWithCommas($in)
{
    return number_format($in);
}
function  WriteToStdOut($text)
{
    $stdout = fopen('php://stdout','w') or die($php_errormsg);
    fputs($stdout, "\n" . $text);
}

function resetApache(){ exec("/usr/bin/sudo /usr/bin/service apache2 restart");}
function resetServer(){ exec("sudo reboot");}
function timeServer(){return ($current_time = exec("date +'%d %b %Y<br />%T %Z'")); }


function frequencyCPU(){return(NumberWithCommas(exec("cat /sys/devices/system/cpu/cpu0/cpufreq/scaling_cur_freq") / 1000));}



function getProcessor(){return(str_replace("-compatible processor", "", explode(": ", exec("cat /proc/cpuinfo | grep Processor"))[1]));}


function getTemp() {return(round(exec("cat /sys/class/thermal/thermal_zone0/temp ") / 1000, 1));}

//$RX = exec("ifconfig eth0 | grep 'RX bytes'| cut -d: -f2 | cut -d' ' -f1");
//$TX = exec("ifconfig eth0 | grep 'TX bytes'| cut -d: -f3 | cut -d' ' -f1");
function systemInfo(){return (split(" ", exec("uname -a"), 4));}




//Uptime

function getUpTime(){
    
    $uptime_array = explode(" ", exec("cat /proc/uptime"));
    $seconds = round($uptime_array[0], 0);
    $minutes = $seconds / 60;
    $hours = $minutes / 60;
    $days = floor($hours / 24);
    $hours = sprintf('%02d', floor($hours - ($days * 24)));
    $minutes = sprintf('%02d', floor($minutes - ($days * 24 * 60) - ($hours * 60)));
    if ($days == 0):
    $uptime = $hours . ":" .  $minutes . "";
    elseif($days == 1):
    $uptime = $days . " d, " .  $hours . ":" .  $minutes . "";
    else:
    $uptime = $days . " d, " .  $hours . ":" .  $minutes . "";
    endif;
    
    return $uptime;
    
}





function cpuUsage(){
    //CPU Usage
    $output1 = null;
    $output2 = null;
    //First sample
    exec("cat /proc/stat", $output1);
    //Sleep before second sample
    sleep(1);
    //Second sample
    exec("cat /proc/stat", $output2);
    $cpuload = 0;
    for ($i=0; $i < 1; $i++)
    {
        //First row
        $cpu_stat_1 = explode(" ", $output1[$i+1]);
        $cpu_stat_2 = explode(" ", $output2[$i+1]);
        //Init arrays
        $info1 = array("user"=>$cpu_stat_1[1], "nice"=>$cpu_stat_1[2], "system"=>$cpu_stat_1[3], "idle"=>$cpu_stat_1[4]);
        $info2 = array("user"=>$cpu_stat_2[1], "nice"=>$cpu_stat_2[2], "system"=>$cpu_stat_2[3], "idle"=>$cpu_stat_2[4]);
        $idlesum = $info2["idle"] - $info1["idle"] + $info2["system"] - $info1["system"];
        $sum1 = array_sum($info1);
        $sum2 = array_sum($info2);
        //Calculate the cpu usage as a percent
        $load = (1 - ($idlesum / ($sum2 - $sum1))) * 100;
        $cpuload += $load;
    }
    $cpuload = round($cpuload, 1); //One decimal place
    return  $cpuload;
    
}









function getMemoryInfo(){
    
    $meminfo = file("/proc/meminfo");
    for ($i = 0; $i < count($meminfo); $i++)
    {
        list($item, $data) = split(":", $meminfo[$i], 2);
        $item = trim(chop($item));
        $data = intval(preg_replace("/[^0-9]/", "", trim(chop($data)))); //Remove non numeric characters
        switch($item)
        {
            case "MemTotal": $total_mem = $data; break;
            case "MemFree": $free_mem = $data; break;
            case "SwapTotal": $total_swap = $data; break;
            case "SwapFree": $free_swap = $data; break;
            case "Buffers": $buffer_mem = $data; break;
            case "Cached": $cache_mem = $data; break;
            default: break;
        }
    }
    $arr["total"]=$total_mem ;
    $arr["used"]=$used_mem = $total_mem - $free_mem;
    $arr["usedswap"]=$used_swap = $total_swap - $free_swap;
    $arr["freepercent"]= $percent_free = round(($free_mem / $total_mem) * 100);
    $arr["usedpercent"]=$percent_used = round(($used_mem / $total_mem) * 100);
    $arr["usedswappercent"]=$percent_swap = round((($total_swap - $free_swap ) / $total_swap) * 100);
    $arr["freeswappercent"]= $percent_swap_free = round(($free_swap / $total_swap) * 100);
    $arr["percentbuff"]= $percent_buff = round(($buffer_mem / $total_mem) * 100);
    $arr["percentcach"]= $percent_cach = round(($cache_mem / $total_mem) * 100);
    $used_mem = NumberWithCommas($used_mem);
    $used_swap = NumberWithCommas($used_swap);
    $total_mem = NumberWithCommas($total_mem);
    $free_mem = NumberWithCommas($free_mem);
    $total_swap = NumberWithCommas($total_swap);
    $free_swap = NumberWithCommas($free_swap);
    $buffer_mem = NumberWithCommas($buffer_mem);
    $cache_mem = NumberWithCommas($cache_mem);
    
    return $arr;
    
}





//Disk space check

function getDiskInfo(){
    $arr;
    exec("df -T -l -BM -x tmpfs -x devtmpfs -x rootfs", $diskfree);
    $count = 1;
    while ($count < sizeof($diskfree))
    {
        list($drive[$count], $typex[$count], $size[$count], $used[$count], $avail[$count], $percent[$count], $mount[$count]) = split(" +", $diskfree[$count]);
        $percent_part[$count] = str_replace( "%", "", $percent[$count]);
        $arr[$count]['drive']=$drive[$count];
        $arr[$count]['typex']=$typex[$count];
        $arr[$count]['size']=$size[$count];
        $arr[$count]['used']=$used[$count];
        $arr[$count]['avail']=$avail[$count];
        $arr[$count]['percent']=$percent[$count];
        $arr[$count]['mount']=$mount[$count];
        $arr[$count]['percfree']=round(($arr[$count]['avail'] / $arr[$count]['size']) * 100);
        $count++;
        
    }
    return $arr;
    
}


?>