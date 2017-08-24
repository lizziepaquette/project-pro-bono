<?php get_header(); ?>
<section class="hero">
    <header>
        <h1>Don't Despair.<br/>Get to Work.</h1>
        <div class="subheading">Project Pro Bono connects skilled volunteers with organizations working for the public good.</div>
    </header>
</section>

<section class="content">
    <?php
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
    ?>
</section>
<?php get_footer(); ?>
