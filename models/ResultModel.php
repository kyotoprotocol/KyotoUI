<?php

class ResultModel extends BaseMongoRecord 
{
    protected static $collectionName = 'results';
    
    public function setGDP($dave) {
        $this->attributes['GDP'] = $dave;
    }
    public function setGDPRate($dave) {
        $this->attributes['GDPRate'] = $dave;
    }
    
    public function getGDP() {
        return $this->attributes['GDP'];
    }
    public function getGDPRate() {
        return $this->attributes['GDPRate'];
    }
    
    public function beforeSave()
    {
        $this->setGDP(new MongoInt64($this->getGDP()));
        $this->setGDPRate(new MongoInt64($this->getGDPRate()));
        $this->setArableLandArea(new MongoInt64($this->getArableLandArea()));
        $this->setAvailableToSpend(new MongoInt64($this->getAvailableToSpend()));
        $this->setCarbonAbsorption(new MongoInt64($this->getCarbonAbsorption()));
        $this->setCarbonOffset(new MongoInt64($this->getCarbonOffset()));
        $this->setCarbonOutput(new MongoInt64($this->getCarbonOutput()));
        $this->setEmissionsTarget(new MongoInt64($this->getEmissionsTarget()));
        $this->setEnergyOutput(new MongoInt64($this->getEnergyOutput()));
    }
}
?>
