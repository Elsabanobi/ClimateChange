<?php
    $lat=$lon="";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      
      $lat = $_POST['lat'];
      $lon = $_POST['lon'];
     
    }
    
    $urlweer = "https://api.openweathermap.org/data/2.5/air_pollution?lat=".  $lat . "&amp;lon=". $lon . "&amp;appid=HERE YOUR OWN KEY";
    $weer = file_get_contents(htmlspecialchars_decode($urlweer));
    $weather = json_decode($weer, true, 5);
    $urlweert = "https://api.openweathermap.org/data/2.5/weather?lat=".  $lat . "&amp;lon=". $lon . "&amp;units=metric&amp;appid=HERE YOUR OWN KEY";
    $weert = file_get_contents(htmlspecialchars_decode($urlweert));
    $weathert = json_decode($weert, true, 5);
    $urlweerf = "https://api.openweathermap.org/data/2.5/onecall?lat=".  $lat . "&amp;lon=". $lon . "&amp;exclude=daily&amp;units=metric&amp;appid=HERE YOUR OWN KEY";
    $weerf = file_get_contents(htmlspecialchars_decode($urlweerf));
    $weatherf = json_decode($weerf, true, 6);



$countrycode = $weathert["sys"]["country"];   
$cityname = $weathert["name"]; 
$timestamp= $weathert["dt"];
$maint = $weathert["main"]["temp"];  
$mainp = $weathert["main"]["pressure"]; 
$mainh = $weathert["main"]["humidity"];
$sunrise = $weathert["sys"]["sunrise"]   ;
$sunset = $weathert["sys"]["sunset"]  ;
$rain1 = $weatherf["minutely"][1]["precipitation"];
$uvi1 = $weatherf["current"]["uvi"];

if (empty($lat)) { echo "you have not yet given the coordinates" . "<br>" . "...  °C " . "<br>" .  "... hPa pressure" . "<br>" . "... % humidity " ;} else { echo  "<br>" . "In " . $countrycode . ", " . $cityname . " it is today " . "<br>" . date(" j F Y, g:i a", $timestamp) . ":" . "<br>";  


echo '<span class="temp" >';
echo $maint ; 
echo '</span>';
echo "  °C " ; 
echo "<br>"; 
echo $mainp ; 
echo " hPa pressure " ; 
echo "<br>" ; 
echo $mainh; 
echo " % humidity " ; } ;
echo "<br>";  
echo "The sun rises at " ;
echo '<span class="day" >'; 
echo date(" g:i a", $sunrise) ;
echo '</span>';   
echo "<br>" ;
echo " and goes down at " ;
echo '<span class="day" >';
echo date(" g:i a", $sunset) ;
echo '</span>';   
echo "<br>";


 


$rain1 = $weatherf["minutely"][0]["precipitation"];
$uvi1 = $weatherf["current"]["uvi"];
echo "Chance on rain: " ; 
echo '<span class="rain" >';
echo $rain1 ;
echo '</span>'; 
echo " (0 → 1)" ;  
echo "<br>" ;
echo "Risk on UV damage: " ; 
echo '<span class="sun" >';
echo $uvi1  ;
echo '</span>'; 
echo " (0 → 11+)" ;
echo "<br>" ;
echo "<br>";


echo "The air quality is : " ;
$level = $weather ["list"][0]["main"]["aqi"];
  switch ($level) {
  case 1:
    echo '<div id="goed">Good</div>';
    break;
  case 2:
    echo '<div id="redelijk">Reasonable</div>';
    break;
  case 3:
    echo '<div id="matig">Moderate</div>';
    break;
  case 4:
    echo '<div id="slecht">Bad</div>';
    break;
  case 5:
    echo '<div id="heelslecht">Very bad</div>';
    break;
  default:
    echo "no diagnose yet " . "<br>";
}


$amountCO = $weather ["list"][0]["components"]["co"]; 
$amountNO = $weather ["list"][0]["components"]["no"];
$amountNO2 = $weather ["list"][0]["components"]["no2"];
$amountO3 = $weather ["list"][0]["components"]["o3"];
$amountSO2 = $weather ["list"][0]["components"]["so2"];
$amountPM2 = $weather ["list"][0]["components"]["pm2_5"];
$amountPM10 = $weather ["list"][0]["components"]["pm10"];
$amountNH3 = $weather ["list"][0]["components"]["nh3"];
echo "in μg/m3: " .  " Carbon monoxide:" . $amountCO .  " Nitrogen mon/dioxide:" . $amountNO .  " /" . $amountNO2 .  " Ozone:" . $amountO3 . "<br>";
echo  " Sulphur dioxide:" . $amountSO2  . " Fine particles:" . $amountPM2  . " Coarse particules:" . $amountPM10 .  " Ammonia:" . $amountNH3 ;
echo "<br>";

$now2 = $weatherf["hourly"][2]["dt"];
$now6 = $weatherf["hourly"][6]["dt"];
$t2 = $weatherf["hourly"][2]["temp"];  
$t6 = $weatherf["hourly"][6]["temp"]; 
$descr2 = $weatherf["hourly"][2]["weather"][0]["description"];
$descr6 = $weatherf["hourly"][6]["weather"][0]["description"];
$rain2 = $weatherf["hourly"][2]["pop"];
$rain6 = $weatherf["hourly"][6]["pop"];
$uvi2 = $weatherf["hourly"][2]["uvi"];
$uvi6 = $weatherf["hourly"][6]["uvi"];
$alerts = $weatherf["alerts"]["description"];

echo "<br>";
echo "At " ; 
echo date(" g:i a", $now2) ; 
echo " it will be " ;
echo '<span class="temp" >'; 
echo $t2 ;
echo '</span>'; 
echo " °C with " ; 
echo $descr2 ;
echo "<br>"; 
echo "Chance on rain: " ;
echo '<span class="rain" >'; 
echo $rain2 ; 
echo '</span>';
echo ". Risk on UV damage: " ;
echo '<span class="sun" >'; 
echo $uvi2  ;
echo '</span>'; 
echo "<br>" ;
echo "Om " ; 
echo date(" g:i a", $now6) ; 
echo " it will be " ;
echo '<span class="temp" >'; 
echo $t6 ; 
echo '</span>';
echo " °C with " ; 
echo $descr6 ; 
echo "<br>";
echo "Chance on rain: " ;
echo '<span class="rain" >'; 
echo $rain6 ;
echo '</span>';
echo ". Risk on UV damage: " ;
echo '<span class="sun" >'; 
echo $uvi6  ;
echo '</span>';
echo "<br>" ;
echo  $alerts;

?> 
