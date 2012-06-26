{extends file="views/layout.tpl"}
{block name=title}Simulation Result - {$simname}{/block}
{block name=head}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    google.load('visualization', '1', {packages:['corechart', 'table', 'geomap', 'motionchart']});
    $(document).ready(function() {
        $(".nav-tabs").button();
        $("#loading").show();    
        $.ajax({
            type:  "GET",
            url: "ajax.php",
            data: {func : 'result', simid : {/literal}{$simid}{literal}},
            success: function(data) {
                $("#loading").delay(100).slideUp('slow');
                window.glbldata = data;
                updateMotionChart(data);
                arrayCountriesTool(data, 'carbonOutput');
                arrayStatsTool(data);
                arrayTradesTool(data);
                    
                updateLineChart(data);  //pass some useful data here parameters = data: ..., options:....
                //addNotices(data);
            }
        });
            
            
        function arrayCountriesTool(data, field){
            var newArray = [];
            newArray.push(['Country', field]);
            $.each(data.countries, function(index, element){
                if(field == 'isKyotoMember'){
                    if(element[field] == 'ANNEXONE' || element[field] == 'NONANNEXONE'){
                        newArray.push([element['ISO2'], parseInt(1)]);
                    } else {
                        newArray.push([element['ISO2'], parseInt(0)]);
                    }
                } else if (field == 'cheated'){
                    if(element[field] == 'true'){
                        newArray.push([element['ISO2'], parseInt(1)]);
                    } else {
                        newArray.push([element['ISO2'], parseInt(0)]);
                    }
                } else {
                    newArray.push([element['ISO2'], parseInt(element[field])]);
                }
                //$.each(output['notices'], function(ind, op){
                    //   $("#simulationNotices").append(ind+' : '+op);    
                //});    
            });
            updateGeochart(newArray);
        };
            
        function arrayStatsTool(data){
            //iterate through the stats array 
            $.each(data.stats, function(index, element){
                if(index == 'globalCarbonChangePercentage'){
                    $('#'+ index).text(element.toFixed(0) + '%'); //billion tonnes
                } else if(index == 'carbonReduction') {
                    $('#'+ index).text((element/1000000).toFixed(0));
                } else if(index == 'finalYearGlobalEmissionTarget'){
                    $('#' + index).text((element/1000000).toFixed(0));
                } else if(index == 'globalGDPChange'){
                    $('#' + index).text((element/1000000000).toFixed(0));
                } else {
                    $('#'+ index).text(element);
                }
            });
        };
            
        function arrayTradesTool(data){
            $.each(data.trades, function(index, element){
                if(index == "totalTradeValue"){
                    $('#'+ index).append((element/1000000000).toFixed(1)+'B');
                } else if(index == 'tradeCount'){
                    $('#'+ index).append((element/1000).toFixed(1));
                } else {
                    $('#'+ index).append((element).toFixed(0));
                }
            });
        }
            
        function arrayParamsTool(data){
            $.each(data.params, function(index, element){
                $('#' + index).append(element);
            });
        }
            
            
        // specific functionality (data array is available here)
        $(".geochart_buttons").children().click( function(e) {
            arrayCountriesTool(glbldata, $(this).attr('id'));
        });
            
    });
        
    function updateGeochart(parameters){
        if(window.geochart) {
            window.geochart.clearChart();  // make chart ready for re-population
        } else {
            window.geochart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
        }
        var data = google.visualization.arrayToDataTable(parameters); // set parameters as data
        var options = {
            colorAxis: { colors: ['#c5e5c5', '#2c662c']},
            datalessRegionColor: ['#da4f49'],
            width: 960,
            height: 500,
            magnifyingGlass: {enable: true, zoomFactor: 100.0}
        }
        //draw the chart   
        window.geochart.draw(data, options);
    }

    function updateLineChart(parameters) {
        if(window.linechart){
            window.linechart.clearChart();
        } else {
            window.linechart = new google.visualization.LineChart(document.getElementById('global_carbon_chart'));
        }
        var newArray = [];
        newArray.push(['Year', 'Carbon Output']);
        $.each(parameters.timeline, function(index, element){
            newArray.push(element);
        });
        var data = google.visualization.arrayToDataTable(newArray);
        if(parameters.options){
            var options = parameters.options;
        } else { //default options
            var options = { 
                title: 'Global Carbon Output vs Time',
                width: 960,
                height: 500,
                curveType: 'function',
                hAxis : {title: 'Simulation Year'},
                vAxis : {title: 'Global Carbon Output (tons)'}
            };
        }
        //draw the chart    
        window.linechart.draw(data, options);
    }
        
    function updateMotionChart(parameters){
        var data = new google.visualization.DataTable();
        var rows = [];
        var options = {};
        $.each(parameters.countries, function(index, output){
            rows.push([output['ISO'], new Date(output['year'],0,1), parseInt(output['carbonOutput']), parseInt(output['GDP']), output['isKyotoMember']]);
        });
        data.addColumn('string', 'Country');
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Carbon Output');
        data.addColumn('number', 'GDP');
        data.addColumn('string', 'Annex');
        data.addRows(rows);
        
        options['width'] = 960;
        options['height'] = 500;
        options['state'] = '{"orderedByX":false,"xLambda":0,"colorOption":"4","time":"1900-00-01","xZoomedDataMax":1200,"iconKeySettings":[],"yZoomedIn":false,"duration":{"timeUnit":"D","multiplier":1},"orderedByY":false,"yZoomedDataMax":617,"xZoomedIn":false,"iconType":"BUBBLE","xAxisOption":"2","nonSelectedAlpha":0.4,"yZoomedDataMin":150,"xZoomedDataMin":300,"yLambda":0,"sizeOption":"2","uniColorForNonSelected":false,"yAxisOption":"3","playDuration":15000,"dimensions":{"iconDimensions":["dim0"]},"showTrails":true}';

        var motionchart = new google.visualization.MotionChart(
            document.getElementById('motion_chart'));
        motionchart.draw(data, options);
    }
    
    {/literal}    
