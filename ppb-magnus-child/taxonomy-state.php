<?php
/**
 * Template for displaying a state listing of organizations, grouiped by what
 * they do (their focus) with their description and the skills they want of
 * volunteers (their skills),
 *
 * There's special handling for skill items. A skill of the form 
 * "Web Design :: High" gets displayed as "Web Design" with a "time-high" CSS
 * class that can be reused later.
 */

get_header(); ?>

<?php 
$groups = array();
foreach (get_terms('issue') as $term)  {
    $groups[$term->name] = get_posts(array(
        'posts_per_page' => -1, 
        'post_type'      => 'organization', 
        'tax_query'      => array(
            'relation'      => 'AND',
            array(
                'taxonomy'  => 'issue',
			    'field'     => 'name',
			    'terms'     => $term->name
		    ),
            array(
                'taxonomy'  => 'state',
			    'field'     => 'name',
			    'terms'     => get_queried_object()->name              
            )
        ),
    ));
} 
?>

<div id="listing">
    <h1><?php echo get_queried_object()->name; ?></h1>
    <div id="selectors"></div>

    <?php foreach($groups as $term=>$posts): ?>
    <?php if (!$posts) continue; ?>
    <h2><?php echo $term ?></h2>
    <?php foreach($posts as $p): ?>
        <div class="org">
            <div class="org-thumb">
                <?php echo get_the_post_thumbnail($p); ?>
            </div>
            <div class="org-content">
                <h3 class="org-name">
                    <?php echo apply_filters('the_title', $p->post_title); ?>
                </h3>
                <div class="org-description"> 
                    <?php 
                    // Automatic <p> tags move the "Learn more." link to the 
                    // next line, which looks weird. Instead, wrap the *whole
                    // thing* (including the link) in a <p> tag at the end.
                    remove_filter('the_content', 'wpautop');
                    $content = apply_filters('the_content', $p->post_content);
                    $url = get_post_meta($p->ID, 'learn_more_url', true);
                    if ($url) {
                        $content .= ' <a href=' . $url . '> Learn more. </a>';
                    } 
                    echo '<p>' . $content . '</p>';
                    // Restore the filter for future users
                    add_filter('the_content', 'wpautop');
                    ?>
                </div>
                <div class="org-skill-row"> 
                    <?php 
                    $skill_terms = wp_get_post_terms($p->ID, 'skill', 
                        array('orderby' => 'name'));
                    array_map('skill_term_item', $skill_terms); 
                    ?>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
    <?php endforeach; ?>
</div>  

<?php 
// $skill_term names are of the form "{SkillName}[ :: {Short,Medium,Long}]"
// but any value can be in the second position and gets converted to a CSS
// class
function skill_term_item($skill_term) { 
    $components = explode(' :: ', $skill_term->name);
    if (count($components) == 1) { 
        echo '<span class="org-skill-term">' . $components[0] . '</span>'; 
    }
    else {
        $time = strtolower($components[1]);
        echo ('<span class="org-skill-term time-' . $time . '">');
        echo $components[0];
        echo '</span>'; 
    }
} 

// Unused so far, break down a skill component into its constituent parts

function skill_base($skill_term) {
    return explode(' :: ', $skill_term->name)[0];
}

function skill_time($skill_term) {
    $exploded = explode(' :: ', $skill_term->name);
    return (count($exploded) > 1 ? $exploded[1] : null);
}
?>