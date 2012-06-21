{extends file="views/layout.tpl"}
{block name=title}Welcome{/block}
{block name=head}
<script>
    $(function(){
    $('a[rel="tooltip"]').tooltip();
    });
</script>
{/block}
{block name=body}
{if isset($mongodriver)}
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Serious Error</strong> No PHP MONGO Driver Installed! <a href="https://github.com/kyotoprotocol/KyotoUI">See README</a>
    </div>
{elseif isset($mongodbconnect)}
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Error</strong> Mongo Connection missing <a href="https://github.com/kyotoprotocol/KyotoUI">See README.Your local Mongo program may not be installed, or active.</a>
    </div>
{/if} 
<div class="row">
    <div class="span12">
        <div class="hero-unit" style="height: 600px; background-image: url('includes/img/penguins2.jpg'); background-position: center;">
            <h1>Welcome to KyotoUI!</h1>
            <p>This is the web interface for the <a href="https://github.com/farhanrahman/kyoto">Kyoto Protocol</a> simulator built upon <a href="http://www.presage2.info/">Presage</a>. </p>
            <div class="btn-toolbar">
                    <div class="btn-group">
                <a href="initialise.php" class="btn btn-large btn-primary">Get started</a >
                    </div>
                    <div class="btn-group">
                            {if ($setdb=='local')}
                                <a href="#" class="btn btn-large btn-success disabled">Using local db</a >
                            {else}
                                <a href="index.php?database=local" class="btn btn-large btn-info">Switch to local db</a >
                            {/if}
                            {if ($setdb=='remote')}
                                <a href="#" class="btn btn-large btn-success disabled">Using remote db</a >
                            {else}
                                <a href="index.php?database=remote" class="btn btn-large btn-info">Switch to remote db</a >
                            {/if}
                   </div>        
             </div>
        </div>
    </div>
</div>


    <a id="dave" rel="tooltip" href="test.php" title="Contribute and we'll add you in!" style="float:right;" ><i class="icon-thumbs-up"></i>Contributors</a>

{/block}