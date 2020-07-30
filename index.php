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

$roomIndex = 0;
?>

    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <!-- (ADD LATER)References to styles -->
        <link href ="style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"> </script>
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

        <script>
            $(document).ready(function () {
                $("#btn").click(function (event) {
                        $("#TEST").load("test.php");
                });
            });
        </script>

        <script>
            $( function() {
                $( "#tabButtons" ).tabs({
                    beforeLoad: function( event, ui ) {
                        ui.jqXHR.fail(function() {
                            ui.panel.html(
                                "Couldn't load this tab. We'll try to fix this as soon as possible. " +
                                "If this wouldn't be a demo." );
                        });
                    }
                });
            } );
        </script>

        <script>
            $(document).ready(function () {
                $("#btn").click(function (event) {
                    $("#test").load("test2.php");
                    $("#tabButtons").tabs();
                });
            });
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
            <ul>
                <?php
                $index = 0;
                foreach ($floors as $floor)
                {
                    echo '<li id="'.$index.'"><a href="#tabcontent-'.$index.'">'.$floor.'</a></li>';
                    $index++;
                }
                ?>
            </ul>
            <div id = test>

            </div>
        </div>
    </div>
    </div>
    </body>
    </html>
</div>
