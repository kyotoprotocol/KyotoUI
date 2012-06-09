<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');

        $simulation = new SimulationModel();
            
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            $sim = $simulation->findOne(array(), array('countries' => 1));
        }
        
        $countries = $sim->getCountries();
        $simID = new MongoInt64($sim->getID());
        
        foreach ($countries as $c) {
            $countriesDisplay[$c['ISO']] = $c;
            $countriesDisplay[$c['ISO']]['arableLandAreaPC'] = (int)(($c['arableLandArea']/$c['landArea'])*100) ;
            $countriesDisplay[$c['ISO']]['ISO2'] = toISO2($c['ISO']);
        }
        
        $smarty->assign('countries',$countriesDisplay);
        $smarty->assign('simulationname', $sim->getName());
        $smarty->assign('simID', $simID);
        $smarty->display('views/simOverview.tpl');
?>