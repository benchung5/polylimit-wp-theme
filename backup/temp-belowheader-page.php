<?php $onepix_option = onepix_get_global_options(); //need this to include theme settings option variables   ?>

<?php 
if ( (!is_page_template( 'template-contact.php' ) && 'onepix_' . SHOWCASE_NAME !== get_post_type() && !is_page_template( 'template-showcase.php' ) && !is_search() && !is_404()) || is_single()  ) { ?>
    
    <div class="full-width-img full-width-img-internal plax-img " data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background: url(<?php 
    if (get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true) !== "") {
        echo get_post_meta(get_the_ID(), 'onepix_custom_img_url_input', true);
    } else {
        echo $onepix_option['onepix_sitewide_img_url_input'];
    }

    ?>) top right;">
        <div id="internal-header-grad">
            <div id="internal-page-header-wrapper">
                <div class="row">
                    <div class="medium-12 columns">
                        <h1 class="page-header internal-page-header"><?php 

                        if (is_category()) {
                            single_cat_title();
                            
                        } elseif (is_tag()) {
                            single_tag_title();
                        } elseif (is_archive()) {
                            wp_title('');
                        } elseif (is_search()) {
                            echo 'Search for &quot;' . wp_specialchars($s);
                        } elseif (is_404()) {
                            echo 'Error 404 Not Found';
                        } elseif (is_single()) {
                            wp_title('');
                        } else {
                            //echo wp_title( ' | ', false, right ); 
                            echo get_the_title();
                            
                        }
                        ?>
                        </h1>
                        <div class="page-header-right">
                            <?php the_breadcrumb(); ?>
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
            </div>
        </div> <!--internal header grad-->
    </div>
<?php } elseif (is_page_template( 'template-contact.php' )) { ?>

<div class="contact-map-header">

<!--         google map for contact page-->
          <script type="text/javascript">
//            function initialize() {
//
//                var leeds = new google.maps.LatLng(53.80583, -1.548903);
//
//                var firstLatlng = new google.maps.LatLng(53.80583, -1.548903);              
//
//                var firstOptions = {
//                    zoom: 16,
//                    center: firstLatlng,
//                    mapTypeId: google.maps.MapTypeId.ROADMAP 
//                };
//
//                var map = new google.maps.Map(document.getElementById("map_leeds"), firstOptions);
//
//                firstmarker = new google.maps.Marker({
//                    map:map,
//                    draggable:false,
//                    animation: google.maps.Animation.DROP,
//                    title: 'Your Client',
//                    position: leeds
//                });
//
//                var contentString1 = '<p>The Address<br />Of your client<br />in<br />here</p>';
//
//
//                var infowindow1 = new google.maps.InfoWindow({
//                    content: contentString1
//                });
//
//                google.maps.event.addListener(firstmarker, 'click', function() {
//                    infowindow1.open(map,firstmarker);
//                });
//
//            }
            </script>
        
            <div class="map">

                <div id="map_leeds" style="width: 100%; height: 400px"></div>  

            </div>

</div>
<?php } elseif ('onepix_' . SHOWCASE_NAME == get_post_type() || is_page_template( 'template-showcase.php' ) || is_search() || is_404()) { ?>

<!--render no pageheader if it's this type of page-->
<?php } else { ?>

<div class="plain-internal-header">
    <div class="row">
        <div class="medium-12 columns">
            <h1 class="page-header"><?php 

            if (is_category()) {
                single_cat_title();
            } elseif (is_tag()) {
                single_tag_title();
            } elseif (is_archive()) {
                wp_title('');
            } elseif (is_search()) {
                echo 'Search for &quot;' . wp_specialchars($s);
            } elseif (is_404()) {
                echo 'Error 404 Not Found';
            } elseif (is_single()) {
                wp_title('');
            } else {
                //echo wp_title( ' | ', false, right ); 
                echo get_the_title();
            }
            ?>
            </h1>
        </div>
    </div>
</div>
    

<?php } ?>


<div class="body-container">

