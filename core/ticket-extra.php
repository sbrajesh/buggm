<?php

/*** User related**/

function buggm_get_user_ids_from_user_names($user_names){
    if(is_string($user_names))
        $user_names=explode (',', $user_names);
    $user_ids=array();
    if(empty($user_names))
        return $user_ids;
    foreach($user_names as $user_name){
        //get the user is and add it to user meta
        $user=get_user_by('login',$user_name);//returns bool or object
        if(!empty($user))
            $user_ids[]=$user->ID;
        
       
      }
   return $user_ids;   
}
/*
 * we assume a list of owner usernames are passed
 */
function buggm_update_ticket_owner($ticket_id,$owners){
    //$owner_users=explode(',',$owners);
    //get user ids
    //delete existing owners
    $settings=buggm_get_settings();
    $meta_key=$settings->get_owners_key_name();
    delete_post_meta($ticket_id, $meta_key);
    foreach($owners as $owner_user){
        //get the user is and add it to user meta
        $user=get_user_by('login',$owner_user);
        add_post_meta($ticket_id, $meta_key, $user->ID);//add it to user meta(yes multiple meta keys with same name)
    }
    
}

function buggm_get_ticket_owner_ids($ticket_id){
    $settings=buggm_get_settings();
   
    return get_post_meta($ticket_id, $settings->get_owners_key_name());
}

/**
 * returns the list of usernames separated with comma
 * @param type $ticket_id
 * @return type 
 */
function buggm_get_ticket_owners($ticket_id,$linked=false){
   
    $owners=  buggm_get_ticket_owner_ids($ticket_id);
    if(empty($owners))
      return '';
  $owner_list=array();
  foreach($owners as $owner_id){
      if($linked){
          $owner_list[]=buggm_get_user_link($owner_id);
          continue;
      }
      $user=get_user_by('id',$owner_id);
      $owner_list[]=$user->user_login;
  }
  return join(",",$owner_list);
    
}
function buggm_list_ticket_owners($ticket_id,$linked=false){
    echo buggm_get_ticket_owners($ticket_id,$linked);
}
function buggm_record_ticket_owner_change($new_owners,$old_owners,$ticket_id,$comment_id){
           
            $diff=array_diff(array_merge($old_owners,$new_owners), array_intersect($old_owners,$new_owners));//I guess we are looking for A U B - A Intersecton B
           
             if(empty($diff)||(!$old_owners&&!$new_owners))//
                 return;
             buggm_update_ticket_owner($ticket_id, $new_owners);
             if(empty($old_owners))
                 $info=sprintf (__('<strong>Owner</strong> set to %s','buggm'),join(',',$new_owners));
             else if(empty($new_owners))
                 $info=sprintf (__('<strong>Owner</strong> %s deleted','buggm'),join(',',$old_owners));
             else
                 $info=sprintf (__('<strong>Owner</strong> changed from %s to %s','buggm'),join(',',$old_owners),join(',',$new_owners));
             
             if(!empty($info))
                    buggm_record_ticket_change($comment_id, $info);   
            
}
/**
 * Ticket CC functionality
 * //add user/users to cc list
 * //remove user from cc list
 * //get all cssd users
 * @param type $ticket_id
 * @param type $username 
 */


function buggm_add_user_to_cc_list($ticket_id,$users=array()){
    $settings=buggm_get_settings();
    $meta_key=$settings->get_cc_key_name();
    foreach($users as $user_id){
        add_post_meta($ticket_id, $meta_key, $user_id);
    }
    
}

function buggm_remove_user_from_cc_list($ticket_id,$user_id){
    $settings=buggm_get_settings();
    $meta_key=$settings->get_cc_key_name();
    delete_post_meta($ticket_id, $meta_key, $user_id);//only delete this user from the list
}
function buggm_get_cced_user_ids($ticket_id){
    $settings=buggm_get_settings();
    $meta_key=$settings->get_cc_key_name();
    return get_post_meta($ticket_id, $meta_key);
}
function buggm_list_cced($ticket_id){
    echo buggm_get_cced_list($ticket_id);
}
function buggm_is_user_in_cc_list($ticket_id,$user_id){
    $ccd_users=buggm_get_cced_user_ids($ticket_id);
    
    if(empty($ccd_users)||!in_array($user_id, $ccd_users))
            return false;
    return true;
}

function buggm_get_cced_list($ticket_id){
   $ccds=buggm_get_cced_user_ids($ticket_id);
  if(empty($ccds))
      return '';
  $ccd_list=array();
  foreach($ccds as $ccd_user){
      $user=new WP_User($ccd_user);
      $ccd_list[]=$user->user_login;//we will strip the domain
  }
  return join(",",$ccd_list);
}

/**
 * add new ticket, save to database
 */

