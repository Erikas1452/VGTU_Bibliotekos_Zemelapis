let floorImages;

let mainTabButtons;
let mainTabContents;

let subTabButtons;
let subTabContents;

let imgSource;
let imgWidth;
let imgHeight;

let canvas;
let ctx;
let scale;

let preferedWidth = 550;

let tableContents;

function getShelfThemes(shelfID) {
    $.post("./fetchShelfThemes.php",{
        shelfID: shelfID
    },function (data,status) {
        data = JSON.parse(data);
        tableContents=data;
        console.log(data);
        loadTable(data);
    })
}

function loadTable(data) {
    $(".tableContents").load("./fillTable.php",{
        contents: tableContents
    },function () {

    });
}

function drawAllShelves(mapID)
{
    $.post("./fetchAllCoords.php",
    {
        map: mapID
    },function (data, status) {
        data = JSON.parse(data);
        data["coords"].forEach(function(element){
            getScale();
            drawRectangle(element["x1"]/scale[0],element["y1"]/scale[1],element['width']/scale[0],element['height']/scale[1]);
        });
    });
}

function getShelf(mapID,x,y) {
    $.post("./fetchShelf.php",{
        map: mapID,
        x: x,
        y: y
    },function(data,status){
        data = JSON.parse(data);
        console.log(data);
        clearCanvas();
        drawRectangle(data["x1"]/scale[0],data["y1"]/scale[1],data['width']/scale[0],data['height']/scale[1]);
        getShelfThemes(data["id"]);
    });
}

function getScale() {
    scale = [imgWidth/canvas.width,imgHeight/canvas.height];
}

function getMousePosition(canvas, event) {
    let rect = canvas.getBoundingClientRect();
    x = event.clientX - rect.left;
    y = event.clientY - rect.top;
    return [x,y];
}

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

function enableClicking()
{
    canvas.addEventListener("mousedown", function(e)
    {
        let coordinates=getMousePosition(canvas, e);
        let ID = document.getElementById("roomCanvas").getAttribute("name");
        getScale();
        getShelf(ID,coordinates[0]*scale[0],coordinates[1]*scale[1]);
    });
}

function loadTab(mapID,tabID) {
    $("#tabContent").load("loadMainTab.php",{
        map: mapID
    },function () {
        refreshData();
        getFloorImage(mapID);
        showContent(tabID);
    });
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

function getRoomImage(mapID)
{
    $.post("./fetchMap.php",{
        map: mapID
    },function (data,status) {
        let temp = JSON.parse(data);
        imgSource=temp[0];
        loadImage();
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
        loadFloorImage();
    });
}

function loadFloorImage()
{
    canvas = document.getElementById("floorCanvas");
    ctx = canvas.getContext('2d');
    image = new Image();
    image.onload = function () {
        imgWidth = image.naturalWidth;
        imgHeight = image.naturalHeight;
        console.log(imgWidth,imgHeight);
        drawImageOnCanvas();
    };
    image.src = imgSource;
}

function loadImage()
{
    canvas = document.getElementById("roomCanvas");
    ctx = canvas.getContext('2d');
    image = new Image();
    image.src = imgSource;
    image.onload = function () {
        imgWidth = image.naturalWidth;
        imgHeight = image.naturalHeight;
        console.log(imgWidth,imgHeight);
        drawImageOnCanvas();
    };
}

function drawImageOnCanvas() {
    let tempScale = preferedWidth/image.naturalWidth;
    canvas.width = image.naturalWidth * tempScale;
    canvas.height = image.naturalHeight * tempScale;
    ctx.drawImage(image,0,0,canvas.width,canvas.height);
 }

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
    resetMainTabButtons();
    resetSubTabButtons();
    hideSubContent();

    mainTabButtons[contentIndex].style.borderBottom="3px solid #269BF0";
    mainTabButtons[contentIndex].style.color="#269BF0";
    hideMainTabButtons();
    mainTabContents[0].style.display="block";
    floorImages[0].style.display="-webkit-box";
}

function showSubContent(subContentIndex)
{
    hidefloorImages();
    resetSubTabButtons();
    subTabButtons[subContentIndex].style.backgroundColor="transparent";
    subTabButtons[subContentIndex].style.color="#269BF0";
    subTabButtons[subContentIndex].style.borderBottom="3px solid #269BF0";
    hideSubContent();
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
function hideMainTabButtons()
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