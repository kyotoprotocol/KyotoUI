<?php
include('head.php');
include('admin/dbconfig.php');


try {
$m = new Mongo();
    $db = $m->selectDB(DB);
    #echo 'david';
    
    $list = $db->listCollections();
        echo "<ul>";
            foreach ($list as $collection) {
                echo "<li> $collection... </li>";
            }
        echo "</ul>";
    
    // remove any previous defaults to be sure
    $CountryDefaults = $db->selectCollection("CountryDefaults");
    $CountryDefaults->drop();
    
    $db->createCollection("CountryDefaults");
    $CountryDefaults = $db->selectCollection("CountryDefaults");
    
    $file = fopen('admin/data.csv', 'r');
    // grab the first line - for headers possibly useful later
     $line = fgetcsv($file);
    while (($line = fgetcsv($file)) !== FALSE) {
        
        //add each country as a new object in mongo
        $country = array ("ISO" => $line[2], "name" => $line[1], "type" => $line[0], "totalArea" => $line[5], "landArea" => $line[6], "waterArea"  => $line[7], "arableLand" => $line[8], "ISO2" => $line[9]);
        $CountryDefaults->insert($country);

    }
    fclose($file);

 
    
} catch (MongoConnectionException $e)
{
    echo $e;
}



?>