;(function($, window, document, undefined) {

    $.fn.onePixSettings = function() {

        //options area error messages -----------------------------------//        

        $(document).ready(function() {

        var error_msg = $("#message p[class='setting-error-message']");
        // look for admin messages with the "setting-error-message" error class
        if (error_msg.length != 0) {
            // get the title
            var error_setting = error_msg.attr('title');

            // look for the label with the "for" attribute=setting title and give it an "error" class (style this in the css file!)
            $("label[for='" + error_setting + "']").addClass('error');

            // look for the input with id=setting title and add a red border to it.
            $("input[id='" + error_setting + "']").attr('style', 'border-color: #CC0000');
        }

        });
        
        //wordpress color picker -----------------------------------//        

        $(document).ready(function() {

                // Add Color Picker to all inputs that have 'color-field' class
                $(function() {
                    $('.color-picker').iris();
                });
     
        });
        
        //fadein on page load --------------------------------------------------------//

        $(document).ready(function () {
            if ($('.loading-container').length) {

                //to show loading animation
                $imgloader = $('.loading-container');
                $loadingimg = $('<div id="canvasloader-container" class="onepix-imgloader"></div>');


//          $loadingimg.attr("src","images/flexslider/loading.gif");
                $imgloader.prepend($loadingimg);

//          canvasloader code
                var cl = new CanvasLoader('canvasloader-container');
                cl.setColor('#4f4f4f'); // default is '#000000'
                cl.setDiameter(45); // default is 40
                cl.setDensity(75); // default is 40
                cl.setRange(0.7); // default is 1.3
                cl.setSpeed(3); // default is 2
                cl.setFPS(22); // default is 24
                cl.show(); // Hidden by default

                $(window).load(function () {
                    $('.onepix-imgloader').fadeOut();
                    
                    var content = $(".loading-container > .content ");
                        content.fadeTo(8000, 100);
                });

            }

        });
        
        $(document).ready(function () {
            
            //remove paragraph tags
//            $( "p" ).remove();
//            $('h3').nextUntil('h3').wrapAll('<div class="tabcontent" />'); 
//            $( 'string' ).insertBefore( 'h3' );
            $('.settings-tabs-content h2').each(function () {
//                $(this).nextUntil('h3').andSelf().wrapAll('<div class="tabcontent" /></div>');
                //get the title, insert dashes and make lowercase to change to an id
                var id = ($(this).html()).toString();
                id = id.replace(/\s+/g, '-').toLowerCase();
                $(this).nextUntil('h2').andSelf().wrapAll('<div id="' + id + '" class="tabcontent"/></div>');
            });


//            $( "p" ).remove();

            // setup ui tabs for settings
            
            
            // get the latest tab selected before page saved/refreshed to persist the selected tab
            var tabInput = themeSettings_data.current_tab_input;
            
            $('.onepix-settings-tabs').tabs({
                // tabs created event
                create: function (event, ui) {
                    console.log(tabInput);
                },
                // set the active tab using a tab id
                active: tabInput,
                // event to handle the current tab selected
                activate: function (event, ui) {
                    // cause tab content to fade in and out depending on selected,
                    ui.newPanel.find("div.tabcontent")
                            .css({
                                opacity: 0
                            })
                            .animate({
                                opacity: 1
                            });

                    // get the index of the current selected tab
                    var currentTabIndex = ui.newTab.index();

                    $("#onepix_current_tab").attr('value', currentTabIndex)

//                    var tabNumber = ui.index;
//                    var tabName = $(ui.tab).text();

                }
            });
            

            
            //hover states on the static widgets
            $('#dialog_link, ul#icons li').hover(
                    function () {
                        $(this).addClass('ui-state-hover');
                    },
                    function () {
                        $(this).removeClass('ui-state-hover');
                    }
            );



        });


        //end $.fn.onePixSettings = function ()
    }

    // call the plugin (must use body since it will only work when an element is called)
    $('body').onePixSettings();


})(jQuery, window, document);


