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
        alert("new source");
        imgWidth=temp[1];
        imgHeight=temp[2];
        loadImage();
    });
}

function getFloorImage(mapID)
{
    $.post("./fetchFloorMap.php",{
        map: mapID
    },function (data,status) {
        let temp = JSON.parse(data);
        imgSource=temp[0];
        alert("new source");
        imgWidth=temp[1];
        imgHeight=temp[2];

        loadFloorImage();
    });
}

function loadFloorImage()
{
    canvas = document.getElementById("floorCanvas");
    ctx = canvas.getContext('2d');
    image = new Image();
    image.onload = function () {
        alert("Drawing image");
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
    alert("Drawing image");
    drawImageOnCanvas();
};
}

function drawImageOnCanvas() {

     ctx.drawImage(image,0,0,600,575);
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
    floorImages[0].style.display="block";
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
    floorImages[1].style.display="block";
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