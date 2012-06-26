<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">   
  <title>{block name=title}Kyoto Web App{/block}</title>
  </html>
        <link rel=StyleSheet href="includes/css/bootstrap.css" type="text/css">
        <link rel=StyleSheet href="includes/css/kyoto.css" type="text/css"> 
    <script src="includes/js/jquery-1.7.2.min.js"></script>
    <script src="includes/js/bootstrap.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
        $('.alert-success').delay(500).slideDown('slow');
        $('.alert-error').delay(500).slideDown('slow');
        $('.alert-success').delay(2000).slideUp('slow');
    });
</script>
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
                    Admin
                    <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="initialise.php">Import Simulations</a></li>
                        <li><a href="export.php">Export Simulations</a></li>
                        <li><a href="index.php">Change Database</a></li>
                        <!--<li><a href="#">Export Editor</a></li>-->
                    </ul>
                </li>
                {if isset($simList)}
                <li class="dropdown" id="menu2">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#menu2">
                    Simulations
                    <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                            <li><a href="simulations.php?">List all</a></li>
                            <li class="divider"></li>
                        {foreach $simList as $item}
                            <li><a href="simOverview.php?simid={$item@key}">{$item}</a></li>
                        {/foreach}
                    </ul>
                </li>
                {else}
                <li><a href="simulations.php">Simulations</a>
                {/if}
                </li>
                </ul>
                <a class="brand" href="index.php?" style="float: right;font-weight: bold; color: rgb(ad,ad,ad); text-shadow: 0px 1px 0px rgba(255, 255, 255, 0.1), 0px 0px 30px rgba(255, 255, 255, 0.125);">
                db:{$smarty.session.database}
                {if (substr_count($smarty.server.SERVER_NAME,'buildr')>0) }
                    [ise.buildr]
                {/if}
                </a>
        </div>
    </div>
</div>
    {if isset($smarty.get.simid)}
       {include file='views/simList.tpl'}
    {else}
    <div class="container" style="margin-top: 55px">
        {/if}
        
        {if isset($error)}
            <div class="alert alert-error">
                {$error}
            </div>
        {/if}
        {block name=body}     
        {/block}
    </div>
</body>