<?php
/**
 * Template for the "Get Political" page, with the header content and
 * a listing of political organizations using the orgs.php partial.
 *
 * Template Name: Get Political
 */

get_header();
?>

<section id="content" class="site-content">
    <div id="primary" class="content-area">
        <h1> Get Political </h1>
        <div id="political-page-content">
            <?php
            while(have_posts()) {
                the_post();
                the_content();
            }
            ?>
        </div>

        <div class="listing" id="political-page-orgs">
            <?php
            $political_orgs = get_posts(array(
                'posts_per_page' => -1,
                'post_type'      => 'organization',
                'tax_query'      => array(array(
                    'taxonomy' => 'issue',
                    'field'    => 'name',
                    'terms'    => 'Political'
                ))
            ));

            foreach($political_orgs as $org) {
                set_query_var('org', $org);
                set_query_var('hide_skills', true);
                get_template_part('partials/org');
            }
            ?>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
