{extends file="views/layout.tpl"}
{block name=title}Welcome{/block}
{block name=head}
<script>
    $(function(){
    $('a[rel="tooltip"]').tooltip();
    });
</script>
{/block}
{block name=body}

    <div class="hero-unit">
    <h1>Welcome Howard!</h1>
    <p>This is the kyoto web interface. </p>
    <p>
    <a href="initialise.php" class="btn btn-primary btn-large">
    Enjoy
    </a>
    </p>
    </div>
    <a id="dave" rel="tooltip" href="test.php" title="Contribute and we'll add you in!" style="float:right;" ><i class="icon-thumbs-up"></i>Contributors</a>

{/block}