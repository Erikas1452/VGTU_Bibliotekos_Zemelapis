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

let preferedWidth;
let preferedHeight;

//Themes of Shelf
let tableContents;

//Cache for search bar
let searchCache;
let searchTopic;

//Cache for tables
let tables;

//map type which is used to search for specified theme (floor and room maps can have same id)
let idType = null;

$(document).ready(function () {

    preferedWidth = 940;
    preferedHeight = 800;

    simulateClick(document.querySelectorAll(".tabButtons button")[0].id);

    $(document).mousemove(function(e){

        let cpos = { top: e.pageY + 10, left: e.pageX + 20 };

        $('#besideMouse').offset(cpos);
    });
});

// --------------Getting Data (and loading it after getting it)----------- //


function getTables(mapID , file)
{
    $.post(file,
        {
            id: mapID
        }, function (data,status) {
            tables = JSON.parse(data);
        });
}

//getting all shelves to mark and caching it for further use
function getShelves(topic)
{
    $.post("./php/fetchShelves.php",{
        topic: topic
    },function (data,status) {
        //caching data
        searchCache = JSON.parse(data);
        searchTopic = topic;
    });
}

//getting data about shelf (themes it contains) and loading it afterwards
function getShelfThemes(shelfID) {
    $.post("./php/fetchShelfThemes.php", {
        shelfID: shelfID
    }, function (data, status) {
        data = JSON.parse(data);
        tableContents = data;
        console.log(data);

        //loading shelf table to web
        loadTable(data);
    });
}

//getting shelf and colouring it on click
function getShelf(mapID,x,y) {
    $.post("./php/fetchShelf.php",{
        map: mapID,
        x: x,
        y: y
    },function(data,status){
        data = JSON.parse(data);
        if(data)
        {
            //Marking new selected shelf on canvas
            if(!isMarked(mapID,x,y))
            {
                clearCanvas();
                if(searchCache)drawAllShelves(mapID);
                drawRectangle(data["x1"] / scale[0], data["y1"] / scale[1], data['width'] / scale[0], data['height'] / scale[1])
            }
            //Clearing canvas and redrawing old shelves from search
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

//Getting room ID from click and loading it afterwards
function getRoom(mapID,x,y) {
    $.post("./php/fetchRoomID.php",{
        map: mapID,
        x: x,
        y: y
    },function(data,status){
        data = JSON.parse(data);
        if(data)
        {
            loadSubTab(data["id"]);
        }
    });
}

function getImage(mapID,file,fnc,mapType)
{
    $.post(file,{
        map: mapID
    },function (data,status) {

        let temp = JSON.parse(data);

        imgSource=temp[0];

        loadImage(mapID,mapType);

        //enabling interactivity after loading image
        fnc();
    });
}

// ------------- LOGIC ------------- //

//Checks if theres table in provided coordinates
//and provides name of table if its a table
function isTable(x,y) {
    let res = false

    //Recalculating coordinates to adapt to size of canvas on web
    x *= scale[0];
    y *= scale[1];

    //
    if(tables)
    {
        let temp = tables["tables"];
        temp.forEach(function (table) {
            if( (x >= table["x1"] && x <= table["width"] + table["x1"]) && (y >= table["y1"] && y <= table["height"] + table["y1"]))
            {
                res = table["name"];
                return res
            }
        });
    }
    return res;
}

//Checks if provided coordinate (on click) is shelf that was already marked
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

//  ||------------Loading data-------------||

function loadImage(mapID, type)
{
    idType = type;

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

     //Loading Tabs

function loadMainTab(mapID,tabID)
{
    $("#tabContent").load("./php/loadMainTab.php",{
        map: mapID,
    },function () {

        $('#besideMouse').hide();

        refreshData();

        getImage(mapID,'./php/fetchFloorMap.php',floorInteractivitySetup,'floorId');
        getTables(mapID,'./php/fetchFloorTables.php');

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

function loadSubTab(mapID) {
    $("#tabContent").load("./php/loadSubTab.php",{
        map: mapID
    },function () {
        $('#besideMouse').hide();

        refreshData();

        getImage(mapID,'./php/fetchMap.php',roomInteractivitySetup,'roomId');
        getTables(mapID,'./php/fetchRoomTables.php');

        showSubContent();
    });
}

    //Loading table of shelf content
function loadTable(data) {
    $(".tableContents").load("./php/fillTable.php",{
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
    floorImages=document.querySelectorAll(".tabContent .mapImage");

    mainTabButtons=document.querySelectorAll(".tabButtons button");
    mainTabContents=document.querySelectorAll(".tabContent");

}

function showContent(contentIndex)
{
    //reseting styles
    resetMainTabButtons();

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

    //displaying subtab image div
    floorImages[0].style.display="block";
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

function setupTableHover()
{
    canvas.addEventListener("mousemove",hover);
}

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

function hover(event)
{
    getScale();

    temp = getMousePosition(canvas,event);

    if(isTable(temp[0],temp[1]))
    {
        let data = isTable(temp[0],temp[1]);
        let str = data;

        displayHover(str);
    }
    else disableHover();

}

function displayHover(msg)
{
    $("#besideMouse").show();
    $("#besideMouse").html(msg);
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


function enableClicking(fnc)
{
    //on click actions
    canvas.addEventListener("mousedown", fnc);
}

function selectShelf(event)
{
    let coordinates=getMousePosition(canvas, event);
    let ID = document.getElementById("imageCanvas").getAttribute("name");

    getScale();
    //Requesting info about shelf contents
    getShelf(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
}

function selectRoom(event)
{
    let coordinates=getMousePosition(canvas, event);
    let ID = document.getElementById("imageCanvas").getAttribute("name");

    getScale();

    getRoom(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
}