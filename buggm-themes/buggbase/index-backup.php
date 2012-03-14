 <?php get_header();?>
    <div id="container">
        <div id="contents">
            <?php if(have_posts()):
                $i=1;
            
                ?>
            <ol id="ticket-list">
            <?php while(have_posts()):the_post();
            $i++;
            if($i%2==0)
                $class='ticket-even';
            else
                $class='ticket-odd';
            ?>
                <li <?php post_class();?> id="ticket-<?php the_ID() ;?>">

                        
			<p class="ticket-author">
                            by <strong><?php echo buggm_get_the_reporter_name();?></strong> on <em><?php the_date(F, j, Y);?></em>			</p>
                        <?php buggm_ticket_status();?>
			
			<h2 class="ticket-title">
                            <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> "><?php the_title();?></a>
                        </h2>

			<ul class="ticket-meta">
				
                        <li>
                                <small>Ticket</small>
                                   <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> ">#<?php the_ID();?></a>
                      
                        </li>

                        <li><small>Status</small><a rel="tag" href="http://demos.appthemes.com/qualitycontrol/status/open/">Open</a></li>
                        <li><small>Type</small><?php echo buggm_get_ticket_type();?></li>
                        <li><small>Component</small><?php echo buggm_get_ticket_component();?></li>
                        <li><small>Version</small><?php echo buggm_get_ticket_version();?></li>
                        <li><small>Milestone</small><?php echo buggm_get_ticket_milestone();?></li>
                        <li><small>severity</small><?php echo buggm_get_ticket_severity();?></li>
                        <li><small>Priority</small><?php echo buggm_get_ticket_priority();?></li>
                        
                       		</li>

	<li>
		<small>Last Updated</small>
		11:26 am	</li>

	<li>
		<small>Modified by</small>
					tsnerffle			</li>



			</ul>

                        
		</li>
                <!-- <li <?php post_class($class);?> >
                    <h2><a href="<?php the_permalink();?>" rel="<?php the_title_attribute();?>"><?php the_title();?></a></h2>
                    <div class="entry">
                        <?php the_excerpt();?>
                    </div>
                </li> -->
                <?php //get_template_part('entry');?>
            <?php endwhile;?>
            </ol>    
            <?php else:?>
            <div class="error">
                <p>Nothing found</p>
            </div>    
            <?php endif;?>
        </div>
        <?php get_sidebar();?>
        <div class="clear"></div>
    </div>     
   <?php get_footer();?>