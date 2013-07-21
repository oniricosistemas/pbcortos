// JavaScript Document
$(document).ready(function(){
    // BROWSER Detection //
    var browser=navigator.appName;
    var b_version=navigator.appVersion;
    var version=parseFloat(b_version);

    // Using browser detection to disable the jQuery Blend effect on the main menu in IE6 and Opera - z-index issues //

    /*if (b_version.indexOf("MSIE 6.0")==-1 && browser.indexOf("Opera")==-1 && b_version.indexOf("MSIE 7.0")==-1) {
    $("#menu_group_main a").blend();
    }    */

    // I have used IF statements to avoid missing elements or functions on pages. //
    // The effects will work only if the linked element exists in the document    //

    if ( $("#main").length > 0 ) {

        $(".portlet").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
        .find(".portlet-header")
        .addClass("ui-widget-header ui-corner-top")
        .prepend('<span class="ui-icon ui-icon-triangle-1-n ui-icon-triangle-1-s"></span>')
        .end()
        .find(".portlet-content");
        // We make arrow button on any portlet header to act as a switch for sliding up and down the portlet content //
        $(".portlet-header .ui-icon").click(function() {
            $(this).parents(".portlet:first").find(".portlet-content").slideToggle("fast");
            $(this).toggleClass("ui-icon-triangle-1-s");
            return false;
        });

        // We create the protlets and style them accordingly by script //
        $(".portlet2").addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
        .find(".portlet2-header")
        .addClass("ui-widget-header ui-corner-top")
        .prepend('<span class="ui-icon ui-icon-triangle-1-n"></span>')
        .end()
        .find(".portlet2-content");
        // We make arrow button on any portlet header to act as a switch for sliding up and down the portlet content //
        $(".portlet2-header .ui-icon").click(function() {
            $(this).parents(".portlet2:first").find(".portlet2-content").slideToggle("fast");
            $(this).toggleClass("ui-icon-triangle-1-s");
            return false;
        });
    }

});
// THE jQuery scripts end here //
