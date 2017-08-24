<?php
/*
 * Produces the theme header, including the elements of the `navbar-menu` menu
 * that the theme regesters (see functions.php)
 */ ?>

<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta content="width=device-width, initial-scale=1" name="viewport">
<meta name="description" content="<?= get_bloginfo('description'); ?>">
<?php wp_head();?>
</head>

<body>
<header id="masthead">
    <div id="masthead-core">
        <a id="masthead-logo" href="<?= get_bloginfo('wpurl');?>">
            <img src="http://projectprobono.com/wp-content/uploads/2017/02/logo-2.png">
       </a>

        <div id="masthead-brand">
            <div id="title">
                <a href="<?= get_bloginfo('wpurl'); ?>">
                    <?= get_bloginfo('name'); ?>
                </a>
            </div>
            <div id="tagline">
                <?= get_bloginfo('description'); ?>
            </div>
        </div>

        <div id="masthead-nav-toggle" class="closed">
            <i class="icon-bars" aria-hidden="true"></i>
        </div>
    </div>
    <!--  -->

    <?php
    wp_nav_menu(array(
        'container'       => 'nav',
        'container_id'    => 'masthead-nav',
        'container_class' => 'closed',
        'fallback_cb'     => 'false',
    ));
    ?>
</header>
