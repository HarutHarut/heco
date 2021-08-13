

const myModal = new HystModal({
    linkAttributeName: "data-hystmodal",
});


// Dropdown toggle
$(function() {
    $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown').slideToggle(200);
    });

    $(document).click(function(e) {
        var target = e.target;
        if (!$(target).is('.dropdown-toggle') && !$(target).parents().is('.dropdown-toggle'))
        { $('.dropdown').slideUp(200); }
    });
});


// right menu
$(document).ready(function (){
    $("#open-menu").click(function () {
        $(".navbar-menu-container").addClass("navbar-menu-opened");
    });
    $("#close-menu").click(function () {
        $(".navbar-menu-container").removeClass("navbar-menu-opened");
    });
})

$(window).scroll(function() {
    var scroll = $(window).scrollTop();

    if (scroll >= 10) {
        $("body").addClass("page-scroll");
    } else {
        $("body").removeClass("page-scroll");
    }
});


// profile menu mobile open
$(document).ready(function (){
    // $(".open-menu-filter").click(function () {
    //     $(".profile-menu").toggleClass("profile-menu-open");
    //     $("body").toggleClass("opened-menu");
    // });

    $('.open-menu-filter').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();

        $('.profile-menu').toggleClass('profile-menu-open');
        $('body').toggleClass('opened-menu');

        $(document).one('click', function closeMenu (e){
            if($('.profile-menu').has(e.target).length === 0){
                $('.profile-menu').removeClass('profile-menu-open');
                $('body').removeClass('opened-menu');
            } else {
                $(document).one('click', closeMenu);
            }
        });
    });
})


// First we get the viewport height and we multiple it by 1% to get a value for a vh unit
let vh = window.innerHeight * 0.01;
// Then we set the value in the --vh custom property to the root of the document
document.documentElement.style.setProperty('--vh', `${vh}px`);

window.addEventListener('resize', () => {
    // We execute the same script as before
    let vh = window.innerHeight * 0.01;
    document.documentElement.style.setProperty('--vh', `${vh}px`);
});



