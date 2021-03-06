<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');

$simList = simulationList();
//POST copy simulation?
if (!isset($_SESSION['display'])) {
    // First visit this session, so make some session defaults.
        $_SESSION['simfilterstate']     = 'all';
        $_SESSION['simfiltertype']      = 'all';
        $_SESSION['simfilterlimit']     = '100';
        $_SESSION['display']            = 'display';
}

if (isset($_POST['type'])) {
    // A filter request has been made!
    $_SESSION['simfilterstate'] = $_POST['state'];
    $_SESSION['simfiltertype'] = $_POST['type'];
    $_SESSION['simfilterlimit'] = $_POST['limit'];
    $_SESSION['display'] = $_POST['display'];
    header("Location: simulations.php?#filterset"); /* Redirect browser */
}

if (isset($_POST['simulationcopy'])) {
    if (in_array($_POST['simulationname'],$simList)) {
        $smarty->assign('error', 'Cannot copy due to duplicate name error. Choose a different name');
    } else {
        //Go ahead and create the copy
        //Get next sim id from presage table "counters"
        $counter = new CountersModel();
        $id = $counter->findOne(array("_id" => "simulations"));
        $useid = $id->getNext()+1;
        $id->setNext(new MongoInt64($useid));
        $id->save();
        
        // Load simulation to be copied
        $simulation = new SimulationModel();
        $sim = $simulation->findOne(array("_id" => (int)$_POST['simulationcopy']));

        $newsim = new SimulationModel(
                                        array(  '_id'               =>  new MongoInt64($useid),
                                                'name'              =>  $_POST['simulationname'],
                                                'classname'         =>  $sim->getClassname(),
                                                'description'       =>  $_POST['simulationdescription'],
                                                'state'             =>  DEFAULT_STATE,
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
} elseif (isset($_GET['keep'])) {
        $sims = new SimulationModel();
    $dave = $sims->findOne(array("_id" => (int)$_GET['simid']));
    $dave->setKeep('true');
    $dave->save();
}


    $simquery = new SimulationModel();    // instantiate collection model
 
    if ($_SESSION['simfilterstate'] == 'all') {
        //don't filter
        $state = array();
    } elseif ($_SESSION['simfilterstate'] == 'notstarted') {
        $state = array('state'=>'NOT STARTED');
    } elseif ($_SESSION['simfilterstate'] == 'running') {
        $state = array('state'=>'RUNNING');
    } elseif ($_SESSION['simfilterstate'] == 'complete') {
        $state = array('state'=>'COMPLETE');
    }

 
    if ($_SESSION['simfiltertype'] == 'all') {
        //don't filter
        $type = array();
    } elseif ($_SESSION['simfiltertype'] == 'kyoto') {
        $type = array('classname'=>DEFAULT_CLASSNAME);
    }

    if ($_SESSION['display'] == 'all') {
        //don't filter
        $keep = array();
    } elseif ($_SESSION['display'] == 'display') {
        $keep = array('keep'=>'true');
    }
    $search1 = array_merge($type, $state);
    $search2 = array_merge($keep, $search1);
    
    $results = $simquery->find($search2, array('sort'=>array("_id"=>-1), 'limit'=>(int)$_SESSION['simfilterlimit']));

    $s = array();
    foreach ($results as $sim) {
        $s[] = $sim->getAttributes();
    }


$smarty->assign('simList',$simList);
$smarty->assign('simulations', $s);
$smarty->assign('DEFAULT_CLASSNAME',DEFAULT_CLASSNAME);
$smarty->display('views/simulations.tpl');

?>
