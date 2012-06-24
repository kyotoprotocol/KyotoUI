<?php

class CountryTotalsModel extends BaseMongoRecord 
{
    protected static $collectionName = 'countrytotals';
    
    public function beforeSave()
    {
        $this->setGDP(new MongoInt64($this->getGDP()));
        $this->setArableLandArea(new MongoInt64($this->getArableLandArea()));
        $this->setAvailableToSpend(new MongoInt64($this->getAvailableToSpend()));
        $this->setCarbonAbsorption(new MongoInt64($this->getCarbonAbsorption()));
        $this->setCarbonOffset(new MongoInt64($this->getCarbonOffset()));
        $this->setCarbonOutput(new MongoInt64($this->getCarbonOutput()));
        $this->setEmissionsTarget(new MongoInt64($this->getEmissionsTarget()));
        $this->setEnergyOutput(new MongoInt64($this->getEnergyOutput()));
    
        //may need to add more here
    }
}
?>
