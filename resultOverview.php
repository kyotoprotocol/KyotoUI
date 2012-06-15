<?php

/*
 * Displays overview of a single simulation result
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());

$simulation = new SimulationModel();    // instantiate collection model

if (isset($_GET['simid'])) {
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid'], "state" => "COMPLETE"));
} else {
    var_dump('Please set simulation id'); die(); //temporary error reporting
}



if($sim){
    $smarty->assign('simid', $sim->getID());
} else {
    var_dump('No simulations finished'); die(); //temporary error reporting
    $smarty->assign('simid', NULL);
    $smarty->assign('noSims', true);
}

$smarty->display('views/resultOverview.tpl');
    
?>
