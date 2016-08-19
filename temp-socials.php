<?php 
if ( ! defined( 'ABSPATH' ) ) { exit; }
$onepix_option = onepix_get_global_options(); //need this to include theme settings option variables  ?>
<div class="socials <?php echo strtolower($onepix_option['onepix_socials_size']) . ' ' . strtolower($onepix_option['onepix_socials_shape']) . ' ' . strtolower($onepix_option['onepix_socials_color']); ?>">
            
    <?php if ($onepix_option['onepix_facebook_url_input']) { ?>
        <a class="social link-facebook"alt="facebook" href="<?php echo $onepix_option['onepix_facebook_url_input'] ?>"><i class="fa fa-facebook fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_twitter_url_input']) { ?>
        <a class="social link-twitter" alt="twitter" href="<?php echo $onepix_option['onepix_twitter_url_input'] ?>"><i class="fa fa-twitter fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_linkedin_url_input']) { ?>
        <a class="social link-linkedin" alt="linkedin" href="<?php echo $onepix_option['onepix_linkedin_url_input'] ?>"><i class="fa fa-linkedin fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_pinterest_url_input']) { ?>
        <a class="social link-pinterest" alt="pinterest" href="<?php echo $onepix_option['onepix_pinterest_url_input'] ?>"><i class="fa fa-pinterest fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_googleplus_url_input']) { ?>
        <a class="social link-googleplus" alt="googleplus" href="<?php echo $onepix_option['onepix_googleplus_url_input'] ?>"><i class="fa fa-google-plus fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_instagram_url_input']) { ?>
        <a class="social link-instagram" alt="instagram" href="<?php echo $onepix_option['onepix_instagram_url_input'] ?>"><i class="fa fa-instagram fa-lg simple_social"></i></a>
    <?php } ?>
    <?php if ($onepix_option['onepix_youtube_url_input']) { ?>
        <a class="social link-youtube" alt="youtube" href="<?php echo $onepix_option['onepix_youtube_url_input'] ?>"><i class="fa fa-youtube fa-lg simple_social"></i></a>
    <?php } ?>
    <div class="clear"></div>
</div>
