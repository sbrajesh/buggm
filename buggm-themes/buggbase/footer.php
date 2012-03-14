 <footer id="footer">
       <p> 
			 
            Powered By <a href="http://wordpress.org/" title="WordPress.org">WordPress</a> &amp;
            <a href="http://buggm.com/">BuggM</a> |
            Developed By <a href="http://buddydev.com/">BuddyDev.com</a> | 
            <?php if(!is_user_logged_in()):?>
            <a href="<?php echo wp_login_url(home_url());?>"><?php _e('Login','buggm');?></a>

            <?php else:?>
            <a href="<?php echo wp_logout_url(home_url());?>"><?php _e('Logout','buggm');?></a>
            <?php endif;?>
            
        </p>
    </footer>
</div>
</body>
</html>