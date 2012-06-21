<?php
/*
 * Handles all ajax requests to the backend
 *
/* Instructions:
 * $output array contains 2 arrays, stats, and countries
 * countries contains all information output about individual countries this is
 * useful for displaying on the geochart etc.
 * stats contains global data - add parameters to this which are calculated about the entire
 * world. The javascript will then put these parameters into any element with the same id 
 * as the parameters index in the array - if there are special requirements e.g. rounding,
 * this can be done in the javascript.
 */


include('admin/config.php');

$simulation = new SimulationModel();    // instantiate collection model
if (isset($_GET['simid'])) {
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
} else {
    var_dump('failed'); die();
}

switch ($_GET['func']) {
   /* case 'load' :
        //$attributes = $sim->getAttributes();
        $countries = $sim->getCountries();
        //$output = $attributes;
        $output = array();
        $noMembers = 0;
        foreach ($countries as $c) {            // package countries to contain all relevant data
            $output['countries'][$c['ISO']] = $c;
            $output['countries'][$c['ISO']]['arableLandAreaPercent'] = (int)(($c['arableLandArea']/$c['landArea'])*100) ;
            $output['countries'][$c['ISO']]['ISO2'] = toISO2($c['ISO']);
            $output['countries'][$c['ISO']]['GDPperkm2'] = (int)(($c['GDP']/$c['landArea'])) ;
            $initialCarbonOutput += $c['carbonOutput'];
            if(rand(0,10) > 5){
                //set it to be a member
                $output['countries'][$c['ISO']]['kyotoMember'] = 1;
                $output['countries'][$c['ISO']]['cheat'] = 1;
                $noMembers ++;
            } else {
                $output['countries'][$c['ISO']]['kyotoMember'] = 0;
                $output['countries'][$c['ISO']]['cheat'] = 0;
            }
            $output['countries'][$c['ISO']]['carbonChangePercentage'] = rand(0, 100);
        }
        
        $output['stats']['carbonOutput'] = $initialCarbonOutput; //calculated overview data
        $output['stats']['globalCarbonChangePercentage'] = (($initialCarbonOutput - rand(1000000, $initialCarbonOutput))/$initialCarbonOutput)*100;
        $output['stats']['numberOfMemberCountries'] = $noMembers;
        ajaxSend($output);
        break;*/
    
    case 'result' :
        $result = new ResultModel();
        $id = new MongoInt64($sim->getId());
        $results = $result->find(array("simID" => $id));
        
        $params = array();
        $global = array();
        
        foreach($results as $res){
            $attributes = $res->getAttributes();

            if($attributes['ISO']){
                $params[$attributes['ISO']] = $attributes;
            } else {    //if no isos - useless in reality but good for debugging at this stage
                ajaxSend(array('error', 'No country ISOs'));
            }
        }
         
        $output = array('stats' => $global, 'countries' => $params);
        
        ajaxSend($output);
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