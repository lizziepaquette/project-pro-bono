<?php $org = get_query_var('org'); ?>

<div class="org">
    <div class="org-thumb">
        <?php echo get_the_post_thumbnail($org); ?>
    </div>
    <div class="org-content">
        <h3 class="org-name">
            <?php echo apply_filters('the_title', $org->post_title); ?>
        </h3>
        <div class="org-description">
            <?php
            // Automatic <p> tags move the "Learn more." link to the next line,
            // which looks weird. Instead, wrap the *whole thing* (including the
            // link) in a <p> tag at the end.
            remove_filter('the_content', 'wpautop');
            $content = apply_filters('the_content', $org->post_content);
            $url = get_post_meta($org->ID, 'learn_more_url', true);
            if ($url) {
                $content .= ' <a href=' . $url . '> Learn more. </a>';
            }

            echo '<p>' . $content . '</p>';
            // Restore the filter after use
            add_filter('the_content', 'wpautop');
            ?>
        </div>

        <div class="org-skill-row">
            <?php
            $skill_terms = wp_get_post_terms($org->ID, 'skill',
                array('orderby' => 'name'));
            
            foreach($skill_terms as $skill_term) {
                set_query_var('skill_term', $skill_term);
                get_template_part('partials/skill');
            }
            ?>
        </div>
    </div>
</div>