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

})();
