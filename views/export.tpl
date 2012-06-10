{extends file="views/layout.tpl"}
{block name=title}Initialise Data{/block}

{block name=body}

<div class="row">
    <div class="span12">
        <h1>Export CSV</h1>
        <br>
    </div>
</div>
<div class="row">
    <div class="span6">
        <form class="well">
            <label>Export CSV file</label>
            <input class="input-xlarge focused" id="filename" value="mynewdata.csv" type="text">
            <p class="help-block">This will be saved in admin/.<br>Note: if you name it data.csv or babydata.csv you'll be writing over the provided defaults. (Maybe that's what you want to do - but how do I know?)</p>
            <label class="checkbox">
            <input type="checkbox" disabled="disabled" > Check only if you're an absolute legend
            </label>
            <button type="submit" class="btn">Submit</button>
        </form>
    </div>
</div>

{/block}