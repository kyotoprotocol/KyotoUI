{extends file="views/layout.tpl"}

{block name=title}Finished Simulations{/block}

{block name=head}{/block}

{block name=body}
<div class="row">
    <div class="span8">
        <h1>Finished Simulations</h1> 
    </div>
 </div>
<blockquote>
Shows the list of finished simulations in mongodb in the database: Presage
</blockquote>
{if isset($success)}
<div class="row">
    <div class="span12">
        <div class="alert alert-success">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>Success!</strong> {$success}
        </div>
    </div>
 </div>
{/if} 

<div class="row">
    <div class="span12">
        <table class="table table-bordered table-condensed">
            <!--<colgroup>
                <col class="span1">
                <col class="span4">
                <col class="span4">
                <col class="span2">
            </colgroup>-->
            <thead>
                <tr>
                    <th>_id</th>
                    <th>Status</th>
                    <th style="width:250px;">Name</th>
                    <th>Description</th>
                    <!--<th>Parameters</th>-->
                    <th style="width:80px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                {foreach $simulations as $s}
                <tr>
                    <td>
                        {$s["_id"]}
                        <!-- Hover box for copy simulation -->
                        <div class="modal hide" id="sim{$s["_id"]}">
                           <form class="well" name="input" action="simulations.php" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Create a copy of {$s["name"]}</h3>
                            </div>
                            <div class="modal-body">
                                <div class="control-group">
                                    <label>Name of new Simulation</label>
                                    <input class="input-xlarge focused" name="simulationname" value="{$s["name"]}" type="text">
                                    <label>Author: Who owns this simulation?</label>
                                    <input class="input-xlarge" name="author" value="Howard?" type="text">
                                    <label class="control-label" for="textarea">Description</label>
                                    <div class="controls">
                                    <textarea class="input-xlarge" name="simulationdescription" id="textarea" rows="6">{$s["description"]}</textarea>
                                    </div>
                                    <input name="simulationcopy" value="{$s["_id"]}" type="hidden">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Create a copy</button>
                            </div>
                           </form>
                        </div>
                        <!-- END Hover box for copy simulation -->
                        <!-- Hover box for delete simulation -->
                        <div class="modal hide" id="simdel{$s["_id"]}">
                           <form class="well" name="input" action="simulations.php" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Are you sure you want to delete: {$s["name"]}</h3>
                            </div>
                            <div class="modal-body">
                                <div class="control-group">
                                    <input name="simulationid" value="{$s["_id"]}" type="hidden">
                                    <input name="delete" value="{$s["_id"]}" type="hidden">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </div>
                           </form>
                        </div>
                        <!-- END Hover box for delete simulation -->
                    </td>
            {*if ($s['classname']==$DEFAULT_CLASSNAME)*}
                 <!-- next two cells are kyoto simulation specific-->
                    <td>
                        {if $s["state"] == "NOT STARTED" }
                        <span class="label label-inverse">{$s["state"]}</span>
                        {else if $s["state"] == "AUTO START" }
                        <span class="label label-important">{$s["state"]}</span>
                        {else}
                        <span class="label">{$s["state"]}</span>
                        {/if}
                    </td>
                    <td>
                        <h3>{$s["name"]}</h3>
                    </td>
                    <td>
                        {if isset($s["description"]) }
                            {$s["description"]}
                        {else}
                          	<div class="alert alert-info" style="margin-bottom: 2px;">
                                   <strong>Missing Description!</strong><br> If you've created this in PresageCLI or PresageWEBUI it's unlikely to work due to missing data.
                                </div>
                        {/if}    
                    </td>
                    {*<td>
                        <dl class="dl-horizontal">
                            
                        {foreach from=$s key=key item=param}
                           {if ($key == "description") }
                           {elseif ($key == "createdAt") or ($key == "currentTime") or ($key == "finishedAt")}
                               <dt>{$key}</dt>
                               {if $param == 0}
                                   <dd>Not Set</dd>
                               {else}
                                <dd>{date("M j, Y  g:i a", substr($param, 0, -3))}</dd>
                                {/if}
                           {elseif ($key == "state") }
                           {elseif ($key == "id") }
                           {elseif ($key == "countries") }
                           {elseif ($key == "children") }
                           {elseif ($key == "classname") }
                           {elseif ($key == "parent") }
                           {elseif ($key == "name") }
                           {elseif ($key == "parameters") }
                                <dt>{$key}</dt>
                                {foreach from=$param key=k item=subparam}
                                    <dd>{$k} : {$subparam}</dd>
                                {/foreach}
                           {elseif (is_array($param)) }
                                <dt>{$key}</dt>
                                <dd>array</dd>
                           {else}
                                <dt>{$key}</dt>
                                <dd>{$param}</dd>
                           {/if}
                        
                        {/foreach}
                        </dl>
                    </td>*}

                    <td>
                        <div class="btn-group">          
                            <a class="btn btn-primary" href="simOverview.php?simid={$s["_id"]}" >View</a>
                            <a class="btn btn-primary dropdown-toggle " data-toggle="dropdown"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <!--<li><a href="#">View Countries</a></li>-->
                                <li><a href="export.php?simid={$s["_id"]}">Export to CSV</a></li>
                                <li><a href="simEdit.php?simid={$s["_id"]}">Edit</a></li>
                                <li><a href="rawResultOutput.php?simid={$s["_id"]}">Raw RESULTS</a></li>
                                <li><a data-toggle="modal" href="#sim{$s["_id"]}">Copy</a></li>
                                <li><a data-toggle="modal" href="#simdel{$s["_id"]}">Delete</a></li>
                                <!--            <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>-->
                            </ul>
                        </div><!-- /btn-group -->
                    </td>
                {*else}
                <!--not a kyoto simulation-->
                <td colspan="3">
                    <div class="alert" style="margin-bottom: 2px;">
                        <strong>{$s['name']}</strong> -- Non Kyoto Simulation ({$s['classname']})
                    </div>
                </td>
                    <td>
                        <div class="btn-group">          
                            <a class="btn btn-danger" data-toggle="modal" href="#simdel{$s["_id"]}">Delete</a>
                        </div><!-- /btn-group -->
                    </td>
                {/if*}
                <tr>
                {/foreach}
             </tbody>
        </table>
    </div>
 </div>

    
{/block}