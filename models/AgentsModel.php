<?php

class AgentsModel extends BaseMongoRecord 
{
    protected static $collectionName = 'agents';
    
    public function beforeDestroy() {
        parent::beforeDestroy();
            $agentstateQ = new AgentStateModel();    // instantiate collection model
            $agentstate = $agentstateQ->find(array('aid'=>$this->getAid()));
            foreach ($agentstate as $as) {
            $as->destroy();
            }
        
    }
    
}
?>
