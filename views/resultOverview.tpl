{extends file="views/layout.tpl"}
{block name=title}Simulation Result - {$simName}{/block}
{block name=head}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    $(document).ready(function() {
        $('.nav-tabs').button();
        $("ul.nav-pills > li").click(function() {
            $(".active").removeClass("active");
            $(this).addClass("active"); 
            //ajax here
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: {func : $(this).attr('id')},
                success: function(data) {
                    //load data and redraw chart
                    updateTable(data);
                    //show div hide others
                }
            });
        });
    });
    {/literal}    
</script>
<script type="text/javascript">
    {literal}
    google.load("visualization", "1", {packages:["corechart", "table"]});
    google.setOnLoadCallback(drawChart);
         
     function drawChart() {
         var data = google.visualization.arrayToDataTable([
             ['Year', 'Carbon Output'],
             ['2004', 1000],
             ['2005', 1100],
             ['2006', 1100],
             ['2007', 1300]
         ]);
             
         window.options = {
             title: 'Global Carbon Output',
             hAxis: {title: 'Year', titleTextStyle: {color: 'blue'}},
             yAxis: {title: 'Tonnes CO2', titleTextStyle: {color: 'blue'}}
         };
             
         window.table = new google.visualization.AreaChart(document.getElementById('co2_chart'));
             
         table.draw(data, options);
     }
         
     function updateTable(parameters){
        if(table) {
            table.clearChart();  // make chart ready for re-population
        }
        var data = google.visualization.arrayToDataTable(parameters); // set parameters as data

        table.draw(data, options);
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