<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


try {
    $db = startDB();
    $updated = false;
    $CountryDefaults = $db->selectCollection("CountryDefaults");

        if (isset($_POST['_id'])){                       //check post data set
            foreach(array_keys($_POST) as $key){
                if($key != '_id'){                      //remove _id from array to be updated
                    $countryData[$key] = $_POST[$key];
                }
            }
            $mongoId = new MongoID($_POST['_id']);      //ensure proper Mongo ID
            $CountryDefaults->update(array('_id' => $mongoId), $countryData);
            $smarty->assign('updated', true);
        }  
    
    // Load specific country
        if (isset($_GET['country'])) {
            $cursor = $CountryDefaults->findOne(array("ISO" => $_GET['country']));
            $country = $cursor['name'];
        } else {
            $cursor = $CountryDefaults->findOne();
            $country = $cursor['name'];
        }
        $smarty->assign('countrydata', $cursor);

        $cursor = $CountryDefaults->find()->sort(array('name' => 1));
        // Provide array for dropdown links
        foreach ($cursor as $obj) {
            $line['ISO'] = $obj['ISO'];
            $line['name'] = $obj['name']. '   '. $obj['ISO'];
            $dave[] = $line;
        }
        
        $smarty->assign('dropdown',$dave);                    
        $smarty->assign('country', $country);
        $smarty->display('views/country.tpl');

        $cursor = $CountryDefaults->find();
 
} catch (MongoConnectionException $e) {
    echo $e;
}



?>