<?php
include 'php/DataGetter.php';

$data = new DataGetter();

//Data
$data->connect();
$data->getThemes();

$themes = $data->returnThemes();

$searchFor = null;
$searchStatus = false;
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <!-- (ADD LATER)References to styles -->
        <link href ="style.css" rel="stylesheet">
    </head>

    <div class="wrapper">
    <body>

    <script src="script.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"> </script>

    <div>
        <h2>ATVIROJO FONDO ŽEMĖLAPIS</h2>
    </div>

    <div class="mainContainer">
    <div>
        <form method="POST">
            <label for="DropDown1">Tema:</label> <br>
            <input type="text" list="DropDown1" name="dropDown1" />
            <datalist id="DropDown1">
                <?php
                //Filling Search-Bar
                foreach ($themes as $item)
                {
                    echo '<option value="'.$item[1].'">'.$item[1].'</option>';
                }
                ?>
            </datalist>
            <input type="submit" name="Search" value="Ieškoti" id="btn"/>
        </form>

        <br>

        <div id="tabButtons" class="tabButtons">
            <?php
            //creating tabs
            if(isset($_POST["Search"]))
            {
                foreach ($themes as $theme)
                {
                    if($_POST["dropDown1"] == $theme[1])
                    {
                        $searchStatus = true;
                        $searchFor = $theme[0];
                    }
                }

            }

            if($searchStatus == true)
            {
                $data->getFloorTabsByTopic($searchFor);
                $floors = $data->returnFloorNames();

                $singleQuote = "'";

                $searchFor = $singleQuote.$searchFor.$singleQuote;

                $index = 0;
                foreach($floors as $floor)
                {
                    echo '<button id="tab-'.$floor[1].'"onclick="getShelves('.$searchFor.'), loadTab('.$floor[1].','.$index.');">'.$floor[0].'</button>';
                    $index++;
                }
            }

            else
            {
                $data->getFloorTabs();
                $floors = $data->returnFloorNames();
                $index = 0;
                foreach($floors as $floor)
                {
                    echo '<button id="tab-'.$floor[1].'" onclick="loadTab('.$floor[1].','.$index.')">'.$floor[0].'</button>';
                    $index++;
                }
            }
            ?>
        </div>

        <div id="mapContainer" class="mapContainer">
            <div id="tabContent" class="tabContent">

            </div>
        </div>

    </div>
    </div>
    </div>
    </body>
    </html>
</div>
