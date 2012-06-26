{extends file="views/layout2.tpl"}
{block name=title}Maps{/block}
{block name=head}
<html manifest="/cache.manifest" itemscope itemtype="http://schema.org/Visualization">
    <meta property="og:title" content="MigrationsMap.net"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="http://migrationsmap.net/"/>
    <meta property="og:image" content="http://migrationsmap.net/facebook-image.png"/>
    <meta property="og:site_name" content="MigrationsMap.net"/>
    <meta property="fb:admins" content="548900828"/>
    <meta property="og:description" content="Interactive Migrations Map: Where are migrants coming from? Where have migrants left?"/>

    <meta itemprop="name" content="MigrationsMap.net">
    <meta itemprop="description" content="Interactive Migrations Map: Where are migrants coming from? Where have migrants left?">
    <meta itemprop="image" content="http://migrationsmap.net/facebook-image.png">

    <link rel="stylesheet" type="text/css" href="maps/univers-else-font/stylesheet.css" />
    <script type="text/javascript" src="maps/raphael.js"></script>
    <link type="text/css" href="maps/jquery-ui-1.8.16.custom/css/ui-darkness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
    <script type="text/javascript" src="maps/jquery-ui-1.8.16.custom/js/jquery-1.6.2.min.js"></script>
    <script type="text/javascript" src="maps/jquery-ui-1.8.16.custom/js/jquery-ui-1.8.16.custom.min.js"></script>
    <script type="text/javascript" src="maps/signals.js"></script>
    <script type="text/javascript" src="maps/hasher.js"></script>
    <script type="text/javascript" src="maps/modernizr.geoloc.js"></script>
    <!--<link rel="stylesheet" type="text/css" href="maps/main.css" />-->
{literal}
    <style>
    html {
     overflow: -moz-scrollbars-vertical;
     overflow: scroll;
    }
    #container2{
    margin: auto;
    width:1200px;
    position: relative;
    }
    </style>

    
    
{/literal}

{/block}
{block name=body}
<h1>{$simName}</h1>
<div class="row">
    <div class="span4">
        <select style="display: inline" class="span4" id="country_select">
        </select>
    </div>
    <div class="span6">
        <div  style="display: inline" class="btn-group" data-toggle="buttons-radio">
            <button href="#" id="in"  class="btn">Buyer</button>
            <button href="#" id="out" class="btn">Seller</button>
            <button href="#" id="both" class="btn">Both</button>
            <button href="#" id="all" class="btn">All Trades, All Countries</button>
        </div>
    </div>
</div>

{/block}
{block name=mapbody}

<div id="container2">

