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

sub_tabs.forEach(tab => {
    sub_tab.addEventListener('click', () => {
        const sub_target = document.querySelector(tab.dataset.tabTarget)
        sub_tabContents.forEach(tabContent => {
            sub_tabContent.classList.remove('active')
        })
        tabs.forEach(tab => {
            sub_tab.classList.remove('active')
        })
        sub_target.classList.add('active');
        sub_tab.classList.add('active');
    })
})