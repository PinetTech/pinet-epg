function renderLabel(text) {
    var template = '<div class="select__label">{{text}}<i class="fa fa-times"></i></div>';
    return $(template.replace("{{text}}", text));
}

function updateLabel(sel, text) {
    var label = renderLabel(text);
    $(sel).append(label);
}

function initialize() {
    var tab = initTab(); 
    if($('.actionbar .fa-times').length > 0) {
        $('.actionbar .fa-times').removeInputVal();
    }    

    $('.movietypes .sub-navi > li.active').each(function(i){
    	var self = $(this);
    	var rendertext = self.text();
    	updateLabel('.select', rendertext);
    });    
}