{extends file="views/layout.tpl"}
{block name=title}Simulation Overview - {$simName}{/block}
{block name=head}
{literal}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
 <script>
    $(function() {
        $(document).ready(function() { 
            {/literal}
                window.bigtime = {$countries|@json_encode};     // convert array of countries to JSON
            {literal};
        });
        $(".params").click(function() {     // when a button is clicked
            var newarray = [];
            var self = this;
            newarray.push(['Country', $(this).attr('id')]);
            $.each(bigtime, function(index, country) {      // loop taking the relevant data
                newarray.push([country['ISO2'], parseInt(country[$(self).attr('id')])]);
            });
            show(newarray); // pass to function in order to show updated geochart
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
                    ['{$c['ISO2']}', {$c['arableLandAreaPercent']}], // default geochart data
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
            geochart.clearChart();  // make chart ready for re-population
        }
        var data = google.visualization.arrayToDataTable(parameters); // set parameters as data
        window.options = {
            colorAxis: { colors: ['#c5e5c5', '#2c662c']},
            datalessRegionColor: ['#da4f49'],
            width: 960,
            height: 500,
            magnifyingGlass: {enable: true, zoomFactor: 100.0}
        };
        var chart = new google.visualization.GeoChart(document.getElementById('visualization'));
        chart.draw(data, options);
    }        
    
</script>
{/literal}
{/block}
{block name=body}

<div class="row">
    <div class="span12">
        <ul class="nav nav-pills">
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">Map view<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {foreach from=($dropdownlist) key=k item=c}
                        <li><a href='#' class="params" id="{$c}">{$c}</a></li>
                {/foreach}
                </ul>
            </li>
            <li><a href="simEdit.php?simid={$simID}"><i class="icon-cog"></i>Edit Simulation</a></li>
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="path/to/page.html"><i class="icon-cog"></i>Edit Countries<b class="caret"></b></a>
                <ul class="dropdown-menu">
                {foreach $simData['countries'] as $cnt}
                    <li><a href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a></li>
                {/foreach}
                </ul>
            </li>

        </ul>            
    </div>
</div> 

<div class="row">
    <div class="span12">
        <div id="visualization"></div>
    </div>
</div> 
       

<div class="row">
    <div class="span4">
        <h1>{$simName}</h1>
    </div>
    <div class="span8"></div>
</div> 
<div class="row">
    <div class="span12">
        <blockquote>
        {$simDescription}
        </blockquote>
    </div>
</div>                
<div class="row">
     <div class="span12">
        <table class="table table-condensed">
             <tbody>
                {foreach $simData as $c}
                    {if $c@key == 'countries'}
                        <tr>
                            <td>{$c@key} [{$c|@count}]</td>
                            <td>
                                {if $c|@count > 20}
                                <ul class="nav nav-pills">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="path/to/page.html"><i class="icon-cog"></i>Edit Countries<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                        {foreach $c as $cnt}
                                            <li><a href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a></li>
                                        {/foreach}
                                        </ul>
                                    </li>
                                </ul>
                                {else}
                                {foreach $c as $cnt}
                                    <a class="btn-mini btn-info" href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a>
                                {/foreach}
                                {/if}
                            </td>
                        <tr>
                    {elseif $c@key == 'parameters'}
                        <tr>
                            <td>{$c@key}  [{$c|@count}]</td>
                            <td>
                                <dl class="dl-horizontal">
                                    {foreach $c as $p}
                                        <dt>{$p@key}</dt>
                                        <dd>{$p}</dd>
                                    {/foreach}
                                </dl>
                            </td>
                        <tr>
                    {elseif $c@key == 'children' or $c@key == 'parent' or  $c@key == 'description' or $c@key == 'name' }
                    {else}
                        <tr>
                            <td>{$c@key}</td>
                            <td>{$c}</td>
                        <tr>
                    {/if}
                {/foreach}
                <tr>
             </tbody>
        </table>

     </div>
</div>

{/block}