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
$secondFloor->generateBase64Uri();
?>
<form method="POST">
<input width="600" height="564" type="image" name="myimage" src="<?php echo $secondFloor->returnBase64() ?>">
</form>
<?php
$x = $_POST['myimage_x'];
$y= $_POST['myimage_y'];

echo $x;
echo '<br>';
echo $y;
?>
