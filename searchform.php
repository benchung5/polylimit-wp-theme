<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<form role="search" method="get" id="searchform" action="<?php echo home_url( '/' ); ?>">
    <div>
<!--        <input type="submit" id="searchsubmit" value="" />-->
        <a href="javascript:void(0)" class="search-submit-button">
<!--            <i class="fa fa-search"></i>-->
        </a>
        <div id="searchtext">
            <input type="text" value="" name="s" id="s" />
        </div>
        
    </div>
</form>
