{extends file="views/layout.tpl"}
{block name=title}Simulation Result - {$simName}{/block}
{block name=head}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    $(document).ready(function() {
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
<p class="lead">Simulation result overview page</p>
<div class="row-fluid">
        <div class="subnav">
        <!-- sidebar -->
            <ul class="nav nav-pills">
                <li class="active" id="overview"><a href="#"><i class="icon-white icon-home"></i> Overview</a></li>
                <li id="group"><a href="#"><i class="icon-book" ></i> Per Group</a></li>
                <li><a href="#"><i class="icon-pencil" ></i> Per Country</a></li>
                <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-flag"></i> Help</a></li>
            </ul>
        </div>
        <div class="span10">
            <div id="co2_chart"></div>
        </div>
</div> 

{/block}