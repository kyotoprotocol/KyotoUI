<?php
include('functions.php');
// Database options
define ("HOST", "127.0.0.1:27017");
define ("DB", "presage");
define ("SIMTREE", "simulations");


//Kyoto Simulation Defaults
define ("DEFAULTSIM", "defaultsimulation");
define ("DEFAULTCLASS", "SimulateKyoto");
define ("DEFAULTSTATE", "NOT STARTED");
define ("DEFAULTCURRENTTIME", "0");
define ("DEFAULTFINISHTIME", "10");
define ("DEFAULTDESCRIPTION", "This is a default class. Ideally all countries are included and it is designed to demonstrate how beautiful the economic models are that we have created.");


        
// Template options (smarty)

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
