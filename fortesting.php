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
$auditorium101 = Map::withName("images/VGTUB_101.png","101 Auditorija");
$auditorium102 = Map::withName("images/VGTUB_102.png","102 Auditorija");

$auditorium201 = Map::withName("images/VGTUB_2a_201.png","201 Auditorija");
$auditorium211 = Map::withName("images/VGTUB_2a_211.png","211 Auditorija");
$auditorium217 = Map::withName("images/VGTUB_2a_217.png","217 Auditorija");

$firstFloorAuditoriums = array($auditorium101,$auditorium102);

$secondFloorAuditoriums = array($auditorium201,$auditorium211,$auditorium217);

//Interactive Map data
$testShelfThemes = array(array("001","Matematika"),array("002","Diskrecioji"));
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
<div class="wrapper">
    <div>
    <h2>ATVIROJO FONDO ŽEMĖLAPIS</h2>
    </div>

    <div class="mainContainer">
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

            <?php $handler->displayButton("Ieškoti","Search") ?>

            <?php
            if(!isset($_POST["Search"]))
            {
                foreach ($floors as $floor)
                {
                    $floor->changeStatus(true);
                    $floor->generateBase64Uri();
                }
                foreach ($firstFloorAuditoriums as $auditorium)
                {
                    $auditorium->changeStatus(true);
                    $auditorium->generateBase64Uri();
                }
                foreach ($secondFloorAuditoriums as $auditorium)
                {
                    $auditorium->changeStatus(true);
                    $auditorium->generateBase64Uri();
                }
            }
            else {

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
                    for ($i = 0; $i < sizeof($secondFloorAuditoriums); $i++) {
                        $secondFloorAuditoriums[$i]->fillMapByTheme($shelves, $searchFor);
                    }
                }
                foreach ($secondFloorAuditoriums as $auditorium) $auditorium->generateBase64Uri();

                foreach ($secondFloorBlocks as $block) {
                    $shelves = $block->returnShelves();
                    for ($i = 0; $i < sizeof($firstFloorAuditoriums); $i++) {
                        $firstFloorAuditoriums[$i]->fillMapByTheme($shelves, $searchFor);
                    }
                }
                foreach ($firstFloorAuditoriums as $auditorium) $auditorium->generateBase64Uri();


            }
            ?>
        </form>

        <br>

        <div class="tabButtons">
        <?php
        $index = 0;
        foreach($floors as $floor) {
            echo '<button onclick="showContent('.$index.')" onclick="showSubContent('.$roomIndex.')">'.$floor->returnName().'</button>';
            $index++;
        }
        ?>
        </div>
        <div class="mapContainer">
        <!-- button 1 -->
        <div class="tabContent">
            <?php
            $roomIndex = $subContentCount + 1;
            $count = 0;
            $auditoriumsToPrint = array();
            $auditoriumNames = array();
            foreach ($firstFloorAuditoriums as $auditorium)
            {
                if($auditorium->returnStatus())
                {
                    $auditoriumsToPrint[$count] = $auditorium;
                    $auditoriumNames[$count] = $auditorium->returnName();
                    $count++;
                }
            }
            $handler->displayTabs($auditoriumNames,$subContentCount);
            ?>
            <div class="floorImage">
            <?php $handler->displayImage($floors[$libraryIndex]->returnBase64(),545,520); ?>
            </div>
            <div class="table">
                 <?php $handler->displayTable($testShelfThemes); ?>
            </div>
            <?php
            $libraryIndex++;
            $handler->fillContentWithMaps($auditoriumsToPrint,$handler);
            ?>
        </div>
        <!-- button 2 -->
        <div class="tabContent">
            <?php
            $roomIndex = $subContentCount + 1;
            $count = 0;
            $auditoriumsToPrint = array();
            $auditoriumNames = array();
            foreach ($secondFloorAuditoriums as $auditorium)
            {
                if($auditorium->returnStatus())
                {
                    $auditoriumsToPrint[$count] = $auditorium;
                    $auditoriumNames[$count] = $auditorium->returnName();
                    $count++;
                }
            }
            $handler->displayTabs($auditoriumNames,$subContentCount);
            ?>
            <div class="floorImage">
                <?php $handler->displayImage($floors[$libraryIndex]->returnBase64(),545,520); ?>
            </div>
            <?php
            $libraryIndex++;
            $handler->fillContentWithMaps($auditoriumsToPrint,$handler);
            ?>
        </div>
        </div>
    </div>
</div>
</body>
</html>

<?php

?>