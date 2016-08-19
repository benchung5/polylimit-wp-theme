<?php
/**
 * Sidebar
 *
 * @author 	WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
 ?>
	
<div id="sidebar" class="large-3 columns">

        <?php if ( ! dynamic_sidebar( 'Sidebar Shop' ) ) : ?><!-- Shop Sidebar --><?php endif ?>
        <?php //get_sidebar( 'shop' ); ?>
	
</div><!--sidebar-->






