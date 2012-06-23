<?php

class SimulationModel extends BaseMongoRecord 
{
    protected static $collectionName = 'simulations';
    
    public function beforeSave()
    {
        $this->setFinishedAt(new MongoInt32($this->getFinishedAt()));
        $this->setCreatedAt(new MongoInt64($this->getCreatedAt()));
        $this->setParent(new MongoInt64($this->getParent()));
        $this->setFinishTime(new MongoInt64($this->getFinishTime()));
        $this->setCurrentTime(new MongoInt32($this->getCurrentTime()));
    }
}

?>
