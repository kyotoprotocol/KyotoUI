<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');

    $simulation = new SimulationModel();    // instantiate collection model
    
    // Load specific simulation
    if (isset($_GET['simid'])) {
        $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        $attributes = $sim->getAttributes();
    }
                    $resultcheckq = new ResultModel();    // instantiate collection model
                    $resultcheck = $resultcheckq->find(array("simID" => (int)$_GET['simid']));
               //     var_dump($resultcheck);

                    $resultCnt = $resultcheck->count();
                  
          
    //Get simulation parameters
    $simulation = new SimulationModel();    // instantiate collection model
    $agents = new AgentsModel();    // instantiate collection model
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
    $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
    $simprop = $sim->getParameters();

    //Process-wide definitions
    define ("TICK_YEAR", $simprop['TICK_YEAR']);
    //define ("TICK_LENGTH", $simprop['finishTime']);
    define ("TICK_LENGTH", $sim->getCurrentTime());
    define ("YEARS", floor(TICK_LENGTH/TICK_YEAR));
    //define ("OUTPUTFORM", 'HTTPREQUEST');
    define ("OUTPUTFORM", 'JSON');
    $count = $agents->find(array("simID"=>$simID));
    $agentCount = $count->count();                          // How many agents we have
    $steps = $agentCount*4*YEARS;                           // Total Steps in simulation - could save a few lookups in future.
    $agentSteps = YEARS*4;          
                 //   var_dump($steps);

        if ($steps == $resultCnt){
            $completedProcess = true;
        } else {
            $completedProcess = false;

        }
    $smarty->assign('completedProcess', $completedProcess);
    $smarty->assign('simName', $attributes['name']);
    $smarty->display('views/simRun.tpl');
        
?>