<?php

/*
 * Displays overview of all simulation results held in database
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');

$simulation = new SimulationModel();
$sims = $simulation->findAll(array('state' => 'COMPLETE'));

foreach($sims as $sim){
    echo '<a href="resultOverview?simid='.$sim->getID(). '">'. $sim->getName().'</a> <br>';
}

die();

    
    $smarty->assign('simulations', $sims);
    $smarty->display('views/resultsOverview.tpl');
        
?>
