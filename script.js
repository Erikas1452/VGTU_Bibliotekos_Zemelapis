//Tabs

let floorImages;

let mainTabButtons;
let mainTabContents;

let subTabButtons;
let subTabContents;

//Image/Canvas
let imgSource;
let imgWidth;
let imgHeight;

let canvas;
let ctx;
let scale;

let preferedWidth = 600;
let preferedHeight = 450;

//Themes of Shelf
let tableContents;

//Cache for search bar
let searchCache;
let searchTopic;

let rooms = new Set();

//map type which is used to search for specified theme (floor and room maps can have same id)
let idType = null;

$(document).ready(function () {
    simulateClick(document.querySelectorAll(".tabButtons button")[0].id);
});

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
        if(JSON.parse(data))
        {
            data = JSON.parse(data);
            console.log(data);

            //Marking selected Shelf
            clearCanvas();
            drawRectangle(data["x1"] / scale[0], data["y1"] / scale[1], data['width'] / scale[0], data['height'] / scale[1]);

            //Getting themes that are in selected shelf
            getShelfThemes(data["id"]);
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
        enableClicking();
    });
}

function getFloorImage(mapID)
{
    $.post("./fetchFloorMap.php",{
        map: mapID
    },function (data,status) {
        let temp = JSON.parse(data);
        imgSource=temp[0];
        loadFloorImage(mapID);
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
        showSubContent(tabID);
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
    x = event.clientX - rect.left;
    y = event.clientY - rect.top;
    return [x, y];
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

// --------------Interactiveness---------- //

function enableClicking()
{
    //on click actions
    canvas.addEventListener("mousedown", function(e)
    {
        //Get coordinates and map ID that is being clicked on
        let coordinates=getMousePosition(canvas, e);
        let ID = document.getElementById("roomCanvas").getAttribute("name");

        getScale();

        //Requesting info about shelf contents
        getShelf(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
    });
}

// --------------Drawing----------- //

function clearCanvas()
{
    ctx.clearRect(0,0,1000,1000);
    drawImageOnCanvas();
}

function drawRectangle(x1,y1,width,height)
{
    ctx.fillStyle = "#269BF0";
    ctx.fillRect(x1,y1,width,height);
}

function drawAllShelves(id)
{
    console.log(searchCache["shelves"]);
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

    subTabButtons=document.querySelectorAll(".tabContent .subTabButtons button");
    subTabContents=document.querySelectorAll(".tabContent .subTabContent");
}

function showContent(contentIndex)
{
    //reseting styles
    resetMainTabButtons();
    resetSubTabButtons();
    hideSubContent();

    //Changing style of selected tab
    mainTabButtons[contentIndex].style.borderBottom="3px solid #269BF0";
    mainTabButtons[contentIndex].style.color="#269BF0";

    hideMainTabContents();

    //displaying maintab image div
    mainTabContents[0].style.display="block";
    floorImages[0].style.display="-webkit-box";
}

function showSubContent(subContentIndex)
{
    hidefloorImages();
    resetSubTabButtons();

    //Changing style of selected tab
    subTabButtons[subContentIndex].style.backgroundColor="transparent";
    subTabButtons[subContentIndex].style.color="#269BF0";
    subTabButtons[subContentIndex].style.borderBottom="3px solid #269BF0";

    hideSubContent();

    //displaying subtab image div
    subTabContents[0].style.display="block";
    floorImages[1].style.display="-webkit-box";
}

function resetSubTabButtons()
{
    subTabButtons.forEach(function(node){
        node.style.backgroundColor="";
        node.style.color="";
        node.style.borderBottom="";
    });
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