<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php if ( is_category() ) {
		echo 'Category Archive for &quot;'; single_cat_title(); echo '&quot; - '; bloginfo( 'name' );
	} elseif ( is_tag() ) {
		echo 'Tag Archive for &quot;'; single_tag_title(); echo '&quot; - '; bloginfo( 'name' );
	} elseif ( is_archive() ) {
		wp_title(''); echo ' Archive - '; bloginfo( 'name' );
	} elseif ( is_search() ) {
		echo 'Search for &quot;'.wp_specialchars($s).'&quot; - '; bloginfo( 'name' );
	} elseif ( is_front_page() || is_home() ) {
		bloginfo( 'name' ); echo ' - '; bloginfo( 'description' );
	}  elseif ( is_404() ) {
		echo 'Error 404 Not Found - '; bloginfo( 'name' );
	} elseif ( is_single() ) {
		wp_title('');
	} else {
		echo wp_title(''); echo ' - '; bloginfo( 'name' );
	} ?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<meta name="viewport" content="width=device-width; initial-scale=1"/><?php /* Add "maximum-scale=1" to fix the Mobile Safari auto-zoom bug on orientation changes, but keep in mind that it will disable user-zooming completely. Bad for accessibility. */ ?>
	<link rel="icon" href="<?php bloginfo('template_url'); ?>/1pixel_favicon.ico" type="image/x-icon" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<link rel="alternate" type="application/rss+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'rss2_url' ); ?>" />
	<link rel="alternate" type="application/atom+xml" title="<?php bloginfo( 'name' ); ?>" href="<?php bloginfo( 'atom_url' ); ?>" />
        <?php wp_enqueue_script("jquery"); /* Loads jQuery if it hasn't been loaded already */ ?>
	<?php /* The HTML5 Shim is required for older browsers, mainly older versions IE */ ?>
	<!--[if lt IE 9]>
		<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php wp_head(); ?> <?php /* this is used by many Wordpress features and for plugins to work proporly */ ?>
	<?php $onepix_option = onepix_get_global_options(); //need this to include theme settings option variables ?>
        
</head>

<!--if contact page, load google map, and load body class on all pages-->
<body <?php if (is_page_template( 'template-contact.php' )) { echo 'onload="initialize()" onunload="GUnload()"'; } ?> <?php body_class() ?>>
    
<?php do_action('onepix_very_top'); /* #fixednav */ ?>
    
<div class="hide">
	<p><a href="#content"><?php _e('Skip to Content'); ?></a></p><?php /* used for accessibility, particularly for screen reader applications */ ?>
</div><!--.none-->

<?php if (!$onepix_option['onepix_unboxed_layout']) { ?>
<div id="main"><!-- this encompasses the entire Web site -->
<?php } ?>

<header id="site-header">
    <div id="header-inner">
        <?php if ($onepix_option['onepix_menu_type'] == 'Standard') { ?>
        <div id="header-main-wrapper">
             <div id="header-main" class="row">
                     <div class="large-2 columns media-center-lg">
                         <div id="logo-header" style="max-width: <?php echo $onepix_option['onepix_logo_max_width'] ?>px;">
                             <a href="<?php echo home_url(); ?>" style="height: <?php echo $onepix_option['onepix_header_height'] ?>px;">
                             <span> <!--for vertical align-->
                             <img src="<?php echo $onepix_option['onepix_logo_img_url']; ?>" alt="Logo" title="<?php bloginfo('name'); ?>"/>
                             </span>
                             </a>
                         </div>
                     </div>
                     <div class="large-10 columns">
                         <div id="header-right">
                             <?php if ($onepix_option['onepix_menu_type'] == 'Standard') { ?>
                                 <div id="nav-primary" class="nav">
                                     <div class="nav-wrapper">
<!--                                             this remains hidden until sticky-->
                                         <div id="logo-header-sticky" style="max-width: <?php echo $onepix_option['onepix_logo_max_width'] ?>px;">
                                             <a href="<?php echo home_url(); ?>">
                                             <span> <!--for vertical align-->
                                             <img src="<?php echo $onepix_option['onepix_logo_img_url']; ?>" alt="Logo" title="<?php bloginfo('name'); ?>"/>
                                             </span>
                                             </a>
                                         </div>

                                         <nav style="height: <?php echo $onepix_option['onepix_header_height'] ?>px;">

                                         <?php
                                         //call the main menu

                                         if (has_nav_menu('header-menu')) {
                                                wp_nav_menu(array(
                                                    'theme_location' => 'header-menu',
                                                    'menu_class' => 'custom_main_menu',
                                                    'echo' => true,
                                                    'before' => '',
                                                    'after' => '',
                                                    'link_before' => '',
                                                    'link_after' => '',
                                                    'walker' => new Onepix_Walker()
                                                ));
                                            } ?>
                                            <?php get_template_part( 'search', 'header' ); ?>
                                        </nav>
                                     </div><!--#nav-wrapper-->
                                 </div><!--#nav-primary-->
                             <?php } ?>
   
                         </div>
                     </div>
             </div>
        </div>
        <?php } ?>
        <?php if ($onepix_option['onepix_menu_type'] == ('Giant')) { ?>
        <div id="nav-primary-giant-wrapper" >
            <!--                <div id="menuheight-placeholder"></div>-->
            <div id="nav-primary-giant" class="nav row padding-columns">
                <div class="nav-wrapper">
                    <div id="logo-header" style="max-width: <?php echo $onepix_option['onepix_logo_max_width'] ?>px;">
                        <a href="<?php echo home_url(); ?>" style="height: <?php echo $onepix_option['onepix_header_height'] ?>px;">
                        <span> <!--for vertical align-->
                        <img src="<?php echo $onepix_option['onepix_logo_img_url']; ?>" alt="Logo" title="<?php bloginfo('name'); ?>"/>
                        </span>
                        </a>
                    </div>
                    <nav style="height: <?php echo $onepix_option['onepix_header_height'] ?>px;">                     
                        <?php
                        //call the main menu

                        wp_nav_menu(array(
                            'theme_location' => 'header-menu',
                            'menu_class' => 'custom_main_menu',
                            'echo' => true,
                            'before' => '',
                            'after' => '',
                            'link_before' => '',
                            'link_after' => '',
                            'walker' => new Onepix_Walker()
                        ));
                        ?>
                        <?php get_template_part( 'search', 'header' ); ?>
                    </nav>
                </div>
                <div class="clear"></div>
            </div>
            <div id="giant-menu-wrapper">
                <div id="giant-menu">
                </div>
            </div>
        </div>
        <?php } ?>
        
        <div id="mobile-menu-container">
            <div id="mobile-selector">
                <img id="mobile-logo" src="<?php echo $onepix_option['onepix_logo_img_url']; ?>" alt="Logo" title="<?php bloginfo('name'); ?>"/>
                <?php get_template_part( 'search', 'header' ); ?>
                <div id="mobile-icon"></div>
            </div>
            <?php if ($onepix_option['onepix_menu_type'] == ('Giant')) { ?>

                    <div id="mobile-menu" unselectable="on" class="unselectable"><?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => '0', 'fallback_cb' => 'header-menu',) ); ?></div>

            <?php } else { ?>
            <div id="mobile-menu" unselectable="on" class="unselectable"><?php wp_nav_menu( array( 'theme_location' => 'header-menu', 'container' => '0', 'fallback_cb' => 'header-menu',) ); ?></div>
            <?php }?>
        </div>
     </div>
</header>

<div class="clear"></div>

<div class = "loading-container">

<div id="main-wrapper"><!-- the wrapper for header, footer, and content area -->