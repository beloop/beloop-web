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

    var body = $('body');
    var wrapper = $('.am-wrapper');
    var leftSidebar = $('.am-left-sidebar');
    var openSidebar = false;
    var spinner, loader;

    //Core private functions
    var leftSidebarInit = function leftSidebarInit() {

        var oSidebar = function oSidebar() {
            body.addClass(config.openLeftSidebarClass + ' ' + config.transitionClass);
            openSidebar = true;
        };

        var cSidebar = function cSidebar() {
            body.removeClass(config.openLeftSidebarClass).addClass(config.transitionClass);
            sidebarDelay();
        };

        /*Open-Sidebar when click on topbar button*/
        $('.am-toggle-left-sidebar').on('click', function(e) {
            e.stopPropagation();
            e.preventDefault();

            if (openSidebar && body.hasClass(config.openLeftSidebarClass)) {
                cSidebar();
            } else if (!openSidebar) {
                oSidebar();
            }

        });

        /*Close sidebar on click outside*/
        $(document).on('touchstart mousedown', function(e) {
            if (!$(e.target).closest(leftSidebar).length && body.hasClass(config.openLeftSidebarClass)) {
                cSidebar();
            }
        });

        /*Calculate sidebar tree active & open classes*/
        $('li.active', leftSidebar).parents('.parent').addClass('active open');
    };

    var sidebarDelay = function sidebarDelay() {
        openSidebar = true;
        setTimeout(function () {
            openSidebar = false;
        }, config.openSidebarDelay);
    };

    var loaderInit = function loaderInit() {
        var opts = {
            lines: 16, // The number of lines to draw
            length: 3, // The length of each line
            width: 3, // The line thickness
            radius: 14, // The radius of the inner circle
            color: '#58806D', // #rgb or #rrggbb
            speed: 2.1, // Rounds per second
            trail: 60, // Afterglow percentage
            shadow: false, // Whether to render a shadow
            hwaccel: false // Whether to use hardware acceleration
        };

        loader = document.getElementById('loader');
        spinner = new Spinner(opts).spin(document.getElementById('spin'));
    };

    var hideSpinner = function hideSpinner() {
        spinner.stop();

        if (loader) {
            loader.classList.add('hidden');
        }
    };

    var pageGallery = function pageGallery() {
        //Initialize Mansory
        var $container = $('.gallery-container');

        // initialize
        $container.masonry({
            columnWidth: 0,
            itemSelector: '.item'
        });

        //Resizes gallery items on sidebar collapse
        $("#sidebar-collapse").click(function(){
            $container.masonry();
        });

        //MagnificPopup for images zoom
        // $('.image-zoom').magnificPopup({
        //     type: 'image',
        //     mainClass: 'mfp-with-zoom', // this class is for CSS animation below
        //     zoom: {
        //         enabled: true, // By default it's false, so don't forget to enable it
        //
        //         duration: 300, // duration of the effect, in milliseconds
        //         easing: 'ease-in-out', // CSS transition easing function
        //
        //         // The "opener" function should return the element from which popup will be zoomed in
        //         // and to which popup will be scaled down
        //         // By defailt it looks for an image tag:
        //         opener: function(openerElement) {
        //             // openerElement is the element on which popup was initialized, in this case its <a> tag
        //             // you don't need to add "opener" option if this code matches your needs, it's defailt one.
        //             var parent = $(openerElement).parents("div.img");
        //             return parent;
        //         }
        //     }
        //
        // });

        $container.imagesLoaded( function() {
            $container.masonry();
        });
    };

    return {
        //General data
        conf: config,

        //Init function
        init: function(options) {

            var Spinner = Spinner || null;

            //Extends basic config with options
            $.extend(config, options);

            /*Left Sidebar*/
            leftSidebarInit();

            /*Loader init*/
            loaderInit();

            /*Body transition effect*/
            leftSidebar.on('transitionend webkitTransitionEnd oTransitionEnd MSTransitionEnd', function () {
                body.removeClass(config.transitionClass);
            });
        },

        hideSpinner: hideSpinner,
        pageGallery: pageGallery
    };

})();
