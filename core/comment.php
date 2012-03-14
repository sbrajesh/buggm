<?php
//do_action('comment_post', $comment_ID, $commentdata['comment_approved']);
//do_action('trash_comment', $comment_id);
//do_action('delete_comment', $comment_id);
/*
 * Comment Related
 */
/**
 * used by wp_list_comments to format the comment
 * @param type $comment
 * @param type $args
 * @param type $depth 
 */
function buggm_format_ticket_comment( $comment, $args, $depth ) {	
	$GLOBALS[ 'comment' ] = $comment;
	
        $updates =buggm_get_ticket_changes(get_comment_ID());
		
	$i = 0;
    ?>
	<li <?php comment_class( 'ticket-comment' ); ?> id="comment-<?php comment_ID(); ?>"> 
		<span class="alignright"><a href="<?php  echo get_comment_link();?>"><?php _e('permalink','buggm');?></a></span>
		<div class="commenter-info"> 
			<span class="commenter-avatar">
                            <a href="<?php echo buggm_get_user_url($comment->user_id); ?>">
                                   <span class='avatar'> <?php echo buggm_get_avatar($comment->user_id, 24);?> </span>
                                   <?php echo buggm_get_user_name($comment->user_id);?>
                            </a> 
                        </span>
                        <small><?php printf( __( 'about <em>%s</em> ', 'buggm' ), buggm_time_since( get_comment_time( 'U' ),current_time( 'timestamp' )  )); ?></small>
		</div> 
                    <div class="clear"></div>
		<div class="comment-info"> 
		
			<div class="comment-entry">
			
				<?php comment_text(); ?>
				
				<?php if( $updates ) : ?>
					
					<ul class="update-list">
						<?php foreach( $updates as $update ) : ?>
							<li><?php echo $update; ?></li>
						<?php endforeach; ?>
					</ul>
					
				<?php endif; ?>
				
			</div>
			
		</div>
<?php
	
}
/**
 * Create and save a comment
 */
//needs improvement
function buggm_save_comment(){
    //verify the comment
    if(!check_admin_referer('buggm_new_comment')||!current_user_can('buggm_add_comment')){
        buggm_add_user_feedback(__('You are not authorized!','buggm'),'error');
        return;
        
    }
    //if the comment is not valid, inform user    
    if(!buggm_is_valid_comment()){
        buggm_add_user_feedback(__('No changes were made!','buggm'),'error');
        return;
    }
    //add comment to database
    $comment_id=buggm_add_comment();
    buggm_add_user_feedback(__('Ticket updated successfully','buggm'));
     do_action('buggm_new_comment',$comment_id);
     //now redirect
            wp_redirect( get_comment_link( $comment_id) );
            exit(0);
    
}
//creates comment, no validation, nothing here, check buggm_save_comment 
function buggm_add_comment($post_id=false){
    $user_id=buggm_get_current_user_id();
    $post=wp_get_single_post($post_id);
   // echo "I am called";
    //wp_die("yehhh");
    $content=$_POST['comment'];
    //validate nonce
    $commentdata=array(
        'comment_approved'=>1,
        'comment_post_ID'=>$post->ID,
        'user_id'=>$user_id,
        'comment_author'=>  buggm_get_user_name($user_id),
        'comment_content'=>$content,
        
        );
    $comment_id=wp_insert_comment($commentdata);
    
   
    return $comment_id;
}
//not implemented in v1.0
//we will not need it anyway
function buggm_update_comment(){
    do_action('buggm_update_comment');
}

/**
 * Record properties changes(except the resolution)
 */
add_action('buggm_new_comment','buggm_record_taxonomy');
//for each component, we will record the change in the taxonomy/status
function buggm_record_taxonomy($comment_id){
     $comment=get_comment($comment_id);
     $ticket_id=$comment->comment_post_ID;
     $taxonomies=buggm_get_all_taxonomies();
     $resolution_taxonomy=buggm_get_resolution_taxonomy();
     $keywords_taxonomy=buggm_get_keywords_taxonomy();
    foreach($taxonomies as $taxonomy){
        if($taxonomy==$resolution_taxonomy||$taxonomy==$keywords_taxonomy)
            continue;//do not record change in resolution, let us relay it to the function which records ticket status change
        
     $old_term_id=buggm_get_term_id($ticket_id, $taxonomy);
     $new_term_id=$_POST['tax_input'][$taxonomy];
     $info=buggm_prepare_change_info($comment_id, $new_term_id, $old_term_id, $taxonomy);
      if(!empty($info)){
          buggm_record_ticket_change($comment_id, $info);   
          
          if(is_numeric($new_term_id))
              $new_term_id=intval ($new_term_id);//otherwise ternm will be arrray for the tags/keywords
        
          wp_set_object_terms($ticket_id, $new_term_id, $taxonomy);
      }
    }
  
    
}

?>