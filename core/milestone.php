<?php
function buggm_get_milestone_taxonomy(){
    $settings=buggm_get_settings();
    $taxonomy=$settings->get_taxonomy('milestone');
    return $taxonomy;
}
function buggm_get_ticket_milestone($ticket_id=false){
    //get current ticket post id
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
    
    return  get_the_term_list( $ticket_id, buggm_get_milestone_taxonomy(), '', ',', '' );
}


function buggm_get_ticket_milestone_id($ticket_id=false){
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
    return buggm_get_term_id($ticket_id, buggm_get_milestone_taxonomy());
}

function buggm_update_ticket_milestone($ticket_id,$milestone_id){
    
    $updates=wp_set_object_terms($ticket_id, $milestone_id, buggm_get_milestone_taxonomy());
    if(!is_wp_error($updates))
        return true;
    return false;
}

function  buggm_list_ticket_milestone_dd($ticket_id=false){
    //if ticket id is vine, the last selected term should be selected
    $selected=0;
    $taxonomy=buggm_get_milestone_taxonomy();
    
    if($ticket_id){
        $selected=wp_get_object_terms($ticket_id, $taxonomy,array('fields' => 'ids'));
        $selected=  array_pop($selected);
    }
    echo buggm_list_terms(array('taxonomy'=>$taxonomy,'selected'=>$selected));
 }
//record mileston changes
 //add_action('buggm_new_comment','buggm_record_milestone_change');
 function buggm_record_milestone_change($comment_id){
     $comment=get_comment($comment_id);
     
     $old_term_id=buggm_get_ticket_milestone_id($comment->comment_post_ID);
     $taxonomy=buggm_get_milestone_taxonomy();
     
     $new_term_id=$_POST['tax_input'][$taxonomy];
     $info=buggm_prepare_change_info($comment_id, $new_term_id, $old_term_id, $taxonomy);
    //call record function
     if(!empty($info))
        buggm_record_ticket_change($comment_id, $info);
 }
 
?>