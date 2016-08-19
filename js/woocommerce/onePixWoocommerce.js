;(function ($, window, document, undefined) {

    $.fn.onePixelWoocommerce = function (options) {
        $(document).ready(function () {
            
            if (onePixel_data.is_shop_page) {
                
                //product thumb hover
                $('ul.products li .content-prod-wrapper').hover(function () {
                    
                    

                    $(this).children('.prod-metawrapper').children('.add_to_cart_button').animate({marginTop: '20px'}, 5, 'easeOutQuart');
                    //fade out other products
                    $(this).parent().siblings().stop().fadeTo('fast', 0.5);
                    //apply border
//                $(this).find('img').css({"border":"2px solid #eee"});
                    //fade in meta
                    $(this).children('.prod-metawrapper').stop().fadeIn('fast');
                    $(this).children('.tranp-mask').stop().fadeIn('fast');

//                $(this).children('.add_to_cart_button').animate({ marginTop: '20px' }, 1000);


                }, function () {  // mouseout 
                    //fade in other products
                    $(this).parent().siblings().stop().fadeTo('fast', 1);
                    //fade out meta
                    $(this).children('.prod-metawrapper').stop().fadeOut('fast');
                    $(this).children('.tranp-mask').stop().fadeOut('fast');
                    $(this).children('.prod-metawrapper').children('.add_to_cart_button').animate({marginTop: '30px'}, 5);
                    //remove border
//                $(this).find('img').css({"border":"0"});
//                must use .stop() to prevent animation buildup in rollover, rollout
                });
                
            }

        });
        
        $(document).ready(function () {
            
            $( '<a class="button" href="'+  onePixel_data.shop_url  +'">Reset</a>' ).insertAfter( ".price_slider_amount button[type='submit']" );
//            alert(onePixel_data.shop_url);


        });

        //end $.fn.onePixelWoocommerce = function ( options )
    }

    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixelWoocommerce();


})(jQuery, window, document);