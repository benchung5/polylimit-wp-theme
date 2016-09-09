;(function ( $, window, document, undefined ) {
    
    $.fn.onePixel = function ( options ) {
        
        // Create some defaults, extending them with any options that were provided
        var settings = $.extend( {
            'location'         : 'top',
            'background-color' : 'blue'
        }, options);
        
        // check what menu type we're working with    
        var dataMenutype = onePixel_data.menutype;
        
        // get slideshow settings    
        var dataSliderDirection = onePixel_data.slideshow_direction;
        var dataSlideshowSpeed = onePixel_data.slideshow_speed;
        var dataAnimationSpeed = onePixel_data.slideshow_animation_speed;
        var dataAnimationLoop = false;
        if (onePixel_data.slideshow_animation_loop == 1) {
            dataAnimationLoop = true;
        } else {
            dataAnimationLoop = false;
        }
        var dataAnimationType = onePixel_data.slideshow_animation_type;
        
        //fadein on page load --------------------------------------------------------//
        //to display loading animation before it's ready
        $(document).ready(function() {
            if ($('.loading-container').length) {
                
                //to show loading animation
                $imgloader = $('.loading-container');
                $loadingimg = $('<div id="canvasloader-container" class="onepix-imgloader"></div>');


//          $loadingimg.attr("src","images/flexslider/loading.gif");
                $imgloader.prepend($loadingimg);

//          canvasloader code
                var cl = new CanvasLoader('canvasloader-container');
                cl.setColor('#fb9e05'); // default is '#000000'
                cl.setDiameter(45); // default is 40
                cl.setDensity(75); // default is 40
                cl.setRange(0.7); // default is 1.3
                cl.setSpeed(3); // default is 2
                cl.setFPS(22); // default is 24
                cl.show(); // Hidden by default

                $(window).load(function () {
                    $('.onepix-imgloader').fadeOut();
                    // fade in content (using opacity instead of fadein() so it retains it's height.
                    //if home slider doesn't exist (else the slider callback handles this)...
                    if (!$('.homeslider').length || !$('homeslider').children().length) {
                        fade_in_page();
                    }

                });
                
            }

        });
        
//        used to bind loading for the page and flexslider ()
        function fade_in_page() {
            $('.loading-container > *:not(.onepix-imgloader)').fadeTo(8000, 100);
        }

        // init flexsliders ---------------------------------------------------------------//
    
        $(window).load(function() {
            
            $('.flexslider.homeslider').flexslider({
                direction: dataSliderDirection,
                slideshowSpeed: dataSlideshowSpeed,
                animationSpeed: dataAnimationSpeed,
                animationLoop: dataAnimationLoop,
                animation: dataAnimationType,
                easing: "easeInOutExpo",
//                useCSS: true,
//                direction: "horizontal",
//                slideshowSpeed: 7000,
//                animationSpeed: 600,
//                animationLoop: false,
//                animation: "slide",
                controlNav: false,
                slideshow: true,
                pauseOnHover: true,
//                fade in flexslider image once loaded
                start: function () {
//                      make sure the page fades in after the slider is loaded
                        fade_in_page();
//                        make sure the caption fades in after the slider is loaded
                        $('.flex-caption-wrapper').fadeTo(8000, 100);
                }
            });

            // The slider being synced must be initialized first
            $('.carousel').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 218,
                itemMargin: 5, //this is the total combined margin between li indicated in css
                move: 1, //this causes it to just move one space at a time
            });

            $('.slider').flexslider({
                animation: "slide",
                controlNav: false,
                animationLoop: false,
                slideshow: false,
                sync: "#carousel"
            });
    
            $('.slider-thumbnav').flexslider({
                animation: "slide",
                controlNav: "thumbnails"
            });
    
            $('.slider-widget .flexslider-widget').flexslider({
                animation: "slide",
                directionNav: false,
                slideshowSpeed: 7000,
            });
  
        });
    

        // mobile menu------------------------------------------------------------//

        $(document).ready(function() {

            // non dropdown select version mobile menu
            $('#mobile-menu-container .menu').custom_mobileMenu();


            // for submenu...
            // the stop is to make smooth animatins without the common problem of multiple queued animations 
            $('#nav-secondary ul.sub-menu > li > a, #nav-primary ul.sub-menu > li > a').hover(function() {
                $(this).find('.sub-menu').fadeIn();
            },
            function() {
                $(this).find('.sub-menu').fadeOut();
            });
            
        });

        // dropdown menu ------------------------------------------------------------//

        $(document).ready(function($) {

            // the stop is to make smooth animatins without the common problem of multiple queued animations 
            
            // for inheader and belowheader style submenu--------------//
            
            $('#nav-primary > .nav-wrapper > nav > div > ul > li, #nav-primary-b > .nav-wrapper > nav > div > ul > li').hover(function() {
                $(this).children('ul.sub-menu').stop(true, true).fadeIn(100);
            },
            function() {
                $(this).children('ul.sub-menu').stop(true, true).fadeOut(100);

            });
            
//           for submenu (2nd level)
            $('#nav-primary nav ul.sub-menu > li.menu-item-has-children, #nav-primary-b > .nav-wrapper > nav > div > ul > li > ul.sub-menu').hover(function() {
                //alert('got me');
                var position = $(this).position();
                //$(this).children('ul.sub-menu').css( "top", position.top );
                $(this).children('ul.sub-menu').stop(true, true).show();
//                alert(position.top);
            },
            function() {
                $(this).children('ul.sub-menu').stop(true, true).hide();

            });
            
        });

        // "stellar" parallax --------------------------------------------------//

        $(document).ready(function() {
            $.stellar({
                horizontalScrolling: false
            });
        })

        //sticky menu ----------------------------------------------------//
 
        $(document).ready(function () {
            
        if(onePixel_data.is_scrollnav !== '1'){
            
            if (dataMenutype == 'Giant') {
                $("#nav-primary-giant-wrapper").sticky({topSpacing: 0});
            } else if (dataMenutype == 'Standard') {
                $("#nav-primary").sticky({topSpacing: 0});
                $('#nav-primary').on('sticky-start', function () {
                    $(this).hide();
                    $(this).fadeIn('slow');
                });
                $('#nav-primary').on('sticky-end', function () {
                });
            }

            $("#mobile-menu-container").sticky({topSpacing: 0});
            
        }

        });

        //button hover ----------------------------------------------------//

        //must do this since css won't allow it while controlling the shortcode
        $(function () {
            //copy the colour and hover color of the element (set by the shortcode) and apply it to the hover bg
            $('a.btn.outline, .load-more-link').hover(
                    function () {
                        var that = $(this);
                        var color = that.data("color");
                        that.css("background", color);
                        if (that.data("color_hover")) {
                            var color_hover =  that.data("color_hover");
                            that.css("color", color_hover);
                            that.children( "i" ).css( "color", color_hover );
                        } else {
                            that.css("color", '#fff');
                        }
                    },
                    function () {
                        var that = $(this);
                        var color = that.data("color");
                        that.css("background", "transparent");
                        that.css("color", color);
                    }
            );
        });
        
        //header search form ----------------------------------------------------//

        //must do this since css won't allow it while controlling the shortcode
        $(function () {
            //copy the colour and hover color of the element (set by the shortcode) and apply it to the hover bg
            $('#searchform #searchclose').click(
                    function () {
                       $('#searchform #searchwrap').hide();
                    });
            $('#searchform #searchbtn').click(
                    function () {
                       $('#searchform #searchwrap').show();
                    });
                
        });


        //back to top --------------------------------------------------//

        $(function() {

            $(window).scroll(function() {
                //important -> height: auto must be set or jquery scrollTop() won't work
                if($(this).scrollTop() > 100) {

                    //remove
                    console.log($(this).scrollTop());

                    $('#toTop').fadeIn(3000);
                } else {
                    $('#toTop').fadeOut();
                }
            });
            $('#toTop').click(function() {
                $('html, body').animate(
                {
                    scrollTop:0
                },
                800,
                "easeInOutExpo",
                function() {
                    $('#toTop').fadeOut(1200);
                });
            });
        });
        

        //search submit button ---------------------------------------------//

        $(document).ready(function() {
            $("a.search-submit-button").click(function()
            {
                $("form#searchform").submit();
            });
        })

        //tabs ---------------------------------------------------------//

        $(function(){
            if ( $( ".onepix-tabs" ).length ) {
                $('.onepix-tabs').tabs({
                    activate: function( event, ui ) {
                        ui.newPanel.find("div.tabcontent")
                        .css({
                            opacity:0
                        })
                        .animate({
                            opacity:1
                        });  
                
                    }
                });
            }
            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                function() {
                    $(this).addClass('ui-state-hover');
                },
                function() {
                    $(this).removeClass('ui-state-hover');
                }
                );
        });

        //accordion ----------------------------------------------------//

        $(document).ready(function($) {
            if ( $( ".onepix-accordion" ).length ) {
                $( ".onepix-accordion" ).accordion({
                    collapsible: true,
                    active: false,
                    header: 'div.accordion-section > h3',
                    heightStyle: 'content'
                });
            }

        });
        
        //giant version dropdown menu ------------------------------------------------------------//
        
        $(document).ready(function($){
//            only execute if has giant menu
            if (dataMenutype == 'Center Header Giant' || dataMenutype == 'Giant') {
                
                // get the screen position of the nav menu (must do this because events cant properly handle
                // the giant menu mouse over
                var offset = $('#nav-primary-giant').offset();
                var menu_top = offset.top;

                // hide/show giant menu
                $('#nav-primary-giant-wrapper').hover(
                        function() {
                            $(this).show();
                        }, function() {
                    //"mouseout"
                    hide_giant_menu();
                }
                );

                // hide/show giant menu
                $('#nav-primary-giant > .nav-wrapper > nav > div > ul > li').hover(
                        function() {
                            if ($(this).hasClass('menu-item-has-children')) {

                                hide_giant_menu();
                                show_giant_menu($(this));
                                //set all other menu items to off
                                $('#nav-primary-giant > .nav-wrapper > nav > div > ul > li').data('current', 'off');
                            }
                        }, function() {
                    //must have this "mouseout" emply funtion to avoid hover firing on mouseout

                }
                );

                function show_giant_menu(this_element) {
                    if (this_element.hasClass('menu-item-has-children')) {
                        this_element.find('#giant-submenu-wrapper').clone().appendTo("#giant-menu-wrapper #giant-menu");
                        $('#giant-menu-wrapper #giant-menu').stop(true, true).fadeIn(100);
                        $('#giant-menu-wrapper #giant-menu #giant-submenu-wrapper').stop(true, true).fadeIn(100);
                    }
                }

                function hide_giant_menu() {
                    $('#giant-menu-wrapper #giant-menu').stop(true, true).fadeOut(100);
                    $('#giant-menu-wrapper #giant-menu #giant-submenu-wrapper').remove();
                }

            }
        });
        
    //end $.fn.onePixel = function ( options )
    }
    
    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixel();

    
})( jQuery, window, document );