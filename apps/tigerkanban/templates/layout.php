<!DOCTYPE html>
<html>
<head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico"/>
    <script>var baseurl = "<?php echo url_for('@homepage'); ?>";</script>
    <?php include_stylesheets() ?>
    <?php include_javascripts() ?>
</head>
<body>
<div id="header">

    <?php include_component("index","header"); ?>

</div>


<div id="content">
    <?php echo $sf_content ?>
    <div class="clearer"></div>
</div>

<div id="footer">TigerKanBan v0.1<br><br>For more information see: <a href="https://github.com/farion/TigerKanBan" target="_blank">https://github.com/farion/TigerKanBan</a>
</div>
<div id="loader" class="ui-widget-overlay">
    <div class="indicator"></div>
</div>
</body>
</html>
