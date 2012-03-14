<?php

/**
 * @package buggbase
 *  
 * Post/Page/other post type entry
 * 
 */

?>
<li <?php post_class();?> id="post-<?php the_ID() ;?>">
    <header>
          <h2 class="title">
                <a rel="permalink" title="Permalink to <?php  the_title_attribute();?>" href="<?php the_permalink();?> "><?php the_title();?></a>
         </h2>
         <span class="author"><?php _e('Posted by','buggm');?> <strong><?php echo get_the_author();?></strong> on <em><?php the_time('F j, Y');?></em></span>
     <div class="clear"></div>
    </header>
   
    <div class="entry">
        <?php the_excerpt();?>
        <a class="readmore" href="<?php the_permalink();?>"> <?php _e('Read more.','buggm');?>.</a>
    <div class="clear"></div>
</div>
</li>   

	