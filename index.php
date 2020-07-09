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
                    $handler ->buttonPressed("Search");
                ?>
            </form>
        </div>
        <div>
            <?php
            $fakedata = array(97,223,157,236,'Matematika',193,303,259,319,93,295,132,340);
            ?>
        </div>
    </body>
</html>