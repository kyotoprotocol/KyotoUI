<?php

include('admin/dbconfig.php');


try {
$m = new Mongo();
    $db = $m->selectDB(DB);
    #echo 'david';
    
} catch (MongoConnectionException $e)
{
    echo $e;
}



?>