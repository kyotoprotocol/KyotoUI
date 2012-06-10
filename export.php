<?php

/*
 * To be used for exporting simulations as CSV for git update/upload
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->caching = false;
$smarty->assign('simList',simulationList());

//obtain list and (if any) selected sim

    $simquery = new SimulationModel();    // instantiate collection model
    $results = $simquery->findAll();

    foreach ($results as $sim) {
        $s = $sim->getAttributes();
        $simulations[$s["_id"]] = $s["name"];
    }
    $smarty->assign('simulations', $simulations);
    if (isset($_GET['simid'])) {
        $selected = $_GET['simid'];
    } else {
        $selected = end($simulations);
    }
    $smarty->assign('selectedsim',$selected);

  
//Make CSV
if (isset($_POST['filename'])) {
    $filename = $_POST['filename'];
    $smarty->assign('success', 'true');
    $smarty->assign('filename', $filename);
    
    $notices[] = "Making CSV for sim: ".$_POST['simulation'];
    $simquery2 = new SimulationModel();    // instantiate collection model
    $sim = $simquery2->findOne(array("_id" => (int)$_POST['simulation']));
    //var_dump($sim);
    $countries = $sim->getCountries();
    $countriesKeys = array_keys(end($countries));
    $CSVarray = array();

    $fp = fopen('local/'.$filename, 'w');

    unset($countriesKeys['_id']);
    fputcsv($fp, $countriesKeys);

    
    foreach($countries as $country) {
        $CSVarray_sub = array();
        foreach($countriesKeys as $key){
            
            if ($key == "_id") {
                // remove
            } else {
                $CSVarray_sub[$key] = $country[$key];
            }
        }
            fputcsv($fp, $CSVarray_sub);
//$CSVarray[] = $CSVarray_sub;
            unset($CSVarray_sub);
    }
    $notices[] = "Saving as: ".$filename;

   fclose($fp); 
    
    $smarty->assign('notices',$notices);
} else {

    $smarty->assign('filename', 'mynewdata.csv');

}





//Render page
$smarty->display('views/export.tpl');

?>
