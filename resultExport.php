<?php

/*
 * To be used for exporting simulations as CSV for git update/upload
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->assign('simid',$_GET['simid']);

//obtain list and (if any) selected sim

if (isset($_GET['part'])) {
    
                $resultQ = new ResultModel();    // instantiate collection model
            $results = $resultQ->find(array("simID" => (int)$_GET['simid']),array('offset'=>floor($_GET['part']*5000), 'limit'=>5000,  'sort'=>array('ISO'=>1,'year'=>1,'quarter'=>1)));
         $fp = fopen('local/'.$_GET['simid'].'results.csv', 'a');
         //fseek($fp,-1, SEEK_END);
            $previous = array();
             if ($_GET['part']=='0'){
                    $dave2 = array(
                        'Tick', 
                        'Quarter', 
                        'ISO', 
                        'Year', 
                        'GDPRate', 
                        'GDP', 
                        'AvailableToSpend',   
                        'CarbonOffset', 
                        'CarbonOutput', 
                        'EnergyOutput', 
                        'ArableLandArea', 
                        'CarbonAbsorption', 
                        'IsKyotoMember',  
                        'Cheated'
                            );
               fputcsv($fp, $dave2);

             }

            foreach($results as $r) {
                if ($previous==$r){
                // echo 'error<br>';
                } else {
                   // var_dump($r->getAttributes());
                    $dave = array(
                        $r->getTick(), 
                        $r->getQuarter(), 
                        $r->getISO(), 
                        $r->getYear(), 
                        $r->getGDPRate(), 
                        $r->getGDP(), 
                        $r->getAvailableToSpend(),   
                        $r->getCarbonOffset(), 
                        $r->getCarbonOutput(), 
                        $r->getEnergyOutput(), 
                        $r->getArableLandArea(), 
                        $r->getCarbonAbsorption(), 
                        $r->getIsKyotoMember(),  
                        $r->getCheated()
                            );
                fputcsv($fp, $dave);

                   echo $r->getISO().$r->getYear().':'.$r->getQuarter().'<br>';
                }
                $previous = $r;
            }
            fclose($fp); 
            $part = (int)$_GET['part'];
            $total=  (int)$_GET['total'];
            $part++;
            if(($part<$total)) {
            header("Location: resultExport.php?simid=".$_GET['simid']."&part=".(int)($part)."&total=".$_GET['total']); /* Redirect browser */
            }
    
} else {


    //Make CSV
    if (isset($_GET['simid'])) {


            $resultQ = new ResultModel();    // instantiate collection model
            $results = $resultQ->find(array("simID" => (int)$_GET['simid']),array('sort'=>array('ISO'=>1,'year'=>1,'quarter'=>1)));
            $count = $results->count();
            $count2 =  ceil($count/5000);
            $smarty->assign('count',$count);
            $smarty->assign('count2',$count2);

            $list = array();
            for ($i=0; $i<$count2; $i++) {
                $list[] = $i;
            }
            $smarty->assign('list',$list);

            //LOOP

            //END LOOP
    // fclose($fp); 


    }

}



//Render page
$smarty->display('views/resultExport.tpl');

?>
