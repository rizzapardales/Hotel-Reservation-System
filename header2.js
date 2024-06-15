window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    var navbar = document.querySelector('.navbar');
    if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
        navbar.classList.add('fixed-navbar');
    } else {
        navbar.classList.remove('fixed-navbar');
    }
}
