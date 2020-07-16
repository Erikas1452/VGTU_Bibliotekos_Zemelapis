<?php
include 'DataGetter.php';
include 'Display.php';
include 'EventHandler.php';
include 'Map.php';

$data = new DataGetter();
$handler = new EventHandler();

//Data
$data->getThemes();
$data->getShelves();

$themes = $data->returnThemes();
$shelves_to_mark = $data->returnShelves();

//Floors
$first_floor = Map::withName("images/VGTUB_1a.png", "1 Aukštas");
$second_floor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");

$floors = array($first_floor,$second_floor);
//Auditoriums
$auditoriums = array();

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
        $floors[0]->fillMapByTheme($shelves_to_mark,$search_for);
        $floors[0]->saveMap('images/VGTUB_2a'.'_'.$search_for.'.png');

        $floors[1]->fillMapByTheme($shelves_to_mark,$search_for);
        $floors[1]->saveMap('images/VGTUB_1a'.'_'.$search_for.'.png');
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
        $count = 0;
        $maps = array();
        foreach($floors as $floor)
        {
           if($floor->returnStatus())
           {
               $mapsToPrint[$count] = $floor;
               $maps[$count] = $floor->returnName();
               $count++;
           }
        }
        $handler->displayTabs($maps,$subContentCount);
        $handler->fillContentWithMaps($mapsToPrint,$handler);
        ?>
    </div>
    <!-- button 2 -->
    <div class="tabContent">
        <div class="subTabButtons">
            <button onclick="showSubContent(2)">101 Auditorija</button>
            <button onclick="showSubContent(3)">102 Audiotrija</button>
            <button onclick="showSubContent(4)">103 Auditorija</button>
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
            <button onclick="showSubContent(5)">1 Lentyna</button>
            <button onclick="showSubContent(6)">2 Lentyna</button>
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