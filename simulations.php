<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');
    
$db = startDB();
    
$simulations = $db->selectCollection(SIMTREE);
$cursor = $simulations->find();
$simulationList = iterator_to_array($cursor);


//$search = $simulations->findOne(array("_id" => 6), array("countries" => 1));


$smarty->assign('simulations', $simulationList);
$smarty->display('views/simulations.tpl');

?>
