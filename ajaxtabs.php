<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>jQuery UI Tabs - Content via Ajax</title>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script>
        $( function() {
            $( "#tabs" ).tabs({
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
        $( function() {
            $( "#subtabs" ).tabs({
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

</head>
<body>

<div id="tabs">
    <ul>
        <li><a href="#tabs-1">Preloaded</a></li>
        <li><a href="#tabs-2">Tab 2</a></li>
        <li><a href="#tabs-3">Tab 3</a></li>
    </ul>
    <div id="tabs-1">
        <p>Well</p>
    </div>
    <div id="tabs-2">
        <p>Helloo</p>
    </div>
    <div id="tabs-3">
        <div id="subtabs">
            <ul>
                <li><a href="#subtabs-1">Preloaded subtab</a></li>
                <li><a href="#subtabs-2">subTab 2</a></li>
                <li><a href="#subtabs-3">subTab 3</a></li>
            </ul>
            <div id="subtabs-1">
                <p>There</p>
            </div>
            <div id="subtabs-2">
                <p>General</p>
            </div>
            <div id="subtabs-3">
                <p>Kenobi</p>
            </div>
        </div>
    </div>
</div>


</body>
</html>


