<?php

    require('libs/Smarty.class.php');
    $smarty = new Smarty;

    
include('admin/config.php');


try {
    
    $db = startDB();
       
    $list = $db->listCollections();
    $smarty->assign('collections',$list);
    $smarty->assign('host',HOST);
    $smarty->assign('db',DB);


    // remove any previous defaults to be sure
    if (isset($_GET['init'])) {    
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
    //debug                echo $header . " " . $line[$i];
                $i++;
            }
            //add each country as a new object in mongo
            $CountryDefaults->insert($country);
            unset($country); //Empty country variable.
        }
        fclose($file);
    $smarty->assign('status',"Success");
    } else {
     $smarty->assign('status',"Not Started");
     $smarty->assign('go', 'true');
        
    }
    
} catch (MongoConnectionException $e)
{
    //echo $e;
    $smarty->assign('status',$e);

}

    $smarty->display('views/initialise.tpl');


?>