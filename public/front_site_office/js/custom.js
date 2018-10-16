$(document).ready(function(){
let hash = window.location.hash;
$('a').closest('li').removeClass('active');
$('a[href=\"' + hash + '\"]').closest('li').addClass('active');


    $("a[href^='#']").click(function(e) {
        var position = $($(this).attr("href")).offset().top ;
        $("body, html").animate({
            scrollTop: position - 100
        } ,800 );
    });
    $(".owl-carousel").owlCarousel({
        navigation : true,
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem: true,
        pagination: true,
        navContainer: '#customNav',
        // dotsContainer: '#customDots',
        items:1
    });
    $('.tz-select-insc option[value="2"]').attr("selected",true);
    $('.tz-select-insc').parent().parent().css("display","none");
    $('.inputfile').parent().parent().addClass('btn btn-primary tz-btn-primary')
    $('.owl-prev').addClass('btn btn-primary tz-btn-slide');
    $('.owl-next').addClass('btn btn-primary tz-btn-slide');
    $('.tz-tache,.tz-voeux').parent().css("display","none");
});