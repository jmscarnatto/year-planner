 <?php 

date_default_timezone_set('America/Sao_Paulo');  

$requested_year = $_GET["y"]; 

if (isset($requested_year)) 
{ 
  $current_year = $requested_year; 
} else 
{ 
  $current_year = date("Y");
}  

$thisDay = date("d");
$thisMonth = date("m");
$feriados = array();

holidays(); 
$fds = array(1,7,8,14,15,21,22,28,29,35,36);
$dia = array("S","M","T","W","T","F","S");
$months_names = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
$days_in_month = array(31,february_days($current_year),31,30,31,30,31,31,30,31,30,31); 
$first_day_number_of_month = array(
                days_on_month(1),
                days_on_month(2),
                days_on_month(3),
                days_on_month(4),
                days_on_month(5),
                days_on_month(6),
                days_on_month(7),
                days_on_month(8),
                days_on_month(9),
                days_on_month(10),
                days_on_month(11),
                days_on_month(12)
                );  
$HTML = "<div id='globalYearPlanner'><ul><li style='width: 35px;'>&nbsp;</li>";  

for ($z=1; $z<=5;$z++)
{ 
    for ($x=0; $x<=6; $x++)
    {  
        $HTML .= "<li class='dias' >".$dia[$x]."</li>";
    } 
}  

$HTML .= "<li class='dias'>S</li><li class='dias'>M</li></ul>";
$numDay = 1; 
for ($y=0; $y<=11;$y++)
{ 
    $HTML.="<ul><li width=17 align='center' class='meses'>".$months_names[$y]."</li>"; 
    for ($w=1; $w<=37;$w++)
    {
        if ($w<$first_day_number_of_month[$y] || $w>($days_in_month[$y]-1 + $first_day_number_of_month[$y])) 
        { 
            $HTML.="<li class='vacios'></li>"; 
        } else 
        { 
            $r543y = $w + 1 - $first_day_number_of_month[$y];  
            $thisNewDay = "#".($y + 1)."/".$r543y."/".$current_year."#"; 
            $thisDayName = jddayofweek(cal_to_jd(CAL_GREGORIAN,($y + 1),$r543y,$current_year),2); 
            if($r543y<10) 
            { 
                $y76s= $months_names[$y]."0".$r543y; 
            } else
            { 
                $y76s= $months_names[$y].$r543y;
            } 
            $HTML.="<li id='".$y76s."' "; 
            if($thisDayName=="Sat" || $thisDayName=="Sun")
            { 
                $HTML.="name='".$thisDayName."' "; 
            } else
            { 
                $HTML.="name='".$numDay."' ";
            } 
            $HTML.= "class='".Formatting($w,$y,$r543y).$r543y."</li>"; $numDay++;
        } 
    } 
    $HTML .= "</ul>";
} 
$HTML.="</div>";
echo $HTML;

function february_days($some_year) 
{ 
    if (checkdate(2,29,$some_year)) 
    { 
        return 29; 
    } else 
    { 
        return 28; 
    } 
 }  

function days_on_month($mesId) 
{ 
    global $current_year; 
    return(jddayofweek(cal_to_jd(CAL_GREGORIAN,$mesId,1,$current_year),0))+1; 
}  

function Formatting($nro_col, $nro_mes, $nro_dia) 
{
    global $fds, $thisDay, $thisMonth, $feriados; $Format = "normal'>"; 
    for ($i=0;$i<=10;$i++) 
    { 
        if ($nro_col == $fds[$i]) 
        { 
            $Format ="finde'>";  
        } 
    }  
    for ($i=0;$i<=sizeof($feriados);$i++)
    {  
        if ($nro_mes == substr($feriados[$i],0,2)-1 && $nro_dia == substr($feriados[$i],2)) 
        { 
            $Format = "feriado'>";
        }          
    }
    if ($nro_dia == $thisDay && $nro_mes == ($thisMonth-1)) 
    { 
            $Format = "hoje'>";
    } 
    return $Format; 
}  

function holidays() 
{ 
    global $feriados; 
    $Doc = new DOMDocument(); 
    $Doc->load("xml/feriados.xml");
    $root = $Doc->getElementsByTagName( "feriado" ); 
    $counter = 0; 
    foreach ($root AS $item) 
    { 
        $feriados[$counter] = $item->getAttribute('code'); 
        $counter++;
    } 
    return $feriados; 
}  

?> 
