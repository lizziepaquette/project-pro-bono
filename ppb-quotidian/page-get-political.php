<?php
/**
 * Template for the "Get Political" page, which is just like a normal page, but
 * includes a listing of 'Political' organizations using the
 * content-organization.php partial, like a state.
 *
 * Template Name: Get Political
 */

get_header();
?>

<section class="content">
    <div id="political-page-content">
        <?php
        while(have_posts()) {
            the_post();
            the_title("<h1>", "</h1>");
            the_content();
        }
        ?>
    </div>
    <div id="political-org-listing">
        <?php
        $political_posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type'        => 'organization',
            'tax_query'        => array(array(
                'taxonomy' => 'issue',
                'field'    => 'name',
                'terms'    => 'Political'
            ))
        ));

        foreach ($political_posts as $post) {
            setup_postdata($post);
            get_template_part('content', 'organization');
            wp_reset_postdata();
        }
        ?>
    </div>
</section>

<?php wp_footer(); ?>
