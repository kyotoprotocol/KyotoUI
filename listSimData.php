<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simList',simulationList());
        
            
            if (isset($_POST['delete'])){

            }







        $simulation = new SimulationModel();    // instantiate collection model
        $simquery = $simulation->find(array(),array(array('sort'=>'currentTime')));
        
        $i=0;
        foreach ($simquery as $sim) {
                    $agents = new AgentsModel();    // instantiate collection model
                    $co = $agents->find(array('simID'=>$sim->getID()))->count();
                    $i = $sim->getCurrentTime()*$co;
            $damageArray[$i]['FAT'] = $i;
            $damageArray[$i]['agentCount'] = $co;
            $damageArray[$i]['ID'] = $sim->getID();
            $damageArray[$i]['name'] = $sim->getName();
            $damageArray[$i]['description'] = $sim->getDescription();
            $damageArray[$i]['author'] = $sim->getAuthor();
            $damageArray[$i]['currentTime'] = $sim->getCurrentTime();

        }
        arsort($damageArray);
        $smarty->assign('damagearray',$damageArray);
        $smarty->display('views/listSimData.tpl');
?>