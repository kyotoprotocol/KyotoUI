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

    $smarty->assign('simName', $attributes['name']);
    $smarty->display('views/simRun.tpl');
        
?>