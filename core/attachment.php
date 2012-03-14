<?php
/**
 * Attachement related
 */
/**
 * action functions
 */
add_action('buggm_new_ticket','buggm_add_attachment_on_new_ticket',10,2);
//we always store upload information in comment
function buggm_add_attachment_on_new_ticket($ticket_id,$comment_id=false){
    if(empty($comment_id))
        return ;
    $attachment= buggm_handle_upload_attachment($ticket_id, 'ticket_attachment','buggm_new_ticket');
    
    if(!empty($attachment)&&!is_wp_error($attachment)) {
       $info=sprintf(__("added <a href='%s'>%s</a>",'buggm'),wp_get_attachment_url($attachment ),buggm_get_attached_file_name($attachment)); 
       buggm_record_ticket_change($comment_id, $info);

   }
}
//comment 
function buggm_add_attachment_on_update($comment_id){
   $comment=get_comment($comment_id);
   $ticket_id=$comment->comment_post_ID;
   $attachment= buggm_handle_upload_attachment($ticket_id, 'ticket_attachment','buggm_new_comment');
   //record it in the comment meta
   if(!empty($attachment)&&!is_wp_error($attachment)) {
       $info=sprintf(__("added <a href='%s'>%s</a>",'buggm'),wp_get_attachment_url($attachment ),buggm_get_attached_file_name($attachment)); 
       buggm_record_ticket_change($comment_id, $info);

   }
}

add_action( 'buggm_new_comment', 'buggm_add_attachment_on_update' );
function buggm_delete_attachement(){
    
}
/**
 * Handle attachment upload
 * @param type $ticket_id
 * @param type $input_field_name
 * @return type 
 */
function buggm_handle_upload_attachment($ticket_id,$input_field_name,$action){
        require_once( ABSPATH . 'wp-admin/includes/admin.php' );
        $post_data=array();
        $override=array('test_form'=>false,'action'=>$action);
	$attachment = media_handle_upload( $input_field_name, $ticket_id ,$post_data,$override);
	
	return $attachment;
}
/**
 * List the recent uploads as an unordered list
 * @param type $ticket_id 
 */
function buggm_list_attachment($ticket_id=false){
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id ();
    $args = array(
	'post_type' => 'attachment',
	'numberposts' => null,
	'post_status' => null,
	'post_parent' => $ticket_id
);
    
    $attachments = get_posts($args);
    if ($attachments) :
       
        echo "<ul class='ticket-attachment-list'> ";
    
            foreach ($attachments as $post) :
                setup_postdata($post);?>
        	
                <li id="attachment-<?php the_ID(); ?>">
                    <a href="<?php echo wp_get_attachment_url($post->ID ); ?>"><?php echo buggm_get_attached_file_name($post->ID); //get_the_title($post->ID); ?></a>
                    <span class='attachment-meta-info'> <?php printf( __( 'by %1$s on %2$s', 'buggm' ), get_the_author(), buggm_time_since(get_the_time()) ); ?></span>
               </li>
											
            <?php endforeach; ?>
           <?php   
	echo "</ul>";
									
   endif;
   wp_reset_query();
 }
 
 /**
  * returns the filename without any path details for the uploaded file, e.g: abc.patch and so
  * @param type $attachment_id
  * @return type 
  */

 function buggm_get_attached_file_name($attachment_id){
     $file =get_attached_file($attachment_id);
     return basename($file);

 }
?>