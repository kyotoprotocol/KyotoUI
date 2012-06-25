<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');
    
/*
    $simquery = new SimulationModel();    // instantiate collection model
    $results = $simquery->find();

    //$s = array();
    foreach ($results as $sim) {
        var_dump($sim->getAttributes());
        $sim->save();
    }
*/
    $trade = new TradeModel();    // instantiate collection model
    $trade->ensureIndex(array('simID'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $trade->ensureIndex(array('broadcaster'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $trade->ensureIndex(array('initiator'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $trade->ensureIndex(array('tradeType'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $trade->ensureIndex(array('investmentType'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    
    $results = new ResultModel();    // instantiate collection model
    $results->ensureIndex(array('simID'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $results->ensureIndex(array('year'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $results->ensureIndex(array('quarter'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    $results->ensureIndex(array('ISO'=>1));//, 'broadcaster'=>1, 'initiator'=>1, 'tradeType'=1, 'investmentType'=>1));
    

?>
