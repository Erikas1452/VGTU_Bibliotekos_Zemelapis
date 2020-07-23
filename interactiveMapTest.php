<?php
include 'php/DataGetter.php';
include 'php/Display.php';
include 'php/EventHandler.php';
include 'php/Map.php';

session_start();

$data = new DataGetter();
$handler = new EventHandler();

//Data
$data->connect();
$data->getThemes();
$data->getShelvesBlocks();

$themes = $data->returnThemes();

//TESTING //TESTING //TESTING //TESTING
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

//Sub tabs count
$subContentCount = 0;

$libraryIndex = 0;
$roomIndex = 1;
$shelfIndex = 2;


//Map SIZE
echo '<br>';
echo 'Original Image size: ';
$secondFloor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");
echo '<br>';
echo 'Width '.$secondFloor->returnWidth();
echo '<br>';
echo 'Length '.$secondFloor->returnLength();

$image = $secondFloor->returnMap();

ob_start();
    imagepng($image);
    $contents = ob_get_contents();
    ob_end_clean();

    $dataUri = "data:image/png;base64," . base64_encode($contents);

$path = "images/VGTUB_2a.png";
//TESTING END //TESTING END //TESTING END //TESTING END

$secondFloor->generateBase64Uri();

?>

<img src="<?php echo $secondFloor->returnBase64()?>" alt ="failed" />

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>VGTU Library Map</title>
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

        echo '    Test :  Selected: '.$searchFor; //Checking if the selected value is extracted correctly
        ?>

    </form>

    <br>

    <div class="tabButtons">
        <button onclick="showContent(0); showSubContent(<?php echo $libraryIndex ?>)">Biblioteka</button>
        <button onclick="showContent(1); showSubContent(<?php echo $roomIndex ?>)">Auditorija</button>
        <button onclick="showContent(2); showSubContent(<?php echo $shelfIndex ?>)">Lentyna</button>
    </div>
    <!-- button 1 -->
    <div class="tabContent">
        <div class="subTabButtons">
            <button onclick="showSubContent(0)">1 Aukstas</button>
            <br>
            <img src="images/VGTUB_2a.png" width="600" height="550" alt="1StFloor" usemap="#1stFloor">

            <map name="1stFloor">
                <area shape="rect" coords="10,10,250,250" alt="Shelf" href="hi.html">
            </map>
        </div>
        <div class="subTabContent">

        </div>
    </div>
    <!-- button 2 -->
    <div class="tabContent">

    </div>
    <!-- button 3 -->
    <div class="tabContent">

    </div>
</div>
</body>
</html>