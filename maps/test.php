<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//$_GET['direction']
//$_GET['countries'];

$filename = "code_to_coordinates.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$countries = json_decode($contents);
unset($handle);
unset($contents);
unset($filename);

$filename = "code_to_name.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$names = json_decode($contents);



// Made by JW so use with caution. Makes an array item to bridge a link between 
function generateFlightPathArray($origin, $remote, $data, $jsoncountries, $names) {
        //$origin = $countries->$test[0].' '.$countries->USA[1];
        //$origin = call_user_func(array($jsoncountries, $origin));
        reset($jsoncountries->$origin);
        $originx = current($jsoncountries->$origin);
        $originy = next($jsoncountries->$origin);

        reset($jsoncountries->$remote);
        $remotex = current($jsoncountries->$remote);
        $remotey = next($jsoncountries->$remote);

        $width  = abs((int)$originx - (int)$remotex);
        $height = abs((int)$originy - (int)$remotey);
        
        $width  = min(array($remotex, $originx))+($width/2);
        $height = min(array($remotey, $originy))+0.3*($height/2);
        
        $array[] = 'M '. (int)$originx . ' ' . (int)$originy . ' Q ' . (int)$width . ' ' .  (int)$height . ' ' . (int)$remotex . ' ' . (int)$remotey . ' ';
        $array[] = $names->$remote;
        $array[] = $data;
    return $array;
}

$test['USA'] = generateFlightPathArray('ESP', 'USA', '999999', $countries, $names);
$test['GRL'] = generateFlightPathArray('ESP', 'GRL', '999999', $countries, $names);
$test['AUS'] = generateFlightPathArray('ESP', 'AUS', '999999', $countries, $names);

echo json_encode($test);

?>





