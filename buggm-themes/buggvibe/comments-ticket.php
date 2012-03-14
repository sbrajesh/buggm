<div id="ticket-comments">
<?php

if ( have_comments() ) :?>
   
    <h3 id="toggle-comments"><?php _e('Change History', 'buggm');?></h3>
     
<ul id="ticket-comment-list">
<?php	wp_list_comments( array( 
		'callback' => 'buggm_format_ticket_comment' 
	) );?>
</ul>
<?php 
endif;

?>
</div>
<?php locate_template(array('forms/comment-form.php'),true);?>
<?php if(!is_user_logged_in()):?>
<div class="error">
    <p> <?php printf(__("You must be <a href='%s'>logged in</a> to add a comment.",'buggm'),wp_login_url(get_permalink(buggm_get_the_ticket_post_id())));?></p>
</div>
<?php endif; ?>