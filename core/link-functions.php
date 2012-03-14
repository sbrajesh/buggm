<?php
function buggm_get_user_link($user_id){
    $link=sprintf("<a href='%s'>%s</a>",buggm_get_user_url($user_id),  buggm_get_user_name($user_id));
    return $link;
}

function buggm_get_user_url($user_id) {
	return get_author_posts_url($user_id);
}

function buggm_get_ticket_base_url(){
    $settings=buggm_get_settings();
   return get_post_type_archive_link($settings->get_post_type());//returns url with an appended /
}
/**
 * Get the url for ticket
 */
function buggm_get_user_tickets_url($user_id=false){
    if(!$user_id)
        return false;
    $user=new WP_User($user_id);
    if(!$user)
        return false;
    $user_login=$user->user_login;
    $url=buggm_get_ticket_base_url()."?ticket_owner=".$user_login;
    return apply_filters('buggm_user_tickets_url',$url,$user_id,$user);
}
?>