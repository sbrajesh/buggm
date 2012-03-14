<?php
get_header();
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<div id="container">
    <div id="contents">
         <header class="page-header">
                    <h1><?php printf( __( 'Search Results for: %s', 'buggm' ), '<span class="context-term">' . get_search_query() . '</span>' ); ?></h1>
            </header>
        <?php if ( have_posts() ) : ?>

           
        <ol id="ticket-list"> 
           
               <?php while(have_posts()):the_post();?>

                    <?php get_template_part('entry',get_post_type());?>
               <?php endwhile;?>
              </ol>
                
              <?php buggm_pagination_links();?>
             <?php else:?>
        <article class="post">
            
            <div class="entry">
                <div class="error">
                   <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'buggm' ); ?></p>
             </div> 
                <?php get_search_form(); ?>
            </div>   
             
        </article>  
           <?php endif;?>
        
    </div>
     
        <?php //get_sidebar();?>
        <div class="clear"></div>
    </div>     
   <?php get_footer();?>
