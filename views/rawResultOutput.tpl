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
    <div class="row">
        <div class="btn-group ">
    {foreach from=$names key=id item=country}
    <a href="rawResultOutput.php?simid={$smarty.get.simid}&number={$id}" class="btn btn-mini">{$country}</a>
    {/foreach}
        </div>
    </div>
</div>
<h1>{$Cname}</h1>
    <ul>
    {foreach from=$properties key=key item=prop}
        <li>{$key}:{$prop}</li>
    {/foreach}
    </ul>
<div class="row">
     <div class="span12">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th rowspan="1">T</th>
                    <th colspan="{$tCount}">Properties[{$tCount}]</th>
 
                </tr>
                <tr>
                </tr>
            </thead>
             <tbody>
                 {foreach from=$ticks item=tick key=tickID}
                 <tr>
                     <td>$tickID</td>
                    {foreach from=$ticks key=propertyK item=property}
                    <td{$property}</td>
                    {/foreach}
                 </tr>
                {/foreach}

             </tbody>
        </table>

     </div>
</div>

{/block}