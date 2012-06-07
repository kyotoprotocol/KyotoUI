{extends file="views/layout.tpl"}
{block name=title}Country View {$country}{/block}
{block name=head}
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    google.load('visualization', '1', {packages: ['geomap']});
    {/literal}
    function drawVisualization() {
    var data = google.visualization.arrayToDataTable([
        ['Country', 'Selected'],
        ['{$country}', 1]
    ]);

    var geomap = new google.visualization.GeoMap(
        document.getElementById('visualization'));
    geomap.draw(data, null);
    }


    google.setOnLoadCallback(drawVisualization);
</script>  
{/block}
{block name=body}
<div class="row">
    <div class="span4">
        <h1>{$country}</h1>
        <ul class="nav nav-pills">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">Dropdown<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {foreach $dropdown as $c}
                    <li><a href='country.php?country={$c.ISO}' >{$c.name}</a></li>
                {/foreach}

                </ul>
            </li>
        </ul>            
    </div>
    <div class="span8"> <div id="visualization" style="width: 800px; height: 400px; margin-left: 50px;"></div></div>
 </div>
                
<div class="row">
    <div class="span12">
        <form class="well" action="country.php?country={$countrydata['ISO']}" method="post">
        <table class="table table-striped">
             <tbody>
                {foreach $countrydata as $c}
                <tr>
                        <td>{$c@key}</td>
                        <td><input type="text" name="{$c@key}" value="{$c}"></td>
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