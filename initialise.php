<?php
/*
 *  $notices[] serve as alerts to the user and also as comments
 *  $smarty is the template file
 *  
 *  by JW
 */
require('libs/Smarty.class.php');
$smarty = new Smarty;
include('admin/config.php');


try {
    
    $db = startDB();
       
    $list = $db->listCollections();
    $smarty->assign('collections',$list);
    $smarty->assign('host',HOST);
    $smarty->assign('db',DB);


    // remove any previous defaults to be sure
    if (isset($_GET['init'])) {    
        //$CountryDefaults = $db->selectCollection("CountryDefaults");
        //$CountryDefaults->drop();
        if (in_array(DB.".".SIMTREE, $list)) {
            $notices[] = 'simulation tree found';
        } else {
            $notices[] = 'simulation tree not found';
            $db->createCollection(SIMTREE);
            $notices[] = 'simulation tree created';
        }
        $simulation = $db->selectCollection(SIMTREE);
        $notices[] = 'looking for defaultsimulation';
        $result = $simulation->findOne(array("name" => DEFAULTSIM));;
        /*
         * Here we need to put a simulation in with the name 'defaultsimulation' 
         * and let it correspond to Sam's simulation ID structure.
         * If defaultsimulation previously existed, it will keep the ID name but be overwritten
         * If it doesnt exist then it will be given an autoincremented ID
         */
        if ($result == NULL){
            $notices[] = 'not found default simulation';
            $notices[] = 'create new default simulation';
            
            
            //$val = $simulation->find()->sort(array('_id'=> -1 ))->limit(1);
            //$simitem = $val->getNext();
            //I know this looks stupid but couldnt get the  above to work so
            //I iterate all simulation entries searching for largest ID.
            $simcursor = $simulation->find();
            $maxid= 0;
            foreach ($simcursor as $doc) {
                if ($doc['_id'] > $maxid) {
                    $maxid = $doc['_id'];
                }
            }           
            $notices[] = 'find maximum ID, current ID is '.$maxid;
            if ($maxid==0) {
            $notices[] = 'No simulations found';
                $nextid = 1;
            } else {
                $nextid = $maxid+1;
            }
            $notices[] = 'ID: '.$nextid;
        } else {
            $notices[] = 'found default simulation';
            $keepid = $result['_id'];
            $simulation->remove(array('name' => DEFAULTSIM));
            $notices[] = 'dropped default simulation';
            $notices[] = 'create new default simulation with ID'.$keepid;
            $nextid = $keepid;
        }
        
        $notices[] = 'loading CSV data';
        $file = fopen('admin/data.csv', 'r');
        // grab the first line - as headers
        $csvheaders = fgetcsv($file);

        while (($line = fgetcsv($file)) !== FALSE) {
                $i = 0;
                foreach ($csvheaders as $header) {
                    $country[$header] = $line[$i];
                $i++;
            }
            //add each country as a new object in mongo
            $CountryArray[$country["ISO"]] = $country;
            //$CountryDefaults->insert($country);
            unset($country); //Empty country variable.
        }
        fclose($file);
        unset($file);
        $notices[] = 'loading CSV parameters';
        $file = fopen('admin/params.csv', 'r');
        // cut out the first line of row headers
        $crap = fgetcsv($file);
        // init finishTime into parameters, if exists in CSV, CSV will overwrite.
            $parameters["finishTime"] = DEFAULTFINISHTIME;
        while (($line = fgetcsv($file)) !== FALSE) {
                $parameters[$line[0]] = $line[1];
            }
        fclose($file);  
        unset($file);
        /*
         * Sam's WEB UI simulation mongo tree uses explicitly declared variables for java
         * Therefore MongoInt64 is used. Most helpful post in the world ever - 2nd answer.
         * http://stackoverflow.com/questions/9006077/mongodb-php-integers-with-decimals
         * 
         */

        $simulation->insert(array(  '_id'               =>  new MongoInt64($nextid),
                                    'name'              =>  DEFAULTSIM,
                                    'classname'         =>  DEFAULTCLASS,
                                    'description'       =>  DEFAULTDESCRIPTION,
                                    'state'             =>  DEFAULTSTATE,
                                    'finishTime'        =>  new MongoInt64($parameters["finishTime"]),
                                    'createdAt'         =>  new MongoInt64(time()*1000) ,
                                    'currentTime'       =>  new MongoInt64(0),
                                    'finishedAt'        =>  new MongoInt64(0),
                                    'parameters'        =>  $parameters,
                                    'parent'            =>  new MongoInt64(0),
                                    'children'          =>  array(),
           //                         'startedAt'         =>  '',
                                    'countries'         =>  $CountryArray
                                    ));        
            $notices[] = 'inserted defaultsimulation';

        if (in_array(DB."."."environmentState", $list)) {
            $notices[] = 'environmentState tree found';
        } else {
            $notices[] = 'environmentState tree not found';
            $db->createCollection("environmentState");
            $notices[] = 'environmentState tree created';
        }
         $environmentState = $db->selectCollection("environmentState");
         if (is_null($environmentState->find(array("simId" => $nextid)))){
         $environmentState->insert(array("simId" => new MongoInt64($nextid)));
         $notices[] = 'environmentState simId inserted';
         } else {
         $notices[] = 'environmentState simId exists already';
         }

   
         
    $smarty->assign('notices',$notices);
        
    $smarty->assign('status',"Success");
    } else {
     $smarty->assign('status',"Not Started");
     $smarty->assign('showbtn', 'true');
        
    }
    
} catch (MongoConnectionException $e)
{
    //echo $e;
    $smarty->assign('status',$e);

}

    $smarty->display('views/initialise.tpl');


?>