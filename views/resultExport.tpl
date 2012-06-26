{extends file="views/layout.tpl"}
{block name=title}Simulation Overview - {$simName}{/block}
{block name=head}

{/block}
{block name=body}
<div class="container">
    <h1>{$count}</h1>
        <br>
            <h2>{$count2}</h2>
            <ul>
            {foreach $list as $l}
                <li><a href="resultExport.php?simid={$simid}&part={$l}&total={$count2}">CLICK ONCE</a></li>  
            {/foreach}
            </ul>
    <a href="local/{$simid}results.csv">Download Results</a>

</div>
{/block}