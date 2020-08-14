<?php

if (isset($_POST["contents"]))
{
    $contents = $_POST["contents"];
}
if (isset($_POST["udk"])) $udk = $_POST["udk"];

echo '<table>';
    echo'<tr>';
        echo'<th class="udk">UDK</th>';
        echo'<th class="theme">Tema</th>';
    echo'</tr>';
    foreach ($contents as $themes)
    {
        foreach ($themes as $theme) {
            if(isset($udk) && $udk == $theme["udk"]) echo '<tr class="marked">';
            else echo '<tr>';
            echo '<td class="udk">' .$theme["udk"] . '</td>';
            echo '<td class="theme">'.$theme["name"].'</td>';
            echo '</tr>';
        }
    }
echo '</table>';