/*
--------------------------------------------------------------
  Template Name: Orbiter - Responsive Admin Dashboard Template
  File: Core JS File
--------------------------------------------------------------
 */
"use strict";
$(document).ready(function() {
    /* -- Menu js -- */
    $.sidebarMenu($('.vertical-menu'));

    (function() {
        for (var a = window.location, abc = $(".vertical-menu a").filter(function() {
            return this.href == a || this.href === a.toString();
        }).addClass("active").parent().addClass("active"); ;) {
            if (!abc.is("li")) break;
            abc = abc.parent().addClass("in").parent().addClass("active");
        }
    })();

    /* -- Infobar Setting Sidebar -- */
    $("#infobar-settings-open").on("click", function(e) {
        e.preventDefault();
        $(".infobar-settings-sidebar-overlay").css({"background": "rgba(0,0,0,0.4)", "position": "fixed"});
        $("#infobar-settings-sidebar").addClass("sidebarshow");
    });
    $("#infobar-settings-close").on("click", function(e) {
        e.preventDefault();
        $(".infobar-settings-sidebar-overlay").css({"background": "transparent", "position": "initial"});
        $("#infobar-settings-sidebar").removeClass("sidebarshow");
    });

    /* -- Menu Hamburger -- */
    $(".menu-hamburger").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("toggle-menu");
        $(".menu-hamburger img").toggle();
    });

    /* -- Menu Topbar Hamburger -- */
    $(".topbar-toggle-hamburger").on("click", function(e) {
        e.preventDefault();
        $("body").toggleClass("topbar-toggle-menu");
        $(".topbar-toggle-hamburger img").toggle();
    });

    /* -- Media Size -- */
    function mediaSize() {
        if (window.matchMedia('(max-width: 767px)').matches) {
            $("body").removeClass("toggle-menu");
            $(".menu-hamburger img.menu-hamburger-close").hide();
            $(".menu-hamburger img.menu-hamburger-collapse").show();
        }
    };
    mediaSize();
    window.addEventListener('resize', mediaSize, false);

    /* -- Switchery  -- */
    document.querySelectorAll('.js-switch-setting-first, .js-switch-setting-second, .js-switch-setting-third, .js-switch-setting-fourth, .js-switch-setting-fifth, .js-switch-setting-sixth, .js-switch-setting-seventh, .js-switch-setting-eightth').forEach(function(elem) {
        if (elem && !elem.switchery) {
            new Switchery(elem, {
                color: '#0d6efd',
                size: 'small'
            });
        }
    });

    /* -- Bootstrap Popover -- */
    $('[data-toggle="popover"]').popover();

    /* -- Bootstrap Tooltip -- */
    $('[data-toggle="tooltip"]').tooltip();

});
