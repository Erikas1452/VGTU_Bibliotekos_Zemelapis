let floorImages;

let mainTabButtons;
let mainTabContents;

let subTabButtons;
let subTabContents;

function loadTab(mapID,tabID) {
    $(document).ready(function(){
        $("#tabContent").load("loadMainTab.php",{
            map: mapID
        });
        refreshData();
        showContent(tabID);
    });
}

function loadSubTab(mapID,tabID) {
    $(document).ready(function(){
        $("#subTabContent").load("loadSubTab.php",{
            map: mapID
        });
        refreshData();
        showSubContent(tabID);
    });
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