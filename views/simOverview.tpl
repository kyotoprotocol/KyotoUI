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
                        <!-- Hover box for copy simulation -->
                        <div class="modal hide" id="sim{$simID}">
                           <form class="well" name="input" action="simulations.php" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Create a copy of {$simName}</h3>
                            </div>
                            <div class="modal-body">
                                <div class="control-group">
                                    <label>Name of new Simulation</label>
                                    <input class="input-xlarge focused" name="simulationname" value="{$simName}" type="text">
                                    <label class="control-label" for="textarea">Description</label>
                                    <div class="controls">
                                    <textarea class="input-xlarge" name="simulationdescription" id="textarea" rows="6">{$simDescription}</textarea>
                                    </div>
                                    <input name="simulationcopy" value="{$simID}" type="hidden">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-primary">Create a copy</button>
                            </div>
                           </form>
                        </div>
                        <!-- END Hover box for copy simulation -->

        <div class="btn-toolbar">
            <div class="btn-group">
                    <a id="c1" class="btn dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html"><i class="icon-map-marker"></i>Map view<span class="caret"></span>
                    </a>
                        <ul class="dropdown-menu">
                    {foreach from=($dropdownlist) key=k item=c}
                            <li><a href='#' class="params" id="{$c}">{$c}</a></li>
                    {/foreach}
                
                    </ul>
            </div>
              
            <div class="btn-group">
                    <a id="c2" class="btn dropdown-toggle" data-toggle="dropdown" href=""><i class="icon-cog"></i>Edit Countries<span class="caret"></span>
                    </a>
                        <ul class="dropdown-menu">
                    {foreach $simData['countries'] as $cnt}
                        <li><a href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a></li>
                    {/foreach}
                    </ul>
                <a class="btn" href="simEdit.php?simid={$simID}"><i class="icon-cog"></i>Edit Simulation</a>
                <a class="btn" href="export.php?simid={$simID}"><i class="icon-download"></i> CSV export</a>
                <a class="btn" data-toggle="modal" href="#sim{$simID}"><i class="icon-circle-arrow-right"></i> Copy</a>
            </div>   
        </div>
    </div>
</div> 

<div class="row">
    <div class="span12">
        <div id="visualization"></div>
    </div>
</div> 
       

<div class="row">
    <div class="span8">
        <h1>{$simName}</h1>
    </div>
        <div class="span4"><h5>Author: {$simAuthor}</h5></div>
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