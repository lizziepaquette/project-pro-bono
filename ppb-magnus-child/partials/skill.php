<?php
// $skill_term names are of the form "{SkillName}[ :: {Short,Medium,Long}]"
// but any value can be in the second position and gets converted to a CSS
// class
$skill_term = get_query_var('skill_term');
$components = explode(' :: ', $skill_term->name);
?>

<?php if (count($components) == 1): ?>
    <span class="org-skill-badge"> <?= $components[0]; ?> </span>
<?php else: ?>
    <span class="org-skill-wrapper">
        <?php $time = strtolower($components[1]); ?>
        <span class=<?= "'org-skill-clock clock-{$time}'" ?>>
            <?php
            $path = get_theme_file_uri('/lib/clock-o.svg');
            echo file_get_contents($path); ?>
        </span>
        <span class="org-skill-badge">
            <?= $components[0] ?>
        </span>
    </span>
<?php endif; ?>
