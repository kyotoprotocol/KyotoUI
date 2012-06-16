<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');

$simList = simulationList();
//POST copy simulation?
if (isset($_POST['simulationcopy'])) {
   
    if (in_array($_POST['simulationname'],$simList)) {
        $smarty->assign('error', 'Cannot copy due to duplicate name error. Choose a different name');
    } else {
        //Go ahead and create the copy
        //Get next sim id from presage table "counters"
        $counter = new CountersModel();
        $id = $counter->findOne(array("_id" => "simulations"));
        $useid = $id->getNext();
        $id->setNext(new MongoInt64($useid+1));
        $id->save();
        
        // Load simulation to be copied
        $simulation = new SimulationModel();
        $sim = $simulation->findOne(array("_id" => (int)$_POST['simulationcopy']));

        $newsim = new SimulationModel(
                                        array(  '_id'               =>  new MongoInt64($useid),
                                                'name'              =>  $_POST['simulationname'],
                                                'classname'         =>  $sim->getClassname(),
                                                'description'       =>  $_POST['simulationdescription'],
                                                'state'             =>  $sim->getState(),
                                                'author'            =>  $_POST['author'],
                                                'finishTime'        =>  new MongoInt64($sim->getFinishTime()),
                                                'createdAt'         =>  new MongoInt64(time()*1000) ,
                                                'currentTime'       =>  new MongoInt64(0),
                                                'finishedAt'        =>  new MongoInt64(0),
                                                'parameters'        =>  $sim->getParameters(),
                                                'parent'            =>  new MongoInt64(0),
                                                'children'          =>  array(),
                    //                         'startedAt'         =>  '',
                                                'countries'         =>  $sim->getCountries()
                                                )        
                                );
            $newsim->save();
        $smarty->assign('success', 'Created :'.$_POST['simulationname'].'!');

    }
} elseif (isset($_POST['delete'])) {
    $sims = new SimulationModel();
    $dropitlikeitshot = $sims->findOne(array("_id" => (int)$_POST['simulationid']));
    $dropitlikeitshot->destroy();
        $smarty->assign('success', 'Deleted :'.$_POST['simulationid'].'!');
}


    $simquery = new SimulationModel();    // instantiate collection model
 
    $results = $simquery->find(array(), array('sort'=>array("_id"=>1)));

    $s = array();
    foreach ($results as $sim) {
        $s[] = $sim->getAttributes();
    }


$smarty->assign('simList',$simList);
$smarty->assign('simulations', $s);
$smarty->display('views/simulations.tpl');

?>
