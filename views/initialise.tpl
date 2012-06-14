{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}


{if isset($alert)}
    <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert">×</button>
            {$alert}
           {if isset($notices)}
                <ul>
                    {foreach $notices as $item}
                        <li>{$item}</li>
                    {/foreach}
                </ul>
            Result: <span class="label label-important">{$status}</span> <br><br>
            {/if}

    </div>
{/if} 
<div class="row">
    <div class="span12">
        <h1>Getting Started</h1>
        <br>
    </div>
</div>
<div class="row">
    <div class="span12">
        <h2>Default simulation management</h2>
        <blockquote>
            Get started by clicking "install" for adding the CSV's to your mongo db.<br>
            Useful for initialisation, resetting the database and adding new simulations.
        </blockquote>
        <hr>
        
        <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Author</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
            {foreach $CSVfiles as $file}
          <tr>
            <td>{$file['id']} </td>
            <td>{$file['name']}</td>
            <td>{$file['description']}</td>
            <td>{$file['author']}</td>
            <td>
                <form name="input" action="initialise.php" method="post">
                {if isset($file['installed'])}
                <button name="filename" value="{$file['file']}" type="submit" class="btn btn-danger"><i class="icon-exclamation-sign"></i>reinstall</button>
                {else}
                <button name="filename" value="{$file['file']}"  type="submit" class="btn btn-success"><i class="icon-plus"></i>install</button>
                {/if}
            </td>
          </tr>
            {/foreach}
        </tbody>
      </table>
        <hr>
    </div>
</div>

<div class="row">
    <div class="span12">
        <h2>Tables in MongoDB </h2>
        <blockquote>
        For Host:{$host} using Database:{$db}
        </blockquote>
        <ul>
        {foreach $collections as $item}
            <li>{$item}</li>
        {/foreach}
        </ul>

    </div>
</div>
<div class="row">
    <div class="span6">
        <h2>Empty the tables</h2>
        
                       <div class="modal hide" id="delete">
                           <form class="well" name="input" action="initialise.php" method="post">

                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">×</button>
                                <h3>Are you sure you want to drop the database?</h3>
                            </div>
                            <div class="modal-body">
                                <img src="http://static.moviefanatic.com/images/gallery/puss-in-boots.jpg">
                                    <input type="hidden" name="drop" value="true">
                            </div>
                            <div class="modal-footer">
                                <a href="#" class="btn" data-dismiss="modal">Close</a>
                                <button type="submit" class="btn btn-danger">Drop</button>
                            </div>
                           </form>
                        </div>
        
        
            <form class="well" method="POST">
                <span class="help-block">Will erase all simulations, counter and environmentstate</span>
                <button data-toggle="modal" href="#delete"class="btn btn-danger">Drop</button>
            </form>
    </div>
</div>

 
    
{/block}