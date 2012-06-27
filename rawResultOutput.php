<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());
        

        $simulation = new SimulationModel();    // instantiate collection model
            
        $agents = new AgentsModel();    // instantiate collection model

        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
            $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort'=>array('_id'=>1)));
            //$agentslist = $agents->find();
        } else {
            var_dump('error no sim found'); die(); // basic error reporting
        }
        
        $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
        
        $i = 0;
                        $a = array();
            foreach ($agentslist as $dave) {
                echo 'hello';
                $names[$i] = $dave->getName();
                if (isset($_GET['number'])&&($_GET['number']==$i)) {
                    $binaryUUID=$dave->getAid();
                    $properties = $dave->getProperties();
                    $smarty->assign('properties', $properties);
                    $smarty->assign('Cname', $dave->getName());

                    //AGENT STATE PROCESSOR
                        $agentState = new AgentStateModel();    // instantiate collection model
                        $as = $agentState->find(array("aid"=>$binaryUUID));
                        $count = $as->count();
                        $smarty->assign('tCount', $count);
                        foreach ($as as $ag) {
                        $a[] = $ag->getAttributes();
                        //$statekeys = array_keys($ag->getProperties());
                        }
                        $smarty->assign('ticks', $a);
                        var_dump($a);
                    }
                $i++;
                
            }
    //    $smarty->assign('statekeys', $statekeys);
   //     $smarty->assign('propkeys', $propkeys);
    //    $smarty->assign('propcount', $propcount);
        $smarty->assign('names', $names);
        $smarty->assign('simAuthor', $sim->getAuthor());
        $smarty->assign('simName', $sim->getName());
        $smarty->assign('simDescription', $sim->getDescription());
        $smarty->assign('simData', $sim->getAttributes());
        $smarty->assign('simID', $simID);
        $smarty->display('views/rawResultOutput.tpl');
?>