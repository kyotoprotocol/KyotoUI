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
                <li><a href="resultExport.php?simid={$simid}&part=0&total={$count2}">CLICK ONCE AND WAIT A V LONG TIME</a></li>  
            {*foreach $list as $l}
                
            {/foreach*}
            </ul>
    <a href="local/{$simid}results.csv">Download Results</a>

</div>
{/block}