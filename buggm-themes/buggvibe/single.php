<?php get_header() ?>
	<div id="content" ><!-- content starts here-->
            <div class="padder" role="main">
                

                 <?php if (have_posts()) :?>
                <nav class="single-post-nav">
                    <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'buggm' ) ); ?></span>
                    <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'buggm' ) ); ?></span>
                </nav>
                 
                 <?php   while (have_posts()) : the_post(); ?>
                
                   <div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>



                                        <h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buggvibe' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
                                        <div class="post-img">

                                        <a href="<?php the_permalink();?>" rel="permalink to <?php the_title_attribute();?>" class="post-img"><?php the_post_thumbnail('category-thumb');?></a>

                                        </div>
                                        <br class="clear" />	
                                                <div class="entry">
                                                        <?php the_content( ); ?>
                                                </div>

                                                <div class="post-meta">
                                                <p><?php printf( _x( 'Posted on %s', 'buggvibe' ), get_the_date() ) ?><?php printf( __( ' | by : <span>%1$s</span> | ', 'buggvibe' ), buggm_get_user_link( $post->post_author ) ); ?><?php comments_popup_link( __( '<span>No Comments &#187;', 'buggvibe' ), __( '1 <span>Comment &#187;</span>', 'buggvibe' ), __( '% <span>Comments &#187;</span>', 'buggvibe' ) ); ?></p>

                                                </div>
                                                <p class="tags"><?php the_tags(  __( 'Tags: ', 'buggvibe' )); ?> </p>

                        </div>

                <?php comments_template(); ?>

                <?php endwhile; else: ?>

                        <p><?php _e( 'Sorry, no posts matched your criteria.', 'buggvibe' ) ?></p>

                <?php endif; ?>

      
        
        </div>                 
      </div><!-- content ends here-->
        <?php get_sidebar() ?>
        <div class="clear"></div>			

<?php get_footer() ?>