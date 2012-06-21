{extends file="views/layout.tpl"}
{block name=title}Simulation Editor - {$simName}{/block}
{block name=head}
{literal}
    <script type="text/javascript">  
        //do the ajax call here baby!
        $('').click(function (){
            var nextAgent = 0;
            var totalAgents = 0;
                
            $.ajax({
            type: "GET",
            url: "processor.php",
            data: {simid : {/literal}{$simid}{literal}, agent : '', agentno : ''},
            success: function(data) {
                console.log(data);
            }
            });       
        });
            
            //processor.php?simid=X&agent={nextAgent}&agentno={totalAgents}
    </script>
{/literal}

{/block}


{block name=body}
<div class="span2 offset2">
    button here
</div>

{/block}