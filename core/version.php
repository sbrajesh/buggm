<?php

/*
 *Version related
 */
function buggm_get_version_taxonomy(){
    $settings=buggm_get_settings();
    $taxonomy=$settings->get_taxonomy('version');
    return $taxonomy;
}


/**
 * is version enabled for the current instance
 * @return type 
 */

function buggm_is_version_enabled(){
    $settings=buggm_get_settings();
    return $settings->is_enabled(buggm_get_version_taxonomy());
}
/**
 * Does version taxonomy has terms
 * @return type 
 */
function buggm_is_version_empty(){
    return buggm_is_taxonomy_empty(buggm_get_version_taxonomy());
}

function buggm_list_versions($args){
    
}


function buggm_get_ticket_version($ticket_id=false){
    //get current ticket post id
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
   
    return  get_the_term_list( $ticket_id, buggm_get_version_taxonomy(), '', ',', '' );
}


function buggm_get_ticket_version_id($ticket_id=false){
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
    $term=get_the_terms($ticket_id, buggm_get_version_taxonomy());
    if(!is_wp_error($term))
        return $term[0]->term_id;
    return 0;//0 is invalid
}

function buggm_update_ticket_version($ticket_id,$version_id){
    
    $updates=wp_set_object_terms($ticket_id, $version_id, buggm_get_version_taxonomy());
    if(!is_wp_error($updates))
        return true;
    return false;
}

function  buggm_list_ticket_version_dd($ticket_id=false){
    //if ticket id is vine, the last selected term should be selected
    $selected=0;
    $taxonomy=buggm_get_version_taxonomy();
    
    if($ticket_id){
        $selected=wp_get_object_terms($ticket_id, $taxonomy,array('fields' => 'ids'));
       
        $selected=  array_pop($selected);
    }
    echo buggm_list_terms(array('taxonomy'=>$taxonomy,'selected'=>$selected));
 }

   //record Type  changes
 //add_action('buggm_new_comment','buggm_record_version_change');
 function buggm_record_version_change($comment_id){
     $comment=get_comment($comment_id);
     
     $old_term_id=buggm_get_ticket_version_id($comment->comment_post_ID);
     $taxonomy=buggm_get_version_taxonomy();
     
     $new_term_id=$_POST['tax_input'][$taxonomy];
     $info=buggm_prepare_change_info($comment_id, $new_term_id, $old_term_id, $taxonomy);
    //call record function
     if(!empty($info))
        buggm_record_ticket_change($comment_id, $info);
 }
 
?>