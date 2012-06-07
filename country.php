<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


try {
    $db = startDB();
    $simsDB = $db->selectCollection('simulations');
    
    $simsCountryCursor = $simsDB->find(array(), array('countries' => 1));
    
    foreach($simsCountryCursor as $cc){
        foreach($cc['countries'] as $c){
            $countries[] = $c;
        }
    }
    
    var_dump($countries);
    
/*    foreach($simsCursor as $sims){
        $simulations[] = $sims;
        foreach($sims['countries'] as $country){
            $countries[] = $country;
        }
    }*/ //HOW TO QUERY!
    

        // Load specific simulation
        if (isset($_GET['simid'])) {
            $simsCursor = $simsDB->findOne(array("_id" => $_GET['simid']));
            $simulation = $simsCursor('name');
        } else {
            $simsCursor = $simsDB->findOne();
            $simulation = $simsCursor['name'];
        }
    
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
            $cursor = $simsCursor->findOne(array('countries.ISO' => $_GET['country']));
            $simsCursor->findOne(10);
            $country = $cursor['name'];
        } else {
            $cursor = $simsCursor->findOne(array('countries'));
            $country = $cursor['name'];
        }
        $smarty->assign('countrydata', $cursor);

        $cursor = $countryDefaults->find()->sort(array('name' => 1));
        // Provide array for dropdown links
        foreach ($cursor as $obj) {
            $line['ISO'] = $obj['ISO'];
            $line['name'] = $obj['name']. '   '. $obj['ISO'];
            $dropdown[] = $line;
        }
        
        $smarty->assign('dropdown',$dropdown);                    
        $smarty->assign('country', $country);
        $smarty->display('views/country.tpl');

        $cursor = $countryDefaults->find();
 
} catch (MongoConnectionException $e) {
    echo $e;
}



?>