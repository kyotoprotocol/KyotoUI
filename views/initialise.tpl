{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}

<div class="row">
    <div class="span12">
        <h1>Getting Started</h1>
        <br>
    </div>
</div>
<div class="row">
    <div class="span12">
        <h2>Default simulation management</h2>
        <blockquote>
            Adds sims to MongoDB using admin/data.csv<br>
            Useful for initialisation and resetting the database
        </blockquote>
        <hr>
        {if isset($showbtn)}
                <a href="initialise.php?init=true" class="btn btn-primary">
            Create Default Simulation
            </a>
                <a href="initialise.php?init=true&size=baby" class="btn btn-primary">
            Create a baby Simulation
            </a>
        {else}
        {/if}
            {if isset($notices)}
                <ul>
                    {foreach $notices as $item}
                        <li>{$item}</li>
                    {/foreach}
                </ul>
            Result: <span class="label label-important">{$status}</span> <br><br>
            {/if}
        <hr>
    </div>
</div>
<div class="row">
    <div class="span12">
        <h2>Default Simulation Status</h2>
        <blockquote>
            Identify what simulations you have initialised.
        </blockquote>
            {if isset($babysim)} 
            <div class="alert alert-success">
                Baby Default simulation found id: {$babysim}
            </div>
            {else}
            <div class="alert alert-error">
                Baby Default simulation missing, press the create button!
            <a href="initialise.php?init=true&size=baby" class="btn btn-primary">
            Create a baby Simulation
            </a>
            </div>                
            {/if}
            {if isset($defsim)} 
            <div class="alert alert-success">
                Default simulation found id: {$defsim}
            </div>
            {else}
            <div class="alert alert-error">
                Default simulation missing, press the create button!
            <a href="initialise.php?init=true" class="btn btn-primary">
            Create Default Simulation
            </a>
            </div>                
            {/if}
    </div>
</div>
<div class="row">
    <div class="span12">
        <h2>Tables in MongoDB </h2>
        For Host:{$host} using Database:{$db}
        <ul>
        {foreach $collections as $item}
            <li>{$item}</li>
        {/foreach}
        </ul>

    </div>
</div>

 
    
{/block}