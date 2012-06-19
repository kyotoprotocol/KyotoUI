<?php
/*
 * Handles all ajax requests to the backend
 */
include('admin/config.php');

$simulation = new SimulationModel();    // instantiate collection model
if (isset($_GET['simid'])) {
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
} else {
    var_dump('failed'); die();
}
    $initialCarbonOutput = 0;
switch ($_GET['func']) {
    case 'load' :
        //$attributes = $sim->getAttributes();
        $countries = $sim->getCountries();
        //$output = $attributes;
        $output = array();
        
        foreach ($countries as $c) {            // package countries to contain all relevant data
            $output['countries'][$c['ISO']] = $c;
            $output['countries'][$c['ISO']]['arableLandAreaPercent'] = (int)(($c['arableLandArea']/$c['landArea'])*100) ;
            $output['countries'][$c['ISO']]['ISO2'] = toISO2($c['ISO']);
            $output['countries'][$c['ISO']]['GDPperkm2'] = (int)(($c['GDP']/$c['landArea'])) ;
            $initialCarbonOutput += $c['carbonOutput'];
        }
        
        $output['stats']['carbonOutput'] = $initialCarbonOutput; //calculated overview data
        
        ajaxSend($output);
        break;
    
    case 'group' :
        //whatever l//code hereoad up les charts with data formatted however
        $data = 
            array(
                array('Year', 'Carbon Output'), 
                array('2004', rand(10, 1000)),
                array('2005', rand(10, 1000))
            ); 
        ajaxSend(dataToArray($data));
        break;
    default : echo 'error';
}


// send ajax data to success function as json
function ajaxSend($array){
    header('content-type: application/json');
    echo json_encode($array);
} 

// convert associative array to array of arrays for google vis.
function dataToArray($data){
    $retVal = array();
    if(is_array($data)){
        if(is_assoc($data)){
            foreach(array_keys($data) as $key){
                    $retVal[] = array($key, $data[$key]);
            }
        } else {
            return $data;
        } 
    } 
    return $retVal;
}

// detect if array is associative
function is_assoc($array) {
    return (is_array($array) && (count($array)==0 || 0 !== count(array_diff_key($array, array_keys(array_keys($array))) )));
} 

?>