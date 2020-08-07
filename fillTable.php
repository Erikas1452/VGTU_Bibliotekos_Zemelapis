<?php

if (isset($_POST["contents"]))
{
    $contents = $_POST["contents"];
}


echo '<table>';
    echo'<tr>';
        echo'<th>Vieta lentynoje</th>';
        echo'<th>Tema</th>';
    echo'</tr>';
    foreach ($contents as $themes)
    {
        foreach ($themes as $theme) {
            echo '<tr>';
            echo '<td>' .$theme["udk"] . '</td>';
            echo '<td>'.$theme["name"].'</td>';
            echo '</tr>';
        }
    }
echo '</table>';