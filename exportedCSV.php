<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * JW RAPIDLY MADE FILE DON'T EXPECT ANY SUPPORT!
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
//$smarty->assign('simList',simulationList());


    
    $db = startDB();
    //Still uses old database function startDB, not the way to do it.
    //$list = $db->listCollections();
    //$smarty->assign('collections',$list);
    $smarty->assign('host',HOST);
    $smarty->assign('db',DB);




    if ($handle = opendir('local')) {
        $simulations = array();

        while (false !== ($entry = readdir($handle))) {
            $tag = substr($entry,0,-7);
            // Loop all SIMULATION CSV's
            $simulation = new SimulationModel();

            if (substr($entry,-7) == 'sim.csv') {
                $file = fopen('local/'.$tag.'params.csv', 'r');
                $csvdata[$tag]['file'] = $entry;
                
                while (($line = fgetcsv($file)) !== FALSE) {
                    $csvdata[$tag][$line[0]] = $line[1];
                }
                $defaultsim = $simulation->findOne(array("name" => $csvdata[$tag]['name']));
                //var_dump($defaultsim);
                if (is_null($defaultsim)) {
                    $csvdata[$tag]['id'] = 'X';
                } else {
                    $csvdata[$tag]['installed'] = 'true';
                    $csvdata[$tag]['id'] = $defaultsim->getID();
                }
                fclose($file);
                unset($file);
                
            }
        }
    closedir($handle);
    }
    $smarty->assign('CSVfiles', $csvdata);
    $smarty->display('views/exportedCSV.tpl');


?>
