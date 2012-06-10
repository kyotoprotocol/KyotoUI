<?php
require('libs/Smarty.class.php');
//require('admin/config.php');
$smarty = new Smarty;
//$smarty->assign('simList',simulationList());
$smarty->display('views/index.tpl');
?>
