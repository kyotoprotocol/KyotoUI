<?php
require('libs/Smarty.class.php');
/*
 * 
  ____          _      
 |  _ \   /\   | |     
 | |_) | /  \  | |     
 |  _ < / /\ \ | |     
 | |_) / ____ \| |____ 
 |____/_/    \_\______|
 * 
 */
$smarty = new Smarty;


// CHECK FOR MONGO DRIVER (PHP EXTENSION)
if (!extension_loaded('mongo')) {
    $smarty->assign('mongodriver', 'on');
    $smarty->assign('local', 'disabled');
} else {
    require('admin/config.php');
    if (startDB()=='failure'){
    $smarty->assign('mongodbconnect', 'on');
    $smarty->assign('local', 'disabled');
    } else {
    $smarty->assign('local', 'enabled');

        if (isset($_POST['database'])) {
            $_SESSION['database']=$_POST['database'];
        }
    }
}

    if (isset($_POST['database'])) {
            $_SESSION['database']=$_POST['database'];
       //     $smarty->assign('setdb', 'remote');
    }

   $smarty->assign('setdb', $_SESSION['database']);

//$smarty->assign('simList',simulationList());
$smarty->display('views/index.tpl');
?>
