<?php
function getTime()
    {
    $a = explode (' ',microtime());
    return(double) $a[0] + $a[1];
    }
$time1 = getTime(); 
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->caching = false;
$smarty->assign('simList',simulationList());

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
    define ("CRAPOUT", false);

//FIRST FIND LIST OF ALL AGENTS PROCESSED
    
    $tickquarter = ((int)TICK_YEAR)/4;
    
    $quarter[0] = array ('offset' => (int)0, 'limit' => (int)floor($tickquarter));
    $quarter[1] = array ('offset' => (int)floor($tickquarter), 'limit' =>(int)floor($tickquarter));
    $quarter[2] = array ('offset' => (int)(floor($tickquarter)*2), 'limit' =>(int)floor($tickquarter));
    $quarter[3] = array ('offset' => (int)(floor($tickquarter)*3), 'limit' =>(int)(TICK_YEAR-(floor($tickquarter)*3)));
    
    if (CRAPOUT) var_dump($quarter);
    if (isset($_GET['agent'])) {
        
        $agentCount = $_GET['agentno'];
        $steps = $_GET['agentno'];
        $currentQuarter = ((int)$_GET['agent']%4);
        $agentOffset = floor((int)$_GET['agent']/4);
        if (CRAPOUT) echo 'Number of agents: '.$agentCount .'<br>';
        if (CRAPOUT) echo 'Number of steps: '.$steps .'<br>';
        if (CRAPOUT) echo 'Agent Number: '.$agentOffset .'<br>';
        if (CRAPOUT) echo 'CurrentQuarter '.$currentQuarter.'<br>';
        
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

    $as = new AgentStateModel();    // instantiate collection model
    //echo $steps .'<br>';
    $outputARY = array();
                        
        foreach ($agentslist as $agent) {
            // EACH COUNTRY AS AGENT
            $agentProperties = $agent->getProperties();
            $iso = $agentProperties['ISO'];
            $kyotostate = 'undefined';
            $notices = array();
            $year = 0;
            
            //CHECK FOR RECORD ALREADY INCASE ACCIDENTALLY REPEAT REQUEST:

            $resultcheckq = new ResultModel();    // instantiate collection model
            $resultcheck = $resultcheckq->findOne(array("simID" => (int)$_GET['simid'], "ISO" =>$iso));
         /*   if (is_null($resultcheck)) {
            //echo 'no record exists<bR>';
            } else {            
            echo 'Record Exists!';
            die();
            } */
            

           
                $agentstate = $as->find(
                                        array("aid"=>$agent->getAid()),
                                        array('limit'=>10,
                                              'offset' => (int)$quarter[$currentQuarter]['offset'],
                                              'limit' => (int)$quarter[$currentQuarter]['limit']
                                              )
                                        );
                if (CRAPOUT) echo 'Number of agentstatesselected '.$agentstate->count().'<br>';
                             //   $i=0;
             /*                   foreach ($agentstate as $ag) {
                                    echo $i++.'<br>';
                                }*/
                if (CRAPOUT) echo 'query offset '.$quarter[$currentQuarter]['offset'].'<br>';
                if (CRAPOUT) echo 'query limit '.$quarter[$currentQuarter]['limit'].'<br>';
        //die();
                $time2 = getTime(); 
                foreach ($agentstate as $ag) {
                // EACH DAY OF COUNTRY
                $countryArray = array();
                $tick = $ag->getTime();
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
                if (CRAPOUT) echo $tick.'<br>';

                    if ($tick  == 0) {
                       //FIRST DAY
                        
                    } elseif ($tick % (TICKS_IN_QUARTER-1) == 0) {
                        // Last Day of the quarter
                        // Here is the year round up. Save and ting
                        if (CRAPOUT) echo 'Save the damn record';
                        $countryArray['simID']             = 9;//$simID;
                        $countryArray['GDP']               = $agentTickProperties['gdp'];
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
                        if ($tick % TICK_YEAR-1 == 0) {
                            //$year++;
                        }
                  //  } elseif ($tick % TICK_YEAR == 1) {
                        //First day of the year 
                    } else {
                        // All other days of the quarter (perhaps adding and shit)
                    }                   
//                    echo $tick.'<br>';
                    //var_dump($ag->getAttributes());
                    //$statekeys = array_keys($ag->getProperties());
                } //End of DAY
                                $time3 = getTime(); 

            $outputARY['ISO'] = $iso;
            $outputARY['totalAgents'] = $steps;
            $progressCount++;
            if ($progressCount==$steps) {
            $outputARY['success'] = 'complete';
            } else {
            $outputARY['timea'] = $time2-$time1;
            $outputARY['timeb'] = $time3-$time2;
            $outputARY['success'] = 'true';
            $outputARY['nextAgent'] = $progressCount;
            $outputARY['percentage'] = (int)(($progressCount/$steps)*100);
            }


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
                    header('content-type: application/json');
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