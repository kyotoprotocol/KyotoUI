<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());


        $simulation = new SimulationModel();    // instantiate collection model
            
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            $sim = $simulation->findOne(array(), array('countries' => 1));
        }
        
        $countries = $sim->getCountries();
        $simID = new MongoInt64($sim->getID());
        
        // Load specific country for editing
        if(isset($_GET['country'])){
            $country = $countries[toISO3($_GET['country'])];
        } else {
            $country = end($countries);
        } 
        
        $ISO2 = toISO2($country['ISO']);
        
        //Grab updated country data - SORT LATER
        if (isset($_POST['ISO'])){                      //check post data set
            foreach(array_keys($_POST) as $key){        //tell this to ignore iso2 in the tpl file
                $country[$key] = $_POST[$key];          //update country
            }
            $countries[$country['ISO']] = $country;
            $sim->setCountries($countries);
            $sim->save();                               // save changes to database collection
            $smarty->assign('updated', true);
        }

        
        // send all required variables to smarty view
        $smarty->assign('agentList', agentList());
        $smarty->assign('simName', $sim->getName());
        $smarty->assign('country', $country);
        $smarty->assign('ISO2', $ISO2);
        $smarty->assign('simID', $simID);
        $smarty->assign('countries', $countries);                    
        $smarty->display('views/country.tpl');

?>