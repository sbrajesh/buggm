<form method="get" id="searchform" class="buggm_form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <div id="simple-filter">
            
		<input type="text" class="field" name="s" id="s" placeholder="<?php esc_attr_e( 'Search', 'buggm' ); ?>" />
		<input type="submit" class="submit" name="submit" id="searchsubmit" value="<?php esc_attr_e( 'Search', 'buggm' ); ?>" />        
                <a href="#" id="search_toggle"> <?php _e('Ticket Search','buggm');?></a>
    </div>      
 </form>