<?php
include 'DataGetter.php';
include 'Display.php';
include 'EventHandler.php';
include 'Map.php';

$data = new DataGetter();
$handler = new EventHandler();

//Data
$data->getThemes();
$data->getShelvesBlocks();

$themes = $data->returnThemes();
$shelves_blocks_to_mark = $data->returnShelvesBlocks();

//TESTING
$second_floor_blocks = $data->returnBlocks();

//1ST block
$coordinates = $second_floor_blocks[0]->returnCoordinates();
$block_themes = $second_floor_blocks[0]->returnThemes();

foreach($coordinates as $coordinate) echo $coordinate.' ';
foreach($block_themes as $theme) echo $theme.' ';

echo'<br>';

//2ND block
$coordinates = $second_floor_blocks[1]->returnCoordinates();
$block_themes = $second_floor_blocks[1]->returnThemes();

foreach($coordinates as $coordinate) echo $coordinate.' ';
foreach($block_themes as $theme) echo $theme.' ';



//Floors
$first_floor = Map::withName("images/VGTUB_1a.png", "1 Aukštas");
$second_floor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");

$floors = array($first_floor,$second_floor);
//Auditoriums
$auditorium201 = Map::withName("images/VGTU_2a_101.png","201 Auditorija");

$auditoriums = array($auditorium201);

//Sub tabs count
$subContentCount = 0;
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
        $second_floor->fillFloorMapByTheme($second_floor_blocks,$search_for);
        $second_floor->saveMap('images/VGTUB_2a'.'_'.$search_for.'.png');

        foreach($second_floor_blocks as $block)
        {
            $shelves = $block->returnShelves();
            $auditorium201->fillFloorMapByTheme($shelves,$search_for);
        }
        $auditorium201->saveMap('images/VGTU_2a_101'.'_'.$search_for.'.png');


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
        <?php
        $mapsToPrint = array();
        $mapNames = array();
        $count = 0;
        foreach($floors as $floor)
        {
            if($floor->returnStatus())
            {
                $mapsToPrint[$count] = $floor;
                $mapNames[$count] = $floor->returnName();
                $count++;
            }
        }
        $handler->displayTabs($mapNames,$subContentCount);
        $handler->fillContentWithMaps($mapsToPrint,$handler);
        ?>
    </div>
    <!-- button 2 -->
    <div class="tabContent">
        <?php
        $count = 0;
        $auditoriumsToPrint = array();
        $auditoriumNames = array();
        foreach ($auditoriums as $auditorium)
        {
            if($auditorium->returnStatus())
            {
                $auditoriumsToPrint[$count] = $auditorium;
                $auditoriumNames[$count] = $auditorium->returnName();
                $count++;
            }
            $handler->displayTabs($auditoriumNames,$subContentCount);
            $handler->fillContentWithMaps($auditoriumsToPrint,$handler);
        }
        ?>
    </div>
    <!-- button 3 -->
    <div class="tabContent">
        <?php
        $count = 0;
        $shelvesToPrint = array();
        $shelvesNames = array("1 Lentyna","2 Lentyna");
        foreach ($auditoriums as $auditorium)
        {
            $handler->displayTabs($shelvesNames,$subContentCount);
            $handler->fillContentWithMaps($shelvesToPrint,$handler);
        }
        ?>
    </div>
</div>
</body>
</html>