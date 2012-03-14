<?php

/*
 * Controls the mailing behaviour of the Buggm
 *  */


function buggm_get_message($ticket_id,$comment){
        $message="";
        ob_start();
	buggm_load_message_template($ticket_id,$comment);
	$message = ob_get_contents();
	ob_end_clean();
	
	return $message;
}

function buggm_get_message_headers($user_emails){
    if(is_array($user_emails))
        $user_emails=join(',',$user_emails);
    
    $site_name=wp_specialchars_decode( get_bloginfo('name'), ENT_QUOTES );
    $domain = (array) explode( '/', site_url() );
    $from_email=apply_filters( 'buggm_email_from_address_filter', 'noreply@' . $domain[2] );
    

    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

    // Additional headers
    $headers .= "To: {$user_emails}" . "\r\n";
    $headers .= "From: {$site_name} <{$from_email}>" . "\r\n";
    return $headers;
}

function buggm_send_mail($emails,$subject,$message){
       
    $message_headers=buggm_get_message_headers($emails);
    wp_mail($emails, $subject, $message, $message_headers);
}

//let us attach some controller for new ticket post/new ticket comment
//on new ticket, send email
add_action('buggm_new_ticket','buggm_send_mail_to_site_owner_on_new_ticket',200,2);
function buggm_send_mail_to_site_owner_on_new_ticket($ticket_id,$comment_id){
    if(!empty($comment_id))
        $comment=get_comment ($comment_id);
    else
        $comment=false;
    $message=buggm_get_message($ticket_id, $comment);
    
    $subject=sprintf("[%s] #%d: %s",get_bloginfo('name'),  $ticket_id,get_the_title($ticket_id));
    $users=buggm_get_admin_user_ids();
    $emails=buggm_get_email_list_from_user_ids($users);
    //foreach($users as $user_id)
   buggm_send_mail($emails, $subject, $message);
}

//on new comment, send email
add_action('buggm_new_comment','buggm_send_emails_on_new_comment',200);
function buggm_send_emails_on_new_comment($comment_id){
    $comment=get_comment($comment_id);
    $ticket_id=$comment->comment_post_ID;
    
    $message=buggm_get_message($ticket_id, $comment);
    
    $subject=sprintf("[%s] #%d: %s",get_bloginfo('name'),  $ticket_id,get_the_title($ticket_id));
    $admin_users=buggm_get_admin_user_ids();
   
    $cc_users=buggm_get_cced_user_ids($ticket_id);
    $users=array_merge($admin_users,$cc_users);
   
    $emails=buggm_get_email_list_from_user_ids($users);
        buggm_send_mail($emails, $subject, $message);
}


add_filter('wp_mail_content_type','buggm_set_content_type');

function buggm_set_content_type($content_type){
    return 'text/html';
}
?>