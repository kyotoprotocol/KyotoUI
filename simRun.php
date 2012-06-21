<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');

    
    $smarty->display('views/simRun.tpl');
        
?>