</script>
 
{/block}

{block name=body}

    <div id="loading" class='modal hide'>
        <div class="modal-body">
            <center><img src="includes/img/loading2.gif"></center>
        </div>
        <div class="modal-footer">
            <strong>loading...</strong>
        </div>
    </div>

<div class="page-header">
    <h1>Simulation {$simid}: {$simname}   <small>{$simdescription}</small></h1>
</div>
<div class="row">
    <div class="span3">
        <div class="well">
            <p id="globalGDPChange" style="color: green;line-height: 96px;font-size: 56px; font-weight: bold"></p>
            <h4>Global GDP Change (Bn$)</h4>
        </div>
        <div class="well">
            <p id="numberOfMemberCountries" style="color: green;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Countries remain in Kyoto Protocol</h4>
        </div>
    </div>
    <div class="span9">
        <table class="table table-bordered">
            <tr>
                <td style="height: 365px;background-image: url('includes/img/dinero_bg.jpg'); padding-top: 50px;padding-right: 20px;">
        <p id="carbonReduction" align="right" style="color: white;line-height: 200px;font-size: 256px; font-weight: bold"></p>
        <h1 align="right"style="color: white;">MILLION TONNES OF GLOBAL CO2 REDUCTION</h1>

                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="span3">
        <div class="well" style="height: 140px;">
            <p id="tradeCount" style="color: black;line-height: 96px;font-size: 86px; font-weight: bold"></p>
            <h4>Thousand Credit Trades</h4>
        </div>
    </div>
    <div class="span2">
        <div class="well" style="height: 140px;">
            <p id="finalYear" style="color: green;line-height: 96px;font-size: 86px; font-weight: bold"></p>
            <h4>Final Sim. Year</h4>
        </div>
    </div>
    <div class="span3">
        <div class="well" style="height: 140px;">
        <p id="cheatcount" style="color: green;line-height: 96px; font-size: 86px; font-weight: bold"></p>
        <h4>No. of Cheating Countries</h4>
        </div>
    </div>
    <div class="span4">
        <div class="well" style="height: 140px;">
            <p id="finalYearGlobalEmissionTarget" style="color: red;line-height: 96px;font-size: 86px; font-weight: bold;"></p>
            <h4>Million tonnes final year global emission target</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Total Trade Value:</strong>
        <div id="totalTradeValue" style="font-size:22px;">
            $
        </div>
        </div>
    </div>
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Max. Credit Value:</strong>
        <div id="maxCreditValue" style="font-size:22px;">
            $
        </div>
        </div>
    </div>
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Min. Credit Value:</strong>
        <div id="minCreditValue" style="font-size:22px;">
            $
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Ave. Credit Value:</strong>
        <div id="averageCreditValue" style="font-size:22px;">
            $
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Buy Trans. Count:</strong>
        <div id="buyCount" style="font-size:22px;">
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>CDM Count:</strong>
        <div id="cdmCount" style="font-size:22px;">
        </div>
        </div>
    </div>
</div>
<hr>
<div class="page-header">
    <h2>
        Multifunctional Geochart
        <small>Note: where true/false is required, 1 and 0 are used respectively.</small>
    </h2> 
</div>
<div class="row">
    <div class="span7 offset6">

            <div class="btn-group geochart_buttons" data-toggle="buttons-radio">
                <button id="carbonOutput" class="btn active">CO2 Tonnes</button>
                <button id="carbonChangePercentage" class="btn">CO2 % Change</button>
                <button id="isKyotoMember" class="btn">Kyoto Members</button>
                <button id="cheated" class="btn">Cheating Countries</button>
            </div>
    </div>
</div>
<div class="row">
<div id="geo_chart"></div>
</div>
<hr>
<!--
<div class="row">
    <div class="span6">
        <h2>Top Performers</h2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>Name</th>
                <th>CO2 Change</th>
                <th>GDP Change</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Leesville</td>
                        <td>- 345453</td>
                        <td>+ -5%</td>
                    </tr>
                    <tr>
                        <td>Winstonscin</td>
                        <td>- 345453</td>
                        <td>+ -5%</td>
                    </tr>
                </tbody>
            </table>
    </div>
    <div class="span6">
        <h2>Worst Performers</h2>
            <table class="table table-bordered table-striped">
                <thead>
                <th>Name</th>
                <th>CO2 Change</th>
                <th>GDP Change</th>
                </thead>
                <tbody>
                    <tr>
                        <td>Leesville</td>
                        <td>- 345453</td>
                        <td>+ -5%</td>
                    </tr>
                    <tr>
                        <td>Winstonscin</td>
                        <td>- 345453</td>
                        <td>+ -5%</td>
                    </tr>
                </tbody>
            </table>
        
    </div>
</div>
-->
<div class="page-header">
    <h2>GDP and Carbon Output vs Time (with Annex Information)</h2>
</div>

<div id="motion_chart"></div>
<hr>

<div class="page-header">
    <h2>Carbon Output vs Simulation Time</h2>
</div>

<div id="global_carbon_chart"></div>
<hr>
<!-- TRADE OUTPUT HERE
<div id="credit_cost_chart" style="width: 900px; height: 500px;"></div>

<div class="row">
    <div class="span12">
        <h2>Simulation Notices Output</h2>
        <div id="simulationNotices" class="container">
            
        </div>
    </div>
</div>
-->
{/block}