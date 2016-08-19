;(function ($, window, document, undefined) {

    $.fn.onePixelMasonry = function (options) {
        $(document).ready(function () {
            
//            eventie.bind( $("#ajax-load-more"), 'click', function() {
//                alert('clicked');
//            });
            

            //load more posts button --//

            if ($("#ajax-load-more").length) {

                var page = 1,
                        $loading = true,
                        $finished = false,
                        $window = $(window),
                        $el = $('#ajax-load-more'),
                        $content = $('#ajax-load-more ul'),
                        $path = onePixel_data.site_url + '/wp-admin/admin-ajax.php';

                //Define button text
                if ($content.attr('data-button-text') === undefined) {
                    $button = 'More posts';
                } else {
                    $button = $content.attr('data-button-text');
                }
                $el.append('<div id="load-more" class="more row media-spacer-med"><a class="load-more-link btn medium outline">' + $button + '</a></div>');

                //runs on window load to wait for images to load in order to calculate height correctly
                $(window).load(function () {
                    if ($("#ajax-load-more").length) {
                        load_posts();
                    }

                });

                $('#load-more').click(function () {
                    //            if(!$loading && !$finished && !$(this).hasClass('done')) {
                    $loading = true;
                    page++;
                    load_posts();
                    //            }       
                });
                
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
                                $data.hide();

                                //persist data in dom element data
                                //set to on to start with
                                $('#masonry-loop').data('layout', 'on');

                                //set the container that Masonry will be inside of in a var
                                var container = document.querySelector('#masonry-loop');
                                //create empty var msnry
                                var msnry;
                                // initialize Masonry after all images have loaded
                                imagesLoaded(container, function () {

                                    msnry = new Masonry(container, {
                                        //          columnWidth: 96,
                                        itemSelector: '.masonry-entry',
                                        gutter: 30

                                    });
                                    if (page == 1) {
                                        
                                        //append the new data
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
                                    }

                                });

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