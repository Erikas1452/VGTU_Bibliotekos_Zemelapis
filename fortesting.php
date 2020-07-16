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
$shelves_to_mark = $data->returnShelvesBlocks();

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

    <div class="tabButtons">
        <button onclick="showContent(0)">Biblioteka</button>
        <button onclick="showContent(1)">Auditorija</button>
        <button onclick="showContent(2)">Lentyna</button>
    </div>
    <!-- button 1 -->
    <div class="tabContent">
        <div class="subTabButtons">
            <button onclick="showSubContent(0)">MAP1</button>
            <button onclick="showSubContent(1)">MAP2</button>
        </div>
        <!-- sub-button 1 -->
        <div class="subTabContent">
            <?php
            //Filling all maps with markers
            $second_floor->fillMapByTheme($shelves_to_mark,$search_for);

            //Displaying map
            $second_floor->saveMap('images/VGTUB_2a'.'_'.$search_for.'.png');
            $handler->onButtonDisplayImage("Search",$second_floor->returnPath()); // <-- Needs a way to find out which map print-out
            $handler->displayTable($themes);
            ?>
        </div>
        <!-- sub-button 2 -->
        <div class="subTabContent">
            <?php
            $first_floor->fillMapByTheme($shelves_to_mark,$search_for);

            $first_floor->saveMap('images/VGTUB_1a'.'_'.$search_for.'.png');
            $handler->onButtonDisplayImage("Search",$first_floor->returnPath()); // <-- Needs a way to find out which map print-out
            $handler->displayTable($themes);
            ?>
        </div>
    </div>
    <!-- button 2 -->
    <div class="tabContent">
        <div class="subTabButtons">
            <button onclick="showSubContent(2)">Auditorija1</button>
            <button onclick="showSubContent(3)">Auditorija2</button>
            <button onclick="showSubContent(4)">Auditorija3</button>
        </div>
        <div class="subTabContent">
            Auditorija1
        </div>
        <div class="subTabContent">
            Auditorija2
        </div>
        <div class="subTabContent">
            Auditorija3
        </div>
    </div>
    <!-- button 3 -->
    <div class="tabContent">
        <div class="subTabButtons">
        <button onclick="showSubContent(5)">Lentyna1</button>
        <button onclick="showSubContent(6)">Lentyna2</button>
        </div>
        <div class="subTabContent">
            Lentyna1
        </div>
        <div class="subTabContent">
            Lentyna2
        </div>
    </div>
</div>
</body>
</html>