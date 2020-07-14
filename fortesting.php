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
    <div class="tab">
        <button class="tablinks" onclick="openTab(event, 'Biblioteka')">Biblioteka</button>
        <button class="tablinks" onclick="openTab(event, 'Auditorija')">Auditorija</button>
        <button class="tablinks" onclick="openTab(event, 'Lentyna')">Lentyna</button>
    </div>
    <div class="tab-content">
        <div id="Biblioteka" class="tabcontent">
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
        <div id="Auditorija" class="tabcontent">
            <h3>Auditorijos zemelapis</h3>
        </div>
        <div id="Lentyna" class="tabcontent">
            <h3>Lentyna</h3>
        </div>
    </div>
</div>
</body>
</html>