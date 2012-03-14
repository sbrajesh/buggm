<?php
/**
 * @package BuggBase
 * 
 * Ticket entry of archive page/index page etc 
 * 
 */
?>
<div <?php post_class();?> id="ticket-<?php the_ID() ;?>">
    <header>
        <h2 class="title">
                <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> "><span class='ticket-no'>#<?php the_ID();?></span>&nbsp;&nbsp;<?php the_title();?></a>
         </h2>
         <span class="author"><?php _e('Reported by','buggm');?> <strong><?php echo buggm_get_the_reporter_name();?></strong> on <em><?php the_time('F j, Y');?></em></span>
     <div class="clear"></div>
    </header>
   
    <div class="entry">
        <?php the_excerpt();?>
        <ul class="ticket-meta">

        <li class="ticket_id"><small><?php _e('Ticket','buggm');?></small><a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> ">#<?php the_ID();?></a></li>
       	<li class="ticket_status"><small><?php _e('Status','buggm');?></small> <?php buggm_ticket_status();?></li>
        <li class="ticket_type"><small><?php _e('Type','buggm');?></small><?php echo buggm_get_ticket_type();?></li>
        <li class="ticket_component"><small><?php _e('Component','buggm');?></small><?php echo buggm_get_ticket_component();?></li>
        <li class="ticket_priority"><small><?php _e('Priority','buggm');?></small><?php echo buggm_get_ticket_priority();?></li>
        <li class="ticket_severity"><small><?php _e('Severity','buggm');?></small><?php echo buggm_get_ticket_severity();?></li>
       
        <li class="ticket_version"><small><?php _e('Version','buggm');?></small><?php echo buggm_get_ticket_version();?></li>
        <li class="ticket_milestone"><small><?php _e('Milestone','buggm');?></small><?php echo buggm_get_ticket_milestone();?></li>
        <li class="ticket_keywords"><small><?php _e('Keywords','buggm');?></small><?php echo buggm_get_ticket_keywords();?></li>
        

        </li>
</ul>
    <div class="clear"></div>
</div>
</div>