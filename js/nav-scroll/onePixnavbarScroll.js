;(function ( $, window, document, undefined ) {


    $.fn.onePixelNav = function () {
        

	var navigation_links = $("nav.menu-nav a");

//var sections = $("section");
//	sections.waypoint({
//		handler: function(event, direction) {
//                    
//                    var active_section = $(this);
//                    var id = active_section.attr("id");	
//
//                    var active_link = $('nav.menu-nav a[href="#' + id + '"]');
//                    navigation_links.removeClass("selected");
//                    active_link.addClass("selected");
//
//		},
////                controlls the offset from the top of the waypoint
//		offset: '-40'
//	})


// check scroll position on window load
        $(document).ready(function () {

            checkVisible();

        });



        $(window).scroll(function () {

            checkVisible();

        });

function checkVisible() {
    
                $("#sections section").each(function (index) {

                var id = "#" + $(this).attr("id");

                var isOnView = isElementVisible(id);
                if (isOnView) {
//          alert('The selected element is visible!');

                    var active_link = $('nav.menu-nav a[href="' + id + '"]');
                    navigation_links.removeClass("selected");
                    active_link.addClass("selected");

                } else { // If not visible
//          alert('oops, the selected elment might be hidden or does not exist');
                }

            });
}



        function isElementVisible(elementToBeChecked)
        {
            var TopView = $(window).scrollTop();
            var BotView = TopView + $(window).height();
            var TopElement = $(elementToBeChecked).offset().top;
            var BotElement = TopElement + $(elementToBeChecked).height();

            return ((BotView <= BotElement) && (TopView >= TopElement));
        }


	
	navigation_links.click( function(event) {
            
            
                var id = $(this).attr("href")

		$.scrollTo(
			id,
			{
				duration: 300,
				offset: 0,
                                onAfter: function() {
//                                    
//                                     use if you need to force the class update incase doesn't scroll all the way
//                                    var active_link = $('nav.menu-nav a[href="' + id + '"]');
//                                    navigation_links.removeClass("selected");
//                                    active_link.addClass("selected");
                                
                                }
			}
		);

	});

        

    }
    
    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixelNav ();

})( jQuery, window, document );


