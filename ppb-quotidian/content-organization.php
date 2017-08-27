<div class="org">
<div class="org-thumb"><?= the_post_thumbnail(); ?></div>
<div class="org-info">
    <h3 class="org-name"><?= the_title(); ?></h3>
    <p>
        <?=  // The content can be multiple paragraphs, only the first matters
        explode("\n", get_the_content())[0]; ?>

        <a href="<?= get_the_permalink(); ?>">
            More info...
        </a>
    </p>

    <?php if (!is_page_template('page-get-political.php')): ?>
    <div class="skill-row">
        <?php foreach (get_the_terms(get_the_ID(), 'skill') as $skill_term): ?>
            <?php
            /*
             * $skill_term names are of the form "SkillName[ :: CSSClass]". The
             * optional second value is lowercased and added as a class to the
             * clock container div as 'cssclass'. The theme has support for
             * 'high', 'medium' and 'low' CSS classes.
             * parts[0] = name, parts[1] = class
             */
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
