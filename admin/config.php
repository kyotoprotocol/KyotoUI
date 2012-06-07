<?php

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


        
// Template options (smarty)

function startDB(){
    $m = new Mongo(HOST);
    $db = $m->selectDB(DB);
    return $db;
}

?>
