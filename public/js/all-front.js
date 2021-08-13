

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

// $(window).scroll(function() {
//     var scroll = $(window).scrollTop();
//
//     if (scroll >= 50) {
//         $("body").addClass("nav-scroll");
//     } else {
//         $("body").removeClass("nav-scroll");
//     }
// });

// profile menu dropdown
// $(function() {
//     $('.dropdown-open').click(function() {
//         $(this).next('.profile-dropdown').slideToggle(200);
//         $(".dropdown-open").toggleClass('active');
//     });
// });

// profile upload image
// $(function(){
//     var container = $('.profile-company-img'), inputFile = $('#file'), img, btn, txt = 'Browse', txtAfter = "";
//
//     if(!container.find('#upload').length){
//         container.find('.input-div').append('<input type="button" value="'+txt+'" id="upload">');
//         btn = $('#upload');
//         container.prepend('<img src="" class="hidden" alt="" id="uploadImg" height="109" width="200">');
//         img = $('#uploadImg');
//     }
//
//     btn.on('click', function(){
//         img.animate({opacity: 0}, 300);
//         inputFile.click();
//     });
//
//     inputFile.on('change', function(e){
//         container.find('label').html( inputFile.val() );
//
//         var i = 0;
//         for(i; i < e.originalEvent.srcElement.files.length; i++) {
//             var file = e.originalEvent.srcElement.files[i],
//                 reader = new FileReader();
//
//             reader.onloadend = function(){
//                 img.attr('src', reader.result).animate({opacity: 1}, 700);
//             }
//             reader.readAsDataURL(file);
//             img.removeClass('hidden');
//         }
//         btn.val(txtAfter);
//     });
// });

// profile menu mobile open
// $(document).ready(function (){
//     $(".open-menu-filter").click(function () {
//         $(".profile-menu").toggleClass("profile-menu-open");
//         $("body").toggleClass("opened-menu");
//     });
// })

// event price open
// $(document).ready(function (){
//     $(".open-price").click(function () {
//         $(".price-section").toggleClass("price-section-open");
//         $("body").toggleClass("price-section-opened");
//     });
// })



