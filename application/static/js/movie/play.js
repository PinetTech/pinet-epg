(function(){

    function checkPoster(player, mobileposter, desktopposter) {
        if($(window).width() < 768) {
            player.poster(mobileposter);
        }   
        else {
            player.poster(desktopposter);
        }   
    }

    function setPoster(player, mobileposter, desktopposter) {
        checkPoster(player, mobileposter, desktopposter);
        $(window).resize(function(){
            checkPoster(player, mobileposter, desktopposter);
        });
    }   

    window.checkPoster = checkPoster;
    window.setPoster = setPoster;

})()

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