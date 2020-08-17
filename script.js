//Tabs

let floorImages;

let mainTabButtons;
let mainTabContents;

let subTabContents;

//Image/Canvas
let imgSource;
let imgWidth;
let imgHeight;

let canvas;
let ctx;
let scale;

let preferedWidth = 850;
let preferedHeight = 800;

//Themes of Shelf
let tableContents;

//Cache for search bar
let searchCache;
let searchTopic;

let rooms = new Set();

//Cache for tables
let tables;

//map type which is used to search for specified theme (floor and room maps can have same id)
let idType = null;

$('#besideMouse').hide();

$(document).ready(function () {
    simulateClick(document.querySelectorAll(".tabButtons button")[0].id);
    $(document).mousemove(function(e){
        let cpos = { top: e.pageY + 10, left: e.pageX + 20 };
        $('#besideMouse').offset(cpos);
    });
});

function display(event)
{
    getScale();
    console.log("moving");
    temp = getMousePosition(canvas,event);
    if(isTable(temp[0],temp[1]))
    {
        let data = isTable(temp[0],temp[1]);
        let str = data;
        console.log(str);
        $("#besideMouse").show();
        $("#besideMouse").html(str);
    }
    else disableHover();

}
function disableHover()
{
    $("#besideMouse").hide();
    $("#besideMouse").html("");
}

function simulateClick(element)
{
    $("#".concat(element)).click();
}

//Sorting provided data
function selectUniqueRooms()
{
    let shelves = searchCache["shelves"];
    shelves.forEach(function(shelf)
    {
        if(!rooms.has(shelf["roomId"]))
        {
            rooms.add(shelf["roomId"]);
        }
    });
}

// --------------Loading Data----------- //

//  ||------------Tables------------||

function getTables(mapID)
{
    $.post("./fetchTables.php",
        {
            id: mapID
        }, function (data,status) {
            tables = JSON.parse(data);
        });
}

//  ||------------Shelves------------||

//getting all shelves to mark and caching it for further use
function getShelves(topic)
{
    $.post("./fetchShelves.php",{
        topic: topic
    },function (data,status) {
        //caching data
        searchCache = JSON.parse(data);
        searchTopic = topic;
        selectUniqueRooms();
    });
}

//getting data about shelf
function getShelfThemes(shelfID) {
    $.post("./fetchShelfThemes.php", {
        shelfID: shelfID
    }, function (data, status) {
        data = JSON.parse(data);
        tableContents = data;
        console.log(data);

        //loading shelf to web
        loadTable(data);
    });
}

//getting shelf and colouring it on click
function getShelf(mapID,x,y) {
    $.post("./fetchShelf.php",{
        map: mapID,
        x: x,
        y: y
    },function(data,status){
        if(data != "Error")
        {
            data = JSON.parse(data);

            if(!isMarked(mapID,x,y))
            {
                clearCanvas();
                if(searchCache)drawAllShelves(mapID);
                drawRectangle(data["x1"] / scale[0], data["y1"] / scale[1], data['width'] / scale[0], data['height'] / scale[1])
            }
            else
            {
                clearCanvas()
                if(searchCache)drawAllShelves(mapID);
            }
            //Getting themes that are in selected shelf
            getShelfThemes(data["id"]);
        }
    });
}

function isTable(x,y) {
    let res = false
    x *= scale[0];
    y *= scale[1];
    if(tables)
    {
        let temp = tables["tables"];
        temp.forEach(function (table) {
            if( (x >= table["x1"] && x <= table["width"] + table["x1"]) && (y >= table["y1"] && y <= table["height"] + table["y1"])) res = table["name"];
        });
    }
    return res;
}

function isMarked(mapID,x,y)
{
    let res = false;

    if(searchCache)
    {
        let shelves = searchCache["shelves"];
        shelves.forEach(function (shelf) {
            if((mapID == shelf["roomId"]) && (x >= shelf["roomX1"] && x <= shelf["roomWidth"] + shelf["roomX1"]) && (y >= shelf["roomY1"] && y <= shelf["roomHeight"] + shelf["roomY1"])) res = true;
        });
    }

    return res;
}

function getRoom(mapID,x,y) {
    $.post("./fetchRoomID.php",{
        map: mapID,
        x: x,
        y: y
    },function(data,status){
        if(data != "Error")
        {
            data = JSON.parse(data);
            loadSubTab(data["id"],0);
        }
    });
}

//  ||------------Maps-------------||

