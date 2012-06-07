<?php

// Database options
define ("HOST", "127.0.0.1:fave");
define ("DB", "presage");

        
// Template options (smarty)

function startDB(){
    
    $m = new Mongo(HOST);
    $db = $m->selectDB(DB);
    return $db;
}

?>
