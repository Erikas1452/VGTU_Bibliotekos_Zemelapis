<?php
include 'php/DataGetter.php';

$data = new DataGetter();

//Data
$data->connect();
$data->getThemes();

$themes = $data->returnThemes();

$searchFor = null;
$themeName = "Ieškoti";

$found = false;

if(isset($_POST["Search"]))
{
    foreach ($themes as $theme)
    {
        if(strtolower($_POST["dropDown1"]) == strtolower($theme[1]))
        {
            $found = true;
            $searchFor = $theme[0];
            $themeName = $theme[1];
        }
    }

}

?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"> </script>
        <script src="script.js"></script>
        <link href ="style.css" rel="stylesheet">
    </head>

    <div class="wrapper">
    <body>

    <p class= "mouseText" style="z-index:10; position:fixed;" id="besideMouse"></p>

    <div>
        <h2>ATVIROJO FONDO ŽEMĖLAPIS</h2>
    </div>

    <div id="mainCont" class="mainContainer">
    <div>
        <form method="POST">
            <label for="DropDown1">Tema:</label> <br>
            <input type="text" placeholder="<?php echo $themeName ?>" list="DropDown1" name="dropDown1" />
            <datalist id="DropDown1">
                <?php
                //Filling Search-Bar
                foreach ($themes as $item)
                {
                    echo '<option>'.$item[1].'</option>';
                }
                ?>
            </datalist>
            <input type="submit" name="Search" value="Ieškoti"/>
        </form>

        <br>

        <div id="tabButtons" class="tabButtons">
            <?php
            //creating tabs
            if($found == true)
            {
                //Generate tabs only for maps the theme was found on
                    $data->getFloorTabsByTopic($searchFor);
                    $floors = $data->returnFloorNames();
                    $singleQuote = "'";

                //Generate all tabs
                    // $data->getFloorTabs();
                    // $floors = $data->returnFloorNames();
                    // $singleQuote = "'";

                $searchFor = $singleQuote.$searchFor.$singleQuote;

                $index = 0;
                foreach($floors as $floor)
                {
                    echo '<button id="tab-'.$floor[1].'"onclick="loadCacheWithMap('.$floor[1].','.$index.','.$searchFor.');">'.$floor[0].'</button>';
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
                    echo '<button id="tab-'.$floor[1].'" onclick="loadMainTab('.$floor[1].','.$index.')">'.$floor[0].'</button> ';
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
