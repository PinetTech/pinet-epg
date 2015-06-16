function renderLabel(text) {
    var template = '<div class="select__label">{{text}}<i class="fa fa-times"></i></div>';
    return $(template.replace("{{text}}", text));
}

function updateLabel(sel, text) {
    var label = renderLabel(text);
    $(sel).append(label);
}

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

    function handletemplate() {
        var showShaftLoad = true;

        var source   = $("#movie-template").html();
        var template = Handlebars.compile(source); 
        var page = 0;

        var tabcontent = $('.tab').find('.tab__content');

        if(tabcontent.attr("more") && tabcontent.attr("more") != "" && tabcontent.attr("more") == "1") {
            $(window).on("scroll", scrollHandler);
        }

        function scrollHandler() {
            if(showShaftLoad 
                && $('.tab').find('.tab__content .movie-content:last-child .movie:nth-last-of-type(1)').length > 0 
                && $(document).scrollTop() > $('.tab').find('.tab__content .movie-content:last-child .movie:nth-last-of-type(1)').offset().top - 450) {
                showShaftLoad = false;
                $('.tab .shaft-load').addClass('show');
                $.post(Clips.siteUrl('search/getMore/'+(++page)), {

                }, function(data){
                    if(data && data.movies && data.movies.length > 0) {
                        var pagesection = $('<div class="movie-content" page="'+ (++page) +'"></div>');
                        $('.tab').find('.tab__content .swiper-slide .pages-container').append(pagesection);                
                        $(data.movies).each(function(k, v){
                            console.log(v);
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
            content.page = ++page;
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

    if($("#movie-template").length > 0) {
        handletemplate();
    }       
});