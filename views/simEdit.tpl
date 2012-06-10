{extends file="views/layout.tpl"}
{block name=title}Simulation Editor - {$simulationname}{/block}
{block name=head}
{/block}

{block name=body}

{if isset($updated)}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> {$simulationname} updated.
    </div>
{/if} 

<div class="row">
    <div class="span4">
        <h1>{$simulationname}</h1>
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
    <div class="span8"> <div id="visualization" style="width: 800px; height: 400px; margin-left: 50px;"></div></div>
 </div>
<div class="row">
    <div class="span12">
        <form class="well" action="simEdit.php?simid={$simID}" method="post">
        <table class="table table-striped">
             <tbody>
                {foreach from=$simulation key=k item=s}
                    <tr>
                        <td>{$k}</td>
                        <td><input type="text" name="{$k}" value="{$s}"></td>
                    <tr>
                {/foreach}
                <tr>
                    <td><button type="submit" class="btn btn-primary"> Save Changes</button></td>
             </tbody>
        </table>
        </form>
    </div>
 </div>


    
{/block}