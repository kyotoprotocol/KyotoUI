<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');

$simquery = new SimulationModel();    // instantiate collection model
$results = $simquery->findAll();

$s = array();
foreach ($results as $sim) {
    $s[] = $sim->getAttributes();
}

    
$smarty->assign('simList',simulationList());
$smarty->assign('simulations', $s);
$smarty->display('views/simulations.tpl');

?>
