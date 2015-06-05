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
    	var tab = initTab(function(){}, {
            slidesPerView: 'auto'
        });

        updateActiveContent(tab);
        tab.content.unlockSwipes();        
    }

    function updateActiveContent(tab) {
        // var index = tab.nav;
        var slides = tab.nav.slides;
        var index = -1;

        $(slides).each(function(i){
            var self = $(this);
            if(self.hasClass('active')) {
                index = i;
            }
        });

        if(index > -1) {
            tab.content.slideTo(index);        
        }
    }

    var showShaftLoad = true;

    var source   = $("#movie-template").html();
    var template = Handlebars.compile(source); 
    var page = 0;

    var tabcontent = $('.tab').find('.tab__content .movie-content');

    if(tabcontent.attr("more") && tabcontent.attr("more") != "" && tabcontent.attr("more") == "1") {
        $(window).on('scroll', scrollHandler);
    }

    function scrollHandler() {
        if(showShaftLoad && $(document).scrollTop() > $('.tab').find('.tab__content .movie-content .movie:nth-last-of-type(1)').offset().top - 450) {
            showShaftLoad = false;
            $('.tab .shaft-load').addClass('show');
            $.post(Clips.siteUrl('movie/getMore/'+(++page)), {

            }, function(data){
                if(data && data.movies && data.movies.length > 0) {
                    var pagesection = $('.tab .tab__content .movie-content');
                    $(data.movies).each(function(k, v){
                        v.url = Clips.siteUrl("movie/play/"+v.id);
                        render(pagesection, v);
                    });
                    prepare();
                }
                else {
                    $('.tab .shaft-load').removeClass('show');
                }
            }, 'json');            
        }                
    }

    function render(context, content) {
        var html = template(content);
        $('.tab').find(context).append(html);
    }

    function prepare() {
        $('.tab .shaft-load').removeClass('show');
        $('.tab').find('.movie[page]').each(function(i){
            var self = $(this);
            var width = self.find(".responsive").width();
            var source = self.find(".responsive").attr("data-image");
            self.find('.responsive img').attr("src", Clips.siteUrl("responsive/size/"+width+"/"+source));
        });
        showShaftLoad = true;                
    }    
}

// updateLabel(".select__choose", "sdsd1");