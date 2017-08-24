window.addEventListener('load', () => {
    let toggle = document.querySelector('#masthead-nav-toggle');
    let nav = document.querySelector('#masthead-nav');
    toggle.addEventListener('click', () => {
        toggle.classList.toggle('closed');
        nav.classList.toggle('closed');
    });
});
