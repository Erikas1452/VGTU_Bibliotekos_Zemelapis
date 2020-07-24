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

//TESTING
    $secondFloorBlocks = $data->returnBlocks();

    //1ST block
    $coordinates = $secondFloorBlocks[0]->returnCoordinates();
    $blockThemes = $secondFloorBlocks[0]->returnThemes();

    foreach($coordinates as $coordinate) echo $coordinate.' ';
    foreach($blockThemes as $theme) echo $theme.' ';

    echo'<br>';

    //2ND block
    $coordinates = $secondFloorBlocks[1]->returnCoordinates();
    $blockThemes = $secondFloorBlocks[1]->returnThemes();

foreach($coordinates as $coordinate) echo $coordinate.' ';
foreach($blockThemes as $theme) echo $theme.' ';

//Floors
$firstFloor = Map::withName("images/VGTUB_1a.png", "1 Aukštas");
$secondFloor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");

$floors = array($firstFloor,$secondFloor);
//Auditoriums
$auditorium201 = Map::withName("images/VGTU_2a_101.png","201 Auditorija");

$auditoriums = array($auditorium201);

//Sub tabs count
$subContentCount = 0;

$libraryIndex = 0;
$roomIndex = 1;
$shelfIndex = 2;

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
        $searchFor = $data->returnSelectedValue();


        echo '    Test :  Selected: '.$searchFor; //Testing if the selected value is extracted correctly
        $secondFloor->fillMapByTheme($secondFloorBlocks,$searchFor);
        $secondFloor->generateBase64Uri();

        $firstFloor->fillMapByTheme($secondFloorBlocks,$searchFor);
        $firstFloor->generateBase64Uri();

        foreach($secondFloorBlocks as $block)
        {
            $shelves = $block->returnShelves();
            $auditorium201->fillMapByTheme($shelves,$searchFor);
        }
        $auditorium201->generateBase64Uri();
        ?>

    </form>

    <br>

    <div class="tabButtons">
        <?php
        echo $libraryIndex." ".$roomIndex." ".$shelfIndex;
        ?>
        <button onclick="showContent(0); showSubContent(<?php echo $libraryIndex ?>)">Biblioteka</button>
        <button onclick="showContent(1); showSubContent(<?php echo $roomIndex ?>)">Auditorija</button>
        <button onclick="showContent(2); showSubContent(<?php echo $shelfIndex ?>)">Lentyna</button>
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
            $handler->displayTabs($auditoriumNames,$subContentCount);
            $handler->fillContentWithMaps($auditoriumsToPrint,$handler);
        }
        ?>
    </div>
    <!-- button 3 -->
    <div class="tabContent">
        <?php
        $shelfIndex = $subContentCount + 1;
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