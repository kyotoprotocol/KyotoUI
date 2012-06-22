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
            type: "GET",
            url: "ajax.php",
            data: {func : 'result', simid : {/literal}{$simid}{literal}},
            success: function(data) {
                $("#loading").delay(100).slideUp('slow');
                console.log(data);
                updateMotionChart();
                //arrayCountriesTool(data, 'carbonOutput', 'geochart');
                arrayStatsTool(data);
                arrayTradesTool(data);
                    arrayParamsTool(data);
                updateLineChart(data);  //pass some useful data here parameters = data: ..., options:....
                addNotices(data);
            }
        });
            
            
        function arrayCountriesTool(data, field){
            var newArray = [];
            $.each(data, function(index, element){
                if(index == 'countries'){
                    newArray.push(['Country', field]);
                    $.each(element, function(index, output){
                        newArray.push([output['ISO2'], parseInt(output[field])]);
                        $.each(output['notices'], function(ind, op){
                            console.log(ind);
                                console.log(op);
                            $("#simulationNotices").append(ind+' : '+op);    
                        });    
                    });
                        
                    return newArray;
                }
            });
        };
            
        function arrayStatsTool(data){
            //iterate through the stats array 
            $.each(data.stats, function(index, element){
                if(index == 'globalCarbonChangePercentage'){
                    $('#'+ index).text(element.toFixed(0) + '%'); //billion tonnes
                } else if(index == 'carbonOutput') {
                    $('#'+ index).text((element/1000000).toFixed(0));
                } else if(index == 'finalYearGlobalEmissionTarget'){
                    $('#' + index).text((element/1000000).toFixed(1));
                } else {
                    $('#'+ index).text(element);
                }
            });
        };
            
        function arrayTradesTool(data){
            $.each(data.trades, function(index, element){
                $('#'+ index).append(element);
            });
        }
            
        function arrayParamsTool(data){
            $.each(data.params, function(index, element){
                console.log('hello');
                $('#' + index).append(element);
            });
        }
            
            
        // specific functionality (data array is available here)
        $(".geochart_buttons").children().click( function(e) {
            arrayCountriesTool(data, $(this).attr('id'), 'geochart');
        });
            
    });
        
    function updateGeochart(parameters){
        if(window.geochart.ready()) {
            window.geochart.clearChart();  // make chart ready for re-population
        } else {
            window.geochart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
        }
        var data = google.visualization.arrayToDataTable(parameters.data); // set parameters as data
        if(parameters.options){
            var options = parameters.options;
        } else { //default set up    
            var options = {
                colorAxis: { colors: ['#c5e5c5', '#2c662c']},
                datalessRegionColor: ['#da4f49'],
                width: 960,
                height: 500,
                magnifyingGlass: {enable: true, zoomFactor: 100.0}
            };
        }
        //draw the chart    
        window.geochart.draw(data, options);
    }

    function updateLineChart(parameters) {
        if(window.linechart){
            window.linechart.clearChart();
        } else {
            window.linechart = new google.visualization.LineChart(document.getElementById('credit_cost_chart'));
        }
        var data = google.visualization.arrayToDataTable(parameters.data);
        if(parameters.options){
            var options = parameters.options;
        } else { //default options
            var options = { 
                title: 'Company Performance'
            };
        }
        //draw the chart    
        window.linechart.draw(data, options);
    }
        
    function updateMotionChart(parameters){
        var data = new google.visualization.DataTable();
        data.addColumn('string', 'Fruit');
        data.addColumn('date', 'Date');
        data.addColumn('number', 'Sales');
        data.addColumn('number', 'Expenses');
        data.addColumn('string', 'Location');
        data.addRows([
            ['Apples', new Date(1988,0,1), 1000, 300, 'East'],
            ['Oranges', new Date(1988,0,1), 950, 200, 'West'],
            ['Bananas', new Date(1988,0,1), 300, 250, 'West'],
            ['Apples', new Date(1988,1,1), 1200, 400, 'East'],
            ['Oranges', new Date(1988,1,1), 900, 150, 'West'],
            ['Bananas', new Date(1988,1,1), 788, 617, 'West']
        ]);

        var motionchart = new google.visualization.MotionChart(
            document.getElementById('motion_chart'));
        motionchart.draw(data, {'width': 800, 'height': 400});
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
            <p id="globalGDPChange" style="color: green;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Global GDP Increase</h4>
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
            <p id="tradeCount" style="color: black;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Credit Trades</h4>
        </div>
    </div>
    <div class="span4">
        <div class="well" style="height: 140px;">
            <p id="finalYear" style="color: green;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Final Year</h4>
        </div>
    </div>
    <div class="span5">
        <div class="well" style="height: 140px;">
            <p id="finalYearGlobalEmissionTarget" style="color: red;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Million tonnes final year global emission target</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Total Trade Value:</strong>
        <div id="totalTradeValue" style="font-size:32px;">
        </div>
        </div>
    </div>
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Max. Credit Value:</strong>
        <div id="maxCreditValue" style="font-size:32px;">
        </div>
        </div>
    </div>
    <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Min. Credit Value:</strong>
        <div id="minCreditValue" style="font-size:32px;">
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Ave. Credit Value:</strong>
        <div id="averageCreditValue" style="font-size:32px;">
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>Buy Trans. Count:</strong>
        <div id="buyCount" style="font-size:32px;">
        </div>
        </div>
    </div>
   <div class="span2">
        <div class="well" style="font-size:11px;">
        <strong>CDM Count:</strong>
        <div id="cdmCount" style="font-size:32px;">
        </div>
        </div>
    </div>
</div>

<hr>
<div class="row">
    <div class="span12">

<!-- Add data-toggle="buttons-radio" for radio style toggling on btn-group -->
            <div class="btn-group geochart_buttons" data-toggle="buttons-radio">
                <button id="carbonOutput" class="btn active">CO2 Tonnes</button>
                <button id="carbonChangePercentage" class="btn">CO2 % Change</button>
                <button id="kyotoMember" class="btn">Kyoto Members</button>
                <button id="cheat" class="btn">Cheating Countries</button>
            </div>
        <h2>GeoChart of CO2 reduction in Tonnes</h2>
            <div id="geo_chart"></div>
    </div>
</div>
<hr>
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
<hr>
<div class="row">
    <div class="span12">
        <h2>Global CO2 Emissions VS Global GDP</h2>
    </div>
</div>


<!-- TRADE OUTPUT HERE -->
<div id="credit_cost_chart" style="width: 900px; height: 500px;"></div>

<div class="row">
    <div class="span12">
        <h2>Motion Chart (the bellex)</h2>
    </div>
</div>


<!-- TRADE OUTPUT HERE -->
<div id="motion_chart"></div>

<div class="row">
    <div class="span12">
        <h2>Simulation Notices Output</h2>
        <div id="simulationNotices" class="container">
            
        </div>
    </div>
</div>

{/block}