<div id="comments">
<?php if ( post_password_required() ) : ?>
		<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'buggm' ); ?></p>
	</div><!-- #comments -->       
<?php
			/* Stop the rest of comments.php from being processed,
			 * but don't kill the script entirely -- we still have
			 * to fully load the template.
			 */
			return;
		endif;
	?>
        
<?php

if ( have_comments() ) :?>
    
        
    <h3 id="toggle-comments">
       <?php 	printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number(), 'buggm' ),
					number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
	?>
    </h3>
        
        
  <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav id="comment-nav-above" class="comment-nav">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'buggm' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'buggm' ) ); ?></div>
                 <div class="clear"></div>
        </nav>
  <?php endif; // check for comment navigation ?>
        
    <ol id="comment-list">
	<?php	wp_list_comments( array( 'callback' => 'buggm_format_comment' ) );?>
    </ol>

    <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav id="comment-nav-below" class="comment-nav">
                <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'buggm' ) ); ?></div>
                <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'buggm' ) ); ?></div>
                <div class="clear"></div>
        </nav>
    <?php endif; // check for comment navigation ?>

	<?php
		/* If there are no comments and comments are closed, let's leave a little note, shall we?
		 * But we don't want the note on pages or post types that do not support comments.
		 */
		elseif ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="nocomments"><?php _e( 'Comments are closed.', 'buggm' ); ?></p>
	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- #comments -->