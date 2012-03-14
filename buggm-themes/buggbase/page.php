 <?php get_header();?>
    <div id="container">
        <div id="contents">
            <?php if(have_posts()):?>
            <?php while(have_posts()):the_post();?>
            
            
             <article id="post-<?php the_ID();?>" <?php post_class();?>>
                 <header class="page-header">
                    <h1><?php the_title();?></h1>
                    
                 </header>         
                            

                <div class="entry">
                    <?php the_content();?>
                    <?php //buggm_list_attachment();?>
                    <?php edit_post_link();?>
                </div>
                 
       
        </article>     
        
         <?php //comments_template(); ?>
        
     <?php endwhile;?>
   <?php else:?>
     <div class="error">
          <p><?php _e('Nothing found!','buggm');?></p>
      </div>    
   <?php endif;?>
 </div>
 
 <div class="clear"></div>
</div>     
<?php get_footer();?>