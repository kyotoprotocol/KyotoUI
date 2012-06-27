{extends file="views/layout.tpl"}
{block name=title}Simulation Overview - {$simName}{/block}
{block name=head}
{literal}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
 <script>
    $(function() {
        $(document).ready(function() {
            $('.simwiz').show(); //show simulation wizard 'breadcrumbs'
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
        $("#runbutton").click(function(){
                $(this).hide();
                $("#runningbutton").show();
                $.ajax({
                    type: "GET",
                    url: "ajax.php",
                    data: {func : 'run', simid : '{/literal}{$smarty.get.simid}{literal}'},
                    success: function(data){
                       if(data == 0){
                           //success
                           setTimeout(function(){
                               location.reload();}
                            ,10000);
                      } else {
                          //failed
                          $("#runningbutton").text('FAILED');
                      }
                    }
                });
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
                    {foreach from=$simData['countries'] key=key item=cnt}
                        <li><a href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a></li>
                    {/foreach}
                    </ul>
                <a class="btn" href="simEdit.php?simid={$simID}"><i class="icon-cog"></i>Edit Simulation</a>
                <a class="btn" href="export.php?simid={$simID}"><i class="icon-download"></i> CSV export</a>
                <a class="btn" data-toggle="modal" href="#sim{$simID}"><i class="icon-circle-arrow-right"></i> Copy</a>
                {if $simData['state']=="COMPLETE"}
                {else}
                <button class="btn btn-danger" id="runbutton">RUN SIM</button>  
                <button class="btn btn-danger" id="runningbutton" style="display:none;">RUNNING <img src='/includes/img/ajax-loader.gif'></button>
                {/if}
            </div>   
        </div>
    </div>
</div> 

<div class="row">
    <div class="span1">
        <div style="width: 15px; height: 15px; background: #da4f49; float: right;">&nbsp;</div>
    </div>
    <div class="span11">
       <h6>Countries that are not defined in this simulation</h6>
    </div>
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
                {foreach from=$simData key=key item=c}
                    {if $key == 'countries'}
                        <tr>
                            <td>{$key} [{$c|@count}]</td>
                            <td>
                                {if $c|@count > 20}
                                <ul class="nav nav-pills">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown" href="path/to/page.html"><i class="icon-cog"></i>Edit Countries<b class="caret"></b></a>
                                        <ul class="dropdown-menu">
                                        {foreach from=$c item=cnt}
                                            <li><a href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a></li>
                                        {/foreach}
                                        </ul>
                                    </li>
                                </ul>
                                {else}
                                {foreach from=$c item=cnt}
                                    <a class="btn-mini btn-info" href="country.php?country={$cnt['ISO']}&simid={$simID}">{$cnt['name']}</a>
                                {/foreach}
                                {/if}
                            </td>
                        <tr>
                     {elseif ($key == "createdAt") or ($key == "startedAt") or ($key == "finishedAt")}
                               <tr>
                                   <td>{$key}</td>
                               {if $c == 0}
                                   <td>Not Set</td>
                               {else}
                                <td>{date("M j, Y  g:i a", (int)substr($c, 0, -3))}</td>
                                {/if}
                                </tr>
                    {elseif $key == 'parameters'}
                        <form action="simOverview.php?simid={$simID}" method="POST">
                        <tr>
                            <td>{$key}  [{$c|@count}]</td>
                            <td>
                                <dl class="dl-horizontal">
                                    {foreach from=$c key=k item=p}
                                        {if $k == "finishTime"}
                                        <!-- do nothing -->
                                        {else}
                                            <dt>{$k}</dt>
                                            <dd>{$p}</dd>
                                        {/if}
                                    {/foreach}
                                </dl>
                            </td>
                        <tr>
                        </form>
                    {elseif $key == 'children' or $key == 'parent' or  $key == 'description' or $key == 'name' }
                    {else}
                        <tr>
                            <td>{$key}</td>
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