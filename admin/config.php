<?php
include('functions.php');
include('libs/mongorecord/BaseMongoRecord.php');
include('models/SimulationModel.php');
include('models/EnvironmentStateModel.php');
include('models/CountersModel.php');

// Database options
// Remote host: 155.198.117.244
define ("HOST", "127.0.0.1:27017");
define ("DB", "presage");
define ("SIMTREE", "simulations");


//Kyoto Simulation Defaults
define ("DEFAULT_STATE", "NOT STARTED");
define ("DEFAULT_CURRENTTIME", "0");
define ("DEFAULT_FINISHTIME", "10");
define ("DEFAULT_CLASSNAME", "uk.ac.ic.kyoto.Simulation");

define ("AGENT_CLASS_LIST", "NonAnnex,AbstractPostCommunistCountry,EU,CanadaAgent,USAgent,NonParticipant");


BaseMongoRecord::$connection = new Mongo(HOST);
BaseMongoRecord::$database = 'presage';


//some of the old code still uses this method of connecting. Instead use a MongoRecord model
function startDB(){
    try {
        $m = new Mongo(HOST);
        $db = $m->selectDB(DB);
        return $db;
    } catch(MongoConnectionException $e) {
        echo $e;
        echo "DB FAIL";
        die();
    }
}


function simulationList() {
    $simquery = new SimulationModel();    // instantiate collection model
    $results = $simquery->find(array(), array('sort'=>array("_id"=>1)));
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
