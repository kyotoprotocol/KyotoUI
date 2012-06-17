<?php
require('libs/Smarty.class.php');
//
$smarty = new Smarty;

// CHECK FOR MONGO DRIVER (PHP EXTENSION)
if (!extension_loaded('mongo')) {
    $smarty->assign('mongodriver', 'on');
} else {
    require('admin/config.php');
    if (startDB()=='failure'){
    $smarty->assign('mongodbconnect', 'on');
    }
}




//$smarty->assign('simList',simulationList());
$smarty->display('views/index.tpl');
?>
