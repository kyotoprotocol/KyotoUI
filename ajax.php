<?php
/*
 * Handles all ajax requests to the backend
 */

switch ($_GET['func']) {
    case 'overview' :
        $data = 
            array('Year' => 'Carbon Output', 
                '2004' => rand(10, 1000), 
                '2005'=> rand(10, 1000), 
                '2006'=> rand(10, 1000),
                '2007'=> rand(10, 1000),
                '2008'=> rand(10, 1000), 
                '2009'=> rand(10, 1000),
                '2010'=> rand(10, 1000),
                '2011'=> rand(10, 1000),
                '2012'=> rand(10, 1000)
            );
        ajaxSend(dataToArray($data));
        break;
    case 'group' :
        //whatever load up les charts with data formatted however
        $data = 
            array(
                array('Year', 'Carbon Output'), 
                array('2004', rand(10, 1000)),
                array('2005', rand(10, 1000))
            ); 
        ajaxSend(dataToArray($data));
        break;
    default : echo 'error';
}


// send ajax data to success function as json
function ajaxSend($array){
    header('content-type: application/json');
    echo json_encode($array);
} 

// convert associative array to array of arrays for google vis.
function dataToArray($data){
    $retVal = array();
    if(is_array($data)){
        if(is_assoc($data)){
            foreach(array_keys($data) as $key){
                    $retVal[] = array($key, $data[$key]);
            }
        } else {
            return $data;
        } 
    } 
    return $retVal;
}

// detect if array is associative
function is_assoc($array) {
    return (is_array($array) && (count($array)==0 || 0 !== count(array_diff_key($array, array_keys(array_keys($array))) )));
} 

?>