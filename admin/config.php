<?php
include('functions.php');
include('libs/mongorecord/BaseMongoRecord.php');
include('models/SimulationModel.php');
include('models/EnvironmentStateModel.php');
include('models/CountersModel.php');

// Database options
define ("HOST", "127.0.0.1:27017");
define ("DB", "presage");
define ("SIMTREE", "simulations");


//Kyoto Simulation Defaults
define ("DEFAULT_SIMCSV", "data.csv");
define ("DEFAULT_SIM", "defaultsimulation");
define ("DEFAULT_CLASS", "SimulateKyoto");
define ("DEFAULT_STATE", "NOT STARTED");
define ("DEFAULT_CURRENTTIME", "0");
define ("DEFAULT_FINISHTIME", "10");
define ("DEFAULT_DESCRIPTION", "This is a default class. Ideally all countries are included and it is designed to demonstrate how beautiful the economic models are that we have created.");

//Config params for baby simulation if we necessary
define ("DEFAULT_BABY_SIMCSV", "babydata.csv");
define ("DEFAULT_BABY_SIM", "defaultbabysimulation");
define ("DEFAULT_BABY_CLASS", DEFAULT_CLASS);
define ("DEFAULT_BABY_STATE", DEFAULT_STATE);
define ("DEFAULT_BABY_CURRENTTIME", DEFAULT_CURRENTTIME);
define ("DEFAULT_BABY_FINISHTIME", DEFAULT_FINISHTIME);
define ("DEFAULT_BABY_DESCRIPTION", "This is a default baby class, has a smaller dataset to get going.");


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

?>
