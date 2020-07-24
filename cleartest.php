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

$secondFloor = Map::withName("images/VGTUB_2a.png", "2 Aukštas");

$width = $secondFloor->returnWidth();
$length = $secondFloor->returnLength();

$ratio = 0.25;

$modifiedWidth = $width * $ratio;
$modifiedLength = $length * $ratio;

echo '<br>';
echo $width;
echo '<br>';
echo $length;
echo '<br>';
echo '<br>';
echo '<br>';
echo $modifiedWidth;
echo '<br>';
echo $modifiedLength;

$selectedShelf = null;

$x = $_POST['myimage_x'];
$y = $_POST['myimage_y'];

if(isset($_POST["myimage_x"]))
    {
        for($i = 0; $i < sizeof($secondFloorBlocks); $i++)
        {
            $coordinates = $secondFloorBlocks[$i]->returnCoordinates();
            $coordinates = recalculateCoordinates($coordinates,$ratio);
            if(clickedOnShelf($coordinates,$x,$y)) $selectedShelf = $secondFloorBlocks[$i];
        }
    }
if($selectedShelf != null) $secondFloor->fillSelectedShelf($secondFloorBlocks,$selectedShelf);
else $secondFloor->fillMapByTheme($secondFloorBlocks,"x+");

$secondFloor->generateBase64Uri();
?>
<form method="POST">
<input width="<?php echo $modifiedWidth ?>" height="<?php echo $modifiedLength ?>" type="image" name="myimage" src="<?php echo $secondFloor->returnBase64() ?>">
</form>
<?php

echo $x;
echo '<br>';
echo $y;

function clickedOnShelf($coordinates,$mouseX,$mouseY)
{
    if(( $mouseX >= $coordinates[0] && $mouseY >= $coordinates [1]) && ($mouseX <= $coordinates[2] && $mouseY <= $coordinates [3])) return true;
    else return false;
}

function recalculateCoordinates($coordinates,$ratio)
{
    $newCoordinates = array();
    for ($i = 0; $i < sizeof($coordinates); $i++)
    {
        $newCoordinates[$i] = $coordinates[$i] * $ratio;
    }
    return $newCoordinates;
}
?>

