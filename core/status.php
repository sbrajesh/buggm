<?php
/**
 * print current ticket status(new/closed/reopened etc)
 */
function buggm_ticket_status(){
    echo buggm_get_ticket_status();
}
/**
 * Return the ticket status
 * @param type $ticket_id
 * @return string status 
 */
function buggm_get_ticket_status($ticket_id=false,$linked=true){
    //get current ticket post id
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
   
    $settings=buggm_get_settings();
    $status=  get_post_meta( $ticket_id,$settings->get_status_key_name(), true );
    if(!$linked)
        return $status;
    $url=get_post_type_archive_link($settings->get_post_type())."?ticket_status={$status}";
    return sprintf(__('<a href="%1$s"  title="%2$s" class="%3$s">%4$s</a>'),$url,__('Tickets with status ', 'buggm').$status,'ticket-status status-'.$status, $status);
    
}
/**
 * Updates the current ticket status in the ticket meta
 * @param type $ticket_id
 * @param type $resolution
 * @return type 
 */
function buggm_update_ticket_status($ticket_id,$status){
    //get current ticket post id
    //check for allowed resolution
   $settings=buggm_get_settings();
   if(buggm_is_valid_ticket_status($status))
        return  update_post_meta( $ticket_id,$settings->get_status_key_name(), $status );
   return false;
}
/**
 * Not very useful, just a reminder of what status a ticket can have
 * @return type 
 */
function buggm_get_possible_status(){
    return apply_filters('buggm_valid_ticket_status',array('new','closed','reopened','assigned','accepted'));
    
}
function buggm_is_valid_ticket_status($status){
    $valid_status=buggm_get_possible_status();
    if(in_array($status, $valid_status))
            return true;
    return false;
}

//Record the change in ticket status when the ticket properties are changed/comment is added
add_action('buggm_new_comment','buggm_record_status_change');
function buggm_record_status_change($comment_id){
     $comment=get_comment($comment_id);
     $ticket_id=$comment->comment_post_ID;
     $current_status=buggm_get_ticket_status($ticket_id,false);
     
     if($_POST['buggm_action']=='leave')
         return;//we are leaving the ticket as it is
     switch($_POST['buggm_action']){
         case 'resolve':
             $new_status='closed';
             //record resolution here
             
             break;
         case 'reassign':
              $new_status='assigned';
             //assigned to whom ?
             $assigned_users=buggm_get_ticket_owners($ticket_id);//list of users assigned to
             $assigned_users=explode(',',$assigned_users);
             $new_assigned_users=$_POST['buggm_assign_to'];
             $new_assigned_users=explode(',',$new_assigned_users);
             buggm_record_ticket_owner_change($new_assigned_users, $assigned_users,$ticket_id,$comment_id);
             break;
         case 'reopen':
              $new_status='reopened';
             //no need to do it, the comment record taxonomy will delete the resolution and d its jobs
             $info=buggm_prepare_change_info($comment_id, 0, buggm_get_ticket_resolution_id($ticket_id), buggm_get_resolution_taxonomy());
             //delete resolution
             
            // $info="Iban batuta";
             buggm_update_ticket_resolution($ticket_id, 0);//delete resolution
              buggm_record_ticket_change($comment_id, $info);
              unset($info);
             break;
         case 'accept':
             $new_status='accepted';
             //set the current user as the owner of the ticket
             global $current_user;
             get_currentuserinfo();
             $new_assigned_users=array($current_user->user_login);
             //buggm_update_ticket_owner($ticket_id,$new_assigned_users );
              $assigned_users=buggm_get_ticket_owners($ticket_id);//list of users assigned to
             $assigned_users=explode(',',$assigned_users);
             buggm_record_ticket_owner_change($new_assigned_users, $assigned_users,$ticket_id,$comment_id);
             break;
     }
     
    
       
   
     
    //now check if status is changed
     if(empty($current_status))
         $current_status='new';//fallback
    if($current_status!=$new_status){
        buggm_update_ticket_status($ticket_id, $new_status);
        $info=sprintf(__('<strong>%s</strong> changed from %s to %s','buggm'),__('Status','buggm'),$current_status,$new_status);
    }
 if(!empty($info))
      buggm_record_ticket_change($comment_id, $info);   
}
?>