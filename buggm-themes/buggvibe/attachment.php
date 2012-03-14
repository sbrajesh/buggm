<?php get_header(); ?>
	
               <div id="content"><!-- content starts here-->

                

                <div class="padder" id="attachments-page" role="main">

                        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>

                              

                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                        <div class="author-box">
                                                <?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
                                                <p><?php printf( _x( 'by %s', 'Post written by...', 'buggm' ), str_replace( '<a href=', '<a rel="author" href=', buggm_get_user_link( $post->post_author ) ) ); ?></p>
                                        </div>

                                        <div class="post-content">
                                             <header>
                                                <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buggm' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                                             </header>   
                                                <p class="date">
                                                        <?php the_date(); ?>
                                                        <span class="post-utility alignright"><?php edit_post_link( __( 'Edit this entry', 'buggm' ) ); ?></span>
                                                </p>

                                                <div class="entry">
                                                        <?php echo wp_get_attachment_image( $post->ID, 'large', false, array( 'class' => 'size-large aligncenter' ) ); ?>

                                                        <div class="entry-caption"><?php if ( !empty( $post->post_excerpt ) ) the_excerpt(); ?></div>
                                                        <?php the_content(); ?>
                                                </div>

                                                <p class="postmetadata">
                                                        <?php
                                                                if ( wp_attachment_is_image() ) :
                                                                        $metadata = wp_get_attachment_metadata();
                                                                        printf( __( 'Full size is %s pixels', 'buggm' ),
                                                                                sprintf( '<a href="%1$s" title="%2$s">%3$s &times; %4$s</a>',
                                                                                        wp_get_attachment_url(),
                                                                                        esc_attr( __( 'Link to full size image', 'buggm' ) ),
                                                                                        $metadata['width'],
                                                                                        $metadata['height']
                                                                                )
                                                                        );
                                                                endif;
                                                        ?>
                                                        &nbsp;
                                                </p>
                                        </div>

                                </article>


                                <?php comments_template(); ?>

                        <?php endwhile; else: ?>

                                <p><?php _e( 'Sorry, no attachments matched your criteria.', 'buggm' ) ?></p>

                        <?php endif; ?>

                </div>

        


       </div><!-- content ends here-->
       <?php get_sidebar() ?>
     <br class="clear"/>
<?php get_footer(); ?>
