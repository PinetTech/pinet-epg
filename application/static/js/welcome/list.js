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
                    // multiplier = (c.maxTranslate() - c.minTranslate()) / (s.maxTranslate() - s.minTranslate());
                    // controlledTranslate = (translate - s.minTranslate()) * multiplier + c.minTranslate();
                    // if (s.params.controlInverse) {
                    //     controlledTranslate = c.maxTranslate() - controlledTranslate;
                    // }
                    multiplier =  ( (c.wrapper.width()) / (s.slides.length / (s.slides.length - 1) ) ) / (s.maxTranslate() - s.minTranslate());
                    controlledTranslate = (translate - s.minTranslate()) * multiplier + c.minTranslate();
                    if (s.params.controlInverse) {
                        controlledTranslate = c.maxTranslate() - controlledTranslate;
                    }   
                    console.log(c.slides.length);
                    // console.log(controlledTranslate);
                    c.updateProgress(controlledTranslate);
                    c.setWrapperTranslate(controlledTranslate, false, s);
                    // s.updateActiveState(c);
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

    var tab = {};
    tab.navOptions = {
        slidesPerView: 'auto'
    };
    tab.nav = new Swiper('.tab .tab__nav', tab.navOptions);
    tab.thumbsOptions = {
        slidesPerView: 'auto'
    };
    tab.nav.lockSwipes();
    tab.thumbs = new Swiper('.tab .tab__thumbs', tab.thumbsOptions);
    tab.thumbs.lockSwipes();
    tab.contentOptions = {
        spaceBetween: 10,
        slidesPerView: 'auto'
    };
    tab.contentOptions.onSlideChangeEnd = function(swiper) {
        console.log(swiper);
        tab.nav.activeIndex = swiper.activeIndex;
        tab.nav.update();
    }
    tab.content = new Swiper('.tab .tab__content', tab.contentOptions);
    tab.content.lockSwipes();
    tab.content.params.control = tab.thumbs;
    overwriteTabController(tab.content);

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
    }
    
    // updateLabel(".select__choose", "sdsd1");