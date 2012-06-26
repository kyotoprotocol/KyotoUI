<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



  include("admin/config.php");
    $agents = new AgentsModel();    // instantiate collection model
    $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1)));
    echo '<ol>';
    foreach ($agentslist as $ag) {
            $totalASQ = new AgentStateModel();    // instantiate collection model
            $totalAS = $totalASQ->find(array("aid"=>$ag->getAid()));
        echo '<li>'.$ag->getName().':'.$totalAS->count().'</li>';
        
            
    }

    echo '</ol>';



?>
