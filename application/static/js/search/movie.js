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

var showShaftLoad = true;

$(window).scroll(function(){
    if(showShaftLoad && $(document).scrollTop() > $('.tab').find('.tab__content .movie-content:last-child .movie:nth-last-of-type(1)').offset().top - 450) {
        showShaftLoad = false;
        $('.tab .shaft-load').addClass('show');
    }        
});

var source   = $("#movie-template").html();
var template = Handlebars.compile(source); 
var page = 0;

function render(context, content) {
    var html = template(content);
    content.page = ++page;
    $('.tab').find(context).append(html);
}

var content = {sourceurl: 'test/01.png', asset_name:"sdsdsds", area:"sdsdsd", program_type_name:"sdsdsds", summary_short:"sdsdsds", url:"sdsds"};
setTimeout(function(){
    var pagesection = $('<div class="movie-content" page="'+ (++page) +'"></div>');
    $('.tab').find('.tab__content .swiper-slide .pages-container').append(pagesection);
    for(var i =0; i < 10; i++) {
        render(pagesection, content);
    }
    $('.tab .shaft-load').removeClass('show');
    $('.tab').find('.movie[page]').each(function(i){
        var self = $(this);
        var width = self.find(".responsive").width();
        var source = self.find(".responsive").attr("data-image");
        self.find('.responsive img').attr("src", Clips.siteUrl("responsive/size/"+width+"/"+source));
    });
    showShaftLoad = true;
}, 10000);



}