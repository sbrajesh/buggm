<?php get_header() ?>
		<div id="featured-box">
			<?php if ( !function_exists('dynamic_sidebar')
						|| !dynamic_sidebar('featured-slideshow') ) : ?>

			<?php endif; ?>
			
			
			<br class="clear" />
		
		</div>
		
		<div id="container">
		
		<div id="content-bg">  <!--content-bg starts here -->
				
				<div id="content"><!-- content starts here-->
				<?php if(is_active_sidebar("homepage-content-sec")): ?>	
				<?php dynamic_sidebar('homepage-content-sec');?>
				
				<?php else:?>
				
				<div class="widget-error">
				<?php _e( 'Please log in and add widgets to <b>home page first-section</b> .', 'buggvibe' ) ?> <a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=third-section"><?php _e( 'Add Widgets', 'buggvibe' ) ?></a>
				</div>
				
				<?php endif;?>
				</div><!-- content ends here-->
				
				
				<?php get_sidebar() ?>
					<br class="clear"/>
			
		</div>  <!--content-bg ends here -->
		
			
<?php get_footer() ?>
