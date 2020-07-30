<?php
$index = 0;
$contents = array("auditorija1", "auditorija2");
foreach ($contents as $content)
{
    echo '<div id="tabcontent-' . $index . '" class="tabContent">';
    echo $content;
    echo '</div>';
    $index++;
}
?>
