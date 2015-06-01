function renderLabel(text) {
    var template = '<div class="select__label">{{text}}<i class="fa fa-times"></i></div>';
    return $(template.replace("{{text}}", text));
}

function updateLabel(sel, text) {
    var label = renderLabel(text);
    $(sel).append(label);
}

function initialize() {
    var slide = '';
    setTimeout(function(){
        slide = new Slide('.slide');
    }, 0);
    if($('.tab').length > 0) {
    	var tab = initTab();
    }

    if($('.select').length > 0) {
    	$('.select').on('click', '.select__label .fa-times', function(e){	
    		var self = $(e.currentTarget);
    		var selectLabel = self.parent();
    		// window.location.href = "http://www.baidu.com";
    	});
    }

    $('.movietypes .sub-navi > li.active').each(function(i){
    	var self = $(this);
    	var rendertext = self.text();
    	updateLabel('.select', rendertext);
    });
}

// updateLabel(".select__choose", "sdsd1");

$('.action').click(function(){
	//alert('dfsaf');
});