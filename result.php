<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->display('views/result.tpl');


?>
