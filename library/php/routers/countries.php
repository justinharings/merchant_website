<?php
if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
{
    $ip = $_SERVER['HTTP_CLIENT_IP'];
}
else if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
{
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
}
else 
{
    $ip = $_SERVER['REMOTE_ADDR'];
}

function iptocountry($ip) 
{
    $numbers = preg_split( "/\./", $ip);
    
    include($_SERVER['DOCUMENT_ROOT'] . "/library/third-party/ip-to-country/".$numbers[0].".php");
    
    $code=($numbers[0] * 16777216) + ($numbers[1] * 65536) + ($numbers[2] * 256) + ($numbers[3]);    
    
    foreach($ranges as $key => $value)
    {
        if($key <= $code)
        {
	        if($ranges[$key][0] >= $code)
	        {
		        $country = $ranges[$key][1];
		        break;
		    }
        }
    }
    
    if ($country=="")
    {
	    $country = "unknown";
	}
    
    return $country;
}

switch($_country_code)
{
	case "GB":
		$_country_code = "EN";
	break;
	
	case "US":
		$_country_code = "EN";
	break;
}

$_country_code = iptocountry($ip);
?>