<?php

require('libs/Smarty.class.php');
$smarty = new Smarty;
$smarty->assign('foo','bar');

include('admin/config.php');


    try {
        $db = startDB();
        $simsDB = $db->selectCollection('simulations'); 
            
        // Load specific simulation
        if (isset($_GET['simid'])) {
            $sim = $simsDB->findOne(array("_id" => (int)$_GET['simid']));
        } else {
            $sim = $simsDB->findOne();
        }
        
        if(isset($_GET['country'])){
            $country = $sim['countries'][toISO3($_GET['country'])];
        } else {
            $country = $sim['countries']['ALB'];
        } 
        
        //Grab updated country data - SORT LATER
        if (isset($_POST['ISO'])){                      //check post data set
            foreach(array_keys($_POST) as $key){        //tell this to ignore iso2 in the tpl file
                $country[$key] = $_POST[$key];          //update country
            }
            $simID = new MongoInt64($sim['_id']);
          //     var_dump($country);
         //   $simsDB->update(array('_id' => $simID, 'countries' => $country['ISO']), array('$set' => array("countries" => $country)));
          //  var_dump($sim);
            //find 'systems.score' : { '$gte' : 15 } 
            //find 'systems.score' : { '$gte' : 15 } 
            //UPDATE users SET a=1 WHERE b='q'
            //	$db->users->update(array("b" => "q"), array('$set' => array("a" => 1)));
            
                            /* 
                            * _id:     "4f44af6a024342300e000001",
                    title:   "A book", 
                    created: "2012-02-22T14:12:51.305Z"
                    authors: [{"_id":"4f44af6a024342300e000002"}] 
                             * 
             * update _id field of first matched by _id author    
                    collection.update({'_id': "4f44af6a024342300e000001",
                    //you should specify query for embedded document
                    'authors._id' : "4f44af6a024342300e000002" }, 
                    // you can update only one nested document matched by query                   
                    {$set: { 'authors.$._id': "1" }} )
                             * 
             db.objects.update(
                              {'items.2':
                                          {$exists:
                                                   true
                                           } 
                              }, 
                              {'$set': 
                                       {'items.2.blocks.0.txt': 
                                                               'hi'
                                        }
                              }
                              )
                              
             */

            

            $db->simulations->update(array($simID.'countries.ALB' => array("exists"=>"true")), array($set => array($simID.'countries.ALB' => $country)));
           // var_dump($simsDB->find(array('_id' => $simID, array("countries"=>"ALB"))));
            //
            //
            //$simsDB->update(array('_id' => $simID, 'countries' => $country['ISO']), $country);
            $smarty->assign('updated', true);
        }
            
        //Bit crude I guess but I haven't got a better idea and you shouldn't be on this page without a simId
        //if (!in_array($sim, "country")){
        //   echo "Cannot find a default country class in a default simulation";
        //    die();
        //}

        foreach(array_keys($sim['countries']) as $key){
            $cDrop[] = array('ISO' => $key, 'name' => $sim['countries'][$key]['name']);
        }
        
        $country['ISO2'] = toISO2($country['ISO']); 
        
        $smarty->assign('simid', $sim['_id']);
        $smarty->assign('simulationname', $sim['name']);
        $smarty->assign('country', $country);
        $smarty->assign('cDrop', $cDrop);                    
        $smarty->display('views/country.tpl');

} catch (MongoConnectionException $e) {
    echo $e;
}
?>