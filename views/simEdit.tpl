{extends file="views/layout.tpl"}
{block name=title}Simulation Editor - {$simName}{/block}
{block name=head}
{/block}

{block name=body}

{if isset($updated)}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> {$simName} updated.
    </div>
{/if} 

<div class="row">
    <div class="span4">
        <h1>{$simName}</h1>
        <ul class="nav nav-pills">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">Simulations<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {foreach from=$simulations key=k item=s}
                    <li><a href='simEdit.php?simid={$s->getID()}' >{$s->getName()}</a></li>
                {/foreach}

                </ul>
            </li>
        </ul>            
    </div>
 </div>
<div class="row">
    <div class="span12">
        <form class="well" action="simEdit.php?simid={$simid}" method="post">
        <table class="table table-striped">
             <tbody>
                {foreach from=$attributes key=k item=s}
                    {if is_array($s)}
                        {if $k == 'parent' or $k == 'children'}
                        {else if $k == 'countries'}
                            <tr>
                                <td><strong>{$k}:</strong>
                                <a class='btn' href='country.php?simid={$simid}'>Edit Countries</a></td>
                            </tr>
                        {else if $k == 'parameters'}
                            <tr><td><strong>{$k}:</strong><td></tr>
                            {foreach from=$s key=k2 item=s2}
                                {if $k2 == 'finishTime'}
                                {else}
                                    <tr>
                                        <td class='indented'>{$k2}</td>
                                        <td class='indented'><input type="text" name="param_{$k2}" value="{$s2}"></td>
                                    <tr>
                                {/if}
                            {/foreach}
                        {/if}
                    {else}
                        {if $k == 'parent' or $k == 'children'}
                        {else}
                            <tr>
                                <td>{$k}</td>
                                {if strlen($s) > 50}
                                    <td><textarea cols="30" rows="4" name="{$k}">{$s}</textarea></td>
                                {else}
                                    <td><input type="text" name="{$k}" value="{$s}"></td>
                                {/if}
                            <tr>
                        {/if}
                    {/if}
                {/foreach}
                <tr>
                    <td><button type="submit" class="btn btn-primary"> Save Changes</button></td>
             </tbody>
        </table>
        </form>
    </div>
 </div>

{/block}