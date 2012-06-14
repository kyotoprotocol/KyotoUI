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
        // Not the best idea to default load sim, no idea if an error occurs in linking simid!!
        //    $sim = $simulation->findOne(array(), array('countries' => 1));
        }
        
        $countries = $sim->getCountries();      // populate countries array from collection
        $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
        

        //ADD comparison data for map here:
        foreach ($countries as $c) {            // package countries to contain all relevant data
            $countriesDisplay[$c['ISO']] = $c;
            $countriesDisplay[$c['ISO']]['arableLandAreaPercent'] = (int)(($c['arableLandArea']/$c['landArea'])*100) ;
            $countriesDisplay[$c['ISO']]['ISO2'] = toISO2($c['ISO']);
            $countriesDisplay[$c['ISO']]['GDPperkm2'] = (int)(($c['GDP']/$c['landArea'])) ;
            foreach (agentList() as $agenttype){
                if ($c['className'] == $agenttype) {
                    $countriesDisplay[$c['ISO']]['Group'.$agenttype] = (int)1 ;
                } else {
                    $countriesDisplay[$c['ISO']]['Group'.$agenttype] = (int)0 ;
                }
            }
        }
        
        
        //Make list for dropdown + js
        $array = array_keys(end($countriesDisplay));
        foreach ($array as $item) {
            // Take care of non number examples.
            $countryd = end($countriesDisplay);
            if (is_numeric($countryd[$item])) {
                $dropdownarray[] = $item;
            }
        }
//        var_dump($dropdownarray);
        $smarty->assign('dropdownlist',$dropdownarray);
        $smarty->assign('countries',$countriesDisplay);
        
        $smarty->assign('simAuthor', $sim->getAuthor());
        $smarty->assign('simName', $sim->getName());
        $smarty->assign('simDescription', $sim->getDescription());
        $smarty->assign('simData', $sim->getAttributes());
        $smarty->assign('simID', $simID);
        $smarty->display('views/simOverview.tpl');
?>