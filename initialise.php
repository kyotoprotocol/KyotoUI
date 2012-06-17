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
//$smarty->assign('simList',simulationList());


try {
    
    $db = startDB();
    //Still uses old database function startDB, not the way to do it.
    $list = $db->listCollections();
    $smarty->assign('collections',$list);
    $smarty->assign('host',HOST);
    $smarty->assign('db',DB);


    
    // V rough implementation of making a full default simulation, or a baby one
    if (isset($_POST['filename'])) {    
            $notices[] = 'Importing: '.$_POST['filename'];
            
            $tag = substr($_POST['filename'],0,-7);
            $file = fopen('admin/csv/'.$tag.'params.csv', 'r');
            // grab the first line - as headers
  //          $notices[] = 'loading CSV parameters';
  //          $notices[] = 'loading simulation parameters';
            while (($line = fgetcsv($file)) !== FALSE) {
                $simData[$line[0]] = $line[1];
                if (substr($line[0],0,6) == 'param.') {
                        $paramData[substr($line[0],6)] = $line[1];
                }
            }
            fclose($file);
            unset($file);

            define ("DEFAULTSIMCSV", $_POST['filename']);
            define ("DEFAULTSIM", $simData['name']);
            define ("DEFAULTCLASS", $simData['classname']);
            define ("DEFAULTSTATE", DEFAULT_STATE);
            define ("DEFAULTCURRENTTIME", DEFAULT_CURRENTTIME);
            define ("DEFAULTFINISHTIME", $simData['finishTime']);
            define ("DEFAULTDESCRIPTION", $simData['description']);
            $paramData["finishTime"] = DEFAULTFINISHTIME;

        $simulation = new SimulationModel();

    //    $notices[] = 'looking for '.DEFAULTSIM;
        $defaultsim = $simulation->findOne(array("name" => DEFAULTSIM));

        /*
         * Here we need to put a simulation in with the name 'defaultsimulation' 
         * and let it correspond to Sam's simulation ID structure.
         * If defaultsimulation previously existed, it will keep the ID name but be overwritten
         * If it doesnt exist then it will be given an autoincremented ID
         */
        if ($defaultsim == NULL){
    //        $notices[] = 'not found '.DEFAULTSIM;
    //        $notices[] = 'create new '.DEFAULTSIM;
            
            // find insert id
            $counter = new CountersModel();
            $id = $counter->findOne(array("_id" => "simulations"));

            if ($counter->count() < 1){
                //counters doesnt exist so make it
     //           $notices[] = 'Counters table doesnt exist (likely a new mongo db)';
                $counter->setID('simulations');
                $counter->setNext(new MongoInt64(1));
                $counter->save();
                $useid = 1;
     //           $notices[] = 'Created counters branch in mongo, using simid:'.$useid;
            } else {
     //           $notices[] = 'Found counters table (likely used Presage WEB UI)';
                $useid = $id->getNext();
                $useid++;
                $id->setNext(new MongoInt64($useid));
                $id->save();
    //            $notices[] = 'Using simid:'.$useid;
            }
            
        } else {
            $useid = $defaultsim->getID();
  //          $notices[] = 'found '.DEFAULTSIM.$useid;
            $defaultsim->destroy();
  //          $notices[] = 'dropped '.DEFAULTSIM.$useid;
            $defaultsim->save();
            unset ($defaultsim);
    //        $notices[] = 'create new '.DEFAULTSIM.' with ID'.$useid;
        }
   //     $notices[] = 'loading CSV data';
        $file = fopen('admin/csv/'.DEFAULTSIMCSV, 'r');
        // grab the first line - as headers
        $csvheaders = fgetcsv($file);
        while (($line = fgetcsv($file)) !== FALSE) {
                $i = 0;
                foreach ($csvheaders as $header) {
                    $country[$header] = $line[$i];
                $i++;
            }
            //add each country as a new object in array, indexed by ISO code
            $CountryArray[$country["ISO"]] = $country;
            unset($country); //Empty each country variable.
        }
        fclose($file);
        unset($file);

        /*
         * Sam's WEB UI simulation mongo tree uses explicitly declared variables for java
         * Therefore MongoInt64 is used. Most helpful post in the world ever - 2nd answer.
         * http://stackoverflow.com/questions/9006077/mongodb-php-integers-with-decimals
         * 
         */
//            $defaultsim = new SimulationModel();
//            $defaultsim->setID(new MongoInt64($useid));
//            $defaultsim->save();

            //Uses fancy ORM constructors but CamelCase introduces underscores: camel_case.
            //Instead use the constructor as array.
            /*
                $defaultsim->setName(DEFAULTSIM);
                $defaultsim->setClassname(DEFAULTCLASS);
                $defaultsim->setDescription(DEFAULTDESCRIPTION);
                $defaultsim->setState(DEFAULTSTATE);
                $defaultsim->setFinishTime(new MongoInt64($parameters["finishTime"]));
                $defaultsim->setCreatedAt(new MongoInt64(time()*1000));
                $defaultsim->setCurrentTime(new MongoInt64(0));
                $defaultsim->setFinishedAt(new MongoInt64(0));
                $defaultsim->setParameters($parameters);
                $defaultsim->setParent(new MongoInt64(0));
                $defaultsim->setChildren(array());
                $defaultsim->setCountries($CountryArray);
                $defaultsim->save();
                */
            
        // old array method. 
            $defaultsim = new SimulationModel(
                                            array(  '_id'               =>  new MongoInt64($useid),
                                                    'name'              =>  DEFAULTSIM,
                                                    'classname'         =>  DEFAULTCLASS,
                                                    'author'         =>  $simData['author'],
                                                    'description'       =>  DEFAULTDESCRIPTION,
                                                    'state'             =>  DEFAULTSTATE,
                                                    'finishTime'        =>  new MongoInt64(DEFAULTFINISHTIME),
                                                    'createdAt'         =>  new MongoInt64(time()*1000) ,
                                                    'currentTime'       =>  new MongoInt64(0),
                                                    'finishedAt'        =>  new MongoInt64(0),
                                                    'parameters'        =>  $paramData,
                                                    'parent'            =>  new MongoInt64(0),
                                                    'children'          =>  array(),
                        //                         'startedAt'         =>  '',
                                                    'countries'         =>  $CountryArray
                                                    )        
                                    );
                $defaultsim->save();

         
            $notices[] = 'inserted '.DEFAULTSIM;

            $environmentState = new EnvironmentStateModel();
       
            $environmentStateItem = $environmentState->findOne(array("simId" => $useid));
            if ($environmentStateItem == NULL) {
   //         $notices[] = 'environmentState tree not found';
            $environmentState = new EnvironmentStateModel(array("simId" => new MongoInt64($useid)));
            $environmentState->save();

            $notices[] = 'environmentState tree item made';
            } else {
   //         $notices[] = 'environmentState tree item found';
            }
  
         
    $smarty->assign('notices',$notices);
    $smarty->assign('alert',' ');
        
    $smarty->assign('status',"Success");
    // End of the initialise script
    // Start of drop script
    } elseif (isset($_POST['drop'])) {    
                $smarty->assign('alert',' Sim Table dropped');

            $environmentState = new EnvironmentStateModel();
            $dropitlikeitshot = $environmentState->findAll();
            foreach ($dropitlikeitshot as $dog) {
                $dog->destroy();
            }
            $sims = new SimulationModel();
            $dropitlikeitshot = $sims->findAll();
            foreach ($dropitlikeitshot as $dog) {
                $dog->destroy();
            }
            $counter = new CountersModel();
            $dropitlikeitshot = $counter->findAll();
            foreach ($dropitlikeitshot as $dog) {
                $dog->destroy();
                       
            }
    } elseif (isset($_POST['dropALL'])) {    
        $smarty->assign('alert',' Database Dropped');
         $db->drop();
    } else { //Normal page work:
     $smarty->assign('status',"Not Started");
     $smarty->assign('showbtn', 'true'); //Probably useless now.
    }

    // LOAD SIMULATION CSV's AND COMPARE WITH OTHERS
    if ($handle = opendir('admin/csv')) {
        $simulations = array();

        while (false !== ($entry = readdir($handle))) {
            $tag = substr($entry,0,-7);
            // Loop all SIMULATION CSV's
            $simulation = new SimulationModel();

            if (substr($entry,-7) == 'sim.csv') {
                $file = fopen('admin/csv/'.$tag.'params.csv', 'r');
                $csvdata[$tag]['file'] = $entry;
                
                while (($line = fgetcsv($file)) !== FALSE) {
                    $csvdata[$tag][$line[0]] = $line[1];
                }
                $defaultsim = $simulation->findOne(array("name" => $csvdata[$tag]['name']));
                //var_dump($defaultsim);
                if (is_null($defaultsim)) {
                    $csvdata[$tag]['id'] = 'X';
                } else {
                    $csvdata[$tag]['installed'] = 'true';
                    $csvdata[$tag]['id'] = $defaultsim->getID();
                }
                fclose($file);
                unset($file);
                
            }
        }
    closedir($handle);
    }
    $smarty->assign('CSVfiles', $csvdata);

     
} catch (MongoConnectionException $e)
{
    //echo $e;
    $smarty->assign('status',$e);

}



    $smarty->display('views/initialise.tpl');
    
?>