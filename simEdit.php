<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;

include('admin/config.php');


    $simulation = new SimulationModel();    // instantiate collection model
    
    $simulations = $simulation->findAll();
    

    // Load specific simulation
    if (isset($_GET['simid'])) {
        $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
    } else {
        $sim = $simulation->findOne(array(), array('countries' => 1));
    }
    
    $simID = new MongoInt64($sim->getID());
    
    $dave = $sim->getAttributes();

    $smarty->assign('simulationname', $sim->getName());
    $smarty->assign('simid', $simID);
    $smarty->assign('simulation', $dave);
    $smarty->assign('simulations',  $simulations);
    $smarty->display('views/simEdit.tpl');
        
?>
