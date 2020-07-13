<?php
include 'DataGetter.php';
include 'Display.php';
include 'EventHandler.php';
include 'Map.php';

$data = new DataGetter();
$handler = new EventHandler();

$data->getThemes();
$data->getShelves();

$themes = $data->returnThemes();
$shelves_to_mark = $data->returnShelves();

$first_floor = new Map("images/VGTUB_1a.png");
$second_floor = new Map("images/VGTUB_2a.png");

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <!-- (ADD LATER)References to styles -->
        <link href ="style.css" rel="stylesheet">
        <script src="script.js" defer></script>
    </head>

    <body>

        <div>
            <h2>ATVIROJO FONDO ŽEMĖLAPIS</h2>
        </div>

        <div>
            <form method="POST">
            <label for="DropDown1">Tema:</label> <br>
                <input list="DropDown1" name="DropDown1" />
                <datalist id="DropDown1">
                    <?php
                    foreach ($themes as $item)
                    {
                        echo '<option value="'.$item[0].'">'.$item[0].'</option>';
                    }
                    ?>
                </datalist>
                <?php
                $handler->displayButton("Ieškoti","Search");
                $data->getValueFromSelection("Search","DropDown1");
                $search_for = $data->returnSelectedValue();
                echo '    Test :  Selected: '.$search_for; //Testing if the selected value is extracted correctly
                ?>
            </form>
            <br>
            <ul class="tabs">
                <li data-tab-target="#biblioteka" class="active tab">Biblioteka</li>
                <li data-tab-target="#auditorija" class="tab">Auditorija</li>
                <li data-tab-target="#lentyna" class="tab">Lentyna</li>
            </ul>

            <dvi class="tab-content">
                <div id="biblioteka" data-tab-content class = 'active'>
                    <?php

                    //Filling all maps with markers
                    $first_floor->fillMapByTheme($shelves_to_mark,$search_for);
                    $second_floor->fillMapByTheme($shelves_to_mark,$search_for);

                    //Displaying map
                    $second_floor->saveMap('images/VGTUB_2a'.'_'.$search_for.'.png');
                    $handler->onButtonDisplayImage("Search",$second_floor->returnPath()); // <-- Needs a way to find out which map print-out
                    $handler->displayTable($themes);
                    ?>
                </div>
                <div id="auditorija" data-tab-content>
                    <h3>Auditorijos zemelapis</h3>
                </div>
                <div id="lentyna" data-tab-content>
                    <h3>Lentyna</h3>
                </div>
            </dvi>
        </div>
    </body>
</html>