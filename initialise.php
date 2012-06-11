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

    // set URL and other appropriate options
    
    // V rough implementation of making a full default simulation, or a baby one
    if (isset($_GET['size'])) {    
        if ($_GET['size']=='baby') {    
            $notices[] = 'Making a baby sim';
            define ("DEFAULTSIMCSV", DEFAULT_BABY_SIMCSV);
            define ("DEFAULTSIM", DEFAULT_BABY_SIM);
            define ("DEFAULTCLASS", DEFAULT_BABY_CLASS);
            define ("DEFAULTSTATE", DEFAULT_BABY_STATE);
            define ("DEFAULTCURRENTTIME", DEFAULT_BABY_CURRENTTIME);
            define ("DEFAULTFINISHTIME", DEFAULT_BABY_FINISHTIME);
            define ("DEFAULTDESCRIPTION", DEFAULT_BABY_DESCRIPTION);
        }
   }else{
            $notices[] = 'Making a default sim';
            define ("DEFAULTSIMCSV", DEFAULT_SIMCSV);
            define ("DEFAULTSIM", DEFAULT_SIM);
            define ("DEFAULTCLASS", DEFAULT_CLASS);
            define ("DEFAULTSTATE", DEFAULT_STATE);
            define ("DEFAULTCURRENTTIME", DEFAULT_CURRENTTIME);
            define ("DEFAULTFINISHTIME", DEFAULT_FINISHTIME);
            define ("DEFAULTDESCRIPTION", DEFAULT_DESCRIPTION);
    }

    if (isset($_GET['init'])) {    
        $simulation = new SimulationModel();

        $notices[] = 'looking for '.DEFAULTSIM;
        $defaultsim = $simulation->findOne(array("name" => DEFAULTSIM));

        /*
         * Here we need to put a simulation in with the name 'defaultsimulation' 
         * and let it correspond to Sam's simulation ID structure.
         * If defaultsimulation previously existed, it will keep the ID name but be overwritten
         * If it doesnt exist then it will be given an autoincremented ID
         */
        if ($defaultsim == NULL){
            $notices[] = 'not found '.DEFAULTSIM;
            $notices[] = 'create new '.DEFAULTSIM;
            
            // find insert id
            $counter = new CountersModel();
            $id = $counter->findOne(array("_id" => "simulations"));

            if ($counter->count() < 1){
                //counters doesnt exist so make it
                $notices[] = 'Counters table doesnt exist (likely a new mongo db)';
                $counter->setID('simulations');
                $counter->setNext(new MongoInt64(2));
                $counter->save();
                $useid = 1;
                $notices[] = 'Created counters branch in mongo, using simid:'.$useid;
            } else {
                $notices[] = 'Found counters table (likely used Presage WEB UI)';
                $useid = $id->getNext();
                $id->setNext(new MongoInt64($useid+1));
                $id->save();
                $notices[] = 'Using simid:'.$useid;
            }
            
        } else {
            $useid = $defaultsim->getID();
            $notices[] = 'found '.DEFAULTSIM.$useid;
            $defaultsim->destroy();
            $notices[] = 'dropped '.DEFAULTSIM.$useid;
            $defaultsim->save();
            unset ($defaultsim);
            $notices[] = 'create new '.DEFAULTSIM.' with ID'.$useid;
        }
        $notices[] = 'loading CSV data';
        $file = fopen('admin/'.DEFAULTSIMCSV, 'r');
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
                                                    )        
                                    );
                $defaultsim->save();

         
            $notices[] = 'inserted '.DEFAULTSIM;

            $environmentState = new EnvironmentStateModel();
       
            $environmentStateItem = $environmentState->findOne(array("simId" => $useid));
            if ($environmentStateItem == NULL) {
            $notices[] = 'environmentState tree not found';
            $environmentState = new EnvironmentStateModel(array("simId" => new MongoInt64($useid)));
            $environmentState->save();

            $notices[] = 'environmentState tree item made';
            } else {
            $notices[] = 'environmentState tree item found';
            }
  
         
    $smarty->assign('notices',$notices);
        
    $smarty->assign('status',"Success");
    // End of the initialise script
    // Start of drop script
    } elseif (isset($_POST['drop'])) {    
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
    } else { //Normal page work:
     $smarty->assign('status',"Not Started");
     $smarty->assign('showbtn', 'true'); //Probably useless now.
    }

   
    
     $sQ = new SimulationModel();

     $babysimQ = $sQ->findOne(array("name" => DEFAULT_BABY_SIM));
     if ($babysimQ != NULL){
        
        $smarty->assign('babysim', $babysimQ->getID());
     }
     $defsimQ = $sQ->findOne(array("name" => DEFAULT_SIM));
     if ($defsimQ != NULL){
        $smarty->assign('defsim', $defsimQ->getID());
     }
    
} catch (MongoConnectionException $e)
{
    //echo $e;
    $smarty->assign('status',$e);

}



    $smarty->display('views/initialise.tpl');

    $version = fopen("http://github.com/api/v2/json/commits/list/kyotoprotocol/KyotoInterface/master", "rb");
    $contents = stream_get_contents($version);
    fclose($version);
    unset($version);
    $commitdata = json_decode($contents);
    $webversion = trim($commitdata->commits[0]->parents[0]->id);
    
    $file = fopen('./.git/refs/heads/master', 'r');
    $dave = fgets($file);
    fclose($file);
    $localversion = trim($dave);
    unset($file);

    //v hacky but guess what - I'm not bovad
    if ($localversion != $webversion) {
        ?>
        <div class="alert alert-error">
            Version mismatch from the master branch. Try git pull. (Unless you're working on a branch, that is to be expected).<br>
            Local: <?php echo $localversion; ?><br>
            Web: <?php echo $webversion; ?><br>
            Web: <?php var_dump($commitdata) ?><br>
        </div>
        <?PHP
    }
    
?>