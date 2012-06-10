{extends file="views/layout.tpl"}

{block name=title}Simulations{/block}

{block name=head}{/block}

{block name=body}
<div class="row">
    <div class="span8">
        <h1>View and Edit Simulations</h1> 
    </div>
 </div>

<div class="row">
    <div class="span12">
        <table class="table table-bordered table-striped">
            <colgroup>
                <col class="span1">
                <col class="span2">
                <col class="span4">
                <col class="span4">
                <col class="span2">
            </colgroup>
            <thead>
                <tr>
                    <th>_id</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Parameters</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                {foreach $simulations as $s}
                <tr>
                    <td>
                        {$s["_id"]}
                    </td>
                    <td>
                        <h3>{$s["name"]}</h3>
                        <hr>
                        {if $s["state"] == "NOT STARTED" }
                        <span class="label label-inverse">{$s["state"]}</span>
                        {else if $s["state"] == "AUTO START" }
                        <span class="label label-important">{$s["state"]}</span>
                        {else}
                        <span class="label">{$s["state"]}</span>
                        {/if}
                    </td>
                    <td>
                        {if isset($s["description"]) }
                            {$s["description"]}
                        {else}
                            Missing Description
                        {/if}    
                    </td>
                    <td>
                        <dl class="dl-horizontal">
                        {foreach $s as $param}
                           {if ($param@key == "description") }
                           {elseif ($param@key == "state") }
                           {elseif ($param@key == "id") }
                           {elseif ($param@key == "countries") }
                           {elseif ($param@key == "children") }
                           {elseif ($param@key == "classname") }
                           {elseif ($param@key == "parent") }
                           {elseif ($param@key == "name") }
                           {elseif ($param@key == "parameters") }
                                <dt>{$param@key}</dt>
                                {foreach $param as $subparam}
                                    <dd>{$subparam@key} : {$subparam}</dd>
                                {/foreach}
                           {elseif (is_array($param)) }
                                <dt>{$param@key}</dt>
                                <dd>array</dd>
                           {else}
                                <dt>{$param@key}</dt>
                                <dd>{$param}</dd>
                           {/if}
                        
                        {/foreach}
                        </dl>
                    </td>
                    <td>
                        <div class="btn-group">          
                            <a class="btn btn-primary" href="simOverview.php?simid={$s["_id"]}" >View</a>
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">View Countries</a></li>
                                <li><a href="export.php?simid={$s["_id"]}">Export to CSV</a></li>
                                <li><a href="simEdit.php?simid={$s["_id"]}">Edit</a></li>
                                <li><a href="#">tbc</a></li>
                                <!--            <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>-->
                            </ul>
                        </div><!-- /btn-group -->
                    </td>
                <tr>
                {/foreach}
             </tbody>
        </table>
    </div>
 </div>

    
{/block}