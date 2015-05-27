    // function updatePAS(swiper) {
    //     var slides = swiper.slides;
    //     var pas = swiper.paginationContainer.children();
    //     if(slides.length > 0) {
    //         var originHeight = $(pas).not(function(index, ele){
    //             return $(ele).attr('class').indexOf('active') > -1;
    //         }).height();
    //         if(!swiper.upt) {
    //             swiper.upt = true;
    //             swiper.paginationContainer.height(originHeight);                        
    //         }
    //         slides.each(function(i){
    //             if(pas[i]) {
    //                 var img = slides.eq(i).find('img');
    //                 if(img.length > 0) {
    //                     var src = '';
    //                     img.load(function(){
    //                         if(img.attr('data-pagination-src') != '') {
    //                             src = img.attr('data-pagination-src');
    //                         }
    //                         else {
    //                             src = img.attr('src');
    //                         }                            
    //                         $.stylesheet('.swiper-pagination-bullet:nth-child(' + (i+1) + ')').css({
    //                             'background-image': 'url(' + src + ')'
    //                         });
    //                     });
    //                 }
    //             }
    //         });
    //     }   
    // }

    function initialize() {
        var slide = '';
        setTimeout(function(){
            slide = new Slide('.slide');
        }, 0);
    }
    var style = $.getCustomSelectorStyle('.slide .swiper-pagination-bullet:nth-child(n+1)');

    // if(customStyleSheet != '') {
    //     var style = JSON.parse(customStyleSheet);
    //     var scale = style.scale;
    //     var minscale = style.minscale.replace('px', '');
    //     var autostart = style.autostart;
    // }

    // function changePanginationStyle() {
    //     var width = $('.swiper-pagination-bullet-active').width();
    //     if((width * scale) > minscale) {
    //         $.stylesheet('.swiper-pagination-bullet-active').css({
    //             'height': 64 * scale
    //         });
    //     }
    //     else {
    //         $.stylesheet('.swiper-pagination-bullet-active').css({
    //             'height': minscale
    //         });            
    //     }
    // }

    // $(window).resize(function() {
    //     changePanginationStyle();
    // });


    // var slideOptions = {
    //     nextButton: '.slide .swiper-button-next',
    //     prevButton: '.slide .swiper-button-prev',
    //     spaceBetween: 10,
    //     pagination: '.swiper-pagination',
    //     paginationClickable: true,
    //     paginationBulletRender: function (index, className) {
    //         return '<span class="' + className + '">' + (index + 1) + '</span>';
    //     }                   
    // };

    // var sta = {};

    // slideOptions.onInit = function(swiper) {
    //     swiper.upt = false;
    //     updatePAS(swiper);
    //     // changePanginationStyle();
    // }

    // var slide = new Swiper('.slide', slideOptions);   

    // slide.onResize = function(swiper) {
    //     updatePAS(swiper);
    // }   

    // var tab = {};

    // function clickHandle(e) {
    //     var self = $(e.currentTarget);
    //     var i = self.data('slide-index');
    //     tab.content.slideTo(i);
    // }
    // tab.navOptions = {
    //     slidesPerView: 'auto'
    // };
    // tab.navOptions.onInit = function(swiper) {
    //     var slides = swiper.slides;
    //     if(slides.length > 0) {
    //         slides.each(function(i){
    //             var self = $(this);
    //             self.data('slide-index', i);
    //         });
    //     }
    //     swiper.wrapper.on('click', '.' + swiper.params.slideClass, clickHandle);        
    // }
    // tab.nav = new Swiper('.tab .tab__nav', tab.navOptions);
    // tab.thumbsOptions = {
    //     slidesPerView: 'auto'
    // };
    // tab.nav.lockSwipes();
    // tab.thumbs = new Swiper('.tab .tab__thumbs', tab.thumbsOptions);
    // tab.thumbs.lockSwipes();    
    // tab.contentOptions = {
    //     spaceBetween: 10,
    //     slidesPerView: 'auto'
    // };
    // tab.contentOptions.onSlideChangeEnd = function(swiper) {
    //     console.log(swiper);
    //     tab.nav.activeIndex = swiper.activeIndex;
    //     tab.nav.update();
    // }
    // tab.content = new Swiper('.tab .tab__content', tab.contentOptions);
    // tab.content.params.control = tab.thumbs;
    // overwriteTabController(tab.content);