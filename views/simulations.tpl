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
    <div class="span4">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {foreach $simulations as $s}
                <tr>
                    <td>{$s}</td>
                    <td><span class="label">Default</span></td>
                    <td>
                        <div class="btn-group">
                            <a class="btn btn-primary" href="#"><i class="icon-cog"></i> Options</a>
                            <a class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="#"><span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><i class="icon-edit"></i> Edit</a></li>
                                <li><a href="#"><i class="icon-plus"></i> Duplicate</a></li>
                                <li class="divider"></li>
                                <li><a href="#"><i class="icon-trash"></i> Remove</a></li>
                            </ul>
                        </div>
                    </td>
                <tr>
                {/foreach}
             </tbody>
        </table>
    </div>
 </div>

    
{/block}