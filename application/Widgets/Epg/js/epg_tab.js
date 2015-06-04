(function(){

	function overwriteTabController(swiper) {
		var s = swiper;

		s.updateActiveState = function(controlled) {
			var c = controlled;
			var newActiveIndex = s.activeIndex;
			snapIndex = Math.floor(newActiveIndex / s.params.slidesPerGroup);
			if (snapIndex >= s.snapGrid.length) snapIndex = s.snapGrid.length - 1;

			c.snapIndex = snapIndex;
			c.previousIndex = c.activeIndex;
			c.activeIndex = newActiveIndex;
			c.updateClasses();
		}

		s.controller = {
			setTranslate: function (translate, byController) {
				var controlled = s.params.control;
				var multiplier, controlledTranslate;
				function setControlledTranslate(c) {
					translate = c.rtl && c.params.direction === 'horizontal' ? -s.translate : s.translate;
					multiplier =  ( (c.wrapper.width()) / (s.slides.length / (s.slides.length - 1) ) ) / (s.maxTranslate() - s.minTranslate());
					controlledTranslate = (translate - s.minTranslate()) * multiplier + c.minTranslate();
					if (s.params.controlInverse) {
						controlledTranslate = c.maxTranslate() - controlledTranslate;
					}
					c.updateProgress(controlledTranslate);
					c.setWrapperTranslate(controlledTranslate, false, s);
				}
				if (s.isArray(controlled)) {
					for (var i = 0; i < controlled.length; i++) {
						if (controlled[i] !== byController && controlled[i] instanceof Swiper) {
							setControlledTranslate(controlled[i]);
						}
					}
				}
				else if (controlled instanceof Swiper && byController !== controlled) {
					setControlledTranslate(controlled);
				}
			},
			setTransition: function (duration, byController) {
				var controlled = s.params.control;
				var i;
				function setControlledTransition(c) {
					c.setWrapperTransition(duration, s);
					if (duration !== 0) {
						c.onTransitionStart();
						c.wrapper.transitionEnd(function(){
							if (!controlled) return;
							c.onTransitionEnd();
						});
					}
				}
				if (s.isArray(controlled)) {
					for (i = 0; i < controlled.length; i++) {
						if (controlled[i] !== byController && controlled[i] instanceof Swiper) {
							setControlledTransition(controlled[i]);
						}
					}
				}
				else if (controlled instanceof Swiper && byController !== controlled) {
					setControlledTransition(controlled);
				}
			}
		};
	}

	function initTab(onTabNavClick, tabContentOptions, tabNavOptions) {
		var tab = {};
	    function clickHandle(e) {
	        var self = $(e.currentTarget);
	        var i = self.data('slide-index');
	        tab.content.slideTo(i);
	    }
	    tab.navOptions = {
	        slidesPerView: 'auto'
	    };
	    tab.navOptions = $.extend({}, { slidesPerView: 'auto' }, tabNavOptions);
	    tab.navOptions.onInit = function(swiper) {
	        var slides = swiper.slides;
	        if(slides.length > 0) {
	            slides.each(function(i){
	                var self = $(this);
	                self.data('slide-index', i);
	            });
	        }
	        swiper.wrapper.on('click', '.' + swiper.params.slideClass, clickHandle);   
	        if($.isFunction(onTabNavClick)) {
	        	onTabNavClick(swiper);
	        }
	    };
		tab.nav = new Swiper('.tab .tab__nav', tab.navOptions);
		tab.thumbsOptions = $.extend({}, { slidesPerView: 'auto' }, tabNavOptions);
		tab.nav.lockSwipes();
		tab.thumbs = new Swiper('.tab .tab__thumbs', tab.thumbsOptions);
		tab.thumbs.lockSwipes();
		tab.contentOptions = $.extend({}, tabContentOptions);
		tab.contentOptions.onSlideChangeEnd = function(swiper) {
			tab.nav.activeIndex = swiper.activeIndex;
			tab.nav.update();
			if($.isFunction(tab.contentOptions.changeState)) {
				tab.contentOptions.changeState(swiper);
			}
		}
		tab.content = new Swiper('.tab .tab__content', tab.contentOptions);
		tab.content.params.control = tab.thumbs;
		overwriteTabController(tab.content);

		function checkLocks(tab) {
			if($(window).width() < 768) {
				tab.content.unlockSwipes();
			}
			else {
				tab.content.lockSwipes();
			}
		}

		checkLocks(tab);

		$(window).resize(function(){
			checkLocks(tab);
		});

		return tab;
	}

	window.initTab = initTab;

})()