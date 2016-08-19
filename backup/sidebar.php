<div id="sidebar" class="large-4 columns">
		<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
	<ul>	
			<li id="sidebar-search" class="widget">
				<h4><?php _e('Search'); ?></h4>
				<?php get_search_form(); /* outputs the default Wordpress search form */ ?>
			</li>
			
			<li id="sidebar-nav" class="widget menu">
				<h4><?php _e('Navigation'); ?></h4>
				<ul>
					<?php wp_nav_menu( array( 'theme_location' => 'sidebar-menu' ) ); /* editable within the Wordpress backend */ ?>
				</ul>
			</li>
			
			<li id="sidebar-archives" class="widget">
				<h4><?php _e('Archives') ?></h4>
				<ul>
					<?php wp_get_archives( 'type=monthly' ); ?>
				</ul>
			</li>
	
			<li id="sidebar-meta" class="widget">
				<h4><?php _e('Meta') ?></h4>
				<ul>
					<?php wp_register(); ?>
					<li><?php wp_loginout(); ?></li>
					<?php wp_meta(); ?>
				</ul>
			</li>
	</ul>
		<?php endif; ?>
</div><!--sidebar-->
