<?php
/*
 * Template Name: Scroll Navigation Template
 * 
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
// calling the header.php
get_header();
?>
<div id="scrollnav">
<!-- fixed top side menu-->
<div class="menu-container nav-container">
        <nav class="menu-nav">
            <ul>
                <li><a href="#section1">1</a></li>
                <li><a href="#section2">2</a></li>
                <li><a href="#section3">3</a></li>
            </ul>
        </nav>
</div>
<!-- end fixed top side menu-->
<div id="sections">
    <section id="section1" class="content">
        
    </section>
    <section id="section2" class="content">
    </section>
    <section id="section3" class="content">
        
    </section>
</div>
<!-- #scrollnav -->
</div>
<?php get_footer(); ?>
<?php
// calling footer.php
get_footer();
?>
