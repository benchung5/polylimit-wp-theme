// * ben - non dropdown select version. ----------------//
(function($){
$.fn.custom_mobileMenu = function() {

    // check what menu type we're working with    
    var dataMenutype = onePixel_data.menutype;

    if (dataMenutype == 'Standard') {

        //attach the down arrow for submenu
        $( "#mobile-menu > ul li" ).has( "ul" ).prepend("<span class='submenu-slide' href='#'><i class='fa fa-angle-down fa-6'></i></span>");

        /* toggle nav */
        $("#mobile-icon").on("click", function(){
            $("#mobile-menu > ul").slideToggle('fast');
            $(this).toggleClass("active");
        });
        
        /* toggle submenu items*/
        $("#mobile-menu > ul li span.submenu-slide").on("click", function(){
            $(this).siblings( "ul.sub-menu" ).slideToggle('fast');
        });

    } else if (dataMenutype == 'Giant') {
        //removed second level mobile menu for giant menu style

        /* toggle nav */
        $("#mobile-icon").on("click", function(){
            $("#mobile-menu > ul").slideToggle('fast');
            $(this).toggleClass("active");
        });
        
        /* toggle submenu items*/
        $("#mobile-menu > ul li span.submenu-slide").on("click", function(){
            $(this).siblings( "ul.sub-menu" ).slideToggle('fast');
        });

    }
    

    




};
})(jQuery);
