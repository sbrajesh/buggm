 <?php get_header();?>
    <div id="container">
        <div id="contents">
            <?php if(have_posts()):?>
            <?php while(have_posts()):the_post();?>
            <nav class="single-post-nav">
                <span class="nav-previous"><?php previous_post_link( '%link', __( '<span class="meta-nav">&larr;</span> Previous', 'buggm' ) ); ?></span>
                <span class="nav-next"><?php next_post_link( '%link', __( 'Next <span class="meta-nav">&rarr;</span>', 'buggm' ) ); ?></span>
            </nav>
            
             <article id="post-<?php the_ID();?>" <?php post_class();?>>
                 <header>
                    <h1><?php the_title();?></h1>
                    <div class="post-meta">
                        <?php buggbase_post_info();?>
                    </div>
                 </header>         
                            

                <div class="entry">
                    <?php the_content();?>
                    <?php //buggm_list_attachment();?>
                   <?php edit_post_link( __( 'Edit', 'buggm' ), '<span class="edit-link">', '</span>' ); ?>
                </div>
                 <footer class="entry-meta">
		<?php
			
			$categories_list = get_the_category_list( __( ', ', 'buggm' ) );

			
			$tag_list = get_the_tag_list( '', __( ', ', 'buggm' ) );
			if ( '' != $tag_list ) {
				$utility_text = __( 'This entry was posted in %1$s and tagged %2$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'buggm' );
			} elseif ( '' != $categories_list ) {
				$utility_text = __( 'This entry was posted in %1$s by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'buggm' );
			} else {
				$utility_text = __( 'This entry was posted by <a href="%6$s">%5$s</a>. Bookmark the <a href="%3$s" title="Permalink to %4$s" rel="bookmark">permalink</a>.', 'buggm' );
			}

			printf(
				$utility_text,
				$categories_list,
				$tag_list,
				esc_url( get_permalink() ),
				the_title_attribute( 'echo=0' ),
				get_the_author(),
				esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) )
			);
		?>
		

		<?php if ( get_the_author_meta( 'description' ) && is_multi_author() ) : // If a user has filled out their description and this is a multi-author blog, show a bio on their entries ?>
		<div id="author-info">
			<div id="author-avatar">
				<?php echo get_avatar( get_the_author_meta( 'user_email' ), apply_filters( 'bugbase_author_bio_avatar_size', 68 ) ); ?>
			</div><!-- #author-avatar -->
			<div id="author-description">
				<h2><?php printf( esc_attr__( 'About %s', 'buggm' ), get_the_author() ); ?></h2>
				<?php the_author_meta( 'description' ); ?>
				<div id="author-link">
					<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author">
						<?php printf( __( 'View all posts by %s <span class="meta-nav">&rarr;</span>', 'buggm' ), get_the_author() ); ?>
					</a>
				</div><!-- #author-link	-->
			</div><!-- #author-description -->
		</div><!-- #entry-author-info -->
		<?php endif; ?>
	</footer><!-- .entry-meta -->
       
        </article>     
        
         <?php comments_template(); ?>
        
     <?php endwhile;?>
   <?php else:?>
     <div class="error">
          <p><?php _e('Nothing found','buggm');?></p>
      </div>    
   <?php endif;?>
 </div>
 
 <div class="clear"></div>
</div>     
<?php get_footer();?>