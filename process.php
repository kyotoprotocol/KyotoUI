<?php
function getTime()
    {
    $a = explode (' ',microtime());
    return(double) $a[0] + $a[1];
    }
$time1 = getTime(); 
$time2 = 0; 
$time3 = 0;
$looptimer = getTime(); 

/* THIS IS A COPY OF ESSENTIALS FROM CONFIG.PHP IN ORDER TO MINIMISE PAGE LOAD TIME ON THIS FILE.*/
include('libs/mongorecord/BaseMongoRecord.php');
include('models/SimulationModel.php');
include('models/AgentsModel.php');
include('models/AgentStateModel.php');
include('models/ResultModel.php');
define ("DB", "presage");
define ("SIMTREE", "simulations");
define ("LOCAL_HOST", "127.0.0.1:27017");
define ("REMOTE_HOST", "155.198.117.244:27017");
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
/* END OF ESSENTIALS FROM CONFIG.PHP IN ORDER TO MINIMISE PAGE LOAD TIME ON THIS FILE.*/

//require('libs/Smarty.class.php');
//$smarty = new Smarty;
//include('admin/config.php');
//$smarty->caching = false;
//$smarty->assign('simList',simulationList());

//GET SIM ID
if (isset($_GET['simid'])) {
   
    $simulation = new SimulationModel();    // instantiate collection model
    $agents = new AgentsModel();    // instantiate collection model
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
    $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
    
    $simprop = $sim->getParameters();
    define ("TICK_YEAR", $simprop['TICK_YEAR']);
    define ("TICK_LENGTH", $simprop['finishTime']);
    define ("YEARS", (int)TICK_LENGTH/TICK_YEAR);
    //define ("OUTPUTFORM", 'HTTPREQUEST');
    define ("OUTPUTFORM", 'JSON');
    define ("CRAPOUT", true);

//FIRST FIND LIST OF ALL AGENTS PROCESSED
    
    $tickquarter = ((int)TICK_YEAR)/4;
    
    
    for ($year = 0; $year<YEARS; $year++) {
    $quarter[$year][0] = array ('offset' => ($year*TICK_YEAR)+(int)0, 'limit' => (int)floor($tickquarter));
    $quarter[$year][1] = array ('offset' => ($year*TICK_YEAR)+(int)floor($tickquarter), 'limit' =>(int)floor($tickquarter));
    $quarter[$year][2] = array ('offset' => ($year*TICK_YEAR)+(int)(floor($tickquarter)*2), 'limit' =>(int)floor($tickquarter));
    $quarter[$year][3] = array ('offset' => ($year*TICK_YEAR)+(int)(floor($tickquarter)*3), 'limit' =>(int)(TICK_YEAR-(floor($tickquarter)*3)));
    }
    
    if (CRAPOUT) var_dump($quarter);
    if (isset($_GET['agent'])) {
        
        $agentCount = $_GET['agentno'];
        $steps = $_GET['agentno'];
        $currentQuarter = ((int)$_GET['agent']%4);
        $agentOffset = floor((int)$_GET['agent']/(4*YEARS));
        if (CRAPOUT) echo 'Number of agents: '.$agentCount .'<br>';
        if (CRAPOUT) echo 'Number of steps: '.$steps .'<br>';
        if (CRAPOUT) echo 'Agent Number: '.$agentOffset .'<br>';
        if (CRAPOUT) echo 'CurrentQuarter '.$currentQuarter.'<br>';
        
        
        $aCount = (int)floor($steps/(YEARS*4));
        echo "AHOLE ".$aCount . "# <br>";    

        echo "CURRENT AGENT ".$agentOffset . "# <br>";    
        $agentSteps = $aCount*4;
        echo "AGENT STEPS".$agentSteps . "# <br>";    

        $year = (int)floor($currentQuarter%((4*YEARS)));
        echo "YEAR ".$year . "# dave<br>"; die();
        
        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => $agentOffset, 'limit' => 1));
        $progressCount = ((int)$_GET['agent']);
    } else {
        // Choose the first agent
        $count = $agents->find(array("simID"=>$simID));
//        $steps = $count->count();
        $agentCount = $count->count();
        $steps = $agentCount*4*YEARS;
        if (CRAPOUT) echo 'Number of agents: '.$agentCount .'<br>';
        if (CRAPOUT) echo 'Number of steps: '.$steps .'<br>';
        $currentQuarter = 0;
        if (CRAPOUT) echo 'CurrentQuarter '.$currentQuarter.'<br>';
        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => 0, 'limit' => 1));
        $progressCount = 0;
        //$offset = 0;
    }
    define("TICKS_IN_QUARTER", $quarter[$currentQuarter]['limit']);

    //echo $steps .'<br>';
    $outputARY = array();
                        
        foreach ($agentslist as $agent) {
            // EACH COUNTRY AS AGENT
            $agentProperties = $agent->getProperties();
            $iso = $agentProperties['ISO'];
            $kyotostate = 'undefined';
                $time2 = getTime(); 
            $outputARY['timea'] = number_format(($time2-$time1),2);
$finishloop = false;
            //CHECK FOR RECORD ALREADY INCASE ACCIDENTALLY REPEAT REQUEST:
                    while (($looptimer-$time1 < 20) ){//&& (!$finishloop)) {
            $notices = array();

            $resultcheckq = new ResultModel();    // instantiate collection model
            $resultcheck = $resultcheckq->findOne(array("simID" => (int)$_GET['simid'], "ISO" =>$iso));
         /*   if (is_null($resultcheck)) {
            //echo 'no record exists<bR>';
            } else {            
            echo 'Record Exists!';
            die();
            } */
          //  $currentQuarter++;
    $as = new AgentStateModel();    // instantiate collection model
                $agentstate = $as->find(
                                        array("aid"=>$agent->getAid()),
                                        array('sort' => array('_id' => 1),
                                              'offset' => $quarter[$currentQuarter]['offset'],
                                              'limit' => (int)$quarter[$currentQuarter]['limit']
                                              )
                                        );
                 /*               foreach ($agentstate as $ag) {
                  echo '<br>'.$ag->getTime().'GOTTIME<br>';
                                }
die();*/

               // /*$ag = $agentstate->current();
     /*           for ($off = 0; $off < $quarter[$currentQuarter]['offset']; $off++) {
                  $ag =   $agentstate->next();
                  echo '<br>'.$ag->getTime().'GOTTIME<br>';
                }
                if (CRAPOUT) echo 'Current offset '.$quarter[$currentQuarter]['offset'].'<br>';
                             //   $i=0;*/
             /*                   foreach ($agentstate as $ag) {
                                    echo $i++.'<br>';
                                }*/
                if (CRAPOUT) echo 'query offset '.$quarter[$currentQuarter]['offset'].'<br>';
                if (CRAPOUT) echo 'query limit '.$quarter[$currentQuarter]['limit'].'<br>';
        //die();
               // for ($lim = 0; $lim < $quarter[$currentQuarter]['limit']; $lim++) {
                //$ag = $agentstate->current();
                                foreach ($agentstate as $ag) {
                  echo '<br>'.$ag->getTime().'GOTTIME<br>';
                 //   ($agentstate as $ag) 
                // EACH TICK OF COUNTRY
                $countryArray = array();
                                var_dump($ag);
                                
                $tick = $ag->getTime();
                if (CRAPOUT) echo 'FOUND TIME '.$tick.'<br>';
                $agentTickProperties = $ag->getProperties();
                if ($agentTickProperties['is_kyoto_member'] != $kyotostate) {
                    if ($kyotostate=='undefined'){
                        //Initialise kyotostate so do nothing
                    } else {
                        // A legitimate change so make a record of this
                        $notices[] = array(NOTICE_1, $kyotostate, $agentTickProperties['is_kyoto_member'], $tick);
                    }
                        $kyotostate = $agentTickProperties['is_kyoto_member'];
                }
                if (CRAPOUT) echo 'Ticks in Quarter'.TICKS_IN_QUARTER.'<br>';
                if (CRAPOUT) echo 'Ticks in Quarter -1:'.(int)(TICKS_IN_QUARTER-1).'<br>';
                if (CRAPOUT) echo 'Ticks'.$tick.'<br>';

                    if ($tick  == 0) {
                       //FIRST DAY
                        
                    } elseif ($tick % (TICKS_IN_QUARTER) == (TICKS_IN_QUARTER-1)) {
                        echo 'MODRESULT:'.$tick % (TICKS_IN_QUARTER-1).'<br>';
                        // Last Day of the quarter
                        // Here is the year round up. Save and ting
                        if (CRAPOUT) echo 'Save the damn record';
                        $countryArray['simID']             = 9;//$simID;
                        $countryArray['GDP']               = $agentTickProperties['gdp'];
                        $countryArray['tick']              = $tick;
                        $countryArray['quarter']           = $currentQuarter;
                        $countryArray['ISO']               = $iso;
                        $countryArray['year']              = $year;
                        $countryArray['GDPRate']           = $agentTickProperties['gdp_rate'];
                        $countryArray['availableToSpend']  = $agentTickProperties['available_to_spend'];
                        $countryArray['emissionsTarget']   = $agentTickProperties['emission_target'];
                        $countryArray['carbonOffset']      = $agentTickProperties['carbon_offset'];
                        $countryArray['carbonOutput']      = $agentTickProperties['carbon_output'];
                        $countryArray['isKyotoMember']     = $agentTickProperties['is_kyoto_member'];
                        $countryArray['notices']           = $notices;
                        $notices = array();
                        $result = new ResultModel($countryArray);    // instantiate collection model
                        $result->save();

                        
                  //  } elseif ($tick % TICK_YEAR == 1) {
                        //First day of the year 
                    } elseif ($tick % (TICK_YEAR) == TICK_YEAR-1) {
                            echo 'DAVE TICK'.$tick . '}{' .(TICK_YEAR-1) .'#' ;
                            $year++;
                            echo 'YEAR SHITOUT'.$year;
                       
                    } else {
                        // All other days of the quarter (perhaps adding and shit)
                    }                   
//                    echo $tick.'<br>';
                    //var_dump($ag->getAttributes());
                    //$statekeys = array_keys($ag->getProperties());
                            //        $ag = $agentstate->next();
                } //End of DAYs
                //AT END O' DAY
            $time3 = getTime(); 

            $outputARY['ISO'] = $iso;
            $outputARY['totalAgents'] = $steps;
            $progressCount++;
            if ($progressCount===$steps) {
            $outputARY['success'] = 'complete';
            } else {
            $outputARY['timeb'] = number_format(($time3-$time2),2);
            $outputARY['success'] = 'true';
            $outputARY['nextAgent'] = $progressCount;
            $outputARY['percentage'] = (int)(($progressCount/$steps)*100);
            }
        $looptimer = getTime(); 
        echo 'CURRENT QUARTER PRE '.$currentQuarter;
        $currentQuarter = $progressCount%4;
        echo 'CURRENT QUARTER POST'.$currentQuarter;

        //echo "ticks:".$tick.'/'.(TICK_LENGTH-1).'<br>';
       // die();
                                if ($tick == (TICK_LENGTH-1)) {
                                  $finishloop = true;
                                }
//unset($agentstate);
//unset($as);
                    } // end of while time loop
            }//END OF AGENT
 
        

                IF (OUTPUTFORM == 'HTTPREQUEST') {
                //echo '<a href="process.php?simid='.$simID.'&agent='.$offset.'&agentno='.$steps.'">NEXT</a>';
                    if ($offset>$steps){
                        echo 'finished'; die();
                    }
                header("Location: process.php?simid=".$simID."&agent=".$offset."&agentno=".$steps); /* Redirect browser */
                }


} else {
   echo 'No sim ID mate.';
}

                
                IF (OUTPUTFORM == 'JSON') {
                    //header('content-type: application/json');
                    echo json_encode($outputARY);

                    //echo '<a href="process.php?simid='.$simID.'&agent='.$offset.'&agentno='.$steps.'">NEXT</a>';
                }
                
                
                
                
               /* $properties = $ag->getProperties();
                //prepopulates the array with lots of fake year data.
                for ($m=5; $m<760; $m++) {
                unset($as1);
                $as1 = new AgentStateModel();    // instantiate collection model
                $as1->setAid($agent->getAid());
                $as1->setProperties($properties);
                $as1->setTime($m);
                $as1->save();
                }*/


?>