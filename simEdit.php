<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());

    $simulation = new SimulationModel();    // instantiate collection model
    $simulations = $simulation->findAll();
    
    // Load specific simulation
    if (isset($_GET['simid'])) {
        $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        $postSim = $sim;
        $simID = new MongoInt64($sim->getID());
    }
    
    //Grab updated country data - SORT LATER
    if (isset($_POST['_id'])){                      //check post data set
        foreach(array_keys($_POST) as $key){
            if($key != '_id'){
                if(substr_count($key, 'param_')){
                    $params[str_replace('param_', '', $key)] = $_POST[$key];
                    var_dump($params);
                } elseif($key == 'newKey') {
                    if(strlen($_POST['newKey']) > 0){
                        $params[$_POST['newKey']] = $_POST['newValue'];
                    }
                } elseif ($key == 'newValue'){
                    // do nothing - already taken care of above
                } else {
                    $function = 'set'. ucfirst($key);
                    if($key == 'finishTime' OR $key == 'createdAt' OR $key == 'parent' OR $key == 'currentTime'){   //specify all long int simulation fields here
                        call_user_func(array($postSim, $function), (new MongoInt64($_POST[$key])));
                    } else {
                        call_user_func(array($postSim, $function), $_POST[$key]);
                    }
                }
            } else {
                $postSim->setID($simID);
            }
        }
        $postSim->setParameters($params);
        $postSim->save();                               // save changes to database collection
        $smarty->assign('updated', true);
    }
    
    if($postSim){
        $sim = $postSim;
    }
    
    $attributes = $sim->getAttributes();
    
    $smarty->assign('simName', $sim->getName());
    $smarty->assign('simAuthor', $sim->getAuthor());
    $smarty->assign('simDescription', $sim->getDescription());
    $smarty->assign('simid', $simID);
    $smarty->assign('attributes', $attributes);
    $smarty->assign('simulations',  $simulations);
    $smarty->display('views/simEdit.tpl');
        
?>