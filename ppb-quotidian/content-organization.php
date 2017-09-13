<?php
/**
 * Template for displaying abbreviated information on an organization as part of
 * a list. While `single-organization.php` displays all the content, this
 * displays only the first paragraph. In lieu of the longform information there,
 * it displays skill badges, which contain abbreviated information about what
 * positions are available and how demanding they are.
 *
 * These use a specific naming structure for Skill tags: each term should be of
 * the form "SkillName[ :: TimeCommitment]". The optional second value is
 * lowercased and added to the clock container div. The theme supports `high`,
 * `medium` and `low`, but will add whatever is in the TimeCommitment position.
 */ ?>

<div class="org">
<div class="org-thumb"><?= the_post_thumbnail(); ?></div>
<div class="org-info">
    <h3 class="org-name"><?= the_title(); ?></h3>
    <p>
        <?=  // First paragraph is determined by a newline
        explode("\n", get_the_content())[0]; ?>

        <?php
        $url = get_post_meta(get_the_ID(), 'learn_more_url', true);
        if ($url): ?>
        <a href="<?= esc_url($url); ?>">
            Learn more.
        </a>
        <?php endif; ?>
    </p>

    <?php
    // The get political page is structured as a list of *resources for
    // everyone* - it doesn't make sense to include skill badges here.
    if (!is_page_template('page-get-political.php')): ?>
    <div class="skill-row">
        <?php foreach (get_the_terms(get_the_ID(), 'skill') as $skill_term): ?>
            <?php
            //parts[0] = name, parts[1] = class (optional)
            $parts = explode(' :: ', $skill_term->name) ?>

            <span class="skill">
                <?php if (count($parts) > 1): ?>
                <span class="skill-clock <?= strtolower($parts[1]) ?>">
                    <i class="icon-clock-o" aria-hidden="true"></i>
                </span>
                <?php endif; ?>

                <span class="skill-badge">
                    <?= $parts[0]; ?>
                </span>
            </span>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
</div>
