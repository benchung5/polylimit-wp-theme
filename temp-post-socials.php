<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables  ?>

<div class="socials social-share <?php echo strtolower($onepix_option['onepix_socials_size']) . ' ' . strtolower($onepix_option['onepix_socials_shape']) . ' ' . strtolower($onepix_option['onepix_socials_color']); ?>">

    <a class="social link-facebook" alt="facebook" target="_blank" href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&amp;t=<?php the_title(); ?>" title="Share on Facebook." ><i style="font-size: 17px;" class="fa fa-facebook fa-lg simple_social"></i></a>

    <a class="social link-twitter" alt="twitter" target="_blank" href="http://twitter.com/home/?status=<?php the_title(); ?> - <?php $bitly = onepix_getBitly(get_permalink($post->ID)); echo $bitly ?>" title="Tweet this!" title="Share on Twitter."><i style="font-size: 17px;" class="fa fa-twitter fa-lg simple_social"></i></a>

    <a class="social link-linkedin" alt="linkedin" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink(); ?>&title=<?php the_title(); ?>" title="Share on LinkedIn!" title="Share on LinkedIn"><i style="font-size: 17px;" class="fa fa-linkedin fa-lg simple_social"></i></a>

    <a class="social link-googleplus" alt="googleplus" target="_blank" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" title="Tweet this!" title="Share on LinkedIn"><i style="font-size: 17px;" class="fa fa-google-plus fa-lg simple_social"></i></a>

    <a class="social link-pinterest" alt="pinterest" target="_blank" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php $url = wp_get_attachment_url( get_post_thumbnail_id($post->ID) ); echo $url; ?>" title="Pin this!" title="Pin on Pinterest"><i style="font-size: 17px;" class="fa fa-pinterest fa-lg simple_social"></i></a>
    <div class="clear"></div>
</div>



