<?php

/*
 * Displays overview of a single simulation result
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());

//code here

    $smarty->display('views/resultOverview.tpl');
        
?>