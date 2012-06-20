{extends file="views/layout.tpl"}
{block name=title}Simulation Result - {$simName}{/block}
{block name=head}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}   
    $(document).ready(function() {
        $(".nav-tabs").button();
        $.ajax({
            type: "GET",
            url: "ajax.php",
            data: {func : 'result', simid : {/literal}{$simid}{literal}},
            success: function(data) {
                console.log(data);
                window.data = data;
                arrayCountriesTool(data, 'carbonOutput', 'geochart');
                arrayStatsTool(data);
            }
        });            
            
        function arrayCountriesTool(data, field, chart){
            var newArray = [];
            $.each(data, function(index, element){
                if(index == 'countries'){
                    newArray.push(['Country', field]);
                    $.each(element, function(index, output){
                        newArray.push([output['ISO2'], parseInt(output[field])]);
                    });
                    if(chart == 'geochart'){
                        //updateGeochart(newArray);
                    } else {
                        //add more - look into passing the chart?
                    }
                }
            });
        };
            
        function arrayStatsTool(data){
            //iterate through the stats array 
                console.log(data.stats);
            $.each(data.stats, function(index, element){
                console.log(index);
                if(index == 'globalCarbonChangePercentage'){
                    $('#'+ index).text(element.toFixed(0) + '%'); //billion tonnes
                } else if(index == 'carbonOutput') {
                    console.log('carbonOutput');
                        console.log(element);
                    $('#'+ index).text((element/1000000).toFixed(0));
                } else {
                    $('#'+ index).text((element).toFixed(0));
                }
            });
        };
            
            
        // specific functionality (data array is available here)
        $(".geochart_buttons").children().click( function(e) {
            console.log($(this).attr('id'));
            arrayCountriesTool(data, $(this).attr('id'), 'geochart');
        });
            
    });
    </script>
    
    <script type="text/javascript">
    window.geochart = {};
    window.options = {};
    google.load('visualization', '1', {packages: ['geochart']});

    //google.setOnLoadCallback(updateGeochart);
        
    function updateGeochart(parameters){
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
        var geochart = new google.visualization.GeoChart(document.getElementById('geo_chart'));
        geochart.draw(data, options);
    }        
    
    {/literal}    
</script>
 
{/block}

{block name=body}



<div class="page-header">
    <h1>Simulation 5   <small>Designed to observe what happens when bangladesh bloody go for it.</small></h1>
</div>
<div class="row">
    <div class="span3">
        <div class="well">
            <p id="globalCarbonChangePercentage" style="color: green;line-height: 96px;font-size: 96px; font-weight: bold"></p>
            <h4>Global Reduction of C02</h4>
        </div>
        <div class="well">
            <p id="numberOfMemberCountries" style="color: green;line-height: 96px;font-size: 96px; font-weight: bold">204</p>
            <h4>Countries remain in Kyoto Protocol</h4>
        </div>
    </div>
    <div class="span9">
        <table class="table table-bordered">
            <tr>
                <td style="height: 365px;background-image: url('includes/img/dinero_bg.jpg'); padding-top: 50px;padding-right: 20px;">
        <p id="carbonOutput" align="right" style="color: white;line-height: 200px;font-size: 256px; font-weight: bold"></p>
        <h1 align="right"style="color: white;">MILLION TONNES OF GLOBAL CO2 REDUCTION</h1>

                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="span3">
        <div class="well" style="height: 140px;">
            <p style="color: black;line-height: 96px;font-size: 96px; font-weight: bold">13K</p>
            <h4>Credit Trades</h4>
        </div>
    </div>
    <div class="span4">
        <div class="well" style="height: 140px;">
            <p style="color: green;line-height: 96px;font-size: 96px; font-weight: bold">199M</p>
            <h4>Tonnes of CO2 absorbed by Carbon Reduction</h4>
        </div>
    </div>
    <div class="span5">
        <div class="well" style="height: 140px;">
            <p style="color: red;line-height: 96px;font-size: 96px; font-weight: bold">$40Bn</p>
            <h4>Spent on dirty industry for GDP growth</h4>
        </div>
    </div>
</div>
<div class="row">
    <div class="span2">
        <div class="well">
        fuck
        </div>
    </div>
    <div class="span2">
        <div class="well">
        fuck
        </div>
    </div>
    <div class="span2">
        <div class="well">
        fuck
        </div>
    </div>
    <div class="span2">
        <div class="well">
        fuck
        </div>
    </div>
    <div class="span2">
        <div class="well">
        fuck
        </div>
    </div>
    <div class="span2">
        <div class="well">
        fuck
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
<!-- some CHART SHIT -->
    </div>
</div>



{/block}

<div class="page-header">
    <h1>Simulation 5   <small>Designed to observe what happens when bangladesh bloody go for it.</small></h1>
</div>
<div class="row">
    <div class="span3">
        <div class="well">
            <p style="color: green;line-height: 96px;font-size: 96px; font-weight: bold">16%</p>
            <h4>Global Reduction of C02</h4>
        </div>
        <div class="well">
            <p style="color: green;line-height: 96px;font-size: 96px; font-weight: bold">204</p>
            <h4>Countries remain in Kyoto Protocol</h4>
        </div>
    </div>
    <div class="span9">
        <table class="table table-bordered">
            <tr>
                <td style="height: 365px;background-image: url('includes/img/dinero_bg.jpg'); padding-top: 50px;padding-right: 20px;">
        <p align="right" style="color: white;line-height: 200px;font-size: 256px; font-weight: bold">160M</p>
        <h1 align="right"style="color: white;">TONNES OF GLOBAL CO2 REDUCTION</h1>

                </td>
            </tr>
        </table>
    </div>
</div>
<div class="row">
    <div class="span3">
        <div class="well">
            <p style="color: black;line-height: 96px;font-size: 96px; font-weight: bold">13K</p>
            <h4>Credit Trades</h4>
        </div>
    </div>
    <div class="span4">
        <div class="well">
            <p style="color: green;line-height: 96px;font-size: 96px; font-weight: bold">199M</p>
            <h4>Trees planted</h4>
        </div>
    </div>
    <div class="span5">
        <div class="well">
            <p style="color: red;line-height: 96px;font-size: 96px; font-weight: bold">$40Bn</p>
            <h4>Spent on dirty industry for GDP growth</h4>
        </div>
    </div>
</div>
<hr>
<div class="row">
    <div class="span12">

<!-- Add data-toggle="buttons-radio" for radio style toggling on btn-group -->
            <div class="btn-group" data-toggle="buttons-radio">
                <button class="btn">CO2 Tonnes</button>
                <button class="btn">CO2 % Change</button>
                <button class="btn">Kyoto Members</button>
                <button class="btn">Cheating Countries</button>
            </div>
        <h2>GeoChart of CO2 reduction in Tonnes</h2>
        <iframe src="//google-developers.appspot.com/chart/interactive/docs/gallery/geochart_06d031f6a0bf088f1320a975cdefa0e3.frame" style="border: none;width: 100%; height: 550px;">
  &lt;p&gt;[This section requires a browser that supports iframes.]&lt;/p&gt;
        </iframe>

        
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
<iframe src="//google-developers.appspot.com/chart/interactive/docs/gallery/linechart_a9fba3b6f44d821a89c71526093a1820.frame" style="border: none;width: 100%; height: 500px;">
  &lt;p&gt;[This section requires a browser that supports iframes.]&lt;/p&gt;
</iframe>
    </div>
</div>