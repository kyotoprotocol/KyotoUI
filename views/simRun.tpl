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
                    ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}, agent : data['nextAgent'], agentno : data['totalAgents']});
                    $("#progressbar").width(data['percentage']+'%');  
                    $("#progressbar").text(data['percentage']+'%');
                } else {
                    $("#progressbar").width(100+'%');
                    $("#progressbar").text('done');
                    $("#progressbarcontainer").removeClass("active");
                    console.log('Done!');
                }
            }
            });    
        }
                
        var nextAgent = 0;
        var totalAgents = 0;

        if(nextAgent == 0){
            ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}});
        } else {
            ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}, agent : nextAgent, agentno : totalAgents});
        }
           
            
    });    
    </script>
{/literal}

{/block}

{block name=body}
<div id="progressbarcontainer" class="progress progress-striped
     active">
  <div id="progressbar" class="bar"
       style="width: 0%"></div>
</div>
{/block}