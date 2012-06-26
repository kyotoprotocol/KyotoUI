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
    $simparams = $sim->getParameters();
    $startyear = $simparams['START_YEAR'];
} else {
    var_dump('failed'); die();
}

switch ($_GET['func']) {    
    case 'result' :
        $id = new MongoInt64($sim->getId());
        $intid = (int)$sim->getId();
        
        $result = new ResultModel();
        
        $trade = new TradeModel();
        $tradeArray = $trade->find(array("simID" => (string)$id));
        
    //Generate global data
        
        $countries = array();
        $global = array();
        
        $finalYearResultsQuery = $result->findOne(array("simID" => $intid, "quarter" => (int)3), array("sort" => array("year" => -1)));
        $finalYear = $finalYearResultsQuery->getYear();

        $global['finalYear'] = $finalYear;
        $global['cheatcount'] = 0;
        
        $global['finalYearGlobalEmissionTarget'] = 0;
        $global['numberOfMemberCountries'] = 0;
        $last['totalCarbonOutput'] = 0;
        $last['totalCarbonAbsorption'] = 0;
        $last['globalGDP'] = 0;
        $first['totalCarbonOutput'] = 0;
        $first['totalCarbonAbsorption'] = 0;
        $first['globalGDP'] = 0;

//Generate country data

        $countries = $result->findAll(array('simID' => $intid, 'quarter' => (int)3),array('sort'=>array('year'=>1)));

        foreach($countries as $key => $country){
            if ($country->getYear()==$finalYear) {
                $last['totalCarbonOutput'] += $country->getCarbonOutput();
                $last['totalCarbonAbsorption'] += $country->getCarbonAbsorption();
                $last['globalGDP'] += $country->getGDP();
                $last['cheated'] = $country->getCheated();
                if(($country->getIsKyotoMember() == 'ANNEXONE') OR ($country->getIsKyotoMember() == 'NONANNEXONE')){ 
                    if($country->getQuarter() == 3){
                        $global['numberOfMemberCountries']++;
                    }
                }
                if($last['cheated']){
                    $global['cheatcount']++;
                }
                
                $global['finalYearGlobalEmissionTarget'] += $country->getEmissionsTarget();
            
            } elseif ($country->getYear()==0) {
                $first['totalCarbonOutput'] += $country->getCarbonOutput();
                $first['totalCarbonAbsorption'] += $country->getCarbonAbsorption();
                $first['globalGDP'] += $country->getGDP();
            } else {
                if (isset($years[$country->getYear()])){
                    $years[$country->getYear()] += $country->getCarbonOutput();
                } else {
                    $years[$country->getYear()] = $country->getCarbonOutput();
                }

            }
            $params[$key] = $country->getAttributes();
            $params[$key]['ISO2'] = toISO2($params[$key]['ISO']);
            $params[$key]['cheated'] = $country->getCheated();
        }
        $global['carbonReduction'] = ($first['totalCarbonOutput'] - $first['totalCarbonAbsorption']) - ($last['totalCarbonOutput'] - $last['totalCarbonAbsorption']);
        $global['globalGDPChange'] = $last['globalGDP'] - $first['globalGDP'];
        $global['startyear'] = $startyear;
        
        $timeline[] = array(0, $first['totalCarbonOutput']);
        foreach ($years as $year => $data) {
            $timeline[] = array($year, $data);
        }
        $timeline[] = array($finalYear, $last['totalCarbonOutput']);
        //[new Date(2008, 1 ,1), 30000, null, null, 40645, null, null],

        
//Generate trades data
        
        $trades['totalTradeValue'] = 0;
        $trades['tradeCount'] = $tradeArray->count();
        $trades['buyCount'] = 0;
        $trades['cdmCount'] = 0;
        $trades['averageCreditValue'] = 0;
        
        $minCreditValue = 100000000000000000000;
        $maxCreditValue = 0;
        
        foreach($tradeArray as $t){
            //total trade value
            $trades['totalTradeValue'] += ($t->getQuantity() * $t->getUnitCost());
            //max credit value
            if($maxCreditValue < $t->getUnitCost()){
                $maxCreditValue = $t->getUnitCost();
            }
            //min credit value
            if($minCreditValue > $t->getUnitCost()){
                $minCreditValue = $t->getUnitCost();
            }
            // average trade value
            $trades['averageCreditValue'] += $t->getUnitCost();
            // no. credit buys
            if($t->getTradeType() == 'BUY'){
                $trades['buyCount']++;
            } else {
            // no. cdm transactions
                $trades['cdmCount']++;
            }
        }

        $trades['totalTradeValue'] = (int)$trades['totalTradeValue'];
        $trades['maxCreditValue'] = (int)$maxCreditValue;
        $trades['minCreditValue'] = (int)$minCreditValue;
        
        if($trades['averageCreditValue'] != 0 && $trades['tradeCount'] != 0){
            $trades['averageCreditValue'] = (int)$trades['averageCreditValue']/$trades['tradeCount'];
        } else $trades['averageCreditValue'] = 0;
        
        
        //Bundle output and send to the page      
        $output = array('stats' => $global, 'countries' => $params, 'trades' => $trades, 'timeline'=>$timeline);
        ajaxSend($output);
        break;
        
    case  'run' :
        chdir('../kyoto/kyoto/');
        $command = ('sudo sh sim-run.sh run '.(string)$sim->getID().' > /var/log/kyoto/log'.(string)$sim->getID().'.txt &');
        exec($command);
        ajaxSend(0);
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