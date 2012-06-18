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
        <div class="hero-unit">
            <h1>Welcome to KyotoUI!</h1>
            <p>This is the web interface for the <a href="https://github.com/farhanrahman/kyoto">Kyoto Protocol</a> simulator built upon <a href="http://www.presage2.info/">Presage</a>. </p>
            <p><a href="initialise.php" class="btn btn-primary btn-large">
                Get started
            </a>
            </p>
                 <form name="input" action="index.php" method="post">
             <div class="btn-group">
                    {if ($setdb=='local')}
                        <button type="submit" name="database" value="local" class="btn btn-large disabled">Using local mongo database</button>
                    {else}
                        <button type="submit" name="database" value="local" class="btn btn-large btn-info">Use local mongo database</button>
                    {/if}
                    {if ($setdb=='remote')}
                        <button type="submit" name="database" value="remote" class="btn btn-large disabled">Using remote mongo database</button>
                    {else}
                        <button type="submit" name="database" value="remote" class="btn btn-large btn-info">Use remote mongo database</button>
                    {/if}
              </div>        
                 </form>
        </div>
    </div>
</div>


    
<ul class="thumbnails">
    <li class="span12">
        <a href="#" class="thumbnail">
            <!--- temporarily while on remote desktop<img src="http://www.carbonstreamafrica.com/wp-content/uploads/2008/11/penguins2.jpg" alt="">-->
        </a>
    </li>
</ul>
    <a id="dave" rel="tooltip" href="test.php" title="Contribute and we'll add you in!" style="float:right;" ><i class="icon-thumbs-up"></i>Contributors</a>

{/block}