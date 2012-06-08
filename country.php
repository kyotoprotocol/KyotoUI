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
            $sim = $simsDB->findOne(array("_id" => (int)$_GET['simid']));
            if(isset($_GET['country'])){
                $country = $sim['countries'][$_GET['country']];
            } else {
                $country = $sim['countries']['ALB'];
            } 
        } else {
            $sim = $simsDB->findOne();
            if(isset($_GET['country'])){
                $country = $sim['countries'][$_GET['country']];
            } else {
                $country = $sim['countries']['ALB'];
            }  
        }
    
        foreach(array_keys($sim['countries']) as $key){
            $cDrop[] = array('ISO' => $key, 'name' => $sim['countries'][$key]['name']);
        }
        
        //Grab updated country data - SORT LATER
            if (isset($_POST['_id'])){                       //check post data set
            foreach(array_keys($_POST) as $key){
                //$country = $sim['countries'][$_POST[$key]];
            }
            //$mongoId = new MongoID($_POST['_id']);          //ensure proper Mongo ID
            //$CountryDefaults->update(array('_id' => $mongoId), $countryData);
            //$smarty->assign('updated', true);
        }
        
        $smarty->assign('country', $country);
        $smarty->assign('cDrop',$cDrop);                    
        $smarty->display('views/country.tpl');

} catch (MongoConnectionException $e) {
    echo $e;
}

?>