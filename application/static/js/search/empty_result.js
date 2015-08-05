$(function(){
    if($('.tab').length > 0) {
        var tab = initTab(function(swiper){
            // swiper.wrapper.on('click', '.' + swiper.params.slideClass + ' a', function(e){
            //     e.preventDefault();
            // });           
        });  
        tab.nav.unlockSwipes();
    }
    if($('.actionbar .fa-times').length > 0) {
        $('.actionbar .fa-times').removeInputVal();
    }    

    $.stylesheet('html, body').css({
        height: $(window).height() + 'px'
    });

    if($('.empty-result').length > 0) {
        $('.empty-result').fixCalc();
    }      
});