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
                    <th rowspan="2">AID</th>
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
                 <td>{($agent['name'])}</td>
                 <td>{bin2hex($agent['aid'])}</td>
                    {foreach $agent['properties'] as $property}
                 <td>{$property}</td>
                    {/foreach}
                 </tr>
                 {/foreach}
             </tbody>
        </table>

     </div>
</div>

{/block}