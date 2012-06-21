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
    $smarty->assign('mongodbconnectLocal', 'on');
    $smarty->assign('local', 'disabled');
    } else {
    $smarty->assign('local', 'enabled');

        /*if (isset($_GET['database'])) {
            $_SESSION['database']=$_GET['database'];
                header("Location: index.php?#dbset"); 
        }*/
    }
    //

    if (startRemoteDB()=='failure'){
    $smarty->assign('mongodbconnectRemote', 'on');
    $smarty->assign('remote', 'disabled');
    } else {
    $smarty->assign('remote', 'enabled');
    }

    
    
}

    if (isset($_GET['database'])) {
            $_SESSION['database']=$_GET['database'];
            header("Location: index.php?#dbset"); /* Redirect browser */
    }

   $smarty->assign('setdb', $_SESSION['database']);
//$smarty->assign('simList',simulationList());
$smarty->display('views/index.tpl');
?>
