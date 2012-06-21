{extends file="views/layout.tpl"}
{block name=title}Simulation Editor - {$simName}{/block}
{block name=head}
{literal}
    <script type="text/javascript">  
   
     $(document).ready(function(){
            
        function ajaxProcess(data){
        $.ajax({
            type: "GET",
            url: "process.php",
            data: data,
            success: function(data) {
                console.log(data);
                if(data['nextAgent'] <= data['totalAgents']){
                    ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}, agent : data['nextAgent']+1, agentno : data['totalAgents']});
                    $("#progressbar").width(data['percentage']+'%');    
                } else {
                    //done
                        $("#progressbar").width(100+'%');
                        $("#progressbar").text('done');
                        console.log('done');
                }
                
            }
            });    
        }
                
        $("#process").click(function (){
            var nextAgent = 0;
            var totalAgents = 0;
            var returnData = {};
            
            if(nextAgent == 0){
                ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}});
            } else {
                ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}, agent : nextAgent, agentno : totalAgents});
            }
           
            
        });
    });    
            //processor.php?simid=X&agent={nextAgent}&agentno={totalAgents}
    </script>
{/literal}

{/block}


{block name=body}
<div class="span2 offset2">
    <button id="process" class="btn-group" type="submit">Process {$smarty.get.simid}</button>
</div>

<div class="progress progress-striped
     active">
  <div id="progressbar" class="bar"
       style="width: 0%"></div>
</div>

{/block}