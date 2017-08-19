<?php
/**
 * Template Name: State Org List
 *
 * Template for displaying a state listing of organizations, grouped by what
 * they do (their focus) with their description and the skills they want of
 * volunteers (their skills).
 */

get_header();

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

<div id="primary" class="content-area">
    <h1><?php echo get_queried_object()->name; ?></h1>
    <div id="org-list-instructions">
        <p>Find an organization below that fits your interests, expertise and
           schedule! </p>

        <p> Look at the clocks next to the listings below to figure out
           if the time commitment is right for you. Each color represents
           a different workload: </p>

        <div class="org-skill-row">
        <?php
        $times = array('low', 'medium', 'high');
        foreach($times as $time): ?>
            <span class="org-skill-wrapper">
                <span class=<?= "'org-skill-clock clock-{$time}'" ?>>
                    <?php
                    $path = get_theme_file_uri('/lib/clock-o.svg');
                    echo file_get_contents($path);
                    ?>
                </span>
                <p><?= $time ?> commitment</p>
            </span>
        <?php endforeach ?>
        </div>
    </div>

    <?php
    foreach($groups as $issue=>$orgs) {
        if ($issue == 'Political') continue;
        echo "<h2>{$issue}</h2>";
        foreach($orgs as $org) {
            set_query_var('org', $org);
            get_template_part('partials/org');
        }
    }
    ?>
</div>

<?php wp_footer(); ?>
