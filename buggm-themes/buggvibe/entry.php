                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						<div class="author-box">
							<?php echo get_avatar( get_the_author_meta( 'user_email' ), '50' ); ?>
							

							<?php if ( is_sticky() ) : ?>
								<span class="activity sticky-post"><?php _ex( 'Featured', 'Sticky post', 'buggvibe' ); ?></span>
							<?php endif; ?>
						</div>

						<div class="post-content">
                                                     <header>
                                                        <h1><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buggvibe' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h1>
                                                     </header>
							<p class="date"><?php printf( _x( 'by %s', 'Post written by...', 'buggvibe' ), buggm_get_user_link( $post->post_author ) ) ?> on <?php printf( __( '%1$s <span>in %2$s</span>', 'buggvibe' ), get_the_date(), get_the_category_list( ', ' ) ); ?></p>

							<div class="entry">
								<?php the_content( __( 'Read the rest of this entry &rarr;', 'buggvibe' ) ); ?>
								<?php wp_link_pages( array( 'before' => '<div class="page-link"><p>' . __( 'Pages: ', 'buggvibe' ), 'after' => '</p></div>', 'next_or_number' => 'number' ) ); ?>
							</div>

							<p class="postmetadata"><?php the_tags( '<span class="tags">' . __( 'Tags: ', 'buggvibe' ), ', ', '</span>' ); ?> <span class="comments"><?php comments_popup_link( __( 'No Comments &#187;', 'buggvibe' ), __( '1 Comment &#187;', 'buggvibe' ), __( '% Comments &#187;', 'buggvibe' ) ); ?></span></p>
						</div>

					</article>