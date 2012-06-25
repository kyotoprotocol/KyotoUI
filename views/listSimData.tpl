{extends file="views/layout.tpl"}
{block name=title}Naughty Children page{/block}
{block name=head}
{literal}

{/literal}
{/block}
{block name=body}

<div class="row">
    <div class="span8">
        <h1>Naughty Children page</h1>
    </div>
</div> 
<div class="row">
    <div class="span12">
        <blockquote>
        To identify large sims and to delete redundant ones.
        <br>Ordered by fattest.
        </blockquote>
    </div>
</div>                
            <ul>
                {foreach $list as $li}
                    <li>{$li}</li>
                {/foreach}
            </ul>
<div class="row">
     <div class="span12">
        <table class="table table-bordered table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Author</th>
                    <th>agents</th>
                    <th>processedticks</th>
                    <th>FAT?</th>
                    <th>DEL</th>
                </tr>
            </thead>
             <tbody>
                 {foreach $damagearray as $naughtysim}
                 <tr>
                    <td>{($naughtysim['ID'])}</td>
                    <td>{($naughtysim['name'])}</td>
                    <td>{($naughtysim['description'])}</td>
                    <td>{($naughtysim['author'])}</td>
                    <td>{($naughtysim['agentCount'])}</td>
                    <td>{($naughtysim['currentTime'])}</td>
                    <td>{($naughtysim['FAT'])}</td>
                    <td>Delete</td>
                 </tr>
                 {/foreach}
             </tbody>
        </table>

     </div>
</div>

{/block}