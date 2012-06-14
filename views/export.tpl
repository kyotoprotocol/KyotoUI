{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}

<div class="row">
    <div class="span12">
        <h1>Export Simulation Country data to CSV</h1>
        <br>
    </div>
</div>
{if isset($success)}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> {$filename} created!
    </div>
{/if} 
<div class="row">
    <div class="span6">
          <div class="control-group">
                <form class="well" name="input" action="export.php" method="post">
                    <label>Export CSV file</label>
                    <input class="input-xlarge focused" name="filename" value="{$filename}" type="text">
                    <p class="help-block">This will be saved in local/.<br>This folder is ignored by GIT and intentionally done you if you're overwriting the default CSV's you have to manually copy it. Drag to admin/csv/ to add to git and import.</p>
                    <label class="checkbox">
                    <input type="checkbox" disabled="disabled" > Check only if you're an absolute legend
                    </label>
                        {html_radios name='simulation' options=$simulations
                        selected=$selectedsim separator=''}
                    </label> 
            </div>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
   {if isset($notices)}
    <div class="span6">
        <div class="well">
            <ul>
        {foreach $notices as $notice}
                <li>{$notice}</li>
        {/foreach}
            </ul>
        </div>
    </div>
    {/if}
</div>

{/block}