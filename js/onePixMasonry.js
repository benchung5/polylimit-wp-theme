;(function ($, window, document, undefined) {

    $.fn.onePixelMasonry = function (options) {
        $(document).ready(function () {
            
            //set the container that Masonry will be inside of in a var
            var container = document.querySelector('#masonry-loop');
            
            //create empty var msnry
            var msnry;

            //load more posts button --//

            if ($("#ajax-load-more").length) {

                var page = 1,
                        $loading = true,
                        $finished = false,
                        $window = $(window),
                        $el = $('#ajax-load-more'),
                        $content = $('#ajax-load-more ul'),
                        $path = masonry_data.site_url + '/wp-admin/admin-ajax.php';

                //Define button text
                if ($content.attr('data-button-text') === undefined) {
                    $button = 'More posts';
                } else {
                    $button = $content.attr('data-button-text');
                }
                $el.append('<div id="load-more" class="more row media-spacer-med"><a class="load-more-link btn medium">' + $button + '</a></div>');

                //runs on window load to wait for images to load in order to calculate height correctly
                $(window).load(function () {
                    if ($("#ajax-load-more").length) {
                        load_posts();
                    }

                });
                
//                if (Modernizr.csscolumns) {
//                    /* Script A */alert('passed');
//                } else {
//                    /* Script B */alert('failed');
//                } 
                
//                Modernizr.load({
//                    test: Modernizr.csscolumns,
//                    yep: '/css/masonry-css-columns.js' ,
//                    nope: '/css/masonry.js'
//                }); 

                $('#load-more').click(function () {
                    //            if(!$loading && !$finished && !$(this).hasClass('done')) {
                    $loading = true;
                    page++;
                    load_posts();
                    //            }       
                });
                
                
//                var masoryAcvite = false;
//                
//                $(window).resize(function () {
//                    //turn masonry on and off depending on window size
//                    if (($(window).width() < 1100) && masoryAcvite == true) {
//                        msnry.destroy();
//                        masoryAcvite = false;
//                    }
//                    else if (($(window).width() > 1100) && masoryAcvite == false) {
//                        
//                        msnry = new Masonry(container, {
//                            //          columnWidth: 96,
//                            itemSelector: '.masonry-entry',
//                            gutter: 30
//                        });
////                        msnry.reloadItems();
////                        msnry.layout();
//                        
//                        masoryAcvite = true;
//                    }
//                });
                
                //Load posts function
                var load_posts = function () {

                    // alert(pagenumber);

                    $('#load-more').addClass('loading');
                    $('#load-more a').text("Loading...");
                    $.ajax({
                        type: "GET",
                        data: {
                            action: 'onepix_masonry_ajaxload',
                            postType: $content.attr('data-post-type'),
                            category: $content.attr('data-category'),
                            numPosts: $content.attr('data-display-posts'),
                            pageNumber: page
                        },
                        dataType: "html",
                        url: $path,
                        beforeSend: function () {
                            if (page != 1) {
                                $('#load-more').addClass('loading');
                                $('#load-more a').text("Loading...");
                            }
                        },
                        success: function (data) {

                            // Convert data to an object 
                            $data = $(data);

                            if (data.length > 1) {
                                
                                //hide incoming data before it gets appended
                                $data.hide();

                                //persist data in dom element data
                                //set to on to start with
                                $('#masonry-loop').data('layout', 'on');

                                //postHolder loads invisible posts first for masonry to take from so imagesloaded knows when to fire.
                                var postHolder = $('#masonry-data-holder');
                                
                                postHolder.append($data);
                                
                                
                                
                                //if css columns are not supported use masonry.js
                                if (masonry_data.use_masonry) {
                                    
                                    var gutterSizer = "";

                                    if (masonry_data.has_sidebar == 1) {
                                        gutterSizer = ".has-sidebar .gutter-sizer";
                                    } else {
                                        gutterSizer = ".no-sidebar .gutter-sizer";
                                    }
                                    
                                    // initialize Masonry after all images have loaded
                                    imagesLoaded(postHolder, function () {

                                        msnry = new Masonry(container, {
//                                        columnWidth: 96,
                                            itemSelector: '.masonry-entry',
                                            // use the gutter sizer element so we can use % sizes
                                            gutter: gutterSizer,
                                            //gutter : ".has-sidebar .gutter-sizer"
                                            isAnimated: false
//                                        animationOptions: {
//                                            duration: 100,
////                                            easing: 'linear',
////                                            queue: false
//                                        }

                                        });

                                        if (page == 1) {

                                            //append the new data to the container
                                            $(".posts-wrapper").append($data);
                                            //add/layout newly appended items

                                            msnry.appended($data);
                                            msnry.reloadItems();
                                            msnry.layout();


                                            //trigger layout on window resize
                                            //msnry.bindResize()

                                        } else {

                                            $(".posts-wrapper").append($data);
                                            msnry.appended($data);
                                            msnry.reloadItems();
                                            msnry.layout();
                                        }

                                    });
                                    
                                } else {
                                    //else use css columns to do the trick
                                    imagesLoaded(postHolder, function () {
                                        
                                        $(".posts-wrapper").append($data);
                                    });

                                }

                                $data.fadeIn(500, function () {
                                    $('#load-more').removeClass('loading');
                                    $('#load-more a').text($button);
                                    $loading = false;
                                });



                            } else {
                                $('#load-more').addClass('done');
                                $('#load-more a').text($button);
                                $loading = false;
                                $finished = true;
                            }
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $('#load-more').removeClass('loading');
                            $('#load-more a').text($button);
                            //alert(jqXHR + " :: " + textStatus + " :: " + errorThrown);
                        }
                    });
                }
                
            }

        });
        


        //end $.fn.onePixelMasonry = function ( options )
    }

    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixelMasonry();

})(jQuery, window, document);