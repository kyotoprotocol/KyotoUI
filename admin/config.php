<?php
include('functions.php');
include('libs/mongorecord/BaseMongoRecord.php');
include('models/SimulationModel.php');
include('models/EnvironmentStateModel.php');
include('models/CountersModel.php');
include('models/AgentsModel.php');
include('models/AgentStateModel.php');
include('models/ResultModel.php');






// Database options
// Remote host: 
define ("DB", "presage");
define ("SIMTREE", "simulations");
define ("LOCAL_HOST", "127.0.0.1:27017");
define ("REMOTE_HOST", "155.198.117.244:27017");



//Kyoto Simulation Defaults
define ("DEFAULT_STATE", "NOT STARTED");
define ("DEFAULT_CURRENTTIME", "0");
define ("DEFAULT_FINISHTIME", "10");
define ("DEFAULT_CLASSNAME", "uk.ac.ic.kyoto.simulations.Simulation");

define ("AGENT_CLASS_LIST", "NonAnnex,AbstractPostCommunistCountry,EU,CanadaAgent,USAgent,NonParticipant");


define ("NOTICE_1", "change in kyoto state, before, after, ticknumber");


// Session for remembering database choice.
session_start();
if($_SESSION['database']=='remote') {
    define ("HOST", REMOTE_HOST);
} else {
    $_SESSION['database']='local';
    define ("HOST", LOCAL_HOST);
}




try {
BaseMongoRecord::$connection = new Mongo(HOST);
BaseMongoRecord::$database = 'presage';
    } catch(MongoConnectionException $e) {
        //var_dump($e);
    }

//some of the old code still uses this method of connecting. Instead use a MongoRecord model
function startDB(){
    try {
        $m = new Mongo(HOST);
        $db = $m->selectDB(DB);
        return $db;
    } catch(MongoConnectionException $e) {
   //     echo $e;
   //     echo "DB FAIL";
        return 'failure';
        //die();
    }
}


function simulationList() {
    $simquery = new SimulationModel();    // instantiate collection model
    $results = $simquery->find(array('classname'=> DEFAULT_CLASSNAME ), array('sort'=>array("_id"=>1)));
$simulations = array();
    foreach ($results as $sim) {
        $s = $sim->getAttributes();
        $simulations[$s["_id"]] = $s["name"];
    }
    return $simulations;
}


function agentList() {
    return explode(',',AGENT_CLASS_LIST);
}


?>
