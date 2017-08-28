<?php
/**
 * Template Name: Single Organization
 *
 * Template for displaying a single organization. The organization post type,
 * and associated taxonomies (state, issue, skill) are registered by the PPB
 * Organization Listing plugin.
 *
 * Where available, metadata is displayed in an inset bar near the top,
 * underneath the title. Skill badges are not displayed, since the point of this
 * page is for the content to have more and more specific information about
 * positions than the badges can convey.
 */
get_header(); ?>
<section class="content organization singular">
    <?php if (have_posts()): while(have_posts()): the_post(); ?>
    <h1 class="org-name"><?= the_title(); ?></h3>
    <div class="org-longform">
        <div class="org-thumb">  <?= the_post_thumbnail(); ?> </div>
        <div class="org-long-info">
            <?php // TODO: Consider removing inset if no state or url ?>
            <div class="org-long-meta inset">
                <?php
                // Not all orgs will have a location - Political "orgs", for
                // example are mainly links to resources. They don't need to
                // have anything displayed here.
                $states = get_the_terms(get_the_ID(), 'state');

                if (!empty($state)): ?>
                <div id="location">
                    <strong> Located in: </strong>
                    <?php foreach ($states as $state): ?>
                        <a href="/state/<?= $state->slug ?>">
                            <?= $state->name ?>
                        </a>
                    <? endforeach; ?>
                </div>
                <? endif; ?>

                <?php
                // Similarly, not all orgs will have states. I HOPE they all
                // will (otherwise what's the point?) but the template should
                // render OK even if they don't.
                $url = get_post_meta(get_the_ID(), 'learn_more_url', true);

                if ($url):?>
                <div id="website">
                    <strong> Learn More: </strong>
                    <a target='_blank' href=<?= esc_url($url); ?>>
                        <?= parse_url($url)['host']; ?>
                    </a>
                </div>
                <? endif; ?>
            </div>

            <div class="org-long-body">
                <?php the_content(); ?>
            </div>
        </div>
    </div>
    <?php endwhile; else: ?>
    <p>No content matched your criteria</p>
    <?php endif ?>
</section>
<?php get_footer(); ?>
