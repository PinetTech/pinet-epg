(function(){
    function updatePAS(swiper) {
        var slides = swiper.slides;
        var pas = swiper.paginationContainer.children();
        if(slides.length > 0) {
            var originHeight = $(pas).not(function(index, ele){
                return $(ele).attr('class').indexOf('active') > -1;
            }).height();
            if(!swiper.upt) {
                swiper.upt = true;
                swiper.paginationContainer.height(originHeight);                        
            }
            slides.each(function(i){
                if(pas[i]) {
                    var img = slides.eq(i).find('img');
                    if(img.length > 0) {
                        var src = '';
                        img.load(function(){
                            if(img.attr('data-pagination-src') && img.attr('data-pagination-src') != '') {
                                src = img.attr('data-pagination-src');
                            }
                            else {
                                src = img.attr('src');
                            }                            
                            $.stylesheet('.swiper-pagination-bullet:nth-child(' + (i+1) + ')').css({
                                'background-image': 'url(' + src + ')'
                            });
                        });
                    }
                }
            });
        }   
    }

    var slideOptions = {
        nextButton: '.slide .swiper-button-next',
        prevButton: '.slide .swiper-button-prev',
        spaceBetween: 10,
        pagination: '.swiper-pagination',
        paginationClickable: true,
        paginationBulletRender: function (index, className) {
            return '<span class="' + className + '">' + (index + 1) + '</span>';
        }                   
    };

    slideOptions.onInit = function(swiper) {
        updatePAS(swiper);
    };

    var Slide = function Slide(sel) {
    	return new Swiper(sel, slideOptions);
    };

    window.Slide = Slide;
})()