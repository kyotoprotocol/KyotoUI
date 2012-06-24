<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

define ("DB", "presage");
define ("SIMTREE", "simulations");
define ("LOCAL_HOST", "127.0.0.1:27017");
include('../libs/mongorecord/BaseMongoRecord.php');
include('../models/TradeModel.php');
session_start();
if(isset($_SESSION['database'])) {
    if($_SESSION['database']=='remote') {
        define ("HOST", REMOTE_HOST);
    } else {
        $_SESSION['database']='local';
        define ("HOST", LOCAL_HOST);
    }
} else {
        $_SESSION['database']='local';
        define ("HOST", LOCAL_HOST);    
}

try {
BaseMongoRecord::$connection = new Mongo(HOST);
BaseMongoRecord::$database = 'presage';
    } catch(MongoConnectionException $e) {
        //var_dump($e);
    }


// INCLUDE CONFIG LATER
//$_GET['direction']
$country = $_GET['country'];
$simID = $_GET['simid'];

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
        $array[] = (string)$data;
    return $array;
}

$jsonOut = array();

    if ($_GET['direction']=='all') {
        $tradeQ = new TradeModel();    // instantiate collection model
        $trades = $tradeQ->find(array('simID'=>$simID));
        $lines = array();
        foreach ($trades as $trade){
            if (isset($lines[$trade->getInitiator()][$trade->getBroadcaster()])){
                $lines[$trade->getInitiator()][$trade->getBroadcaster()]['value'] += (int)$trade->getQuantity();
            } else {
                $lines[$trade->getInitiator()][$trade->getBroadcaster()]['value'] = (int)$trade->getQuantity();
            }
        }
        arsort($lines);
        foreach ($lines as $key => $value){
            foreach ($value as $country => $cost) {
                $jsonOut[$key] = generateFlightPathArray($country, $key, (int)$cost, $countries, $names);
            }
        }
    } else {
        $tradeQ = new TradeModel();    // instantiate collection model
        $trades = $tradeQ->find(array('simID'=>$simID,'broadcaster'=>$country));
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





