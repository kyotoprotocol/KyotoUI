{extends file="views/layout.tpl"}
{block name=title}Simulation Overview - {$simName}{/block}
{block name=head}
{literal}

{/literal}
{/block}
{block name=body}

<div class="row">
    <div class="span8">
        <h1>{$simName}</h1>
    </div>
        <div class="span4"><h5>Author: {$simAuthor}</h5></div>
</div> 
<div class="row">
    <div class="span12">
        <blockquote>
        {$simDescription}
        </blockquote>
    </div>
</div>                

<div class="row">
     <div class="span12">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="2">Name</th>
                    <th colspan="{$propcount}">Properties</th>
 
                </tr>
                <tr>
                    {foreach $propkeys as $key}
                    <th>{$key}</th>
                    {/foreach}
                </tr>
            </thead>
             <tbody>
                 {foreach $agents as $agent}
                 <tr>
                    <td rowspan="2">{($agent['name'])}</td>
                        {foreach $agent['properties'] as $property}
                    <td>{$property}</td>
                        {/foreach}
                 </tr>
                 <tr>
                    <td  colspan="{$propcount+1}" >
                        <table>
                            <tbody>
                                <tr>
                                    <th>Time</th>
                                       {foreach $statekeys as $key}
                                        <th>{$key}</th>
                                       {/foreach}    
                                </tr>
                                {if isset($agent['agentstates'])}
                                    {foreach $agent['agentstates'] as $state}
                                        <tr>
                                                <td>{$state['time']}</td>
                                        {foreach $state['properties'] as $statey}
                                            {foreach $statey as $s}
                                                <td>{$s|print_r}</td>
                                            {/foreach}
                                        {/foreach}
                                        </tr>
                                    {/foreach}
                                {/if}
                            </tbody>
                        </table>
                    </td>
                 </tr>
                 {/foreach}
             </tbody>
        </table>

     </div>
</div>

{/block}