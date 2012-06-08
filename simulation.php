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
        } else {
            $sim = $simsDB->findOne();
        }
        $smarty->assign('simulationname', $sim['name']);
        
        //Grab updated country data - SORT LATER
        if (isset($_POST['ISO'])){                      //check post data set
            foreach(array_keys($_POST) as $key){        //tell this to ignore iso2 in the tpl file
                $country[$key] = $_POST[$key];          //update country
            }
            $simID = new MongoInt64($sim['_id']);
       
            

            $db->simulations->update(array($simID.'countries.ALB' => array("exists"=>"true")), array($set => array($simID.'countries.ALB' => $country)));

            $smarty->assign('updated', true);
        }

        foreach(array_keys($sim['countries']) as $key){
            $cDrop[] = array('ISO' => $key, 'name' => $sim['countries'][$key]['name']);
        }
        
       // $country['ISO2'] = toISO2($country['ISO']); 
        
    //    $smarty->assign('simid', $sim['_id']);

      //  $smarty->assign('country', $country);
        $smarty->assign('cDrop', $cDrop);                    
        $smarty->display('views/simulation.tpl');

} catch (MongoConnectionException $e) {
    echo $e;
}
?>