function buggm_add_new_ticket(){
    if(!empty($_POST['action'])&&$_POST['action']=='buggm_new_ticket'){
        //we are sure someone has tried to post a ticket
        //let us verify
        if(!check_admin_referer( 'buggm_new_ticket' )||!current_user_can('buggm_create_ticket')){
            buggm_add_user_feedback(__('You are not authorized.','buggm'),'error');
            return;
        }
       
      //if we are here, the user can create ticket
        $ticket_data=array();
        //validate
        if(empty($_POST['ticket_title'])||empty($_POST['ticket_description'])){
            buggm_add_user_feedback(_('Please do not leave the title or the description blank','buggm'),'error');
            return;
        }
        
       
        $post_data=array(
            'post_type'=>'ticket',
            'post_status'=>'publish',
            'post_author'=>  buggm_get_current_user_id(),
            'post_content'=>$_POST['ticket_description'],
            'post_title'=>$_POST['ticket_title'],
            'comment_status'=>'open'
        );
         
        $ticket_id=wp_insert_post($post_data);
        if(!empty($ticket_id)&&!is_wp_error($ticket_id)){
            //update various taxonomies information
            //or should we hook out ?
            if(!empty($_POST['tax_input'])){
                
                $tax_terms=$_POST['tax_input'];//array and may be multidimensional and key as the taxonomy name
                foreach($tax_terms as $taxonomy => $term_ids){
                    if(is_array($term_ids))
                        $term_ids=array_map('intval',$term_ids);//don't ask me why?, I am not sure why wordpress considers the array as string and not numeric array by default 
                    else                        
                        $term_ids=intval ($term_ids);
                    wp_set_object_terms($ticket_id, $term_ids, $taxonomy,false);//override
                }
            
                
            }
            //update ticket status, set it to new
            buggm_update_ticket_status($ticket_id, 'new');
            buggm_add_user_feedback(__('Ticket successfully created!','buggm'));
            if(!empty($_POST['ticket_cc'])){
                $users_to_be_ccd=esc_html($_POST['ticket_cc']);
                $user_ids=buggm_get_user_ids_from_user_names(explode(',',$users_to_be_ccd));
                if(!empty($user_ids))
                    buggm_add_user_to_cc_list($ticket_id,$user_ids);
            }
            if(!empty($_POST['ticket_owner'])){
                $owners=esc_html($_POST['ticket_owner']);
                //$user_ids=buggm_get_user_ids_from_user_names(explode(',',$owners));
                if(!empty($owners))
                    buggm_update_ticket_owner ($ticket_id,explode(',',$owners));
            }
            
            $comment_id=false;//we are not sure if we will add a comment with upload information
            //check for file upload
            if($_FILES['ticket_attachment']['error'] != UPLOAD_ERR_NO_FILE)
                    $comment_id=buggm_add_comment($ticket_id);//now we are sure
           
            do_action('buggm_new_ticket',$ticket_id,$comment_id);
            
            //now redirect to the ticket page
            wp_redirect( get_permalink( $ticket_id ) );
            exit(0);
        }
    }
}

function buggm_has_cc_changed($ticket_id=false){
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id ();
    if(buggm_is_add_to_cc($ticket_id)||  buggm_is_remove_from_cc($ticket_id))
        return true;
    return false;
    
     
     return false;
}

function buggm_is_add_to_cc($ticket_id){
   
        $cc_action=$_POST['cc_action'];
     
         if(empty ($cc_action))
             return false;//no change
     //find users already in the cc list
     $ccd_users=buggm_get_cced_user_ids($ticket_id);
    //find the current action and 
     if($cc_action=='add'){
         
         $users_to_add=$_POST['ticket_cc'];
         if(empty($users_to_add))
             return false;//no one is there to add
         $users_to_add_ids=buggm_get_user_ids_from_user_names($users_to_add);
         //find if a user in the add list is not in the original list
         $new_cc_users=array_diff($users_to_add_ids,$ccd_users);
         if(!empty($new_cc_users))
             return true;
         return false;
     }
     return false;
}
function buggm_is_remove_from_cc($ticket_id){
     $cc_action2=$_POST['remove_from_cc'];
     if(empty($cc_action2))
         return false;
    
     if($cc_action2=='remove'){
         //get current user id
         $ccd_users=buggm_get_cced_user_ids($ticket_id);
         $current_user_id=buggm_get_current_user_id();
         if(in_array($current_user_id, $ccd_users))
                 return true;
         return false;
         
     }
     return false;
}
/*update ccc list on new comment*/
 add_action('buggm_new_comment','buggm_record_cc_change');
  
 function buggm_record_cc_change($comment_id){
     $comment=get_comment($comment_id);
     $ticket_id=$comment->comment_post_ID;
     if(!buggm_has_cc_changed($ticket_id))
         return ;
     //so we are sure that the ticket cc has changed//
     $ccd_users=buggm_get_cced_user_ids($ticket_id);
     
     //get current users
     
     $cc_action=$_POST['cc_action'];
  
         if($cc_action=='add'){
             //it is asking to add the users to list
             $user_names=$_POST['ticket_cc'];
             $new_ccd_users=buggm_get_user_ids_from_user_names($user_names);
             $users_to_add=array_diff($new_ccd_users,$ccd_users);
            
        if(!empty($users_to_add)){
            buggm_add_user_to_cc_list($ticket_id,$users_to_add);
            //let us add 
             $info=sprintf(__('<strong>CC</strong> %s added.','buggm'),  esc_html($user_names));
             buggm_record_ticket_change ($comment_id, $info);
        }
       
       }  
    
     $cc_action2=$_POST['remove_from_cc'];
     if($cc_action2=='remove'){
            $user_id=buggm_get_current_user_id();
            buggm_remove_user_from_cc_list($ticket_id, $user_id);
            global $current_user;
            $info=sprintf(__('<strong>CC</strong> %s removed.','buggm'),$current_user->user_login);
            buggm_record_ticket_change ($comment_id, $info);
         }   
     
     
     
 }  
?>