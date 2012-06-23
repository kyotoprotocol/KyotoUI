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
            success: function(data){
                console.log(data);
                console.log(data['timea']);
                    console.log(data['timeb']);
                if(data == 'Record Exists!'){
                    $("#progressoutput").append(data + '<br>');
                    $("#progressbar").width(100+'%');
                    $("#progressbar").text('done');
                    $("#progressbarcontainer").removeClass("active");
                    $("#progressoutput").append('All agents processed.');
                } else if(data['success'] == 'failed'){
                    $("#progressbar").width(100+'%');
                    $("#progressbar").text('FAILED');
                    $("#progressbarcontainer").addClass("progress-danger");
                    $("#progressoutput").append('PROCESSING FAILED!!!');
                    return false;
                } else {
                    if(data['nextAgent'] <= data['totalAgents']){
                        $("#progressbar").width(data['percentage']+'%');  
                        $("#progressbar").text(data['percentage']+'%');
                        $("#progressoutput").append(data['nextAgent'] + 
                            '/' + data['totalAgents'] + ' ' 
                            + data['ISO'] + ': Success = ' + 
                            data['success'] + 
                            ' Time Taken(pre DB): ' + data['timea'] +
                            ' Time Taken(DB): ' + data['timeb'] +
                            '<br>');
                        ajaxProcess({simid : {/literal}{$smarty.get.simid}{literal}, agent : data['nextAgent'], agentno : data['totalAgents']});
                    } else {
                        $("#progressbar").width(100+'%');
                        $("#progressbar").text('done');
                        $("#progressbarcontainer").removeClass("active");
                        $("#progressoutput").append('All agents processed.');    
                    }
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
<div>
    <h1>Run and Process Simulation: {$smarty.get.simid}, {$simName}</h1>
    
</div>
<div>
    <h3>Simulation Data Processing:</h3>
</div>
<div id="progressbarcontainer" class="progress progress-striped
     active">
  <div id="progressbar" class="bar"
       style="width: 0%"></div>
</div>
 
<div class="span8 offset2">
    <div id="progressoutput" class="well">
    
    </div>
</div>    
</div>
{/block}