(function(){

    var isIE = document.all && !window.atob;
    if(isIE) {
        $('html').addClass('ie9');
    }

    var customStyles = {};

    customStyles.parse = function(customStyleSheet) {
        var style = customStyleSheet.replace(/'/g,'');
        style = style.replace(/\\/g,'').replace(/^"/g,'').replace(/"$/,'');
        return JSON.parse(style);
    }


    $.getCustomSelectorStyle = function(sel) {
        if(!$.stylesheet('[custom-prop-settings]').rules()[0]) {
            return false;
        }
        var settings = customStyles.parse($.stylesheet('[custom-prop-settings]').rules()[0].style.content);

        var customSel = $.trim(sel) + settings.selector;
        if(!$.isFunction($.stylesheet)) {
            return false;
        }

        if($.stylesheet(customSel).rules()[0]) {
            return customStyles.parse($.stylesheet(customSel).rules()[0].style.content);
        }
        return false;
    }

    $('[data-trigger]').on('click', function(){
        var self = $(this);
        var triggerEle = $(self.data('trigger'));
        triggerEle.toggleClass('open');
        triggerEle.parent().toggleClass('full-screen');
    });

    setInterval(function(){
        if($(window).width() < 768 && $('.menu').length > 0 && $('.menu li').length > 0) {
            $('.menu').resizeMenu();
        }
    }, 30);

    $.fn.hasContentState = function() {        
        var self = $(this);
        var dirtyCheckHandle = function(){
            if(self.val().length > 0) {
                self.addClass('has-content');
            }
            else {
                self.removeClass('has-content');
            }
        };
        var interval = 0;
        self.on('focus', function() {
            interval = setInterval(dirtyCheckHandle, 30);
        });
        self.on('blur', function(){
            clearInterval(interval);
        });
    }

    $.fn.removeInputVal = function() {
        var self = $(this);
        var ele = $(self.attr("remove-input-val-trigger"));
        if(ele.length > 0) {
            self.on('click', function(){
                ele.val('');
            });
        }
    }

    $.fn.resizeAdpat = function(lvc) {
        var self = $(this);     
        if($(window).width() > 1280) {
            self.height($(window).width() * lvc);   
        }
        else {
            self.removeAttr("style");
        }
        $(window).resize(function(){
            if($(window).width() > 1280) {
                self.height($(window).width() * lvc);
            }
            else {
                self.removeAttr("style");
            }            
        });
    }

    $.fn.resizeMenu = function() {
        var self = $(this);
        var menuWidth = $('.menu').width();
        var menuliWidth = $('.menu li').width();
        var menuHeight = $('.menu').height();
        var menuliHeight = $('.menu li').height();
        var mal = parseInt((menuWidth - menuliWidth * 2) / 3);
        var mat = parseInt((menuHeight - menuliHeight * 4) / 5);        
        var isWebkit = 'WebkitAppearance' in document.documentElement.style;     
        if (isWebkit && window.navigator.userAgent.match(/Chrome\/([\d.]+)/) && parseInt(window.navigator.userAgent.match(/Chrome\/([\d.]+)/)[1]) < 19) {
            self.height($(window).height() - self.prev().height());
        }        
        $('.menu li').each(function(i){             
            $(this).css({
                'margin-left': mal,
                'margin-top': mat
            });
        });
    }

    $.fn.fixCalc = function() {
        var isWebkit = 'WebkitAppearance' in document.documentElement.style;     
        if (isWebkit && window.navigator.userAgent.match(/Chrome\/([\d.]+)/) && parseInt(window.navigator.userAgent.match(/Chrome\/([\d.]+)/)[1]) < 19) {
            var self = $(this);
            var prevHeight = self.prev().height();
            var nextHeight = self.next().height();
            self.height($(window).height() - prevHeight - nextHeight);
        }
    }      

})();

$(function(){
    if($('.error-message').length > 0) {
        $('.error-message').resizeAdpat(0.3);
    }

    if($('.error-bgc').length > 0) {
        $('.error-bgc').resizeAdpat(0.37);   
    }

    if($('#field_search').length > 0) {
        $('#field_search').each(function(){
            $(this).hasContentState();
        })
    }
});
