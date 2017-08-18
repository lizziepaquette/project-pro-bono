<?php
/**
 * Template for displaying a state listing of organizations, grouiped by what
 * they do (their focus) with their description and the skills they want of
 * volunteers (their skills).
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

    <?php
    foreach($groups as $term=>$orgs) {
        foreach($orgs as $org) {
            set_query_var('org', $org);
            get_template_part('partials/org');
        }
    }
    ?>
</div>

<?php wp_footer(); ?>