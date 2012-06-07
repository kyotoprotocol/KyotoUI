<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


try {
    $db = startDB();
    $simsDB = $db->selectCollection('simulations');    
    
/*    foreach($simsCursor as $sims){
        $simulations[] = $sims;
        foreach($sims['countries'] as $country){
            $countries[] = $country;
        }
    }*/ //HOW TO QUERY!
    

        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simsDB->findOne(array("_id" => $_GET['simid']));
        } else {
            $sim = $simsDB->findOne();
        }
    
        foreach($sim['countries'] as $country){
            $dropdown[] = ($country['ISO'] . '     ' . $country['name']);
        }
        
    die();
    
        //Grab updated country data - SORT LATER
            if (isset($_POST['_id'])){                       //check post data set
            foreach(array_keys($_POST) as $key){
                $countryData[$key] = $_POST[$key];
            }
            $mongoId = new MongoID($_POST['_id']);          //ensure proper Mongo ID
            $CountryDefaults->update(array('_id' => $mongoId), $countryData);
            $smarty->assign('updated', true);
        }  
    

        
        // Load specific country from within simulation
        if (isset($_GET['country'])) {
            $country = array_search($_GET['country'], $sim['countries']);  //match get country ISO with sim['countries']['iso'] 
            $simsCursor->findOne(10);
            $country = $cursor['name'];
        } else {
            $cursor = $simsCursor->findOne(array('countries'));
            $country = $cursor['name'];
        }
        $smarty->assign('countrydata', $cursor);
        
        $smarty->assign('dropdown',$dropdown);                    
        $smarty->assign('country', $country);
        $smarty->display('views/country.tpl');

        $cursor = $countryDefaults->find();
 
} catch (MongoConnectionException $e) {
    echo $e;
}



?>