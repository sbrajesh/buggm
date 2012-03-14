    </div>  <!--content-bg ends here -->
</div> <!-- #container -->

		

		<footer id="footer">
			<?php if ( is_active_sidebar( 'featured-footer-top-col-1' ) || is_active_sidebar( 'featured-footer-top-col-2' ) || is_active_sidebar( 'featured-footer-top-col-3' ) )  : ?>
				<div id="featured-footer-top">
					<div class="inner">
                                            <div class="first-col col">
                                                <?php dynamic_sidebar('featured-footer-top-col-1');?>
                                            </div>
                                            <div class="second-col col">
                                                <?php dynamic_sidebar('featured-footer-top-col-2');?>
                                            </div>
                                            <div class="third-col col">
                                                <?php dynamic_sidebar('featured-footer-top-col-3');?>
                                            </div>
                                            <div class="clear" ></div>
					</div>
				
				</div>
				
			<?php endif; ?>
			<?php if ( is_active_sidebar( 'featured-footer-bottom-col-1' ) || is_active_sidebar( 'featured-footer-bottom-col-2' ) || is_active_sidebar( 'featured-footer-bottom-col-3' ) )  : ?>
			
			<div id="featured-footer-bottom">
				<div class="inner">
					<div class="first-col col">
                                            <?php dynamic_sidebar('featured-footer-bottom-col-1');?>
					</div>
                                    
					<div class="second-col col">
                                            <?php dynamic_sidebar('featured-footer-bottom-col-2');?>
					</div>
                                    
					<div class="third-col col">
                                            <?php dynamic_sidebar('featured-footer-bottom-col-3');?>
					</div>
					<<div class="clear" ></div>
                                </div>
			</div>
			<?php endif; ?>
			<div id="site-credits" role="contentinfo" >
				
				<p class="inner"><?php printf( __( 'Proudly powered by <a href="%1$s">WordPress</a> and <a href="%2$s">BuggM</a>.', 'buggvibe' ), 'http://wordpress.org', 'http://buggm.com' ) ?> |
                                
                                <?php if(!is_user_logged_in()):?>
                                     <a href="<?php echo wp_login_url(home_url());?>"><?php _e('Login','buggm');?></a>

                                <?php else:?>
                                <a href="<?php echo wp_logout_url(home_url());?>"><?php _e('Logout','buggm');?></a>
                                <?php endif;?>
                                
                                </p>
			</div>

			
		</footer><!-- #footer -->

    </div>	

		<?php wp_footer(); ?>

	</body>

</html>