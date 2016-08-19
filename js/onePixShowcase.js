;(function ($, window, document, undefined) {

    $.fn.onePixelShowcase = function (options) {
        $(document).ready(function () {
            
            // Setting up our variables
            var $filter;
            var $container;
            var $containerClone;
            var $filterLink;
            var $filteredItems;

            //for pagination
            var $pageNav;
            var $itemLimit = showcase_data.showcase_count; //data from theme settings
            var $currentPage = $('#showcase-pagination').data('page');
            var $pageItemsFrom = 0;
            var $pageItemsTo = $itemLimit;

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
                
                // Set our page nav buttons
                $pageNav = $('#showcase-pagination .pagenav');

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
                    
                    //must be called before slicing $filteredItems
                    reset_pagination();

                    $filteredItems = $filteredItems.slice(0, $itemLimit);

                    //end update from querystring ---------------------------------//

                } else {
                    $filteredItems = $containerClone.find('li');        
                    
                    //must be called before slicing $filteredItems
                    reset_pagination();

                    $filteredItems = $filteredItems.slice(0, $itemLimit);

                }
                
                run_quicksand();

            }
            
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

                //must be called before slicing $filteredItems
                reset_pagination();

                $filteredItems = $filteredItems.slice(0, $itemLimit);

                run_quicksand();
            });

            $pageNav.click(function (e)
            {
                if (!$(this).hasClass("disabled")) {

                    update_containersize();

                    var $currentPage = $('#showcase-pagination').data('page');

//                        var $pageItemsTo = $currentPage * $itemLimit;
//                        var $pageItemsFrom = $pageItemsTo - $itemLimit;

                    if ($filter == 'all') {
                        $filteredItems = $containerClone.find('li');
                    }
                    else {
                        $filteredItems = $containerClone.find('li[data-type~=' + $filter + ']');
                        $filteredItems.removeClass('clear');
                    }

                    if ($(this).hasClass("next")) {

                        //disable the next button if it will end up exceeding the total item count on the next page
                        if ($filteredItems.length > $pageItemsTo) {
                            $currentPage = $currentPage + 1;
                            //now that page is incrimented, recalculate and check if the next page will be empty and if so, disable
                            $pageItemsTo = $currentPage * $itemLimit;
                            if ($filteredItems.length <= $pageItemsTo) {
                                $(this).addClass('disabled');
                            }
                            $('#showcase-pagination .pagenav.prev').removeClass('disabled');

                        } else {
                            $(this).addClass('disabled');
                            $('#showcase-pagination .pagenav.prev').removeClass('disabled');
                        }

                    } else if ($(this).hasClass("prev")) {

                        //disable the next button if it will end up exceeding the total item count on the next page
                        if ($currentPage - 1 > 0) {
                            $currentPage = $currentPage - 1;
                            $('#showcase-pagination').data('page', $currentPage);
                            //now that page is incrimented, check if the next page will be empty and if so, disable
                            if ($currentPage <= 1) {
                                $(this).addClass('disabled');
                            }
                            $('#showcase-pagination .pagenav.next').removeClass('disabled');
                            
                        } else {
                            $(this).addClass('disabled');
                            $('#showcase-pagination .pagenav.next').removeClass('disabled');

                        }

                    }
                    

                    $pageItemsTo = $currentPage * $itemLimit;
                    $pageItemsFrom = $pageItemsTo - $itemLimit;
                    
                    $('#test-itemlength').html($filteredItems.length);
                    $('#test-itemsto').html($pageItemsTo);
                    $('#showcase-pagination').data('page', $currentPage);
                    $('#test-currentpage').html($('#showcase-pagination').data('page'));

                    $filteredItems = $filteredItems.slice($pageItemsFrom, $pageItemsTo);

                    run_quicksand();

                }
            });
            
            function reset_pagination() {
                
                //reset variables;
                $currentPage = 1;
                $('#showcase-pagination').data('page', 1);
                $pageItemsFrom = 0;
                $pageItemsTo = $itemLimit;
                
                
                //check if there's need for pagination
                if($filteredItems.length > $itemLimit){
                    //disable just prev button
                    $('#showcase-pagination .pagenav').addClass('disabled');
                    //enable next button
                    $('#showcase-pagination .pagenav.next').removeClass('disabled');
                } else {
                    //disable both buttons
                    $('#showcase-pagination .pagenav').addClass('disabled');
                }
                
                
                //for testing:
//                var $pageItemsTo = $currentPage * $itemLimit;
//                var $pageItemsFrom = $pageItemsTo - $itemLimit;
                $('#test-itemlength').html($filteredItems.length);
                $('#test-itemsto').html($pageItemsTo);
                $('#test-currentpage').html($currentPage);
                $('#test-itemlength').html($filteredItems.length);
                $('#test-prevpage').html('disabled');
                $('#test-nextpage').html('next');
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
                            useScaling: false
                        },
                //need this to ensure lightbox works with quicksand
                function () {
                    lightbox();
                });
                
            }

            //only use 100% width when window resizes (otherzise width is calculated upon animation)
            $(window).resize(function () {
                update_containersize();
            });

            //set the showcase ul width to the wrapper width in pixels
            function update_containersize() {
                $container.css("width", $('.showcase-container').width() + "px");
                $container.css("height", "auto");
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