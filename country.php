<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


    try {
        $db = startDB();
        $simsDB = $db->selectCollection('simulations');    
    
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simsDB->findOne(array("_id" => $_GET['simid']));
            var_dump($simsDB->findOne(array("_id" => (int)$_GET['simid'], 'countries.ISO' => (string)$_GET['country']), array('countries' => 1)));
        } else {
            $sim = $simsDB->findOne();
            var_dump($simsDB->findOne(array("_id" => (int)$sim['_id'], 'countries.ISO' => (string)$_GET['country']), array('countries' => 1)));
        }
    
        foreach($sim['countries'] as $country){
            $dropdown[] = ($country['ISO'] . '     ' . $country['name']);
        }
        
    //die();
    /*
        //Grab updated country data - SORT LATER
            if (isset($_POST['_id'])){                       //check post data set
            foreach(array_keys($_POST) as $key){
                $countryData[$key] = $_POST[$key];
            }
            $mongoId = new MongoID($_POST['_id']);          //ensure proper Mongo ID
            $CountryDefaults->update(array('_id' => $mongoId), $countryData);
            $smarty->assign('updated', true);
        }  */
    
        
        // Load specific country from within simulation
        if (isset($_GET['country'])) {
            
            //var_dump(array_search($_GET['country'], $sim['countries']));
            //$country = $sim['countries'][array_search($_GET['country'], $sim['countries'])];
        } else {
            $country = $sim['countries'][0];
        }
        
        //var_dump($country);
        die();
        
        $smarty->assign('country', $country);
        $smarty->assign('dropdown',$dropdown);                    
        $smarty->display('views/country.tpl');

        $cursor = $countryDefaults->find();
 
} catch (MongoConnectionException $e) {
    echo $e;
}

?>