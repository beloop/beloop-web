/*!
 * amaretti v0.0.1 (http://foxythemes.net/themes/amaretti)
 * Copyright 2014-2015 Foxy Themes all rights reserved 
 */
var App = (function () {
    'use strict';

    //Basic Config
    var config = {
        leftSidebarSlideSpeed: 200,
        openLeftSidebarClass: 'open-left-sidebar',
        removeLeftSidebarClass: 'am-nosidebar-left',
        transitionClass: 'am-animate',
        openSidebarDelay: 400
    };

    var body = $("body");
    var wrapper = $(".am-wrapper");
    var leftSidebar = $(".am-left-sidebar");
    var openSidebar = false;

    //Core private functions
    function leftSidebarInit() {

        function oSidebar() {
            body.addClass(config.openLeftSidebarClass + " " + config.transitionClass);
            openSidebar = true;
        }

        function cSidebar() {
            body.removeClass(config.openLeftSidebarClass).addClass(config.transitionClass);
            sidebarDelay();
        }

        /*Open-Sidebar when click on topbar button*/
        $('.am-toggle-left-sidebar').on("click", function (e) {
            e.stopPropagation();
            e.preventDefault();
            
            if (openSidebar && body.hasClass(config.openLeftSidebarClass)) {
                cSidebar();
            } else if (!openSidebar) {
                oSidebar();
            }

        });

        /*Close sidebar on click outside*/
        $(document).on("touchstart mousedown", function (e) {
            if (!$(e.target).closest(leftSidebar).length && body.hasClass(config.openLeftSidebarClass)) {
                cSidebar();
            }
        });

        /*Calculate sidebar tree active & open classes*/
        $("li.active", leftSidebar).parents(".parent").addClass("active open");
    }

    function sidebarDelay() {
        openSidebar = true;
        setTimeout(function () {
            openSidebar = false;
        }, config.openSidebarDelay);
    }

    return {
        //General data
        conf: config,

        //Init function
        init: function (options) {

            //Extends basic config with options
            $.extend(config, options);

            /*Left Sidebar*/
            leftSidebarInit();

            /*Body transition effect*/
            leftSidebar.on("transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd", function () {
                body.removeClass(config.transitionClass);
            });
        }
    };

})();
