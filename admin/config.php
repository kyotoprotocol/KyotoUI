<?php

// Database options
define ("HOST", "127.0.0.1:27017");
define ("DB", "presage");

        
// Template options (smarty)

function startDB(){
    
    $m = new Mongo(HOST);
    $db = $m->selectDB(DB);
    return $db;
}

?>
