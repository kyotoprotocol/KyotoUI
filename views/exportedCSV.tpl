{extends file="views/layout.tpl"}
{block name=title}Export Download{/block}

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

        
        <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Author</th>
            <th>DOWNLOAD</th>
          </tr>
        </thead>
        <tbody>
            {foreach from=$CSVfiles key=k item=file}
          <tr>
            <td>{$file['id']} </td>
            <td>{$file['name']}</td>
            <td>{$file['description']}</td>
            <td>{$file['author']}</td>
            <td>
                <a href="local/{$k}params.csv">PARAMCSV</a>
                <br>
                <a href="local/{$k}sim.csv">SIMCSV</a>
            </td>
          </tr>
            {/foreach}
        </tbody>
      </table>
        <hr>
    </div>
</div>


 
    
{/block}