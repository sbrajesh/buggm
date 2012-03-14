 <?php get_header();?>
    <div id="container">
        <div id="contents">
            <?php if(!is_home()||!is_front_page()):?>
            <header class="page-header">
                <h1><?php buggm_archive_title();?></h1>
            </header>
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