;(function ($, window, document, undefined) {

    $.fn.onePixelShowcase = function (options) {
        $(document).ready(function () {
            
            // Setting up our variables
            var $filter;
            var $container;
            var $containerClone;
            var $filterLink;
            var $filteredItems;

            if ($().quicksand) {

                showcase_quicksand();

            }

            function showcase_quicksand() {


                // Set our filter
                $filter = $('.filter li.active a').attr('class');

                // Set our filter link
                $filterLink = $('.filter li a');

                // Set our container
                $container = $('ul.filterable-grid');

                // Clone our container
                $containerClone = $container.clone();


                // set our width for update purposes
                update_containersize();


                //update from querystring ---------------------------------//

                //get the the url of the current page
                var url = String(document.location);


                // only if not an all taxonamoy version of the page (category specific)...
                if (url.indexOf('=') >= 0) {

                    // get the querystring from the url
                    // ex: http://myurl.com/?skills=graphic-design
                    var tax = String(url.substring(url.indexOf('=') + 1));

                    update_containersize();

                    // Remove the active class
                    $('.filter li').removeClass('active');

                    // get the current matching filter button for the current taxonomy querystring
                    var taxbutton = $('.filter li[data-type=' + tax + ']');

                    // Apply the 'active' class to it to have it "selected""
                    taxbutton.addClass('active');

                    $filteredItems = $containerClone.find('li[data-type~=' + tax + ']');
                    $filteredItems.removeClass('clear');

                    run_quicksand();

                }

                //end update from querystring ---------------------------------//

                // Apply our Quicksand to work on a click function
                // for each of the filter li link elements
                $filterLink.click(function (e)
                {

                    update_containersize();

                    // Remove the active class
                    $('.filter li').removeClass('active');

                    // Split each of the filter elements and override our filter
                    $filter = $(this).attr('class').split(' ');

                    // Apply the 'active' class to the clicked link
                    $(this).parent().addClass('active');

                    // If 'all' is selected, display all elements
                    // else output all items referenced by the data-type

                    if ($filter == 'all') {

                        $filteredItems = $containerClone.find('li');
                    }
                    else {
                        $filteredItems = $containerClone.find('li[data-type~=' + $filter + ']');
                        $filteredItems.removeClass('clear');
                    }

                    run_quicksand();
                });
            }

            function run_quicksand() {

                // Finally call the Quicksand function
                $container.quicksand($filteredItems,
                        {
                            // The duration for the animation
                            duration: 350,
                            // The easing effect when animating
                            easing: 'easeInOutCirc',
                            // Height adjustment set to dynamic
                            adjustHeight: 'dynamic',
                            //jquery-animate-css-rotate-scale.min.js is needed for "useScaling: true" to work
                            useScaling: true
                        },
                //need this to ensure lightbox works with quicksand
                function () {
                    lightbox();
                });
                

//                $container.quicksandpaginated({
//
//                wrapper: ".largerContainer",
//
//                        container: '.displayArea',
//                        //inner container that will show elements 
//
//                        thumbs: "article",
//                        // selector of element in the list to show : must have a data-categories="Games Utility" 
//                        //with the list of filters in which element shoud be shown and must be in the #master - list
//
//                        filtersContainer: ".filter",
//                        // filter container 
//
//                        filters: "li",
//                        // filter elements, must have an anchor with data-category="Photography" 
//                        //with the filter name which will be the link with the data - categories = "Photography Utility"
//                        //on elements to show
//
//                        prev: ".prev",
//                        // prev nav selector 
//
//                        next: ".next",
//                        // next nav selector 
//
//                        pageNumberContainer: ".nav",
//                        // selector pointing to a div where the nav will be rendered 
//
//                        thumbsHeight:186,
//                        // element to show Height 
//
//                        thumbsWidth:248,
//                        // element to show Width 
//
//                        transitionSpeed:400,
//                        // transition Speed 
//
//                        callback:function(c) {
//                            lightbox();
//                            c.trigger("complete"); }
//                // callback when filter have been applied, c is the container (.displayArea in the example) 
//
//                });



            }

            //only use 100% width when window resizes (otherzise width is calculated upon animation)
            $(window).resize(function () {
                update_containersize();
            });

            //set the showcase ul width to the wrapper width in pixels
            function update_containersize() {
                $('ul.filterable-grid').css("width", $('.showcase-container').width() + "px");
            }

            //for pretty-photo
            function lightbox() {
                $("a[rel^='prettyPhoto']").prettyPhoto({
                    animationSpeed: 'fast',
                    slideshow: 5000,
                    theme: 'pp_default',
                    show_title: false,
                    overlay_gallery: false,
                    social_tools: false
                });

            }

            if ($().prettyPhoto) {
                lightbox();
            }

        })

        //end $.fn.onePixelShowcase = function ( options )
    }

    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixelShowcase();


})(jQuery, window, document);