function getRoomImage(mapID)
{
    $.post("./fetchMap.php",{
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

function setupTableHover()
{
    canvas.addEventListener("mousemove",display);
}

function getFloorImage(mapID)
{
    $.post("./fetchFloorMap.php",{
        map: mapID
    },function (data,status) {

        let temp = JSON.parse(data);

        imgSource=temp[0];

        loadFloorImage(mapID);

        //enabling interactivity after loading image
        enableClicking(selectRoom);
    });
}

function loadFloorImage(mapID)
{
    idType = 'floorId';

    canvas = document.getElementById("floorCanvas");
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

function loadRoomImage(mapID)
{
    idType = 'roomId';

    canvas = document.getElementById("roomCanvas");
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

     //Loading Tabs

function loadMainTab(mapID,tabID)
{
    $("#tabContent").load("loadMainTab.php",{
        map: mapID,
        rooms: Array.from(rooms)
    },function () {
        refreshData();
        getFloorImage(mapID);
        showContent(tabID);
    });
}

function loadCache(mapID,tabID,topic) {
    $.ajax({
        url:getShelves(topic),
        success:function(){
            loadMainTab(mapID,tabID);
        }
    })
}

function loadSubTab(mapID,tabID) {
    $("#subTabContent").load("loadSubTab.php",{
        map: mapID
    },function () {

        refreshData();
        getRoomImage(mapID);
        getTables(mapID);
        showSubContent();
    });
}

    //Loading table of shelf content
function loadTable(data) {
    $(".tableContents").load("./fillTable.php",{
        contents: tableContents,
        udk: searchTopic
    },function () {

    });
}

// ----TESTING---- //
//Test for drawing out all coordinates provided from database for specified map

// function drawAllShelves(mapID)
// {
//     $.post("./fetchAllCoords.php",
//     {
//         map: mapID
//     },function (data, status) {
//         data = JSON.parse(data);
//         data["coords"].forEach(function(element){
//             getScale();
//             drawRectangle(element["x1"]/scale[0],element["y1"]/scale[1],element['width']/scale[0],element['height']/scale[1]);
//         });
//     });
// }
// ----TESTING---- //

// --------------Calculations----------- //

function getMousePosition(canvas, event)
{
    let rect = canvas.getBoundingClientRect();
    let x = event.clientX - rect.left;
    let y = event.clientY - rect.top;
    return [Math.round(x), Math.round(y)];
}

function getScale()
{
    scale = [imgWidth/canvas.width,imgHeight/canvas.height];
}

function saveOriginalWidth()
{
    imgWidth = image.naturalWidth;
    imgHeight = image.naturalHeight;
    console.log(imgWidth, imgHeight);
}

function findRatio()
{
    let ratio = preferedHeight/image.naturalHeight;
    if(image.naturalWidth*ratio > preferedWidth) ratio = preferedWidth/image.naturalWidth;
    else if (image.naturalWidth*ratio < preferedWidth/2) ratio = preferedWidth/image.naturalWidth;
    if (image.naturalHeight*ratio > preferedHeight) ratio = (preferedWidth/1.35)/image.naturalWidth;

    return ratio;
}

function setCanvasSize(ratio)
{
    canvas.width = image.naturalWidth * ratio;
    canvas.height = image.naturalHeight * ratio;
}

// --------------Drawing----------- //

function clearCanvas()
{
    ctx.clearRect(0,0,canvas.width,canvas.height);
    drawImageOnCanvas();
}

function drawRectangle(x1,y1,width,height)
{
    ctx.fillStyle = "#269BF0";
    ctx.fillRect(x1,y1,width,height);
}

function drawAllShelves(id)
{
    let shelves = searchCache["shelves"];

    getScale();

    shelves.forEach(function (node)
    {
        if(idType == "roomId")
        {
            if(node["roomId"] == id)
            {
                drawRectangle(node["roomX1"]/scale[0],node["roomY1"]/scale[1],node["roomWidth"]/scale[0],node["roomHeight"]/scale[1]);
            }
        }
        else if (idType == "floorId")
        {
            if(node["floorId"] == id)
            {
                drawRectangle(node["floorX1"]/scale[0],node["floorY1"]/scale[1],node["floorWidth"]/scale[0],node["floorHeight"]/scale[1]);
            }
        }
    });
}

function prepareCanvas()
{
    let ratio = findRatio();
    setCanvasSize(ratio);
}

function drawImageOnCanvas(mapID)
{
    ctx.drawImage(image,0,0,canvas.width,canvas.height);
    if(searchCache) drawAllShelves(mapID); //If there was a search for some specific topic draw shelves on top of map
 }

// --------------Working with tabs (changing styles etc.)----------- //

//used for updating tabs after loading new content to web
function refreshData()
{
    floorImages=document.querySelectorAll(".tabContent .floorImage");

    mainTabButtons=document.querySelectorAll(".tabButtons button");
    mainTabContents=document.querySelectorAll(".tabContent");

    subTabContents=document.querySelectorAll(".tabContent .subTabContent");
}

function showContent(contentIndex)
{
    //reseting styles
    resetMainTabButtons();
    hideSubContent();

    //Changing style of selected tab
    mainTabButtons[contentIndex].style.borderBottom="3px solid #269BF0";
    mainTabButtons[contentIndex].style.color="#269BF0";

    hideMainTabContents();

    //displaying maintab image div
    mainTabContents[0].style.display="block";
    floorImages[0].style.display="block";
}

function showSubContent()
{
    hidefloorImages();
    hideSubContent();

    //displaying subtab image div
    subTabContents[0].style.display="block";
    floorImages[1].style.display="block";
}

function resetMainTabButtons()
{
    mainTabButtons.forEach(function(node){
        node.style.borderBottom="";
        node.style.color="";
    });
}
function hideMainTabContents()
{
    mainTabContents.forEach(function(node){
        node.style.display="none";
    });
}
function hideSubContent()
{
    subTabContents.forEach(function(node){
        node.style.display="none";
    });
}
function hidefloorImages()
{
    floorImages.forEach(function(node){
        node.style.display="none";
    });
}

function hideContent(content)
{
    content.forEach(function(node){
        node.style.display="none";
    });
}


// --------------Interactiveness---------- //

function enableClicking(fnc)
{
    //on click actions
    canvas.addEventListener("mousedown", fnc);
}

function selectShelf(event)
{
    let coordinates=getMousePosition(canvas, event);
    let ID = document.getElementById("roomCanvas").getAttribute("name");
    getScale();
    //Requesting info about shelf contents
    console.log(coordinates);
    getShelf(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
}

function selectRoom(event)
{
    let coordinates=getMousePosition(canvas, event);
    let ID = document.getElementById("floorCanvas").getAttribute("name");
    getScale();
    getRoom(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
}

//Zoom

function lockScroll()
{
    document.body.style.overflow = 'hidden';
}
function unlockScroll()
{
    document.body.style.overflow = '';
}