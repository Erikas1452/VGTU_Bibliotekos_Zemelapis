const mainTabButtons=document.querySelectorAll(".tabButtons button");
const mainTabContents=document.querySelectorAll(".tabContent");

function showContent(contentIndex)
{
    mainTabButtons.forEach(function(node){
        node.style.borderBottom="";
        node.style.color="";

    });
    mainTabButtons[contentIndex].style.borderBottom="3px solid #269BF0";
    mainTabButtons[contentIndex].style.color="#269BF0";
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
        node.style.borderBottom="";
    });
    subTabButtons[subContentIndex].style.backgroundColor="transparent";
    subTabButtons[subContentIndex].style.color="#269BF0";
    subTabButtons[subContentIndex].style.borderBottom="3px solid #269BF0";
    subTabContents.forEach(function(node) {
        node.style.display ="none";
    });
    subTabContents[subContentIndex].style.display="block";
}

showContent(0);
showSubContent(0);