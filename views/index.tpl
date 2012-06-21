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
        <div class="hero-unit" style="height: 600px; background-image: url('http://www.carbonstreamafrica.com/wp-content/uploads/2008/11/penguins2.jpg'); background-position: center;">
            <h1>Welcome to KyotoUI!</h1>
            <p>This is the web interface for the <a href="https://github.com/farhanrahman/kyoto">Kyoto Protocol</a> simulator built upon <a href="http://www.presage2.info/">Presage</a>. </p>
            <div class="btn-toolbar">
                <button href="initialise.php" class="btn btn-primary btn-large">Get started</button >
                <form name="input" action="index.php" method="post">
                    <div class="btn-group">
                            {if ($setdb=='local')}
                                <button type="submit" name="database" value="local" class="btn btn-large btn-success disabled">Using local db</button>
                            {else}
                                <button type="submit" name="database" value="local" class="btn btn-large btn-info">Switch to local db</button>
                            {/if}
                            {if ($setdb=='remote')}
                                <button type="submit" name="database" value="remote" class="btn btn-large btn-success disabled">Using remote db</button>
                            {else}
                                <button type="submit" name="database" value="remote" class="btn btn-large btn-info">Switch to remote db</button>
                            {/if}
                    </div>        
                </form>
             </div>
        </div>
    </div>
</div>


    <a id="dave" rel="tooltip" href="test.php" title="Contribute and we'll add you in!" style="float:right;" ><i class="icon-thumbs-up"></i>Contributors</a>

{/block}