<?php

/*
 * Displays overview of all simulation results held in database
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');

$simulation = new SimulationModel();
$sims = $simulation->findAll(array('state' => 'COMPLETE'));

    //$smarty->assign('simList', $simList);
    $smarty->assign('simulations', $sims);
    $smarty->display('views/resultsOverview.tpl');
        
?>
