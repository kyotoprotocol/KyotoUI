<?php

/*
 * Displays overview of all simulation results held in database
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());

//code here
        

        $smarty->display('views/resultsOverview.tpl');
        
?>
