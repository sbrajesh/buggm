<?php
add_filter('post_class','buggvibe_post_class');
function buggvibe_post_class($classes){
   // if(!is_single())
        array_unshift ($classes, 'post-item');
    return $classes;
}


add_action("wp_head","buggvibe_print_js");
function buggvibe_print_js(){
	?>
	<script type="text/javascript">
          var buggvibe={};
          buggvibe.menu_down_icon="<?php echo get_template_directory_uri();?>/_inc/dd/down.gif";
          buggvibe.menu_right_icon="<?php echo get_template_directory_uri();?>/_inc/dd/right.gif";
       </script>
<?php


}


function buggvibe_setup_theme() {
	// This theme uses post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Add default posts and comments RSS feed links to head
	add_theme_support( 'automatic-feed-links' );

	
	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => __( 'Primary Navigation', 'buggvibe' ),
		'secondary' => __( 'Secondary Navigation', 'buggvibe'),
		
	) );

	
}
add_action( 'after_setup_theme', 'buggvibe_setup_theme' );

function buggvibe_load_js() {
	wp_enqueue_script( 'dtheme-ajax-js', get_template_directory_uri() . '/_inc/theme.js', array( 'jquery' ));
}
add_action( 'wp_enqueue_scripts', 'buggvibe_load_js' );


function buggvibe_load_css() {
	wp_register_style( 'bpuggbive-css', get_template_directory_uri() . '/_inc/css/default.css', array(), $version );
	
	wp_enqueue_style( 'bpuggbive-css' );
		
	wp_enqueue_style( 'dd-menu',  get_template_directory_uri() . '/_inc/dd/ddsmoothmenu.css' );
	
}
add_action( 'wp_enqueue_scripts', 'buggvibe_load_css' );


add_action('widgets_init','buggvibe_widgets_init');
function buggvibe_widgets_init() {
	
	//Register Sidebar on the left
	register_sidebar( array(
		'name'          => 'Sidebar',
		'id'            => 'sidebar',
		'description'   => __( 'The sidebar widget area', 'buggvibe' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '<div class="seperator"></div></aside>',
		'before_title'  => '<h3 class="widgettitle">',
		'after_title'   => '</h3>'
	) );
	
	// Register 3 column widgets in two footer section i.e Top footer and Bottom footer
	//Top footer
	//First column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-top-col-1', 'buggvibe' ),
		'id' => 'featured-footer-top-col-1',
		'description' => __( 'The top footer col 1', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	//Second column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-top-col-2', 'buggvibe' ),
		'id' => 'featured-footer-top-col-2',
		'description' => __( 'The top footer col 2', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
	
	//Third column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-top-col-3', 'buggvibe' ),
		'id' => 'featured-footer-top-col-3',
		'description' => __( 'The top footer col 3', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );	
	
	
	//Bottom Footer
	//First column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-bottom-col-1', 'buggvibe' ),
		'id' => 'featured-footer-bottom-col-1',
		'description' => __( 'The bottom footer col 1', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

	//Second column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-bottom-col-2', 'buggvibe' ),
		'id' => 'featured-footer-bottom-col-2',
		'description' => __( 'The bottom footer col 2', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );
	
	//Third column widget
	register_sidebar( array(
		'name' => __( 'featured-footer-bottom-col-3', 'buggvibe' ),
		'id' => 'featured-footer-bottom-col-3',
		'description' => __( 'The bottom footer col 3', 'buggvibe' ),
		'before_widget' => '<ul><li id="%1$s" class="widget %2$s">',
		'after_widget' => '</li></ul>',
		'before_title' => '<h3 class="widgettitle">',
		'after_title' => '</h3>',
	) );

}
// a copy of bpdefault comment
function buggvibe_blog_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;

	if ( 'pingback' == $comment->comment_type )
		return false;

	if ( 1 == $depth )
		$avatar_size = 50;
	else
		$avatar_size = 25;
	?>

	<li <?php comment_class() ?> id="comment-<?php comment_ID() ?>">
		<div class="comment-avatar-box">
			<div class="avb">
				<a href="<?php echo get_comment_author_url() ?>" rel="nofollow">
					<?php if ( $comment->user_id ) : ?>
						<?php echo buggm_get_avatar($comment->user_id, $avatar_size)  ?>
					<?php else : ?>
						<?php echo get_avatar( $comment, $avatar_size ) ?>
					<?php endif; ?>
				</a>
			</div>
		</div>

		<div class="comment-content">
			<div class="comment-meta">
				<p>
					<?php
						/* translators: 1: comment author url, 2: comment author name, 3: comment permalink, 4: comment date/timestamp*/
						printf( __( '<a href="%1$s" rel="nofollow">%2$s</a> said on <a href="%3$s"><span class="time-since">%4$s</span></a>', 'buggvibe' ), get_comment_author_url(), get_comment_author(), get_comment_link(), get_comment_date() );
					?>
				</p>
			</div>

			<div class="comment-entry">
				<?php if ( $comment->comment_approved == '0' ) : ?>
				 	<em class="moderate"><?php _e( 'Your comment is awaiting moderation.', 'buggvibe' ); ?></em>
				<?php endif; ?>

				<?php comment_text() ?>
			</div>

			<div class="comment-options">
					<?php if ( comments_open() ) : ?>
						<?php comment_reply_link( array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ); ?>
					<?php endif; ?>

					<?php if ( current_user_can( 'edit_comment', $comment->comment_ID ) ) : ?>
						<?php printf( '<a class="button comment-edit-link bp-secondary-action" href="%1$s" title="%2$s">%3$s</a> ', get_edit_comment_link( $comment->comment_ID ), esc_attr__( 'Edit comment', 'buggvibe' ), __( 'Edit', 'buggvibe' ) ) ?>
					<?php endif; ?>

			</div>

		</div>

<?php
}



/*
 * The comment section comes from bp-default theme
 */
function buggvibe_before_comment_form() {
?>
	<div class="comment-avatar-box">
		<div class="avb">
			<?php $user_id=buggm_get_current_user_id();
                        if ( $user_id ) : ?>
                    <a href="<?php echo buggm_get_user_tickets_url($user_id) ?>">
					<?php echo get_avatar( $user_id, 50 ) ?>
				</a>
			<?php else : ?>
				<?php echo get_avatar( 0, 50 ) ?>
			<?php endif; ?>
		</div>
	</div>

	<div class="comment-content standard-form">
<?php
}
add_action( 'comment_form_top', 'buggvibe_before_comment_form' );


function buggvibe_after_comment_form() {
?>

	</div><!-- .comment-content standard-form -->

<?php
}
add_action( 'comment_form', 'buggvibe_after_comment_form' );





$fwd_btn=get_option("fwd_btn");
//use default if logos are not set
if(empty($fwd_btn))
	$fwd_btn=get_stylesheet_directory_uri()."/_inc/images/more_btn_arrow.png";	

$dwn_btn=get_option("dwn_btn");
//use default if logos are not set
if(empty($dwn_btn))
	$dwn_btn=get_stylesheet_directory_uri()."/_inc/images/admin-menu-arrow.gif";
	
//global vars for social vibe logo
$sv_logo=get_option("sv_logo");
//use default if logos are not set
if(empty($sv_logo))
	$sv_logo=get_stylesheet_directory_uri()."/_inc/images/logo.png";
	


?>