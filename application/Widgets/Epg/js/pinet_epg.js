(function(){

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

    $.fn.hasContentState = function() {        
        var self = $(this);
        setInterval(function(){
            if(self.val().length > 0) {
                self.addClass('has-content');
            }
            else {
                self.removeClass('has-content');
            }

        }, 30);
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

    $.fn.resizeAdpat = function() {
        var self = $(this);     
        if($(window).width() > 1280) {
            self.height($(window).width() * 0.3);   
        }
        else {
            self.removeAttr("style");
        }
        $(window).resize(function(){
            if($(window).width() > 1280) {
                self.height($(window).width() * 0.3);
            }
            else {
                self.removeAttr("style");
            }            
        });
    }

    if($('#field_search').length > 0) {
        $('#field_search').each(function(){
            $(this).hasContentState();
        })
    }
})();

$(function(){
    if($('.error-message').length > 0) {
        $('.error-message').resizeAdpat();
    }
});
