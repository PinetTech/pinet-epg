function renderLabel(text) {
    var template = '<div class="select__label">{{text}}<i class="fa fa-times"></i></div>';
    return $(template.replace("{{text}}", text));
}

function updateLabel(sel, text) {
    var label = renderLabel(text);
    $(sel).append(label);
}

function initialize() {
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
}