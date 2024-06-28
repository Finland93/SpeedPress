<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
    <?php wp_head(); ?>
	<meta name="msapplication-TileColor" content="#000">
	<meta name="theme-color" content="#000">
	<style>@media print {html, body {display: none; }}p, h1, h2, h3, h4, h5, h6, img, iframe, br, li, ul, a, div {-webkit-touch-callout: none;-webkit-user-select: none;-khtml-user-select: none;-moz-user-select: none;-ms-user-select: none;user-select: none;}img, picture, a {-webkit-user-drag: none;-khtml-user-drag: none;-moz-user-drag: none;-o-user-drag: none;user-drag: none;}</style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
            <div class="container">
                <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">
                    <?php bloginfo('name'); ?>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'depth' => 2,
                        'container' => false,
                        'menu_class' => 'navbar-nav ms-auto',
                        'fallback_cb' => 'WP_Bootstrap_Navwalker::fallback',
                        'walker' => new WP_Bootstrap_Navwalker(),
                    ));
                    ?>
                </div>
            </div>
        </nav>
    </header>

