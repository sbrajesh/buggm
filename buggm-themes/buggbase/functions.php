<?php

//do not show adminbar
add_filter('show_admin_bar', '__return_false');
//if(!defined('BP_DISABLE_ADMIN_BAR'))
  //  define('BP_DISABLE_ADMIN_BAR',true);


function buggm_setup_theme(){
    register_nav_menu( 'primary', __( 'Primary Menu', 'buggm' ) );
}
add_action('after_setup_theme','buggm_setup_theme');

add_action('wp_enqueue_scripts','buggm_theme_enqueue_js');
function buggm_theme_enqueue_js(){
    wp_enqueue_script('buggm-theme-js',  get_template_directory_uri().'/_inc/theme.js',array('jquery'));
}

/**
 * Exact copy of twentyeleven_posted_on
 */
function buggbase_post_info() {
	printf( __( '<span class="sep">Posted on </span><a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author"> <span class="sep"> by </span> <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>', 'buggm' ),
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		sprintf( esc_attr__( 'View all posts by %s', 'buggm' ), get_the_author() ),
		esc_html( get_the_author() )
	);
}
/**
 * Taken from TwentyEleven theme as I did not feel like writing it again for normal wordpress pages
 * @param type $comment
 * @param type $args
 * @param type $depth 
 */
function buggm_format_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'buggm' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( 'Edit', 'buggm' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<article id="comment-<?php comment_ID(); ?>" class="comment">
			<footer class="comment-meta">
				<div class="comment-author vcard">
					<?php
						$avatar_size = 32;
						if ( '0' != $comment->comment_parent )
							$avatar_size = 24;

						echo get_avatar( $comment, $avatar_size );

						/* translators: 1: comment author, 2: date and time */
						printf( __( '%1$s on %2$s <span class="says">said:</span>', 'buggm' ),
							sprintf( '<span class="fn">%s</span>', get_comment_author_link() ),
							sprintf( '<a href="%1$s"><time pubdate datetime="%2$s">%3$s</time></a>',
								esc_url( get_comment_link( $comment->comment_ID ) ),
								get_comment_time( 'c' ),
								/* translators: 1: date, 2: time */
								sprintf( __( '%1$s at %2$s', 'buggm' ), get_comment_date(), get_comment_time() )
							)
						);
					?>

					<?php edit_comment_link( __( 'Edit', 'buggm' ), '<span class="edit-link">', '</span>' ); ?>
				</div><!-- .comment-author .vcard -->

				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'buggm' ); ?></em>
					<br />
				<?php endif; ?>

			</footer>

			<div class="comment-content"><?php comment_text(); ?></div>

			<div class="reply">
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply <span>&darr;</span>', 'buggm' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
			</div><!-- .reply -->
		</article><!-- #comment-## -->

	<?php
			break;
	endswitch;
}

?>