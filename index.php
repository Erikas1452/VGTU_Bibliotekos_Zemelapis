<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>VGTU Library Map</title>
        <?php
            include 'DataGetter.php';
            include 'Display.php';
            include 'EventHandler.php';
            include 'Map.php';
        ?>
        <!-- (ADD LATER)References to styles -->
        <!-- <link href ="canvas.css" rel="stylesheet"> -->
    </head>

    <body>
        <div>
            <h2>VGTU BIBLIOTEKOS ZEMELAPIS</h2>
        </div>
        <div>
            <label for="SelectionWindow">Pasirinkite knygų tematiką:</label> <br>
            <?php
                $getter = new DataGetter();
                $handler = new EventHandler();
                $getter->getThemes();
                $themes = $getter->returnThemes();
                $handler->displaySelection($themes,"SelectionWindow");
            ?>
        </div>
        <div>
            <form method="post">
                <?php
                    $handler->displayButton("Ieškoti","Search");
                    $handler ->buttonPressed("Search","images/LT1.jpg"); // <-- Needs a way to find out which map print-out
                ?>
            </form>
        </div>
        <div>
            <?php
            ?>
        </div>
    </body>
</html>