{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}

<h1>Create starter simulation in MongoDB using admin/data.csv</h1>

<hr>
{if isset($showbtn)}
        <a href="/initialise.php?init=true" class="btn btn-primary">
    Create Default Simulation
    </a>
{else}
{/if}
    {if isset($notices)}
        <ul>
            {foreach $notices as $item}
                <li>{$item}</li>
            {/foreach}
        </ul>
    {/if}
Result: <span class="label label-important">{$status}</span> <br><br>

<hr>

<h1>Tables in MongoDB </h1>
For Host:{$host} using Database:{$db}
    <ul>
    {foreach $collections as $item}
        <li>{$item}</li>
    {/foreach}
    </ul>
    
 
    
{/block}