<?php
include 'php/DataGetter.php';
include 'php/Display.php';
include 'php/EventHandler.php';
include 'php/Map.php';

$data = new DataGetter();
$handler = new EventHandler();

//Data
$data->connect();
$data->getThemes();
$data->getShelvesBlocks();
$themes = $data->returnThemes();
$secondFloorBlocks = $data->returnBlocks();
$searchFor = null;

//Floors
$firstFloor = Map::withName("images/VGTUB_1a.png", "1 Aukštas");
$secondFloor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");

$floors = array($firstFloor,$secondFloor);

//Auditoriums
$auditorium101 = Map::withName("images/VGTU_2a_101.png","101 Auditorija");
$auditorium211 = Map::withName("images/VGTUB_2a_211.png","211 Auditorija");
$auditorium217 = Map::withName("images/VGTUB_2a_217.png","217 Auditorija");

$auditoriums = array($auditorium101,$auditorium211,$auditorium217);

//Interactive Map data

//Sub tabs count
$subContentCount = 0;

$libraryIndex = 0;
$roomIndex = sizeof($floors);
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
            //Filling Search-Bar
            foreach ($themes as $item)
            {
                echo '<option value="'.$item[0].'">'.$item[0].'</option>';
            }
            ?>
        </datalist>

        <?php

        if(!isset($_POST["Search"]))
        {
            echo "NULL";
            foreach ($floors as $floor)
            {
                $floor->changeStatus(true);
                $floor->generateBase64Uri();
            }
            foreach ($auditoriums as $auditorium)
            {
                $auditorium->changeStatus(true);
                $auditorium->generateBase64Uri();
            }
            $handler->displayButton("Ieškoti","Search"); //Displaying search button
        }
        else {

            $handler->displayButton("Ieškoti","Search"); //Displaying search button
            $data->getValueFromSelection("Search", "DropDown1");
            $searchFor = $data->returnSelectedValue(); //returns selected value


            //Drawing maps of floors
            for ($i = 0; $i < sizeof($floors); $i++) {
                $floors[$i]->fillMapByTheme($secondFloorBlocks, $searchFor);
                $floors[$i]->generateBase64Uri();
            }
            //Drawing maps of Rooms
            foreach ($secondFloorBlocks as $block) {
                $shelves = $block->returnShelves();
                for ($i = 0; $i < sizeof($auditoriums); $i++) {
                    $auditoriums[$i]->fillMapByTheme($shelves, $searchFor);
                }
            }
            foreach ($auditoriums as $auditorium) $auditorium->generateBase64Uri();
        }
        ?>
    </form>

    <br>

    <div class="tabButtons">
        <button onclick="showContent(0); showSubContent(<?php echo $libraryIndex ?>)">Biblioteka</button>
        <button onclick="showContent(1); showSubContent(<?php echo $roomIndex ?>)">Auditorija</button>
    </div>
    <!-- button 1 -->
    <div class="tabContent">
        <?php
        $libraryIndex = $subContentCount;
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
        $room_index = $subContentCount + 1;
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
        }
        $handler->displayTabs($auditoriumNames,$subContentCount);
        $handler->fillContentWithMaps($auditoriumsToPrint,$handler);
        ?>
    </div>
</div>
</body>
</html>

<?php

?>