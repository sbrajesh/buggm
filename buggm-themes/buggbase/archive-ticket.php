 <?php get_header();?>
    <div id="container">
        <div id="contents">
            <?php
                $is_search=buggm_is_search();
                 $title=buggm_get_archive_title();
               ?>
            <header class="page-header">
                <h1><?php echo $title;?></h1>
            </header>
            <?php if($is_search):?>
            <div class="search-info">
                <p><?php _e('Search Filters','buggm');?></p>
                <?php echo buggm_get_ticket_search_filters();?>
            </div>
            <?php endif;?>
            <?php if(have_posts()):?>
            
            <ol id="ticket-list"> 
           
               <?php while(have_posts()):the_post();?>

                    <?php get_template_part('entry',get_post_type());?>
               <?php endwhile;?>
              </ol>
                
              <?php buggm_pagination_links();?>
             <?php else:?>
             <div class="error">
                    <p><?php _e('Nothing found','buggm');?></p>
             </div>    
           <?php endif;?>
        </div>
        <?php //get_sidebar();?>
        <div class="clear"></div>
    </div>     
   <?php get_footer();?>