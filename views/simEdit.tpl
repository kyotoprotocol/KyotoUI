{extends file="views/layout.tpl"}
{block name=title}Simulation Editor - {$simName}{/block}
{block name=head}
{literal}
    <script type="text/javascript">        
        $(document).ready(function() {
            $("form :input").change(function() {
                $(this).closest('form').data('changed', true);
                $('.alert-info').delay(500).slideDown('slow');
            });
            $("h1").click(function() {
                $(this).hide();
                $("#name").show().focus();
            });
            $("#name").blur(function() {
                $(this).hide();
                $("h1").text($(this).val());
                $("h1").show();
            });
            $("h3").click(function() {
                $(this).hide();
                $("#author").show().focus();
            });
            $("#author").blur(function() {
                $(this).hide();
                $("h3").text($(this).val());
                $("h3").show();
            });
            $("h5").click(function() {
                $(this).hide();
                $("#description").show().focus();
            });
            $("#description").blur(function() {
                $(this).hide();
                $("h5").text($(this).val());
                $("h5").show();
            });
            $("#submit").click(function() {
                $("#editForm").submit();
            });
            $('#name').bind('keypress', function(e) {
                if(e.keyCode==13){
                    $("#name").blur();
                    return false;
                }
            });
            $('#author').bind('keypress', function(e) {
                if(e.keyCode==13){
                    $("#author").blur();
                    return false;
                }
            });
            $('#description').bind('keypress', function(e) {
                if(e.keyCode==13){
                    $("#description").blur();
                    return false;
                }
            });  
        });
    </script>
{/literal}
{/block}

{block name=body}

{if isset($updated)}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Success!</strong> {$simName} updated.
    </div>
{/if}

    <div class="alert alert-info hidden">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>There are unsaved changes to {$simName}!</strong>
    </div>

<form action="simEdit.php?simid={$simid}" id="editForm" method="post">
<div class="row">
    <div class="span12">
        <h1>{$simName}</h1>
        <input type="text" id="name" name="name" value="{$simName}" style="display:none">
        <h3>{$simAuthor}</h3>
        <input type="text" id="author" name="author" value="{$simAuthor}" style="display:none">
        <h5>{$simDescription}</h5> 
        <input class='span12' type="text" id="description" name="description" value="{$simDescription}" style="display:none">
    </div>
 </div>
    <br>
<div class="well">                
<div class="row">
    <div class="span12">
        <table class="table table-striped">
             <tbody>
                {foreach from=$attributes key=k item=s}
                    {if $k == '_id' or $k == 'classname'}
                    <tr>
                        <td>{$k}</td>
                        <td><input type="text" name="{$k}" value="{$s}" readonly="true"></td>
                    </tr>
                    {else if $k == 'createdAt' or $k=='currentTime' or $k=='finishedAt'}
                    <tr>
                        <td>{$k}</td>
                        {if $s == '0'}
                            <td><input type="text" name="{$k}" value="{$s}" readonly="true"></td>
                        {else}
                        <td><input type="text" name="{$k}" value="{$s}" readonly="true">  ({date("M j, Y  g:i a", substr($s, 0, -3))})</td>
                        {/if}
                    </tr>
                    {else if $k == "name" or $k=='author' or $k=='description'}
                    {else if is_array($s)}
                        {if $k == 'parent' or $k == 'children'}
                        {else if $k == 'countries'}
                            <tr>
                                <td><strong>{$k}:</strong></td>
                                <td><a class='btn' href='country.php?simid={$simid}'>Edit Countries</a></td>
                            </tr>
                        {else if $k == 'parameters'}
                            <tr>
                                <td><strong>{$k}:</strong></td>
                                <td></td>
                            </tr>
                            {foreach from=$s key=k2 item=s2}
                                {if $k2 == 'finishTime'}
                                {else}
                                    <tr>
                                        <td class='indented'>{$k2}</td>
                                        <td><input type="text" name="param_{$k2}" value="{$s2}"></td>
                                    </tr>
                                {/if}
                            {/foreach}
                            <tr>
                                <td rowspan="2"><strong>Add New Parameter:</strong></td>
                                <td><input type="text" name="newKey" id="newKey" placeholder="New attribute name..."></td>
                            </tr>
                            <tr> 
                                <td><input type="text" name="newValue" id="newValue" placeholder="New attribute value..."></td>
                                <td></td>
                            </tr>
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
                            </tr>
                        {/if}
                    {/if}
                {/foreach}
                <tr>
                    <td><button class="btn btn-primary" id="submit"> Save Changes</button></td>
                    <td></td>
             </tbody>
        </table>
    </div>
 </div>
</div>
</form>
{/block}