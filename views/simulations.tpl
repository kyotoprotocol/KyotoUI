{extends file="views/layout.tpl"}

{block name=title}Simulations{/block}

{block name=head}{/block}

{block name=body}
<div class="row">
    <div class="span4">
         
    </div>
    <div class="span8"> <div id="visualization" style="width: 800px; height: 400px; margin-left: 50px;"></div></div>
 </div>
<div class="row">
    <div class="span12">
        <table class="table table-striped">
             <tbody>
                {foreach $simulation as $s}
                <tr>
                    <td>{$s@key}</td>
                    <td>{$s}</td>
                <tr>
                {/foreach}
             </tbody>
        </table>
    </div>
 </div>


    
{/block}