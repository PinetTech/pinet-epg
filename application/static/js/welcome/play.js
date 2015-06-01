function initialize() {
    var tab = initTab(function(swiper){
        swiper.wrapper.on('click', '.' + swiper.params.slideClass + ' a', function(e){
            e.preventDefault();
        });           
    }); 	
}