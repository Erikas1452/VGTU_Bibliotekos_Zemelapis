const tabs = document.querySelectorAll('[data-tab-target]')
const tabContents = document.querySelectorAll('[data-tab-content]')

const sub_tabs = document.querySelectorAll('[data-tab-target]')
const sub_tabContents = document.querySelectorAll('[data-tab-content]')

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        const target = document.querySelector(tab.dataset.tabTarget)
        tabContents.forEach(tabContent => {
            tabContent.classList.remove('active')
        })
        tabs.forEach(tab => {
            tab.classList.remove('active')
        })
        target.classList.add('active');
        tab.classList.add('active');
    })
})

const mainTabButtons=document.querySelectorAll(".tabButtons button");
const mainTabContents=document.querySelectorAll(".tabContent");

function showContent(contentIndex)
{
    mainTabButtons.forEach(function(node){
        node.style.backgroundColor="";
        node.style.color="";
    });
    mainTabButtons[contentIndex].style.backgroundColor="red";
    mainTabButtons[contentIndex].style.color="white";
    mainTabContents.forEach(function(node){
        node.style.display="none";
    });
    mainTabContents[contentIndex].style.display="block";
}