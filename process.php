<?php
function getTime()
    {
    $a = explode (' ',microtime());
    return(double) $a[0] + $a[1];
    }
$time1 = getTime(); 
$time2 = 0; 
$time3 = 0;
$looptimer = getTime(); 
        
/* THIS IS A COPY OF ESSENTIALS FROM CONFIG.PHP IN ORDER TO MINIMISE PAGE LOAD TIME ON THIS FILE.*/
include('libs/mongorecord/BaseMongoRecord.php');
include('models/SimulationModel.php');
include('models/AgentsModel.php');
include('models/AgentStateModel.php');
include('models/ResultModel.php');
define ("DB", "presage");
define ("SIMTREE", "simulations");
define ("LOCAL_HOST", "127.0.0.1:27017");
define ("REMOTE_HOST", "155.198.117.244:27017");
session_start();
if(isset($_SESSION['database'])) {
    if($_SESSION['database']=='remote') {
        define ("HOST", REMOTE_HOST);
    } else {
        $_SESSION['database']='local';
        define ("HOST", LOCAL_HOST);
    }
} else {
        $_SESSION['database']='local';
        define ("HOST", LOCAL_HOST);    
}
    try {
        BaseMongoRecord::$connection = new Mongo(HOST);
        BaseMongoRecord::$database = 'presage';
    } catch(MongoConnectionException $e) {
        //var_dump($e);
    }
    
define ("NOTICE_1", "change in kyoto state, before, after, ticknumber");

/* END OF ESSENTIALS FROM CONFIG.PHP IN ORDER TO MINIMISE PAGE LOAD TIME ON THIS FILE.*/
    
    /*
     * Some essential items:
     * 
     *      tick - each row of an agent's agentstate
     *      year - starts at 0
     *      quarter - { 0 , 1 , 2 , 3 }
     * 
     */
    
    
    
