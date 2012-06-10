<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;


include('admin/config.php');

        $simulation = new SimulationModel();    // instantiate collection model
            
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            $sim = $simulation->findOne(array(), array('countries' => 1));
        }
        
        $countries = $sim->getCountries();      // populate countries array from collection
        $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
        
        foreach ($countries as $c) {            // package countries to contain all relevant data
            $countriesDisplay[$c['ISO']] = $c;
            $countriesDisplay[$c['ISO']]['arableLandAreaPC'] = (int)(($c['arableLandArea']/$c['landArea'])*100) ;
            $countriesDisplay[$c['ISO']]['ISO2'] = toISO2($c['ISO']);
        }
        
        $smarty->assign('countries',$countriesDisplay);
        $smarty->assign('simulationname', $sim->getName());
        $smarty->assign('simID', $simID);
        $smarty->display('views/simOverview.tpl');
?>