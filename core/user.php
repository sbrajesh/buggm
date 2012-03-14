<?php
/**
 * Generic User related functions
 * @param type $user_id
 * @return type 
 */

function buggm_get_user_name($user_id){
    $user = get_userdata($user_id);
    return $user->display_name;
}


function buggm_get_avatar($user_id,$size=16,$linked=false){
    $avatar=get_avatar($user_id, $size);
   
    if(!$linked)
        return $avatar;
    $link=sprintf("<a href='%s'>%s</a>",buggm_get_user_url($user_id), $avatar);
    return $link;
}
/**
 * Get User ids by Role for a blog/site
 * @param type $role 
 */
function buggm_get_user_ids_by_role($role){
     $ids=array();
     $users=get_users(array('role'=>$role));
     foreach((array)$users as $user){
         $ids[]=$user->ID;
     }
     return $ids;
} 
function buggm_get_admin_user_ids() {
        return buggm_get_user_ids_by_role('administrator');
}
/**
 * Retuns emails of the users as an array
 * @global type $wpdb
 * @param type $users
 * @param type users
 * @return type 
 */
function buggm_get_email_list_from_user_ids($users){
    if(empty($users))
        return false;
    if(!is_array($users))
        $users=(array)$users;
    
      $user_list=join(',',$users);
    
    global $wpdb;
    $query="SELECT user_email FROM {$wpdb->users} WHERE ID IN ({$user_list})";
    
    $emails=$wpdb->get_col($wpdb->prepare($query));
    return $emails;
}

?>