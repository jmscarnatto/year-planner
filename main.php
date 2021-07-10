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

$this_day_number = date("d");
$this_month_number = date("m");
$holidays = array();

get_holidays(); 
$weekend_columns = array(1,7,8,14,15,21,22,28,29,35,36);
$days_tags = array("S","M","T","W","T","F","S");
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

for ($week=1; $week<=5;$week++) 
{ 
    for ($x=0; $x<=6; $x++) //Recorre el array $days_tags
    {  
        $HTML .= "<li class='dias' >".$days_tags[$x]."</li>";
    } 
}  

$HTML .= "<li class='dias'>S</li><li class='dias'>M</li></ul>";
$numDay = 1; 

for ($month=0; $month<=11;$month++)
{ 
    $HTML.="<ul><li width=17 align='center' class='meses'>".$months_names[$month]."</li>"; 
    for ($w=1; $w<=37;$w++)
    {
        if ($w<$first_day_number_of_month[$month] || $w>($days_in_month[$month]-1 + $first_day_number_of_month[$month])) 
        { 
            $HTML.="<li class='vacios'></li>"; 
        } else 
        { 
            $loop_day = $w + 1 - $first_day_number_of_month[$month];  
            // $thisNewDay = "#".($month + 1)."/".$loop_day."/".$current_year."#"; 
            $this_day_name = jddayofweek(cal_to_jd(CAL_GREGORIAN,($month + 1),$loop_day,$current_year),2); 
            if($loop_day<10) 
            { 
                $day_id= $months_names[$month]."0".$loop_day; 
            } else
            { 
                $day_id= $months_names[$month].$loop_day;
            } 
            $HTML.="<li id='".$day_id."' "; 
            if($this_day_name=="Sat" || $this_day_name=="Sun")
            { 
                $HTML.="name='".$this_day_name."' "; 
            } else
            { 
                $HTML.="name='".$numDay."' ";
            } 
            $HTML.= "class='".set_format($w,$month,$loop_day).$loop_day."</li>"; 
            $numDay++;
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

function days_on_month($month_number) 
{ 
    global $current_year; 
    return(jddayofweek(cal_to_jd(CAL_GREGORIAN,$month_number,1,$current_year),0))+1; 
}  

function set_format($num_col, $num_month, $num_day) 
{
    global $weekend_columns, $this_day_number, $this_month_number, $holidays; $class = "normal'>"; 
    for ($i=0;$i<=10;$i++) 
    { 
        if ($num_col == $weekend_columns[$i]) 
        { 
            $class ="finde'>";  
        } 
    }  
    for ($i=0;$i<=sizeof($holidays);$i++)
    {  
        if ($num_month == substr($holidays[$i],0,2)-1 && $num_day == substr($holidays[$i],2)) 
        { 
            $class = "feriado'>";
        }          
    }
    if ($num_day == $this_day_number && $num_month == ($this_month_number-1)) 
    { 
            $class = "hoje'>";
    } 
    return $class; 
}  

function get_holidays() 
{ 
    global $holidays; 
    $Doc = new DOMDocument(); 
    $Doc->load("xml/holidays.xml");
    $root = $Doc->getElementsByTagName( "feriado" ); 
    $counter = 0; 
    foreach ($root AS $item) 
    { 
        $holidays[$counter] = $item->getAttribute('code'); 
        $counter++;
    } 
    return $holidays; 
}  

?> 
