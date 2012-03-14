<?php
/*
 * Template Name: Create Ticket
 */
?>
<?php get_header();?>
<div id="container">
        <div id="contents">
            <header class="page-header">
                 <h1><?php the_title();?></h1>
             </header>  
            <?php if (current_user_can('buggm_create_ticket') ) : ?>
                <?php locate_template(array('forms/create-ticket.php'),true);?>
            <?php else:?>
            <div class="error">
                <p><?php _e("Sorry, You don't have permission to create tickets",'buggm');?></p>
            </div>
            <?php endif;?>
         </div>
        <?php //get_sidebar();?>
        <div class="clear"></div>
    </div>     
   <?php get_footer();?>