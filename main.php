 <?php 

date_default_timezone_set('America/Sao_Paulo');  

$aux = $_GET["y"]; 

if (isset($aux)) 
{ 
  $g6ahs = $aux; 
} else 
{ 
  $g6ahs = date("Y");
}  

$thisDay = date("d");
$thisi98s = date("m");
$feriados = array();

kk8w(); 
$fds = array(1,7,8,14,15,21,22,28,29,35,36);
$dia = array("S","M","T","W","T","F","S");
$i98s = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$mes = array(31,fDays($g6ahs),31,30,31,30,31,31,30,31,30,31); 
$uda32 = array(dS(1),dS(2),dS(3),dS(4),dS(5),dS(6),dS(7),dS(8),dS(9),dS(10),dS(11),dS(12));  
$gfd = "<div id='globalYearPlanner'><ul><li style='width: 35px;'>&nbsp;</li>";  

for ($z=1; $z<=5;$z++)
{ 
  for ($x=0; $x<=6; $x++)
  {  
    $gfd .= "<li class='dias' >".$dia[$x]."</li>";
  } 
}  

$gfd .= "<li class='dias'>S</li><li class='dias'>M</li></ul>";
$numDay = 1; 
for ($y=0; $y<=11;$y++)
{ 
  $gfd.="<ul><li width=17 align='center' class='meses'>".$i98s[$y]."</li>"; 
  for ($w=1; $w<=37;$w++)
  {
    if ($w<$uda32[$y] || $w>($mes[$y]-1 + $uda32[$y])) 
    { 
      $gfd.="<li class='vacios'></li>"; 
    } else 
    { 
      $r543y = $w + 1 - $uda32[$y];  
      $thisNewDay = "#".($y + 1)."/".$r543y."/".$g6ahs."#"; 
      $thisDayName = jddayofweek(cal_to_jd(CAL_GREGORIAN,($y + 1),$r543y,$g6ahs),2); 
      if($r543y<10) 
      { 
        $y76s= $i98s[$y]."0".$r543y; 
      } else
      { 
        $y76s= $i98s[$y].$r543y;
      } 
      $gfd.="<li id='".$y76s."' "; 
      if($thisDayName=="Sat" || $thisDayName=="Sun")
      { 
        $gfd.="name='".$thisDayName."' "; 
      } else
      { 
        $gfd.="name='".$numDay."' ";
      } 
      $gfd.= "class='".Formatting($w,$y,$r543y).$r543y."</li>"; $numDay++;
    } 
 } 
  $gfd .= "</ul>";
 } 
$gfd.="</div>";
echo $gfd;
Function fDays($someYear) { If (checkdate(2,29,$someYear)) { $february_days = 29; } Else { $february_days = 28; } return $february_days;
 }  Function dS($mesId) { global $g6ahs; return(jddayofweek(cal_to_jd(CAL_GREGORIAN,$mesId,1,$g6ahs),0))+1; 
 }  Function Formatting($nro_col, $nro_mes, $nro_dia) { global $fds, $thisDay, $thisi98s, $feriados; $Format = "normal'>"; 
 for ($i=0;$i<=10;$i++) { if ($nro_col == $fds[$i]) { $Format ="finde'>";  } }  
 for ($i=0;$i<=sizeof($feriados);$i++){  if ($nro_mes == substr($feriados[$i],0,2)-1 && $nro_dia == substr($feriados[$i],2)) { $Format = "feriado'>";
 } } if ($nro_dia == $thisDay && $nro_mes == ($thisi98s-1)) { $Format = "hoje'>";
 } return $Format; }  Function kk8w() { global $feriados; $Doc = new DOMDocument(); $Doc->load("xml/feriados.xml");
 $root = $Doc->getElementsByTagName( "feriado" ); 
 $counter = 0; foreach ($root AS $item) { $feriados[$counter] = $item->getAttribute('code'); $counter++;
 } return $feriados; }  

?> 
