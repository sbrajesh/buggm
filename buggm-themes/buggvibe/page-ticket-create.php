<?php
/*
 * Template Name: Create Ticket
 */
?>
<?php get_header() ?>
		
	<div id="content"><!-- content starts here-->
		

		<div class="padder"  role="main">


				<h2 class="pagetitle"><?php the_title(); ?></h2>

                                        

                            <?php if (current_user_can('buggm_create_ticket') ) : ?>
                                    <?php locate_template(array('forms/create-ticket.php'),true);?>
                            <?php else:?>
                                
                            <div class="error">
                                <p><?php _e("Sorry, You don't have permission to create tickets",'buggm');?></p>
                            </div>
                        <?php endif;?>
                </div><!-- .page -->

		

	</div><!-- content ends here-->
	

	<?php get_sidebar() ?>
        <div class="clear"></div>			
			

<?php get_footer(); ?>