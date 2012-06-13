{extends file="views/layout.tpl"}
{block name=title}Simulation Results - {$simName}{/block}
{block name=head}

<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
    {literal}
    $(document).ready(function() {
        $("ul.nav-list > li").not(".nav-header").click(function() {
            $(".active").removeClass("active");
            $(this).addClass("active");  
            //ajax here
                console.log($(this).val);
            $.ajax({
                type: "GET",
                url: "ajax.php",
                data: $(this).val,
                success: function(data) {
                    //show div hide others
                    //load data and redraw chart
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
             
         var options = {
             title: 'Global Carbon Output',
             hAxis: {title: 'Year', titleTextStyle: {color: 'blue'}},
             yAxis: {title: 'Tonnes CO2', titleTextStyle: {color: 'blue'}}
         };
             
         var chart = new google.visualization.AreaChart(document.getElementById('co2_chart'));
             
         chart.draw(data, options);
     }
     
   
    {/literal}    
</script>
 
{/block}


{block name=body}

<div class="container-fluid">
    <div class="row-fluid">
        <div class="span2">
        <!-- sidebar -->
            <ul class="nav nav-list">
                <li class="nav-header">Carbon</li>
                <li class="active" id="overview"><a href="#"><i class="icon-white icon-home"></i> Overview</a></li>
                <li id="group"><a href="#"><i class="icon-book" ></i> Per Group</a></li>
                <li><a href="#"><i class="icon-pencil" ></i> Per Country</a></li>
                <li class="nav-header">Wealth</li>
                <li><a href="#"><i class="icon-user"></i> Profile</a></li>
                <li><a href="#"><i class="icon-cog"></i> Settings</a></li>
                <li class="divider"></li>
                <li><a href="#"><i class="icon-flag"></i> Help</a></li>
            </ul>
        </div>
        <div class="span10">
            <!-- body lost of stuff here will get hidden/shown depending on the tab clicked-->  
            <div id="co2_chart"></div>
        </div>
    </div> 
</div>
<!--
    <div class="row-fluid">
        <div class="span10">
            <div id="pie_chart"></div>
        </div>
        <div class="span2 offset10">
            <div id="stats_table"></div>
        </div>
    </div>
</div>
-->


{/block}