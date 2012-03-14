<div id="sidebar" role="complementary">
		<?php if ( is_user_logged_in() ) : ?>

		

		<div id="sidebar-me">
                    <a href="<?php echo buggm_get_user_url(buggm_get_current_user_id()) ?>">
				<?php echo buggm_get_avatar(buggm_get_current_user_id(),40 ) ?>
			</a>

                    <h4><?php echo buggm_get_user_link(buggm_get_current_user_id() ); ?></h4>
                    <a class="button logout" href="<?php echo wp_logout_url(site_url() ) ?>"><?php _e( 'Log Out', 'buggvibe' ) ?></a>

			
		</div>

		

		

	<?php else : ?>

		

		
		<form name="login-form" id="sidebar-login-form" class="standard-form" action="<?php echo site_url( 'wp-login.php', 'login_post' ) ?>" method="post">
			<label><?php _e( 'Username', 'buggvibe' ) ?><br />
			<input type="text" name="log" id="sidebar-user-login" class="input" value="<?php if ( isset( $user_login) ) echo esc_attr(stripslashes($user_login)); ?>" tabindex="97" /></label>

			<label><?php _e( 'Password', 'buggvibe' ) ?><br />
			<input type="password" name="pwd" id="sidebar-user-pass" class="input" value="" tabindex="98" /></label>

			<p class="forgetmenot"><label><input name="rememberme" type="checkbox" id="sidebar-rememberme" value="forever" tabindex="99" /> <?php _e( 'Remember Me', 'buggvibe' ) ?></label></p>

			<input type="submit" name="wp-submit" id="sidebar-wp-submit" value="<?php _e( 'Log In', 'buggvibe' ); ?>" tabindex="100" />
			<input type="hidden" name="testcookie" value="1" />
		</form>

		

	<?php endif; ?>

	
	
	<?php if ( !function_exists('dynamic_sidebar')
	        || !dynamic_sidebar('sidebar') ) : ?>
	<div class="widget-error">
		<?php _e( 'Please log in and add widgets to sidebar widget area.', 'buggvibe' ) ?> <a href="<?php echo get_option('siteurl') ?>/wp-admin/widgets.php?s=&amp;show=&amp;sidebar=blog-sidebar"><?php _e( 'Add Widgets', 'buggvibe' ) ?></a>
	</div>

	<?php endif; ?>
	

</div><!-- #sidebar -->
