<?php
require_once("config.php");
session_start();
if(!isset($_SESSION['auth']))
    header("Location: login.php");
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
    
    
     
    <script>
        $(document).ready(function(){
            
            
            updateAll();
            
            $("#updateinfos").on("click",function(e){
                updateAll();
            });
            
            $("#resetapache").on("click",function(e){
               
                $("#overlay").css("display","block");
                 $("#fade").css("display","block");
                resetApache();
            });
            
            
        });
        
        
        function updateAll(){
            
            getNameServer();
            getDescServer();
            getTemp();
            getCpuLoad();
            getFrequency();
            getUptime();
            getMemory();
            getDiskInfo();
            getLog();
        
        }
        
        
        function resetApache(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"resetApache"
                },
                success:function(data){
                    console.log(data);
                },
                error:function(a,b,c){
                    console.log(a+b+c);
                },
                complete:function(){
                    checkconnect();
                }
            }); 
        
        
        }
        
        
        
        function checkconnect(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"checkconnect"
                },
                success:function(data,status){
                    
                $("#overlay").css("display","none");
                 $("#fade").css("display","none");
                    updateAll();
                },
                error:function(){
                    checkconnect();
                }
            });    
        }
        
        function getNameServer(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"nameserver"
                },
                success:function(data,status){
                    $("#nameserver").html(data);
                }
            });    
        }
        
        function getLog(){
            
             $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"getLog"
                },
                success:function(data,status){
                    $("#log").val(data);
                }
            });   
            
            
        }
        
        
        function getLogApache(){
            
             $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"getLogApache"
                },
                success:function(data,status){
                    $("#apachelog").val(data);
                }
            });   
            
            
        }
        function getDescServer(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"description"
                },
                success:function(data,status){
                    $("#descrizioneserver").html(data);
                }
            });   
            
        }
        
        function getTemp(){
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"temp"
                },
                success:function(data,status){
                    $("#tempcpu").html("gradi<span>"+data+"<em>o</em>C</span>");
                }
            }); 
        }
        
        
        function getCpuLoad(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"cpuload"
                },
                success:function(data,status){
                    $("#cpuload").html("<i class='typcn typcn-film'></i> "+data+"%");
                }
            }); 
            
        }
        
        
        function getFrequency(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"frequency"
                },
                success:function(data,status){
                    $("#frequency").html("<i class='typcn typcn-flash-outline'></i> "+data+" Mhz</a>");
                }
            }); 
            
        }
        
        
        function getUptime(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"uptime"
                },
                success:function(data,status){
                    $("#uptime").html("<i class='typcn typcn-time'></i> "+data+"</a>");
                }
            }); 
            
        }
        
        
        function getMemory(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"getmemory"
                },
                success:function(dataa,status){
                    var data = jQuery.parseJSON(dataa);
                    console.log(data);
                    var percused= data.usedpercent;
                    var percfree= data.freepercent;
                    var percbuffer= data.percentbuff;
                    var perccach= data.percentcach;
                    var swapused= data.usedswappercent;
                    var swapfree= data.freeswappercent;
                    $("#ramused").html(percused+"<em>%</em>");
                    $("#ramfree").html(percfree+"<em>%</em>");
                    $("#rambufferized").html(percbuffer+"<em>%</em>");
                    $("#ramchac").html(perccach+"<em>%</em>");
                    $("#swapused").html(swapused+"<em>%</em>");
                    $("#swapfree").html(swapfree+"<em>%</em>");
                    
                    var datamemoria = [
                            {
                                value: percused,
                                color:"#E64C65"
                            },
                            
                            {
                                value : percfree,
                                color : "#4FC4F6"
                            },	
                            {
                                value : percbuffer,
                                color : "#11A8AB"
                            },	
                            {
                                value : perccach,
                                color : "#FCB150"
                            },							
                            
                        ];		
                        
                        $('#graphmemoryram').html('<canvas id="chart" width="220" height="220"></canvas>');
                        var ctx = $('#chart').get(0).getContext("2d");
                        var myNewChart =new Chart(ctx).Doughnut(datamemoria);	
                        
                        
                        
                       
                        
                        
                         var datamemoria = [
                            {
                                value: swapused,
                                color:"#E64C65"
                            },
                            {
                                value : swapfree,
                                color : "#11A8AB"
                            },								
                            
                        ];	
                    
                      $('#swapgraph').html('<canvas id="chart2" width="220" height="220"></canvas>');
                        
                         var ctx = $('#chart2').get(0).getContext("2d");
                        var myNewChart =new Chart(ctx).Doughnut(datamemoria);	
                        
                        
                        }
                        
                        
                        
              }); 
                        
         }
        
        
        
        function getDiskInfo(){
            
            $.ajax({
                url:"functions.php",
                type:"POST",
                data:{
                    action:"getdiskinfo"
                },
                success:function(dataa,status){
                     var data = jQuery.parseJSON(dataa);
                    var ret="";
                    
                    
                    for (var key in data) {
                       var obj = data[key];
                      
                            ret+='<li><div class="progress"><div class="progress-bar" style="width:'+obj.percfree+'%">'+obj.percfree+'%</div></div><div class="clearfix"><p class="downloading"> <i class="fa fa-hdd-o"></i> '+obj.typex+'</p><p class="percentage">'+obj.avail+'</p><div class="clear"></div></div></li>';
                       
                    }
                    
                    
                    $("#listdisk").html(ret);
                    
                   
                }
            }); 
            
        }
                        
                        
                        
    </script>
    <style type=”text/css”>
  
