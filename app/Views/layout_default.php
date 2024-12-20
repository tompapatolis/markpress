<!DOCTYPE html>
<html lang="<?=setting('site_language')?>">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Markpress</title>
<!--        <meta name="description" content="</?=setting('site_description')?>"/>
        <link rel="stylesheet" href="</?=path_assets()?>fonts/arimo/stylesheet-light.css">
        <link rel="stylesheet" href="</?=path_assets()?>fonts/firasans/stylesheet-light.css">
        <link rel="stylesheet" href="</?=path_css()?>vernetic.css?v=</?=setting('version')?>">
        <link rel="stylesheet" href="</?=path_css()?>app.css?v=</?=setting('version')?>">
        </?= $this->include('components/favicon') ?>
        <script src="</?=path_js()?>vernetic-dist.js?v=</?=setting('version')?>" defer></script>
        <script src="</?=path_js()?>app-dist.js?v=</?=setting('version')?>" defer></script>
        </?= $this->renderSection('head') ?>
-->
    </head>

    <body class="<?=body_class()?>" id="<?=body_class()?>">
        <?= $this->renderSection('main') ?>
    </body>
</html>