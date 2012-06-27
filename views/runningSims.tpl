{extends file="views/layout.tpl"}
{block name=title}Export Download{/block}

{block name=body}


<blockquote>
Running Sims on max's server
</blockquote>
<div class="row">
    <div class="span12">
        <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Author</th>
            <th>Progress</th>
          </tr>
        </thead>
        <tbody>
            {foreach from=$simlist key=k item=file}
          <tr>
            <td>{$file['_id']} </td>
            <td>{$file['name']}</td>
            <td>{$file['description']}</td>
            <td>{$file['author']}</td>
            <td>{$file['currentTime']}/{$file['finishTime']}</td>
          </tr>
            {/foreach}
        </tbody>
      </table>
        <hr>
    </div>
</div>


 
    
{/block}