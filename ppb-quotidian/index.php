<?php get_header(); ?>
<section class="content index">
    <?php
    if (have_posts()) {
        // echo '<h1> History </h1>';
        while(have_posts()) {
            the_post();
            $type = get_post_type() != 'post' ? get_post_type() : get_post_format();
            get_template_part('content', $type);
        }
    }
    else {
        echo '<p>No content matched your criteria</p>';
    }
    the_posts_navigation();
    ?>
</section>
<?php get_footer(); ?>
