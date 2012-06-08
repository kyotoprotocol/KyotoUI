<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');
    
$db = startDB();
    
$simulations = $db->selectCollection(SIMTREE);
$cursor = $simulations->find();
$simulationList = iterator_to_array($cursor);

//var_dump($simulationList);


$smarty->assign('simulations', $simulationList);
$smarty->display('views/simulations.tpl');

?>
