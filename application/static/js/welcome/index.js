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
                    var img = slides.eq(i).children('img');
                    if(img.length > 0) {
                        $.stylesheet('.swiper-pagination-bullet:nth-child(' + (i+1) + ')').css({
                            'background-image': 'url(' + img.attr('src') + ')'
                        });
                    }
                }
            });
        }   
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

    var sta = {};

    slideOptions.onInit = function(swiper) {
        swiper.upt = false;
        updatePAS(swiper);
        // changePanginationStyle();
    }

    var slide = new Swiper('.slide', slideOptions);   

    slide.onResize = function(swiper) {
        updatePAS(swiper);
    }

    function overwiteController(swiper) {
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
                    multiplier = (c.maxTranslate() - c.minTranslate()) / (s.maxTranslate() - s.minTranslate());
                    controlledTranslate = (translate - s.minTranslate()) * multiplier + c.minTranslate();
                    if (s.params.controlInverse) {
                        controlledTranslate = c.maxTranslate() - controlledTranslate;
                    }
                    c.updateProgress(controlledTranslate);
                    c.setWrapperTranslate(controlledTranslate, false, s);
                    s.updateActiveState(c);
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

    var thumbsOptions = {
        // spaceBetween: 10,
        slidesPerView: 'auto'
    };

    var thumbs = new Swiper('.swiper-thumbs', thumbsOptions);

    slide.params.control = thumbs;
    overwiteController(slide);

    var sctOptions = {
        slidesPerView: 'auto'
    }

    function clickHandle(e) {
        var self = $(e.currentTarget);
        var i = self.data('slide-index');
        slide.slideTo(i % 5);
    }

    sctOptions.onInit = function(swiper) {
        var slides = swiper.slides;
        if(slides.length > 0) {
            slides.each(function(i){
                var self = $(this);
                self.data('slide-index', i);
            });
        }
        swiper.wrapper.on('click', '.' + swiper.params.slideClass, clickHandle);
    }

    var sct = new Swiper('.slidecator', sctOptions);


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
                    multiplier =  ( (c.wrapper.width()) / (s.slides.length / (s.slides.length - 1) ) ) / (s.maxTranslate() - s.minTranslate())  ;
                    controlledTranslate = (translate - s.minTranslate()) * multiplier + c.minTranslate();
                    if (s.params.controlInverse) {
                        controlledTranslate = c.maxTranslate() - controlledTranslate;
                    }   
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

    function clickHandle(e) {
        var self = $(e.currentTarget);
        var i = self.data('slide-index');
        tab.content.slideTo(i);
    }
    tab.navOptions = {
        slidesPerView: 'auto'
    };
    tab.navOptions.onInit = function(swiper) {
        var slides = swiper.slides;
        if(slides.length > 0) {
            slides.each(function(i){
                var self = $(this);
                self.data('slide-index', i);
            });
        }
        swiper.wrapper.on('click', '.' + swiper.params.slideClass, clickHandle);        
    }
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
        // tab.nav.slideTo(swiper.activeIndex);
        // console.log(tab.nav.updateActiveIndex);
        // tab.nav.updateActiveIndex(swiper.activeIndex);
        tab.nav.activeIndex = swiper.activeIndex;
        tab.nav.update();
    }
    tab.content = new Swiper('.tab .tab__content', tab.contentOptions);
    tab.content.params.control = tab.thumbs;
    overwriteTabController(tab.content);