<?php

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
    //define ("OUTPUTFORM", 'HTTPREQUEST');
    define ("OUTPUTFORM", 'JSON');

//FIRST FIND LIST OF ALL AGENTS PROCESSED
        
    if (isset($_GET['agent'])) {
        $offset =(int) $_GET['agent'];
        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => $offset, 'limit' => 1));
        $steps = $_GET['agentno'];
    } else {
        // Choose the first agent
        $count = $agents->find(array("simID"=>$simID));
        $steps = $count->count();

        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => 0, 'limit' => 1));
        $offset = 0;
    }

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
            if (is_null($resultcheck)) {
            //echo 'no record exists<bR>';
            } else {            
            echo 'record exists<bR>';
            die();
            }
            
                $agentstate = $as->find(array("aid"=>$agent->getAid()));
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
                    if ($tick % TICK_YEAR == 0) {
                        // Last Day of the year
                        // Here is the year round up. Save and ting
          //              echo 'Save the damn record';
                        $countryArray['simID']             = $simID;
                        $countryArray['GDP']               = $agentTickProperties['gdp'];
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
                        $year++;
                    } elseif ($tick % TICK_YEAR == 1) {
                        //First day of the year 
                    } else {
                        // All other days of the year (perhaps adding and shit)
                    }                   
//                    echo $tick.'<br>';
                    //var_dump($ag->getAttributes());
                    //$statekeys = array_keys($ag->getProperties());
                } //End of DAY

            $outputARY['ISO'] = $iso;
            $outputARY['percentage'] = (int)(($offset/$steps)*100);
            $outputARY['totalAgents'] = $steps;
            if ($offset+1==$steps) {
            $outputARY['success'] = 'complete';
            } else {
            $outputARY['success'] = 'true';
            }

            $offset++;
            $outputARY['nextAgent'] = $offset;

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