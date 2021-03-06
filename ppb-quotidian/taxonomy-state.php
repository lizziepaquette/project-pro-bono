<?php
/**
 * Template Name: State Taxonomy
 *
 * Template for displaying a state listing of organizations, grouped by what
 * they do (their focus) with their description and the skills they want of
 * volunteers (their skills).
 */

$state = get_queried_object()->name;
get_header(); ?>

<section class="content">
    <h1><?= $state; ?></h1>

    <?php
    $grouped_orgs = array();
    foreach(get_terms('issue') as $issue) {
        $posts = get_posts(array(
            'posts_per_page' => -1,
            'post_type'      => 'organization',
            'tax_query'      => array(
                'relation'   => 'AND',
                array(
                    'taxonomy' => 'issue',
                    'field'    => 'name',
                    'terms'    => $issue->name
                ),
                array(
                    'taxonomy' => 'state',
                    'field'    => 'name',
                    'terms'    => $state
                )
            )
        ));

        if (!empty($posts)) {
            $grouped_orgs[$issue->name] = $posts;
        }
    }
    ?>

    <?php if (empty($grouped_orgs)): ?>

    <div id="contact" class="inset">
        <p> Unfortunately, we don't have any organizations in <?= $state; ?>
            yet. If you're part of an an organization working in <?= $state; ?>,
            get in touch with us at
            <a href="mailto:project.pro.bono.contact@gmail.com">
            project.pro.bono.contact@gmail.com</a>
    </div>

    <?php else: ?>

    <div id="instructions" class="inset">
        <p> Find an organization below that fits your interests, expertise and
            schedule!
        <p> Look at the clocks next to the listings below to figure out if the
            time commitment is right for you. Each color represents a different
            workload:
        <div class="skill-row">
            <?php foreach (array('low', 'medium', 'high') as $time): ?>
                <span class="skill">
                    <span class="<?= "skill-clock {$time}" ?>">
                        <i class="icon-clock-o" aria-hidden="true"></i>
                    </span>
                    <span class="skill-label">
                        <?= $time ?> commitment
                    </span>
                </span>
            <?php endforeach ?>
        </div>
    </div>

    <?php foreach($grouped_orgs as $issue_name => $posts) {
        echo "<h2>{$issue_name}</h2>";
        foreach($posts as $post) {
            setup_postdata($post);
            get_template_part('content', 'organization');
            wp_reset_postdata();
        }
    }
    ?>

    <?php endif; ?>
</section>

<?php wp_footer(); ?>
