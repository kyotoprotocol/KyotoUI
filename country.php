<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


    try {
        $simulation = new SimulationModel();
        //$hello = $simulation->findOne(array(), array('countries' => 1));
        //$hello->setCountries(array('ALB' => array('name' => 'Albania', 'wank' => 'cunt')));
      // $cunt= $hello->getCountries('ALB');
        //var_dump($cunt);
        //die();
            
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            $sim = $simulation->findOne(array(), array('countries' => 1));
        }
        
        $countries = $sim->getCountries();
        $simID = new MongoInt64($sim->getID());
        
        
        if(isset($_GET['country'])){
            $country = $countries[toISO3($_GET['country'])];
        } else {
            $country = $countries['ALB'];
        } 
        
        $ISO2 = toISO2($country['ISO']);
        
        //Grab updated country data - SORT LATER
        if (isset($_POST['ISO'])){                      //check post data set
            foreach(array_keys($_POST) as $key){        //tell this to ignore iso2 in the tpl file
                $country[$key] = $_POST[$key];          //update country
            }
            $sim->setCountries(array($country['ISO'] => $country));
            $sim->save();
            $smarty->assign('updated', true);
        }
            
        //Bit crude I guess but I haven't got a better idea and you shouldn't be on this page without a simId
        //if (!in_array($sim, "country")){
        //   echo "Cannot find a default country class in a default simulation";
        //    die();
        //}

        //foreach(array_keys($sim['countries']) as $key){
        //    $cDrop[] = array('ISO' => $key, 'name' => $sim['countries'][$key]['name']);
        //}
        $cDrop = $countries;
        
        
        $smarty->assign('simName', $sim->getName());
        $smarty->assign('country', $country);
        $smarty->assign('ISO2', $ISO2);
        $smarty->assign('simID', $simID);
        $smarty->assign('cDrop', $cDrop);                    
        $smarty->display('views/country.tpl');

} catch (MongoConnectionException $e) {
    echo $e;
}
?>