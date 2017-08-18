<?php
// $skill_term names are of the form "{SkillName}[ :: {Short,Medium,Long}]"
// but any value can be in the second position and gets converted to a CSS
// class
$skill_term = get_query_var('skill_term'); 

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
?>