<?php

/*
 * To be used for exporting simulations as CSV for git update/upload
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');



if (isset($_POST)) {
    if ($_POST['filename']) {
        
    }
    
}




//Render page
$smarty->display('views/export.tpl');

?>
