    <div class="container" style="margin-top: 48px">
            <div class="row">
                <div class="span12">
                    <div class="subnav">
                        <ul class="nav nav-tabs">
                        {if (substr_count($smarty.server.PHP_SELF, 'simOverview.php')==1)}
                            <li class="active"><a href="#">Overview</a></li>
                        {else}
                            <li><a href="simOverview.php?simid={$smarty.get.simid}">Pre-Sim Overview</a></li>
                        {/if}
                        {if (substr_count($smarty.server.PHP_SELF, 'simEdit.php')==1) or 
                            (substr_count($smarty.server.PHP_SELF, 'country.php')==1)  
                        }
                            <li class="active"><a href="#">Edit</a></li>
                        {else}
                            <li><a href="simEdit.php?simid={$smarty.get.simid}">Edit</a></li>
                        {/if}
                        {if (substr_count($smarty.server.PHP_SELF, 'simRun.php')==1)}
                            <li class="active"><a href="#">Run</a></li>
                        {else}
                            <li class="disabled"><a href="simRun.php?simid={$smarty.get.simid}">Process</a></li>
                        {/if}
                        {if (substr_count($smarty.server.PHP_SELF, 'resultOverview.php')==1)}
                            <li class="active"><a href="#">Results</a></li>
                        {else}
                            <li class="disabled"><a href="resultOverview.php?simid={$smarty.get.simid}">Infographic Results</a></li>
                        {/if}
                        {if (substr_count($smarty.server.PHP_SELF, 'maps.php')==1)}
                            <li class="active"><a href="#">Trade Maps</a></li>
                        {else}
                            <li class="disabled"><a href="maps.php?simid={$smarty.get.simid}">Trade Map Results</a></li>
                        {/if}
                          <li class="nav-header pull-right ">
                           SIM#{$smarty.get.simid} : 
                                           {if isset($simName)}{$simName}{/if}
                          </li>  
                        </ul>
                    </div>
                </div>
            </div>
