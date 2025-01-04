const siteHeader = document.querySelector('.site-header .inner');
const megamenu = document.querySelector('.has-custom-submenu');
const navbarButtons = document.querySelector('.navbar-buttons');
const mainNav = document.querySelector('.main-navigation');
const navWrap = document.querySelector('.menu-menu-1-container');
const contentNav = document.querySelector('.content-nav');
const navbarButtonsWrap = document.querySelector('.navbar-buttons-wrap');

/**
 * Initializes the Megamenu functionality and handles click and resize events.
 *
 * @return {void}
 */
function Megamenu() {
    let isActive = false;
    let contentNavHeight = calcContentNavHeight();

    moveContentNav();

    window.addEventListener('resize', () => {
        // setTimeout(() => {
            contentNavHeight = calcContentNavHeight();
            moveContentNav();
        // }, "300");
    });

    // megamenu.addEventListener('click', (e) => {
    //     e.preventDefault();
    //     isActive = megamenu.classList.toggle('active');
    //     contentNav.classList.toggle('show', isActive);
    //     contentNav.style.height = isActive ? `${contentNavHeight}px` : null;
    // })
}

/**
 * Calculate the total height of the content navigation.
 *
 * @return {number} The total height of the content navigation.
 */
function calcContentNavHeight() {
    return Array.from(contentNav.children).reduce((acc, child) => {
        return acc + child.offsetHeight
    }, 0);
}

/**
 * Moves the content navigation based on the window width.
 *
 * @return {void}
 */
function moveContentNav() {
    if (window.matchMedia('(max-width: 992px)').matches) {
        // megamenu.appendChild(contentNav);
        navWrap.appendChild(navbarButtons);
    } else {
        // siteHeader.after(contentNav);
        navbarButtonsWrap.appendChild(navbarButtons);
    }
}

export {Megamenu};