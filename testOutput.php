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
            $agentslist = $agents->find(array("simID" => (float) $_GET['simid']));
            //$agentslist = $agents->find();
        } else {
            var_dump('error no sim found'); die(); // basic error reporting
        }
        
        $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
        
        //var_dump($agent);
       // var_dump($agentslist);
            foreach ($agentslist as $dave) {
               // $s[] = $sim->getAttributes();
                $properties = $dave->getProperties();
                $propcount = count($properties);
                $propkeys = array_keys($properties);
               $a[] = $dave->getAttributes();
            }

        $smarty->assign('propkeys', $propkeys);
        $smarty->assign('propcount', $propcount);
        $smarty->assign('agents', $a);
        $smarty->assign('simAuthor', $sim->getAuthor());
        $smarty->assign('simName', $sim->getName());
        $smarty->assign('simDescription', $sim->getDescription());
        $smarty->assign('simData', $sim->getAttributes());
        $smarty->assign('simID', $simID);
        $smarty->display('views/testOutput.tpl');
?>