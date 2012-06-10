<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;

include('admin/config.php');


    $simulation = new SimulationModel();    // instantiate collection model
    
    $simulations = $simulation->findAll();
    

    // Load specific simulation
    if (isset($_GET['simid'])) {
        $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
    } else {
        $sim = $simulation->findOne(array(), array('countries' => 1));
    }

    //Grab updated country data - SORT LATER
    if (isset($_POST['_id'])){                      //check post data set
        foreach(array_keys($_POST) as $key){
            //assemble output
            var_dump($key);
        }
        $sim->setSimulation($editedSim);
        $sim->save();                               // save changes to database collection
        $smarty->assign('updated', true);
    }
    
    $simID = new MongoInt64($sim->getID());
    
    $attributes = $sim->getAttributes();

    $smarty->assign('simName', $sim->getName());
    $smarty->assign('simid', $simID);
    $smarty->assign('attributes', $attributes);
    $smarty->assign('simulations',  $simulations);
    $smarty->display('views/simEdit.tpl');
        
?>
