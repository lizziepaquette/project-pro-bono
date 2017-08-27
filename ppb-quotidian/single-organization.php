<?php get_header(); ?>
<section class="content organization singular">
    <?php if (have_posts()): while(have_posts()): the_post(); ?>
        <h1 class="org-name"><?= the_title(); ?></h3>
        <div class="org-longform">
            <div class="org-thumb">  <?= the_post_thumbnail(); ?> </div>
            <div class="org-long-info">
                <div class="org-long-meta inset">
                    <div id="location">
                        <strong> Located in: </strong>
                        <?php
                        $states = get_the_terms(get_the_ID(), 'state');
                        foreach ($states as $state): ?>
                            <a href="/state/<?= $state->slug ?>">
                                <?= $state->name ?>
                            </a>
                        <? endforeach; ?>
                    </div>

                    <div id="website">
                        <?php
                        $url = get_post_meta(get_the_ID(), 'learn_more_url', true);
                        if ($url): ?>
                            <strong> Learn More: </strong>
                            <a target='_blank' href=<?= esc_url($url); ?>>
                                <?= parse_url($url)['host']; ?>
                            </a>
                        <? endif; ?>

                    </div>
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
