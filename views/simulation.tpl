{extends file="views/layout.tpl"}
{block name=title}Country View - {$country['name']}{/block}
{block name=head}
 
{/block}
{block name=body}

{if isset($updated)}
    <div class="alert alert-success">
        <strong>Success!</strong> {$country['name']} updated.
    </div>
{/if} 

<div class="row">
    <div class="span4">
        <h1>{$simulationname}</h1>
        <ul class="nav nav-pills">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">Dropdown<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {*foreach $cDrop as $c}
                    <li><a href='country.php?country={$c['ISO']}&simid={$simid}' >{$c['name']}</a></li>
                {/foreach*}

                </ul>
            </li>
        </ul>            
    </div>
    <div class="span8"></div>
 </div>
                
<div class="row">
    <div class="span12">
        <form class="well" action="country.php?country={*$country['ISO']}&simid={$simid*}" method="post">
        <table class="table table-striped">
             <tbody>
                {* $country as $c}
                    {if $c@key == 'ISO' or $c@key == 'ISO2' or $c@key == 'name'}
                        <tr>
                            <td>{$c@key}</td>
                            <td><input type="text" name="{$c@key}" value="{$c}" readonly="readonly"></td>
                        <tr>
                    {else}
                        <tr>
                                <td>{$c@key}</td>
                                <td><input type="text" name="{$c@key}" value="{$c}"></td>
                        <tr>
                    {/if}
                {/foreach*}
                <tr>
                    <td><button type="submit" class="btn btn-primary"> Save Changes</button></td>
             </tbody>
        </table>
        </form>
    </div>
 </div>


    
{/block}