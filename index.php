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

$themes = $data->returnThemes();
$searchFor = null;

$floors = array("1 aukstas","2 aukstas");

$contents = array("auditorija1","auditorija2");

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
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"> </script>

        <script>
            function loadTab() {
                $("#1").click(function(event){
                    $("#test").load("test2.php");
                })
            }
        </script>

    </head>

    <div class="wrapper">
    <body>
    <div>
        <h2>ATVIROJO FONDO ŽEMĖLAPIS</h2>
    </div>
    <div class="mainContainer">
    <div>
        <form method="POST">
            <label for="DropDown1">Tema:</label> <br>
            <input type="text" list="DropDown1" name="DropDown1" />

            <datalist id="DropDown1">
                <?php
                //Filling Search-Bar
                foreach ($themes as $item)
                {
                    echo '<option value="'.$item[1].'">'.$item[1].'</option>';
                }
                ?>
            </datalist>
            <input type="button" name="Search" value="Ieškoti" id="btn"/>
        </form>

        <br>

        <div id="tabButtons" class="tabButtons">
            <?php
            $floors = array("1 aukstas", "2 aukstas");
            $index=0;
            foreach($floors as $floor)
            {
                echo '<button id="tab-'.$index.'" onclick="loadTab('.$index.')">'.$floor.'</button>';
                $index++;
            }
            ?>
        </div>
        <div id="mapContainer" class="mapContainer">
        <?php
        $index=0;
        foreach($floors as $floor)
        {
            echo'<div id="tabContent-'.$index.'" class="tabContent">';
            echo'</div>';
            $index++;
        }
        ?>
        </div>

    </div>
    </div>
    </div>
    </body>
    </html>
</div>
