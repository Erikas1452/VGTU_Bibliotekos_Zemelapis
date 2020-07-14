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
            <!-- Selection menu -->
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
            <!-- Tabs for library auditorium and shelf -->
            <ul class="tabs">
                <li data-tab-target="#library" class="active tab">Biblioteka</li>
                <li data-tab-target="#auditorium" class="tab">Auditorija</li>
                <li data-tab-target="#shelf" class="tab">Lentyna</li>
            </ul>
            <div class="tab-content">
                <!-- Library Tab -->
                <div id="library" data-tab-content class = 'active'>
                    <?php
                    $maps = array ("Map1","Map2","Map3");
                    $handler->displayTabs($maps);
                    //Filling all maps with markers
                    $first_floor->fillMapByTheme($shelves_to_mark,$search_for);
                    $second_floor->fillMapByTheme($shelves_to_mark,$search_for);

                    //Displaying map
                    $second_floor->saveMap('images/VGTUB_2a'.'_'.$search_for.'.png');
                    $handler->onButtonDisplayImage("Search",$second_floor->returnPath()); // <-- Needs a way to find out which map print-out
                    $handler->displayTable($themes);
                    ?>
                </div>
                <!-- Auditorium Tab -->
                <div id="auditorium" data-tab-content>
                    <h3>Auditorijos žemėlapis</h3>
                </div>
                <!-- Shelf Tab -->
                <div id="shelf" data-tab-content>
                    <h3>Lentyna</h3>
                </div>
            </div>
        </div>
    </body>
</html>