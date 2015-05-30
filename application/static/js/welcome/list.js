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
    var tab = initTab();
}

// updateLabel(".select__choose", "sdsd1");