<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');
    
$db = startDB();
    
$simulations = $db->selectCollection("simulations");



$smarty->assign('simulations', $simulations);
$smarty->display('views/simulations.tpl');

?>
