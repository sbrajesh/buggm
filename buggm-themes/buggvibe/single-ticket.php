<?php get_header() ?>
	<div id="content" ><!-- content starts here-->
            <div class="padder" role="main">
                

                 <?php if (have_posts()) :?>
                <nav class="single-post-nav">
                    <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'buggm' ) ); ?></span>
                    <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'buggm' ) ); ?></span>
                </nav>
                 
                 <?php   while (have_posts()) : the_post(); ?>
                
                  <div id="ticket" <?php post_class();?>>
            <h1>
                <a href="<?php the_permalink();?>">Ticket #<?php the_ID();?></a>
                <span class="status">(<?php echo buggm_get_ticket_type()." | ";
                                        buggm_ticket_status();?>)</span>
            </h1>
             <div class="ticket-info">
                <div class="date">
                        <p><?php _e('Opened','buggm');?> <?php echo buggm_time_since(get_the_time('U'),current_time( 'timestamp' )  );?></p>
                        <p><?php _e('Last modified','buggm');?> <?php echo buggm_time_since(get_the_modified_time('U'),current_time( 'timestamp' )  );?></p>
               </div>
              <h2 class="summary"><?php the_title();?></h2>
              <table class="properties">
                <tbody>
                    <tr>
                          <th><?php _e('Reported by:','buggm');?></th>
                          <td>
                            <?php echo buggm_get_avatar(buggm_get_the_reporter_id(), 24,true);?>
                            <?php echo buggm_get_reporter_link(buggm_get_the_reporter_id()); ?>
                          </td>
                  
                          <th><?php _e('Owned by:','buggm');?></th>
                          <td><?php buggm_list_ticket_owners(get_the_ID(),true);?>
                          </td>
                    </tr>
                    <tr>
                        <th><?php _e('Priority:','buggm');?></th>
                        <td>
                              <?php echo buggm_get_ticket_priority();?>
                        </td>
                        <th><?php _e('Milestone:','buggm');?></th>
                        <td>
                             <?php echo buggm_get_ticket_milestone();?>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Component:','buggm');?></th>
                        <td>
                            <?php echo buggm_get_ticket_component();?>
                        </td>
                        <th><?php _e('Version:','buggm');?></th>
                        <td>
                            <?php echo buggm_get_ticket_version();?>
                        </td>
                    </tr>
                    <tr>
                        <th><?php _e('Severity:','buggm');?></th>
                        <td>
                            <?php echo buggm_get_ticket_severity();?>
                         </td>
                        <th><?php _e('Keywords:','buggm');?></th>
                        <td>
                            <?php echo buggm_get_ticket_keywords();?>
                        </td>
                    </tr>
                    <tr>
                        <th>
                          Cc:
                        </th>
                        <td colspan="3"><?php buggm_list_cced(get_the_ID());?></td>
                     </tr>
              </tbody>
           </table>
     <!-- end of ticket properties --> 

            <div class="description">
            <h3><?php _e('Description','buggm');?></h3>
            <div>
                <?php the_content();?>
                <?php buggm_list_attachment();?>
            </div>
          </div>
        </div>
    </div>     
        <?php comments_template("/comments-ticket.php"); ?>

                <?php endwhile; else: ?>

                        <p><?php _e( 'Sorry, no posts matched your criteria.', 'buggvibe' ) ?></p>

                <?php endif; ?>

      
        
        </div>                 
      </div><!-- content ends here-->
        <?php get_sidebar() ?>
        <div class="clear"></div>			

<?php get_footer() ?>