#fade {
    display: none;  /* ensures it’s invisible until it’s called */
    position: absolute;  /* makes the div go into a position that’s absolute to the browser viewing area */
    left: 0%; /* makes the div span all the way across the viewing area */
    top: 0%; /* makes the div span all the way across the viewing area */
    background: rgba(0,0,0,0.7);
    width: 100%;
    height: 100%;
    z-index: 99; /* makes the div the second most top layer, so it’ll lay on top of everything else EXCEPT for divs with a higher z-index (meaning the #overlay ruleset) */
}
</style>
</head>
<body>		
    

<div id=”fade”></div>    
<div id="overlay" class="column_right_grid downloading_uploading" style="display: none;position: absolute;  left: 25%; top: 25%; width: 50%; height: 50%; z-index: 100; " ><h3>Caricamento in corso...</h3></div>
    
    
    
    <div class="wrap">	 
        <div class="header">
            <div class="header_top">
                <div class="menu">
                    <a class="toggleMenu" href="#"><img src="images/nav.png" alt="" /></a>
                    <ul class="nav">
                        <li id="updateinfos"><a href="#" ><i class="typcn typcn-arrow-sync-outline"></i> Aggiorna</a></li>
                        <li><a href="filemanager.php"><i class="fa fa-folder-open"></i> File Manager</a></li>
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
    <div class="main">  
        <div class="wrap">  		 
            <div class="column_left">
                <div class="chart">
                    <h3>Memoria RAM</h3>
                    <div class="diagram" id="graphmemoryram">
                        <canvas id="canvas" height="220" width="220"> </canvas>
                    </div>
                    
                    <!----		              
<span><img src="images/chart.png" alt="" /></span>
----->					
                    <div class="chart_list">
                        <ul>
                            <li><a href="#" class="red">Utilizzata<p class="percentage" id="ramused"></p></a></li>
                            <li><a href="#" class="blue">Libera<p class="percentage" id="ramfree"></p></a></li>
                            <li><a href="#" class="purple">Buffered<p class="percentage" id="rambufferized"></p></a></li>
                            <li><a href="#" class="yellow">Cached<p class="percentage" id="ramchac"></p></a></li>
                            <div class="clear"></div>	
                        </ul>
                    </div>
                </div>
                
                
                <div class="chart">
                    <h3>Swap</h3>
                    <div class="diagram" id="swapgraph">
                        <canvas id="canvas2" height="220" width="220"> </canvas>  
                    </div>
                    
                    <!----		              
<span><img src="images/chart.png" alt="" /></span>
----->					
                    <div class="chart_list">
                        <ul>
                            <li><a href="#" class="red">Usata<p class="percentage" id="swapused"></p></a></li>
                            <li><a href="#" class="purple">Libera<p class="percentage" id="swapfree"></p></a></li>
                            <div class="clear"></div>	
                        </ul>
                    </div>
                  
                </div>
                
                
                
                
                
                
            </div> 
            
            <div class="column_middle">
                <div class="column_middle_grid1">
                    <div class="profile_picture">
                        <a href=""><img src="images/Raspberry-Pi-logo.png" alt="" />	</a>		         
                        <div class="profile_picture_name">
                            <h2 id="nameserver"></h2>
                            <p id="descrizioneserver"></p>
                        </div>
                    </div>
                    <div class="articles_list">
                        <ul>
                            <li ><a href="#" class="red" id="cpuload" > </a></li>
                            <li><a href="#" class="purple" id="frequency"> </a></li>
                            <li><a href="#" class="yellow" id="uptime"></a></li>
                            <div class="clear"></div>	
                        </ul>
                    </div>
                </div>
                
                
                <div class="tweets">
                    <h3><i class="typcn typcn-document-text"></i> Ultimo Log</h3>		              
                    <div class="tweets_list">
                        <ul>
                            <li>
                                <textarea style="width:100%; min-height:200px; background:rgba(255,255,255,0); border:none; color:#fff;" id="log"></textarea>
                                <span id="datalog"><?php echo date("d/m/Y") ; ?></span>
                            </li>
                        </ul>
                    </div>
                </div>           
                
            </div>
            
            <div class="column_right">
                <div class="weather">
                    <h3><i><img src="images/tempicon.png" alt="" /> </i> Temperatura</h3>
                    <div class="today_temp">
                        <div class="temp">
                            <figure id="tempcpu"></figure>
                        </div>
                    </div>
                </div>
                
                
                <div class="column_right_grid downloading_uploading">
                    <h3>
                        Spazio Libero
                    </h3>
                    <ul id="listdisk">
                    </ul>
                </div>
                
                
                
            </div>
            <div class="clear"></div>
        </div>
    </div>  
   
</body>
</html>

