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
                <?php
                $getter = new DataGetter();
                $handler = new EventHandler();
                $getter->getThemes();
                $themes = $getter->returnThemes();
                $handler->displaySelection($themes,"DropDown1");
                $handler->displayButton("Pasirinkti","Search");
                ?>
            </form>
            <?php
            $getter->getValueFromSelection("Search","DropDown1");
            $seach_for = $getter->returtSelectedValue();
            echo $seach_for;
            $getter->getShelfs();
            $getter->printShelfs();
            ?>
    </div>
    </body>
</html>