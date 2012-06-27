<?php

/*
 * RUNNING SIMS
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());




    $running = shell_exec('ps -ef | grep java');


    $list = runningIds();

    foreach ($list as $l) {
        
        $simquery = new SimulationModel();    // instantiate collection model
        $results = $simquery->findOne(array('_id'=>$l));
        $simlist[] = $results->getAttributes();
    }
//var_dump($simlist);
$smarty->assign('simlist', $simlist);

//Render page
$smarty->display('views/runningSims.tpl');

?>
