'use strict';

window.addEventListener('load', function() {
    var toggle = document.querySelector('#masthead-nav-toggle');
    var nav = document.querySelector('#masthead-nav');
    toggle.addEventListener('click', function() {
        toggle.classList.toggle('closed');
        nav.classList.toggle('closed');
    });
});
