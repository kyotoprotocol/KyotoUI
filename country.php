<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */






include('admin/dbconfig.php');


try {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <title></title>
  <script type="text/javascript" src="http://www.google.com/jsapi"></script>
  

<?php
    $m = new Mongo();
    $db = $m->selectDB(DB);
    
    $CountryDefaults = $db->selectCollection("CountryDefaults");



        // iterate through the results


    // browse all countries

    // Load specific country
        
        if (isset($_GET['country'])) {
            $cursor = $CountryDefaults->findOne(array("ISO" => $_GET['country'])); //"ISO2": "UK" }
            $country = $cursor['name'];

        } else {
            $cursor = $CountryDefaults->findOne();
            $country = $cursor['name'];
        }
    $cursor = $CountryDefaults->find();
?>
   <script type="text/javascript">
    google.load('visualization', '1', {packages: ['geomap']});

    function drawVisualization() {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'Selected'],
        ['<?php echo $country; ?>', 1]
      ]);
    
      var geomap = new google.visualization.GeoMap(
          document.getElementById('visualization'));
      geomap.draw(data, null);
    }
    

    google.setOnLoadCallback(drawVisualization);
  </script>
</head>
<body>
<?php include('head.php');    ?>
    <div id="visualization" style="width: 800px; height: 400px; margin-left: 50px;"></div>
    <h1><?php echo $country; ?></h1>

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
 
    
</body>
</html>
 <?php 
 
    
} catch (MongoConnectionException $e)
{
    echo $e;
}



?>
