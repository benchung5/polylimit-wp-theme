<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<!--override WooCommerce search form-->
<form role="search" method="get" id="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
    <div>
        <a href="javascript:void(0)" class="search-submit-button"></a>
        <div id="searchtext">
            <input type="text" value="<?php echo get_search_query(); ?>" name="s" id="s" placeholder="<?php _e( 'Search for products', 'woocommerce' ); ?>" />
        </div>
        <input type="hidden" name="post_type" value="product" />
    </div>
</form>