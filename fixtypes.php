<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');
    

    $simquery = new SimulationModel();    // instantiate collection model
    $results = $simquery->find();

    //$s = array();
    foreach ($results as $sim) {
        var_dump($sim->getAttributes());
        $sim->save();
    }



?>
