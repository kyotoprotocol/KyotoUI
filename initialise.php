<?php

    require('libs/Smarty.class.php');
    $smarty = new Smarty;

    
include('admin/config.php');


try {
    $m = new Mongo();
    $db = $m->selectDB(DB);
       
    $list = $db->listCollections();
    $smarty->assign('collections',$list);
    $smarty->assign('host',HOST);
    $smarty->assign('db',DB);


    // remove any previous defaults to be sure
    $CountryDefaults = $db->selectCollection("CountryDefaults");
    $CountryDefaults->drop();
    
    $db->createCollection("CountryDefaults");
    $CountryDefaults = $db->selectCollection("CountryDefaults");
    
    $file = fopen('admin/data.csv', 'r');
    // grab the first line - for headers possibly useful later
     $csvheaders = fgetcsv($file);
     
    while (($line = fgetcsv($file)) !== FALSE) {
            $i = 0;
            foreach ($csvheaders as $header) {
                $country[$header] = $line[$i];
                echo $header . " " . $line[$i];
            $i++;
        }
        //add each country as a new object in mongo
        $CountryDefaults->insert($country);
        unset($country); //Empty country variable.
    }
    fclose($file);

    
    $smarty->assign('status',"Success");
    
} catch (MongoConnectionException $e)
{
    echo $e;
    $smarty->assign('status',$e);

}

    $smarty->display('views/initialise.tpl');


?>