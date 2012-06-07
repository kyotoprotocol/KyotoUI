{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}

<h1>Initialise MongoDB using data.csv</h1>

<hr>
{if isset($go)}
        <a href="/initialise.php?init=true" class="btn btn-primary">
    Create Default Simulation
    </a>
{else}
Wiped old CountryDefault table.<br><br>
Writing new table using data.csv into CountryDefaults<br><br>
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