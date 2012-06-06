<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */



include('head.php');


include('admin/dbconfig.php');


try {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <title>Google Visualization API Sample</title>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  <script type="text/javascript">
    google.load('visualization', '1', {packages: ['geomap']});

    function drawVisualization() {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'Popularity'],
        ['Germany', 200],
        ['United States', 300],
        ['Brazil', 400],
        ['Canada', 500],
        ['France', 600],
        ['RU', 700]
      ]);
    
      var geomap = new google.visualization.GeoMap(
          document.getElementById('visualization'));
      geomap.draw(data, null);
    }
    

    google.setOnLoadCallback(drawVisualization);
  </script>
</head>
<body>
    <div id="visualization" style="width: 800px; height: 400px;"></div>
</body>
</html>
<?php
    $m = new Mongo();
    $db = $m->selectDB(DB);
    
    $CountryDefaults = $db->selectCollection("CountryDefaults");

    $cursor = $CountryDefaults->find();

        // iterate through the results

?>
        <ul class="nav nav-pills">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" data-target="#" href="path/to/page.html">
            Dropdown
            <b class="caret"></b>
            </a>
            <ul class="dropdown-menu">
<?php
                foreach ($cursor as $obj) {
                    echo "<li><a href='country.php?country=".$obj["ISO"]."' >" . $obj["ISO"]. " ". $obj["name"]."</a></li>";
                }
?>
            </ul>
        </li>
        </ul>
<?php
    // browse all countries
        echo "<ul>";
            foreach ($list as $collection) {
                echo "<li> $collection... </li>";
            }
        echo "</ul>";
    // Load specific country
        
        if (isset($_GET['country'])) {
            $country = $_GET['country'];
        } else {
            $cursor = $CountryDefaults->findOne();
            $country = $cursor['name'];
        }

?>
    
 <?php 
 
    
} catch (MongoConnectionException $e)
{
    echo $e;
}



?>
