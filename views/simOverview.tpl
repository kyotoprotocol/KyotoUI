{extends file="views/layout.tpl"}
{block name=title}Simulation Overview - {$simulationname}{/block}
{block name=head}
{literal}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
 <script>
    $(function() {
        $(document).ready(function() { 
            {/literal}
                window.bigtime = {$countries|@json_encode};
            {literal};
        });
        $(".params").click(function() {
            var newarray = [];
            var self = this;
                console.log($(this).attr('id'));
            newarray.push(['Country', $(this).attr('id')]);
            $.each(bigtime, function(index, country) {
                newarray.push([country['ISO2'], country[$(self).attr('id')]]);
            });
                console.log(newarray);
            show(newarray);
            return false;
         });
      });
 </script>
<script type="text/javascript">
    window.geochart = {};
    window.options = {};
    google.load('visualization', '1', {packages: ['geochart']});

    function drawVisualization() {
        var data = google.visualization.arrayToDataTable([
            ['Country', 'arableLandArea %'],
            {/literal}
                {foreach $countries as $c}
                    ['{$c['ISO2']}', {$c['arableLandAreaPC']}],
                {/foreach}
            {literal}
        ]);
            
        window.options = {
            colorAxis: { minValue: 0, maxValue: 100,  colors: ['#c5e5c5', '#2c662c']},
            datalessRegionColor: ['#da4f49'],
            width: 960,
            height: 500,
            magnifyingGlass: {enable: true, zoomFactor: 100.0}
        };

        window.geochart = new google.visualization.GeoChart(
            document.getElementById('visualization'));
        geochart.draw(data, options);
    }

    google.setOnLoadCallback(drawVisualization);
        
    function show(parameters){
        if(geochart) {
            geochart.clearChart();
        }
        var data = google.visualization.arrayToDataTable(parameters);
        var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
        chart.draw(data, options);
    }        
    
</script>
{/literal}
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
    <button class="btn params" id="totalArea">Total Area</button>
<div class="row">
    <div class="span12">
        <div id="visualization"></div>
    </div>
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