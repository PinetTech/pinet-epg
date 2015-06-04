function initialize() {
    var tab = initTab(function(swiper){
        swiper.wrapper.on('click', '.' + swiper.params.slideClass + ' a', function(e){
            e.preventDefault();
        });           
    },{
    	onInit: function(swiper) {
    		var slides = swiper.slides;
    		swiper.contentHeight = [];
    		$(slides).each(function(i){
    			var self = $(this);
    			swiper.contentHeight.push(self.height() + 120);
    		});
    		swiper.wrapper.height(swiper.contentHeight[swiper.activeIndex]);
    	},
    	changeState: function(swiper) {
    		swiper.wrapper.height(swiper.contentHeight[swiper.activeIndex]);
    	}
    }); 		
}