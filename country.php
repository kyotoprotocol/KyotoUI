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
                $country = $sim['countries'][toISO3($_GET['country'])];
            } else {
                $country = $sim['countries']['ALB'];
            } 
        } else {

            $sim = $simsDB->findOne(array(), array("countries" => 1));
       //Bit crude I guess but I haven't got a better idea and you shouldn't be on this page without a simId
        //if (!in($sim, "country")){
        //    echo "Cannot find a default country class in a default simulation";
        //    die();
        }
        
        if(isset($_GET['country'])){
                $country = $sim['countries'][toISO3($_GET['country'])];
            } else {
                $country = $sim['countries']['ALB'];
            }  

    
        foreach(array_keys($sim['countries']) as $key){
            $cDrop[] = array('ISO' => $key, 'name' => $sim['countries'][$key]['name']);
        }
        
        //Grab updated country data - SORT LATER
        if (isset($_POST['_id'])){                      //check post data set
            foreach(array_keys($_POST) as $key){        //tell this to ignore iso2 in the tpl file
                $country[$key] = $_POST[$key];          //update country
            }
            $simDB->update(array('_id' => (int)$sim['_id'], 'countries' => $country['ISO']), $country);
            $smarty->assign('updated', true);
        }
        
        $country['ISO2'] = toISO2($country['ISO']); 
        
        $smarty->assign('country', $country);
        $smarty->assign('cDrop', $cDrop);                    
        $smarty->display('views/country.tpl');

} catch (MongoConnectionException $e) {
    echo $e;
}
?>