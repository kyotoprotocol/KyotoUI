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
          <div class="control-group">
            <form name="input" action="initialise.php" method="post">
            {*html_radios name='simulation' options=$CSVfiles
            separator=''*}
            {foreach $CSVfiles as $file}
                    <label class="radio">
                    <div class="well">
                        <input name="filename" id="{$file['name']}" value="{$file['file']}" type="radio">
                        <h3>{$file['name']}</h3>
                        <h4>by: {$file['author']}</h4>
                        <h5>{$file['file']}</h5>
                        <blockquote>{$file['description']}</blockquote>
                    </div>
                </label>
                {/foreach}
                <button type="submit" class="btn">Import</button>
            </form>
          </div>

                        
                <a href="initialise.php?init=true" class="btn btn-primary">
            Create Default Simulation
            </a>
                <a href="initialise.php?init=true&size=baby" class="btn btn-primary">
            Create a baby Simulation
            </a>
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
            <span class="label label-success">
                Baby Default simulation found id: {$babysim}
            </span>
            {else}
            <span class="label label-important">
                Baby Default simulation missing, press the create button!
            <a href="initialise.php?init=true&size=baby" class="btn btn-primary">
            Create a baby Simulation
            </a>
            </span>     
            {/if}
             <br><br>
            {if isset($defsim)} 
            <span class="label label-success">
                Default simulation found id: {$defsim}
            </span>
            {else}
            <span class="label label-important">
                Default simulation missing, press the create button!
            <a href="initialise.php?init=true" class="btn btn-primary">
            Create Default Simulation
            </a>
            </span>
            {/if}
    </div>
</div>
<div class="row">
    <div class="span12">
        <h2>Tables in MongoDB </h2>
        <blockquote>
        For Host:{$host} using Database:{$db}
        </blockquote>
        <ul>
        {foreach $collections as $item}
            <li>{$item}</li>
        {/foreach}
        </ul>

    </div>
</div>
<div class="row">
    <div class="span6">
        <h2>Empty the tables</h2>
        
            <form class="well" method="POST">
                <span class="help-block">Will erase all simulations, counter and environmentstate</span>
                <input type="hidden" name="drop" value="true">
                <button type="submit" class="btn btn-danger">Submit</button>
            </form>
    </div>
</div>

 
    
{/block}