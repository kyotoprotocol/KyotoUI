<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">   
  <title>{block name=title}Kyoto Web App{/block}</title>
  </html><link rel=StyleSheet href="includes/css/bootstrap.css" type="text/css">
  
    <script src="http://code.jquery.com/jquery-1.7.2.js"></script>
    <script src="includes/js/bootstrap.js"></script>
    {block name=head}{/block}
</head>
<body>
<div class="navbar navbar-fixed-top">
    <div class="navbar-inner">
        <div class="container">
            <a class="brand" href="index.php">
            Kyoto Simulator
            </a>
            <ul class="nav nav-pills">
                <li class="dropdown" id="menu1">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu1">
                    Pre-Simulation
                    <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="initialise.php">Initialise</a></li>
                        <li><a href="country.php">Country</a></li>
                    </ul>
                </li>
                <li><a href="simulations.php">Simulations</a></li>
                </ul>
        </div>
    </div>
</div>
    <div class="container" style="margin-top: 55px">
        {block name=body}{/block}
    </div>
</body>