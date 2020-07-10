<?php
    include 'DataGetter.php';
    include 'Display.php';
    include 'EventHandler.php';
    include 'Map.php';
?>

<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <!-- (ADD LATER)References to styles -->
        <!-- <link href ="canvas.css" rel="stylesheet"> -->
    </head>

    <body>
        <div>
            <h2>VGTU BIBLIOTEKOS ZEMELAPIS</h2>
        </div>
        <div>
            <!-- Dropdown -->
            <form method="post">
                <label for="DropDown1">Knygų tematika:</label> <br>
                <?php ;
                $data = new DataGetter();
                $handler = new EventHandler();
                $data->getThemes();
                $themes = $data->returnThemes();
                $handler->displaySelection($themes,"DropDown1");
                $handler->displayButton("Pasirinkti","Search");
                ?>
            </form>
            <?php
            $data->getValueFromSelection("Search","DropDown1");
            $search_for = $data->returnSelectedValue();
            echo $search_for;
            $data->getShelves();
            $shelves_to_mark = $data->returnShelves();
            $first_floor = new Map("images/LT1.jpg");
            $first_floor->fillMapByTheme($shelves_to_mark,$search_for);
            $first_floor->saveMap("images/LT1_marked.jpg");
            $handler->displayImage("images/LT1_marked.jpg",800,600);
            ?>
        </div>
    </body>
</html>