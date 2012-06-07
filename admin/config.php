<?php

// Database options
define ("HOST", "127.0.0.1:27017");
define ("DB", "presage");
define ("SIMTREE", "simulations2");
define ("DEFAULTSIM", "defaultsimulation");

        
// Template options (smarty)

function startDB(){
    $m = new Mongo(HOST);
    $db = $m->selectDB(DB);
    return $db;
}

?>
