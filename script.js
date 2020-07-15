const mainTabButtons=document.querySelectorAll(".tabButtons button");
const mainTabContents=document.querySelectorAll(".tabContent");

function showContent(contentIndex)
{
    mainTabButtons.forEach(function(node){
        node.style.borderBottom="";
        node.style.color="";

    });
    mainTabButtons[contentIndex].style.borderBottom="3px solid cyan";
    mainTabContents.forEach(function(node){
        node.style.display="none";
    });
    mainTabContents[contentIndex].style.display="block";
}

const subTabButtons=document.querySelectorAll(".tabContent .subTabButtons button");
const subTabContents=document.querySelectorAll(".tabContent .subTabContent");

function showSubContent(subContentIndex)
{
    subTabButtons.forEach(function(node){
        node.style.backgroundColor="";
        node.style.color="";
    });
    subTabButtons[subContentIndex].style.backgroundColor="blue";
    subTabButtons[subContentIndex].style.color="white";
    subTabContents.forEach(function(node) {
        node.style.display ="none";
    });
    subTabContents[subContentIndex].style.display="block";
}

showContent(0);
showSubContent(0);