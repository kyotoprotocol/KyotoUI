<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());


        $simulation = new SimulationModel();    // instantiate collection model

        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            var_dump('error no sim found'); die(); // basic error reporting
        }


$smarty->assign('simAuthor', $sim->getAuthor());
$smarty->assign('simName', $sim->getName());
$smarty->assign('simDescription', $sim->getDescription());
$smarty->assign('simData', $sim->getAttributes());
$smarty->assign('simID', $sim->getID());
$smarty->display('views/maps.tpl');

?>