//Load SIM ID
if (isset($_GET['simid'])) {
   
    //Get simulation parameters
    $simulation = new SimulationModel();    // instantiate collection model
    $agents = new AgentsModel();    // instantiate collection model
    $sim = $simulation->findOne(array("_id" => (int)$_GET['simid']));
    $simID = new MongoInt64($sim->getID()); // ensure simID is of the correct type
    $simprop = $sim->getParameters();

    //Process-wide definitions
    define ("TICK_YEAR", $simprop['TICK_YEAR']);
    define ("TICK_LENGTH", $simprop['finishTime']);
    define ("YEARS", (int)TICK_LENGTH/TICK_YEAR);
    //define ("OUTPUTFORM", 'HTTPREQUEST');
    define ("OUTPUTFORM", 'JSON');
    define ("CRAPOUT", false);

    //Float variable of how many ticks in a quarter
    $tickquarter = ((int)TICK_YEAR)/4;
    
    //Define the database queries by using the following loops.
    for ($year = 0; $year<YEARS; $year++) {
    $quarter[$year][0] = array ('offset' => ($year*TICK_YEAR)+(int)0, 'limit' => (int)floor($tickquarter));
    $quarter[$year][1] = array ('offset' => ($year*TICK_YEAR)+(int)floor($tickquarter), 'limit' =>(int)floor($tickquarter));
    $quarter[$year][2] = array ('offset' => ($year*TICK_YEAR)+(int)(floor($tickquarter)*2), 'limit' =>(int)floor($tickquarter));
    $quarter[$year][3] = array ('offset' => ($year*TICK_YEAR)+(int)(floor($tickquarter)*3), 'limit' =>(int)(TICK_YEAR-(floor($tickquarter)*3)));
    }
    if (CRAPOUT) var_dump($quarter); //Shows the database queries to be made against agents.
    
    if (isset($_GET['agent'])) { //All steps after the first step.
        $agentCount = $_GET['agentno'];                         // Old Agent Count - now total steps in sim.
        $steps = $_GET['agentno'];                              // Total Steps in simulation - could save a few lookups in future.
        $step = $_GET['agent'];                                 // Current Step
        $progressCount = ((int)$_GET['agent']);                 // Same as above
        $currentQuarter = ((int)$_GET['agent']%4);              // Decides what quarter we've been asked to start calculating
        $agentOffset = floor((int)$_GET['agent']/(4*YEARS));    // Grabs agent from URL to obtain binary UUID
        
            if (CRAPOUT) echo 'Number of agents: '.$agentCount .'<br>';
            if (CRAPOUT) echo 'Number of steps: '.$steps .'<br>';
            if (CRAPOUT) echo 'Agent Number: '.$agentOffset .'<br>';
            if (CRAPOUT) echo 'CurrentQuarter '.$currentQuarter.'<br>';
        
        
        $aCount = (int)floor($steps/(YEARS*4));                 //Agent count
        $agentSteps = $aCount*4;                                //How many steps an agent requires
        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => $agentOffset, 'limit' => 1));
    } else {
        // Very first simulation query, initialise everything.
        $count = $agents->find(array("simID"=>$simID));
        $agentCount = $count->count();                          // How many agents we have
        $steps = $agentCount*4*YEARS;                           // Total Steps in simulation - could save a few lookups in future.
        $agentSteps = YEARS*4;                                  // How many steps each agent takes

        if (CRAPOUT) echo 'Number of agents: '.$agentCount .'<br>';
        if (CRAPOUT) echo 'Number of steps: '.$steps .'<br>';
        $currentQuarter = 0;                                    // Initialise first quarter.
        if (CRAPOUT) echo 'CurrentQuarter '.$currentQuarter.'<br>';
        $agentslist = $agents->find(array("simID" => (float) $_GET['simid']),array('sort' => array('_id' => 1), 'offset' => 0, 'limit' => 1));
        $progressCount = 0;                                     // Current Step
        $ensureAgentState = new AgentStateModel();    // instantiate collection model
        $ensureAgentState->ensureIndex(array('aid'=>1));
    }
    if (CRAPOUT) "HELLO<br>";              
    $year = (int)floor((($progressCount)%($agentSteps)/4)); // Calculate the current year
    if (CRAPOUT) "YEAR ".$year . "# dave<br>";              
    $ticksInQuarter = $quarter[$year][$currentQuarter]['limit']; // Set how many ticks are in this quarter.

    
    $outputARY = array();
        foreach ($agentslist as $agent) {
            // EACH COUNTRY AS AGENT
            $agentProperties = $agent->getProperties();
            $iso = $agentProperties['ISO'];
            $kyotostate = 'undefined';
            $time2 = getTime(); 
            $outputARY['timea'] = number_format(($time2-$time1),2);
            $finishloop = false;
            //CHECK FOR RECORD ALREADY INCASE ACCIDENTALLY REPEAT REQUEST:

            $counter = 0;
            $totalASQ = new AgentStateModel();    // instantiate collection model
            $totalAS = $totalASQ->find(array("aid"=>$agent->getAid()));
            $totalticks = $totalAS->count();
            
            
                    //Implement check here asap
                    $resultcheckq = new ResultModel();    // instantiate collection model
                    $resultcheck = $resultcheckq->findOne(array("simID" => (int)$_GET['simid'], "ISO" => $iso, 'year'=> (int)$year,'quarter'=> (int)$currentQuarter));
                    if (is_null($resultcheck)) {
                        //echo 'no record exists<bR>';
                    } else {            
                        echo 'Record Exists!';
                        die();
                    } 
            
            
            /*
             *  BEGIN LOOPING UNTIL FINISHED OR THE AGENT HAS COMPLETED
             */
            while (($looptimer-$time1 < 20) && $counter < $totalticks){//&& (!$finishloop)) {
                    $year = (int)floor((($progressCount)%($agentSteps)/4));
                    if (CRAPOUT) "YEAR ".$year . "# dave<br>"; //die();
                    $ticksInQuarter = $quarter[$year][$currentQuarter]['limit'];
                    $notices = array();

                    $as = new AgentStateModel();    // instantiate collection model
                        $agentstate = $as->find(
                                        array("aid"=>$agent->getAid()),
                                        array('sort' => array('_id' => 1),
                                              'offset' => $quarter[$year][$currentQuarter]['offset'],
                                              'limit' => (int)$quarter[$year][$currentQuarter]['limit']
                                              )
                                        );      // Sets up query to process a quarter
                
                if (CRAPOUT) echo 'query offset '.$quarter[$year][$currentQuarter]['offset'].'<br>';
                if (CRAPOUT) echo 'query limit '.$quarter[$year][$currentQuarter]['limit'].'<br>';
                    foreach ($agentstate as $ag) {
                    $counter++;

                    if (CRAPOUT) '<br>'.$ag->getTime().'GOTTIME<br>';
                        $countryArray = array();
                        $tick = $ag->getTime();
                        if (CRAPOUT) echo 'FOUND TIME '.$tick.'<br>';
                        $agentTickProperties = $ag->getProperties();    //Get the tick specific agent data
                        if ($agentTickProperties['is_kyoto_member'] != $kyotostate) {
                            if ($kyotostate=='undefined'){
                                //Initialise kyotostate so do nothing
                            } else {
                                // A legitimate change so make a record of this
                                $notices[] = array(NOTICE_1, $kyotostate, $agentTickProperties['is_kyoto_member'], $tick);
                            }
                                $kyotostate = $agentTickProperties['is_kyoto_member'];
                        }
                        if (CRAPOUT) echo 'Ticks in Quarter'.$ticksInQuarter.'<br>';
                        if (CRAPOUT) echo 'Ticks in Quarter -1:'.(int)($ticksInQuarter-1).'<br>';
                        if (CRAPOUT) echo 'Ticks'.$tick.'<br>';

                        if ($tick  == 0) {
                        //FIRST DAY

                        } elseif ($tick % ($ticksInQuarter) == ($ticksInQuarter-1)) {
                            if (CRAPOUT) echo  'MODRESULT:'.$tick % ($ticksInQuarter-1).'<br>';
                            // Last Day of the quarter
                            // Here is the year round up. Save and ting
                            if (CRAPOUT) echo 'Save the damn record';
                            $countryArray['simID']             = (int)$_GET['simid'];//$simID;
                            $countryArray['GDP']               = $agentTickProperties['gdp'];
                            $countryArray['tick']              = $tick;
                            $countryArray['quarter']           = $currentQuarter;
                            $countryArray['ISO']               = $iso;
                            $countryArray['year']              = $year;
                            $countryArray['GDPRate']           = $agentTickProperties['gdp_rate'];
                            $countryArray['availableToSpend']  = $agentTickProperties['available_to_spend'];
                            $countryArray['emissionsTarget']   = $agentTickProperties['emission_target'];
                            $countryArray['carbonOffset']      = $agentTickProperties['carbon_offset'];
                            $countryArray['carbonOutput']      = $agentTickProperties['carbon_output'];
                            $countryArray['isKyotoMember']     = $agentTickProperties['is_kyoto_member'];
                            $countryArray['notices']           = $notices;
                            $notices = array();
                            $result = new ResultModel($countryArray);    // instantiate collection model
                            $result->save();
                        } else {
                            // All other days of the quarter (perhaps adding and shit)
                        }                   
                } //End of DAYs
                //AT END O' DAY
            $time3 = getTime(); 

            //Make JSON response
            $outputARY['ISO'] = $iso;
            $outputARY['totalAgents'] = $steps;
            $progressCount++;                                           //Increment the step counter
            if ($progressCount===$steps) {
            $outputARY['success'] = 'complete';
            } else {
            $outputARY['timeb'] = number_format(($time3-$time2),2);
            $outputARY['success'] = 'true';
            $outputARY['nextAgent'] = $progressCount;
            $outputARY['percentage'] = (int)(($progressCount/$steps)*100);
            }
        $looptimer = getTime(); 
        if (CRAPOUT) echo 'CURRENT QUARTER PRE '.$currentQuarter;
        $currentQuarter = $progressCount%4; 
        if (CRAPOUT) echo 'CURRENT QUARTER POST'.$currentQuarter;
            } // end of while time loop
    }//END OF AGENT

} else {
   echo 'No sim ID mate.';
}

                
IF (OUTPUTFORM == 'JSON') {
    header('content-type: application/json');
    echo json_encode($outputARY);
}

?>