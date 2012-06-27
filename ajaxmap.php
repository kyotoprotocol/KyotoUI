<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

include('admin/config.php');

//$_GET['direction']
$country = $_GET['country'];
$simID = $_GET['simid'];

$filename = "maps/code_to_coordinates.json";
$handle = fopen($filename, "r");
$contents = fread($handle, filesize($filename));
fclose($handle);
$countries = json_decode($contents);
unset($handle);
unset($contents);
unset($filename);

$filename = "maps/code_to_name.json";
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
        $array[] = (string)$data;
    return $array;
}

$jsonOut = array();

    if ($_GET['direction']=='all') {
        $tradeQ = new TradeModel();    // instantiate collection model
        $trades = $tradeQ->find(array('simID'=>$simID));
        $lines = array();
        foreach ($trades as $trade){
            $iso1 = $trade->getInitiator();
            $iso2 = $trade->getBroadcaster();
            // CHECK ISO1
            if (isset($lines[$iso1])){
                // ISO1 EXISTS
                    if (isset($lines[$iso1][$iso2])){
                        // ISO1 ISO2 EXISTS
                        $lines[$iso1][$iso2] += (int)$trade->getQuantity();
                    }else{
                        // DOES ISO2 ISO1 EXIST
                        if (isset($lines[$iso2][$iso1])){
                            //ISO2 ISO1 EXISTS
                            $lines[$iso2][$iso1] += (int)$trade->getQuantity();
                        } else {
                            // MAKE ISO1 ISO2
                            $lines[$iso1][$iso2] = (int)$trade->getQuantity();
                        }
                    }
            } else {
                // ISO1 DOESNT EXIST
                if (isset($lines[$iso1])){
                    //ISO2 EXISTS
                        if (isset($lines[$iso2][$iso1])){
                            //ISO2 ISO1 EXISTS
                                $lines[$iso2][$iso1] += (int)$trade->getQuantity();
                        } else {
                            //ISO2 ISO1 DOESNT EXIST
                                $lines[$iso1][$iso2] = (int)$trade->getQuantity();
                        }
                } else {
                    //ISO2 DOESNT EXIST
                            $lines[$iso1][$iso2] = (int)$trade->getQuantity();
                }
            }
        }
        
        //arsort($lines);
        //var_dump($lines);
        foreach ($lines as $key => $value){
            foreach ($value as $country => $cost) {
            /*   echo ' Country: '. 
                        (string)$country .' Country 2 '.
                        (string)$key .' Cost'.
                        (string)$cost['value'].'<br>';*/
                $jsonOut[$key] = generateFlightPathArray($country, $key, (int)$cost['value'], $countries, $names);
            }
        }
    } elseif (substr_count($_GET['direction'],'both')>0) {
        if (substr_count($_GET['direction'],'CDM')>0) {
            //CDM QUERIES
            $investType = 'ABSORB';
        } else {
            // CO2 QUERIES
            $investType = 'INVALID';
        }
        $tradeQ = new TradeModel();    // instantiate collection model
        $trades = $tradeQ->find(array('simID'=>$simID,'broadcaster'=>$country,'investmentType'=>$investType));
        $lines = array();
        foreach ($trades as $trade){
       // var_dump($trade);
            if (isset($lines[$trade->getInitiator()])){
                $lines[$trade->getInitiator()] += (int)$trade->getQuantity();
            } else {
                $lines[$trade->getInitiator()] = (int)$trade->getQuantity();
            }
        }
        unset($trades);
        $trades = $tradeQ->find(array('simID'=>$simID,'initiator'=>$country, 'investmentType'=>$investType));
        foreach ($trades as $trade){
        //var_dump($trades);
            if (isset($lines[$trade->getBroadcaster()])){
                $lines[$trade->getBroadcaster()] += (int)$trade->getQuantity();
            } else {
                $lines[$trade->getBroadcaster()] = (int)$trade->getQuantity();
            }
        }
        arsort($lines);
        foreach ($lines as $key => $value){
            $jsonOut[$key] = generateFlightPathArray($country, $key, (int)$value, $countries, $names);
        }
    } else {
        //
        // inCO2 outCO2 inCDM outCDM here!
        //
        $tradeQ = new TradeModel();    // instantiate collection model
        if (substr_count($_GET['direction'],'CDM')>0) {
            //CDM QUERIES
            $investType = 'ABSORB';
        } else {
            // CO2 QUERIES
            $investType = 'INVALID';
        }
        if (substr_count($_GET['direction'],'in')>0) {
            // INITIATOR QUERY
                        $trader = 'initiator';
        } elseif (substr_count($_GET['direction'],'out')>0) {
            // BROADCASTER QUERY
                        $trader = 'broadcaster';
        }
        $trades = $tradeQ->find(array('simID'=>$simID,$trader=>$country, 'investmentType'=>$investType));
        $lines = array();
        foreach ($trades as $trade){
            if (isset($lines[$trade->getInitiator()])){
                $lines[$trade->getInitiator()] += (int)$trade->getQuantity();
            } else {
                $lines[$trade->getInitiator()] = (int)$trade->getQuantity();
            }
        }
        arsort($lines);
        foreach ($lines as $key => $value){
            $jsonOut[$key] = generateFlightPathArray($country, $key, (int)$value, $countries, $names);
        }
   
    }

//var_dump($jsonOut);
header('content-type: application/json');
echo json_encode($jsonOut);

?>





