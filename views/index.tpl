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
{else}
{if isset($mongodbconnectLocal)}
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Error</strong> Mongo Connection missing <a href="https://github.com/kyotoprotocol/KyotoUI">See README.Your local Mongo program may not be installed, or active.</a>
    </div>
{elseif isset($mongodbconnectRemote)}
    <div class="alert alert-error">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>Error</strong> Mongo Connection missing <a href="https://github.com/kyotoprotocol/KyotoUI">See README.Remote MongoDB connection not found, perhaps you need to be on the VPN.</a>
    </div>

{/if}
{/if} 
<div class="row">
    <div class="span12">
        <div class="hero-unit" style="height: 600px; background-image: url('includes/img/penguins2.jpg'); background-position: center;">
            <h1>Welcome to KyotoUI!</h1>
            <p>This is the web interface for the <a href="https://github.com/farhanrahman/kyoto">Kyoto Protocol</a> simulator built upon <a href="http://www.presage2.info/">Presage</a>. </p>
            <div class="btn-toolbar">
                    <div class="btn-group">
                        <a href="initialise.php" class="btn btn-large btn-primary">Get started</a >
                        <a href="https://github.com/kyotoprotocol/KyotoUI/wiki/KyotoUIHelp" target="_blank" class="btn btn-large btn-primary">Help</a >
                   </div>
                    <div class="btn-group">
                            {if $server==true}
                                    <a href="#" class="btn btn-large btn-success disabled">Using local db on ise.buildr.com</a >
                            {else}
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
                            {/if}    
                   </div>        
             </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="span9">
    <a class="btn" href="https://github.com/kyotoprotocol"><i class="icon-random"></i> Kyoto Protocol on github</a>
    <a class="btn" href="https://github.com/kyotoprotocol/kyoto/raw/development/report/report.pdf" ><i class="icon-file"></i> Download Report</a>
    </div>
    <div class="span3">
    <a id="dave" rel="tooltip" href="test.php" title="Contribute and we'll add you in!" style="float:right;" ><i class="icon-thumbs-up"></i>Contributors</a>
    </div>
</div>
{/block}