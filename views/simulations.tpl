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
                <col class="span7">
                <col class="span3">
            </colgroup>
            <thead>
                <tr>
                    <th>Number</th>
                    <th>Status</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                {foreach $simulations as $s}
                <tr>
                    <td>{$s["name"]}</td>
                    <td><span class="label">Default</span></td>
                    <td>
                        <div class="btn-group">          
                            <button class="btn btn-primary" href="simulations.php?hello" >Action</button>
                            <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button>
                            <ul class="dropdown-menu">
                                <li><a href="#">Edit</a></li>
                                <li><a href="#">Duplicate</a></li>
                                <li><a href="#">Remove</a></li>
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