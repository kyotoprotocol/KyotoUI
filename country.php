<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');


include('admin/config.php');


try {
?>


  

<?php
    $m = new Mongo();
    $db = $m->selectDB(DB);
    
    $CountryDefaults = $db->selectCollection("CountryDefaults");

    // Load specific country
        if (isset($_GET['country'])) {
            $cursor = $CountryDefaults->findOne(array("ISO" => $_GET['country']));
            $country = $cursor['name'];
        } else {
            $cursor = $CountryDefaults->findOne();
            $country = $cursor['name'];
        }
        $smarty->assign('countrydata', $cursor);

        $cursor = $CountryDefaults->find();
        // Provide array for dropdown links
        foreach ($cursor as $obj) {
            $line['ISO'] = $obj['ISO'];
            $line['name'] = $obj['name']. '   '. $obj['ISO'];
            $dave[] = $line;
        }
        $smarty->assign('dropdown',$dave);                    
        $smarty->assign('country', $country);
        $smarty->display('views/country.tpl');

        $cursor = $CountryDefaults->find();
 
} catch (MongoConnectionException $e) {
    echo $e;
}



?>
