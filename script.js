let floorImages=document.querySelectorAll(".tabContent .floorImage");

let mainTabButtons=document.querySelectorAll(".tabButtons button");
let mainTabContents=document.querySelectorAll(".tabContent");

let subTabButtons=document.querySelectorAll(".tabContent .subTabButtons button");
let subTabContents=document.querySelectorAll(".tabContent .subTabContent");

function showContent(contentIndex)
{
    resetMainTabButtons();
    resetSubTabButtons();
    hideSubContent();

    floorImages[contentIndex].style.display="block";
    mainTabButtons[contentIndex].style.borderBottom="3px solid #269BF0";
    mainTabButtons[contentIndex].style.color="#269BF0";
    hideMainTabButtons();
    mainTabContents[contentIndex].style.display="block";
}

function showSubContent(subContentIndex)
{
    hidefloorImages();
    resetSubTabButtons();
    subTabButtons[subContentIndex].style.backgroundColor="transparent";
    subTabButtons[subContentIndex].style.color="#269BF0";
    subTabButtons[subContentIndex].style.borderBottom="3px solid #269BF0";
    hideSubContent();
    subTabContents[subContentIndex].style.display="block";
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