
<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="clear"></div>
</div><!-- end begin body content-->

<?php if (is_active_sidebar('Home Above Footer') && (is_front_page() || is_home())) { ?>
    <section class="above-footer-wrapper">
        <!--    above footer widget area-->
        <?php if (!dynamic_sidebar('Home Above Footer')) : ?><!--Wigitized Above Footer--><?php endif ?>
    </section>
<?php } ?>

<?php $onepix_option = onepix_get_global_options(); //need this to include theme settings option variables  ?>

        <?php if ($onepix_option['onepix_has_subfooter']) { ?>
            <section id="footertop">
                <div class="row media-spacer-med">
                    <div class="medium-4 columns footer1">
                            <?php if ( ! dynamic_sidebar( 'Footer Top 1' ) ) : ?><!-- Footer Top 1 --><?php endif ?>
                    </div>
                    <div class="medium-4 columns footer2">
                        <?php if ( ! dynamic_sidebar( 'Footer Top 2' ) ) : ?><!-- Footer Top 2 --><?php endif ?>
                    </div>
                    <div class="medium-4 columns footer3">
                        <?php if ( ! dynamic_sidebar( 'Footer Top 3' ) ) : ?><!-- Footer Top 3 --><?php endif ?>
                    </div>
                </div>
                <div class="clear"></div>
            </section>
        <?php } ?>
        <footer id="footer" class="padding-bottom">
		<div class="row">
                    <div class="medium-12 columns center media-center-med">
                            <div class="copywright padding-columns">&copy; <a href="<?php bloginfo('url'); ?>/" title="<?php bloginfo('description'); ?>"><?php bloginfo( 'name' ); echo '&nbsp;' . date('Y'); ?></a>.</div>
                    </div>
                </div><!--.container-->
        </footer><!--#footer-->
        <!--back to top (put this at the bottom of content area)-->
        <div id="toTop">
            <div id=toTop-icon-wrap>
                <i class="fa fa-angle-up"></i>
            </div>
        </div>
</div><!--#main container-->

</div><!--#loading container-->

<?php if (!$onepix_option['onepix_unboxed_layout']) { ?>
</div><!--#main -- this encompasses the entire Web site -->
<?php } ?>
<?php wp_footer(); /* this is used by many Wordpress features and plugins to work proporly */ ?>
</body>
</html>