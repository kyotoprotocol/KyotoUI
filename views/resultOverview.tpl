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

<div class="row-fluid">
    <div class="span8">
        <div id="area_chart" ></div>
    </div>
    <div class="span2 offset8">
        <div>
            ELLO<br>
            <br>
            <br>
            ello2
        
        </div>
    </div>
</div> 

{/block}