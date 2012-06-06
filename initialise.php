<?php

include('admin/dbconfig.php');


try {
$m = new Mongo();
    $db = $m->selectDB(DB);
    #echo 'david';
    
    $list = $db->listCollections();
    foreach ($list as $collection) {
        echo "> $collection... <br>";
     //   $collection->drop();
     //   echo "gone\n";
    }
    
    $db->createCollection("CountryDefaults");
    
} catch (MongoConnectionException $e)
{
    echo $e;
}



?>