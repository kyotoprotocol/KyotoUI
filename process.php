<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');
$smarty->caching = false;
$smarty->assign('simList',simulationList());

//GET SIM ID

//FIRST FIND LIST OF ALL AGENTS PROCESSED


//NEXT FIND OUT WHAT AGENT IS TO BE WORKED ON

//LOAD UP AGENT STATE DATA + PROCESS INTO DESIRED TABLE

//header("Location: process.php?page=2"); /* Redirect browser */



?>
