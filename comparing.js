function loadSubTab(mapID,tabID) {
    $("#subTabContent").load("./php/loadSubTab.php",{
        map: mapID
    },function () {
        $('#besideMouse').hide();

        refreshData();

        getRoomImage(mapID);
        getTables(mapID,'./php/fetchRoomTables.php');

        showSubContent();
    });
}

function loadMainTab(mapID,tabID)
{
    $("#tabContent").load("./php/loadMainTab.php",{
        map: mapID,
    },function () {

        $('#besideMouse').hide();

        refreshData();

        getFloorImage(mapID);
        getTables(mapID,'./php/fetchFloorTables.php');

        showContent(tabID);
    });
}

//------------------------------------------------------------

function floorInteractivitySetup()
{
    setupTableHover();
    enableClicking(selectRoom);
}

function roomInteractivitySetup()
{
    setupTableHover();
    enableClicking(selectShelf);
}

function getImage(mapID,file,fnc)
{
    $.post("./php/fetchMap.php",{
        map: mapID
    },function (data,status) {

        let temp = JSON.parse(data);

        imgSource=temp[0];

        loadImage(mapID);

        //enabling interactivity after loading image
        fnc();
    });
}

function getFloorImage(mapID)
{
    $.post("./php/fetchFloorMap.php",{
        map: mapID
    },function (data,status) {

        let temp = JSON.parse(data);

        imgSource=temp[0];

        loadFloorImage(mapID);

        //enabling interactivity after loading image
        setupTableHover();
        enableClicking(selectRoom);
    });
}

function getRoomImage(mapID)
{
    $.post("./php/fetchMap.php",{
        map: mapID
    },function (data,status) {

        let temp = JSON.parse(data);

        imgSource=temp[0];

        loadRoomImage(mapID);

        //enabling interactivity after loading image
        setupTableHover();
        enableClicking(selectShelf);
    });
}

//------------------------------------------------------------

function loadImage(mapID, type)
{
    idType = idType;

    canvas = document.getElementById("imageCanvas");
    ctx = canvas.getContext('2d');

    image = new Image();

    image.src = imgSource;

    //on load display map on web
    image.onload = function () {
        saveOriginalWidth();
        prepareCanvas();
        drawImageOnCanvas(mapID);
    };
}
