<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Basic Metadata -->
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Markpress App - Real-Time Markdown to HTML Converter</title>
        <meta name="description" content="Markpress App seamlessly converts Markdown files into beautiful, fully-structured HTML pages in real-time. Perfect for documentation, blogs, or static content.">
        <meta name="keywords" content="Markpress, Markdown to HTML, real-time Markdown converter, Markdown renderer, documentation tool, blog renderer, static site generator">
        <meta name="author" content="Tom Papatolis">
        <meta name="robots" content="index, follow">

        <!-- Canonical URL -->
        <link rel="canonical" href="https://markpress.org">

        <!-- Performance Optimization -->
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="referrer" content="no-referrer-when-downgrade">
        <meta name="cache-control" content="no-cache">
        <meta name="expires" content="0">

        <!-- Content Security Policy -->
        <meta http-equiv="Content-Security-Policy" content="default-src 'self'; img-src 'self' https://*; script-src 'self'; style-src 'self' 'unsafe-inline';">

        <!-- Open Graph Metadata -->
        <meta property="og:title" content="Markpress App - Real-Time Markdown to HTML Converter">
        <meta property="og:description" content="Convert Markdown files into fully-structured HTML pages instantly. Create beautiful content from Markdown effortlessly with Markpress App.">
        <meta property="og:image" content="<?=path_gfx()?>icon.jpg">
        <meta property="og:url" content="https://markpress.org">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="Markpress App">

        <!-- Twitter Card Metadata -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Markpress App - Real-Time Markdown to HTML Converter">
        <meta name="twitter:description" content="Create stunning HTML pages from Markdown in real time. Perfect for blogs, documentation, and more.">
        <meta name="twitter:image" content="<?=path_gfx()?>icon.jpg">
        <meta name="twitter:site" content="@verdin_dynamics">
        <meta name="twitter:creator" content="@verdin_dynamics">

        <!-- Favicon and Icons -->
        <link rel="icon" href="<?=path_gfx().'favicon'?>/favicon.ico" type="image/x-icon">
        <link rel="apple-touch-icon" sizes="57x57" href="<?=path_gfx().'favicon'?>/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="<?=path_gfx().'favicon'?>/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="<?=path_gfx().'favicon'?>/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="<?=path_gfx().'favicon'?>/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="<?=path_gfx().'favicon'?>/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="<?=path_gfx().'favicon'?>/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="<?=path_gfx().'favicon'?>/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="<?=path_gfx().'favicon'?>/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="<?=path_gfx().'favicon'?>/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192" href="<?=path_gfx().'favicon'?>/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="<?=path_gfx().'favicon'?>/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="<?=path_gfx().'favicon'?>/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="<?=path_gfx().'favicon'?>/favicon-16x16.png">

        <!-- Fonts & CSS -->
        <link rel="stylesheet" href="<?=path_assets()?>fonts/roboto/stylesheet.css">
        <link rel="stylesheet" href="<?=path_css()?>vernito.css?v=<?=setting('version')?>">
        <link rel="stylesheet" href="<?=path_css()?>app.css?v=<?=setting('version')?>">

    </head>

    <body class="<?=body_class()?>" id="<?=body_class()?>">
        <?= $this->renderSection('main') ?>
    </body>
</html>