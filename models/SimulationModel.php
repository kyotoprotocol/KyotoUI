<?php

class SimulationModel extends BaseMongoRecord 
{
    protected static $collectionName = 'simulations';
    
    public function beforeSave()
    {
        $this->setID(new MongoInt64($this->getID()));
        $this->setFinishedAt(new MongoInt64($this->getFinishedAt()));
        $this->setCreatedAt(new MongoInt64($this->getCreatedAt()));
        $this->setParent(new MongoInt64($this->getParent()));
        $this->setFinishTime(new MongoInt32($this->getFinishTime()));
        $this->setCurrentTime(new MongoInt32($this->getCurrentTime()));
        $this->setStartedAt(new MongoInt64($this->getStartedAt()));
    }
   
    public function beforeDestroy() {
        parent::beforeDestroy();

            $agentsQ = new AgentsModel();    // instantiate collection model
            $agents = $agentsQ->find(array('simID'=>$this->getID()));
            foreach ($agents as $ag){
            $ag->destroy();    
            }
                 
        
    }
}

?>