<div id="canvas_container">
    {literal}
    <script type="text/javascript">
        var ten_colors = ["#2F692F" , "#376F37" , "#397139" , "#3C733C" , "#3F763F" , "#427842" , "#467C46" , "#477D47" , "#4B804B" , "#4E824E" , "#548754" , "#578A57" , "#5B8D5B" , "#5E905E" , "#609160" , "#639463" , "#669666" , "#699969" , "#6C9B6C" , "#6E9D6E" , "#719F71" , "#75A375" , "#78A578" , "#7BA77B" , "#7EAA7E" , "#81AD81" , "#84AF84" , "#87B287" , "#8AB48A" , "#8DB68D" , "#90B990" , "#93BC93" , "#96BE96" , "#99C099" , "#9CC39C" , "#9FC59F" , "#A2C8A2" , "#A5CBA5" , "#A8CDA8" , "#ABCFAB" , "#AFD2AF" , "#B1D4B1" , "#B5D7B5" , "#B7D9B7" , "#BADCBA" , "#BDDFBD" , "#C0E1C0" , "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3", "#C3E4C3"];
        var svg_borders;
        var current_arrows=[];
        var current_countries=[];
        var currentCircles=[];
        var currentCountry="USA";
        var previousCountry = "USA";
        var direction = "out";
        var unselected_color = "#eeeeee"; //http://www.colorhexa.com/c7c7c7
        var selected_color = "#D1E8FA";//"#67E667" ;//"#87ceeb";
        var border_color = "#a0a0a0";
        var arrow_color = "#009CFF"//"#add8e6"; //"#fafad2";
        var selected_border = "#75B9F0"//"#add8e6"; //"#fafad2";
        var code_to_name ;
        var name_to_code;
        var code_to_coordinates;
        var userLatitude;
        var userLongitude;
        var GDP ={};
        var HIV = {};
        var POP = {};
        var TUBERCULOSIS = {};
        var UNDER_FIVE_MORTALITY = {};
        var container ;

        function parseHash(hash, redrawing){
            res = the_regexp.exec(hash);
            if (res)
            {
                currentCountry = res[1];
                if (res[2]=='arrivals')
                    direction = 'out';
                else
                    direction = 'in';
            }
            if (redrawing)
            redraw();
        }

        function setHashSilently(hash){
            hasher.changed.active = false; //disable changed signal
            hasher.setHash(hash); //set hash without dispatching changed signal
            hasher.changed.active = true; //re-enable signal
        }
        function lolatoxy(point){
            var lo = point.longitude;
            var la = point.latitude;
            //lo = -122.18994140625; // SF
            //la = 37.33522435930639;
            //lo = 23.5546875; //south of south-africa
            //la = -37.33522435930639;
            var x = (lo+180) * (1200 / 360.0);
            var y = (180 - (la+90)) *  (700.0 / 180.0); 
            return {"x":Math.floor(x),
                    "y":Math.floor(y)
            };
        }
        function flashCircles()
        {
            var c = paper.circle(userLongitude,userLatitude , 1);
            c.attr({"stroke":"white"});
            c.animate({r: 30,stroke:"yellow"}, 333, function(){
                var d = paper.circle(userLongitude,userLatitude , 1);
                c.animate({r: 60,stroke:"white"}, 333);
                d.attr({"stroke":"white"});
                d.animate({r: 30,stroke:"yellow"},333, function(){
                    var e = paper.circle(userLongitude,userLatitude , 1);
                    e.attr({"stroke":"white"});
                    e.animate({r: 30,stroke:"yellow"}, 333);
                    c.animate({r: 90,stroke:"yellow"}, 333);
                    d.animate({r: 60,stroke:"white"},333, function(){
                        c.remove();
                        d.remove();
                        e.remove();
                    });
                });

            });
        }
        function redraw()
        {
            var other_direction = "in";
            var hash_direction = "arrivals"
            if (direction =="in")
            {
                other_direction = "out";
                hash_direction = "departures";
            }
            setHashSilently(currentCountry+"/"+hash_direction);
            removeCurrentDrawings();
            $("#country_select").val(currentCountry);
            draw_arrows_and_paint_countries();

            $("#"+direction).removeClass("on");
            $("#"+other_direction).addClass("on")
        }
        


        
        function color_country(country,color,strokeColor)
        {
            var i;
            var l;
            if (svg_borders.hasOwnProperty(country))
                for (i=0, l= svg_borders[country].length;i<l;i++)
                {
                    if (strokeColor)
                        svg_borders[country][i].animate({"fill":color,"stroke":strokeColor,"stroke-width":2},333);
                    else
                        svg_borders[country][i].animate({"fill":color,"stroke":border_color,"stroke-width":1},333);
                }
        }

        function removeCurrentDrawings()
        {
            color_country(previousCountry,unselected_color);
            var i;
            var l;
            for (i=0,l=current_arrows.length;i<l;i++)
                current_arrows[i].remove();
            for (i=0,l=currentCircles.length;i<l;i++)
                currentCircles[i].remove();

            current_arrows=[];
            for(i=0,l=current_countries.length;i<l;i++)
                color_country(current_countries[i],unselected_color);
            current_countries=[]
        }
        
        function get_click_handler(country){
            return function(){
                previousCountry = currentCountry;
                currentCountry = country;
                redraw();
            }
        }
        
        function get_over_handler(country){
            return function(event){
                color_country(country,selected_color);
                var country_name =  $("#country_name_popup");

                country_name.empty();
                country_name.append("<span id='popup_country_name'> "+code_to_name[country] + "</span><table width='100%'>");
                var pop = insertDecimalPoints(parseFloat(POP[country]).toFixed(0));
                console.log(pop);
                if (!pop || pop=="NaN")
                    pop = "no data";
                
                country_name.append("<tr><th>CO2 Emissions</th><td style='text-align:right;'>" + pop+'</td></tr>');
                var gdp = insertDecimalPoints(parseFloat(GDP[country]).toFixed(0)) ;
                if (gdp && !isNaN(gdp))
                    gdp = '$ '+gdp;
                else
                    gdp ="no data";
                country_name.append("<tr><th>GDP</th><td style='text-align:right;'>" + gdp+'</td></tr>');
                var hiv = HIV[country];
                if (hiv && !isNaN(hiv))
                    hiv = hiv + ' %';
                else
                    hiv = "no data"
                country_name.append("<tr><th>C02 Reduction</th><td style='text-align:right;'>" + hiv+'</td></tr>');
                var tb = parseFloat(TUBERCULOSIS[country]/1000).toFixed(2);
                if (tb && !isNaN(tb))
                    tb = tb + ' %';
                else
                    tb = "no data";
                country_name.append("<tr><th>C02 Absorption</th><td style='text-align:right;'>" + tb +'</td></tr>');
                var mortality =  parseFloat(UNDER_FIVE_MORTALITY[country]/10).toFixed(2);
                if (mortality && !isNaN(mortality))
                    mortality = mortality + ' %';
                else
                    mortality = "no data";
                country_name.append("<tr><th>Cheated?</th><td style='text-align:right;'>" +mortality+'</td></tr></table>' );


                country_name.css("display","block");
                var canvasContainer = $("#canvas_container");
                var canvasTop = canvasContainer.offset().top;
                var canvasLeft = canvasContainer.offset().left;
                if (event.pageY<canvasTop+500)
                    country_name.css("top",event.pageY);
                else
                    country_name.css("top",event.pageY-170);
                country_name.css("left",Math.min(event.pageX,canvasLeft+1200-290));
            }
        }
        function insertDecimalPoints(s)
        {
            var l = s.length;
            var res = ""+s[0];
            for (var i=1;i<l-1;i++)
            {
                if ((l-i)%3==0)
                    res+= ".";
                res+=s[i];
            }
            res+=s[l-1];
            return res;
        }
        function get_out_handler(country){
            return function(event){
                var found=false;
                var i;
                var l;
                var country_name = $("#country_name_popup");
                country_name.css("display","none");
                for (i=0,l=current_countries.length;i<l;i++)
                {
                    if (country === current_countries[i])
                    {
                        found=true;
                        break;
                    }
                }
                if (country==currentCountry)
                    color_country(country,selected_color,selected_border);
                else if (found)
                  color_country(country,ten_colors[i])
                else
                    color_country(country,unselected_color);
            }
        }
        
        function draw_arrows_and_paint_countries()
        {
                {/literal}
            $.getJSON("ajaxmap.php?simid={$smarty.get.simid}&direction="+direction+"&country="+currentCountry+"", function(data) {
                {literal}
                var countries_div = $("#countries");
                var country_name_div = $("#country_name");
                countries_div.empty();
                country_name_div.empty()
                country_name_div.append(code_to_name[currentCountry]);
                $("#popsize").empty();
                var popsize = insertDecimalPoints(parseFloat(POP[currentCountry]).toFixed(0));
                if (popsize!="NaN")
                    popsize = "Pop: "+popsize;
                if (popsize )
                    $("#popsize").append(popsize);
                var counter =0;
                $.each(data, function(country, val) {
                    var line;
                    var i;
                    var l;
                    var path;
                    line = paper.path(val[0]);
                    countries_div.append("<tr><td><div class='color_span span3' style='height:2em;width:2em;background-color:"+ten_colors[counter] +" '>&nbsp;&nbsp;&nbsp;</div></td><td class='span3' value='"+name_to_code[val[1]] +"'>"+val[1]+'</td><td class="span3" style="text-align: right;">'+insertDecimalPoints(val[2])+"</td></tr>")
                    line.attr({stroke:arrow_color,'stroke-width':2,'opacity':0});
                    line.animate({stroke:arrow_color,'stroke-width':2,'opacity':1},333);
                    current_arrows.push(line);
                    color_country(country,ten_colors[counter]);
                    current_countries.push(country);
        
                    var coo = code_to_coordinates[country];
                    var circle = paper.circle(coo[0], coo[1], 2);
                    circle.attr("stroke", arrow_color);
                    circle.attr("fill", arrow_color);
                    currentCircles.push(circle);
                    coo = code_to_coordinates[currentCountry];
                    circle = paper.circle(coo[0], coo[1], 2);
                    circle.attr("stroke", selected_border);
                    circle.attr("fill", selected_border);
                    currentCircles.push(circle);
                    counter++;
                });

                color_country(currentCountry,selected_color,selected_border);
            });
        }

        var paper = new Raphael(document.getElementById('canvas_container'), 1200, 600);

        $.getJSON('maps/world_svg_paths_by_code.json', function(data) {
            svg_borders = {};
            $.each(data, function(country, val) {
                svg_borders[country]=[]
                var line;
                var i;
                var path;
                for (var i=0, l=val.length;i<l;i++)
                {
                    line = paper.path(val[i]);
                    line.attr({stroke:border_color,'stroke-width':1,'fill':unselected_color});
                    line.country=country;
                    $(line.node).click( get_click_handler(country));
                    $(line.node).mousemove( get_over_handler(country));
                    $(line.node).mouseout( get_out_handler(country));

                    svg_borders[country].push(line);
                }
            });
             $.getJSON("maps/name_to_code.json", function(data) {
                 name_to_code = data;
             });
             $.getJSON("maps/GDP.json", function(data) {
                 GDP = data;
             });
            $.getJSON("maps/HIV.json", function(data) {
                 HIV = data;
             });
            $.getJSON("maps/TUBERCULOSIS.json", function(data) {
                 TUBERCULOSIS = data;
             });
            $.getJSON("maps/UNDER-FIVE-MORTALITY.json", function(data) {
                 UNDER_FIVE_MORTALITY = data;
             });
            $.getJSON("maps/POP.json", function(data) {
                 POP = data;
             });

             $.getJSON("maps/code_to_name.json", function(data) {
                 code_to_name = data;
                 var country_select = $("#country_select");
                 $.each(data, function(code, name) {
                     var selected='';
                     if (code=="BEL")
                        selected='selected="selected"';
                     country_select.append("<option value='"+code+"'" +selected+">"+name+'</option>');
                 });
                 country_select.change(function(e){
                    previousCountry = currentCountry;
                    currentCountry = $(this).val();
                    redraw();
                 });
                 //draw_arrows_and_paint_countries();
             });
            $.getJSON("maps/code_to_coordinates.json", function(data) {
                code_to_coordinates = data;
                redraw();
            });


        });
        $(function(){
            if (!Modernizr.geolocation)
                $("#geoloc_me").hide();
            container = $("#container");
            $("#in").click(function(e){
               e.preventDefault();
               direction='out';
               redraw();
            });
            $("#out").click(function(e){
               e.preventDefault();

               direction='in';
               redraw();
            });
            $("#all").click(function(e){
               e.preventDefault();

               direction='all';
               redraw();
            });
            $("#both").click(function(e){
               e.preventDefault();

               direction='both';
               redraw();
            });
            $("#geoloc_me").click(function(e){
                navigator.geolocation.getCurrentPosition(function(data){
                    var userCoordinates = lolatoxy(data.coords);
                    userLatitude = userCoordinates.y;
                    userLongitude = userCoordinates.x;
                    flashCircles();
                });
            });
            $('#geoloc_me').hover(
                function() { $(this).addClass('ui-state-hover'); },
                function() { $(this).removeClass('ui-state-hover'); }
            );
            /*$('#legend').draggable();*/
            $("#legend").delegate(".country_name","click",function(e){
                previousCountry = currentCountry;
                currentCountry = $(this).attr("value");
                redraw();
            });
            $("#legend").delegate(".country_name","mouseenter",function(e){
                $(this).css("text-decoration","underline");
            });
            $("#legend").delegate(".country_name","mouseleave",function(e){
                $(this).css("text-decoration","none");
            });
            var progressBar = $("#progressbar");

            if (window.applicationCache){
                var fileCounter=0;

                window.applicationCache.onprogress = function(event){
                    fileCounter++;
                    progressBar.progressbar({
                            value: fileCounter/4.84
                    });
                    $("#progressbarMessage").html((fileCounter/4.84).toFixed(0) + " % downloaded");
                }
                window.applicationCache.oncached = function(event){
                    $("#progressbarMessage").html("Offline cache ready. You can now access the site without internet connection.")
                };
                window.applicationCache.onnoupdate = function(event){
                    progressBar.progressbar({
                                value: 100
                        });
                    $("#progressbarMessage").html("Cache up-to-date. You can access the site without internet connection.")

                }
                window.applicationCache.onupdateready = function(event){
                    progressBar.progressbar({
                                value: 100
                        });
                    window.applicationCache.swapCache();
                    //$("#progressbarMessage").html("Cache up-to-date. A new version of the site is now available offline.")
                }
                window.applicationCache.onerror = function(event){
                    progressBar.progressbar({
                                value: 100
                        });
                    $("#social").hide();
                    $("#progressbarMessage").html("You're currently using the site offline.")
                }
            }

        });
        var the_regexp = /^([^\/\?]+)\/?(\w*)$/i;

        hasher.initialized.add(parseHash);
        hasher.changed.add(parseHash, true);
        hasher.init(); //start listening for history change
    </script>
</div>
<div class="container">
    <div id="legend">
        <div class="row">
            <div class="span2">
                .
            </div>
            <div class="span8">
                <h2 id="country_name">
                </h2>
                <h3 id="popsize">
                </h3>
            </div>
            <div class="span2">
                .
            </div>
        </div>
        <div class="row">
            <div class="span2">
                .
            </div>
            <div class="span8">
                <table class="table table-condensed table-striped">
                    <thead>
                        <th class="span1"></th>
                        <th class="span3">Name</th>
                        <th class="span3" style="text-align: right;" >CO2 Total</th>
                    </thead>
                    <tbody id="countries">
                    </tbody>
                </table>
            </div>
            <div class="span2">
                .
            </div>
        </div>   
    </div>
</div>

    
<!--<div id="geoloc_me" class="ui-state-default ui-corner-all">
    <span title="Where am I?" class="ui-icon ui-icon-home"></span>
</div>-->
</div>

{/literal}

{/block}