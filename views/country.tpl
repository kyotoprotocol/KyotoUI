{extends file="views/layout.tpl"}
{block name=title}Country View - {$country['name']}{/block}
{block name=head}
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    google.load('visualization', '1', {packages: ['geomap']});
    {/literal}
    function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
            ['Country', 'Selected'],
            ['{$ISO2}', 1]
        ]);
        var geomap = new google.visualization.GeoMap(
            document.getElementById('visualization'));
        google.visualization.events.addListener(geomap, 'regionClick', function(e){
        window.location = "country.php?country="+e["region"]+"&simid="+{$simID};
        });
        geomap.draw(data, null);
    }
    
    google.setOnLoadCallback(drawVisualization);
    
</script>  

{/block}
{block name=body}

{if isset($updated)}
    <div class="alert alert-success">
        <strong>Success!</strong> {$country['name']} updated.
    </div>
{/if} 

<div class="row">
    <div class="span4">
        <h1>{$country['name']}</h1>
        <ul class="nav nav-pills">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">Countries<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {foreach $countries as $c}
                    <li><a href='country.php?country={$c['ISO']}&simid={$simID}' >{$c['name']}</a></li>
                {/foreach}

                </ul>
            </li>
        </ul>            
    </div>
    <div class="span8"> <div id="visualization" style="width: 800px; height: 400px; margin-left: 50px;"></div></div>
 </div>
                
<div class="row">
    <div class="span12">
        <form class="well" action="country.php?country={$country['ISO']}&simid={$simID}" method="post">
        <table class="table table-striped">
             <tbody>
                {foreach $country as $c}
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
                {/foreach}
                <tr>
                    <td><button type="submit" class="btn btn-primary"> Save Changes</button></td>
             </tbody>
        </table>
        </form>
    </div>
 </div>


    
{/block}