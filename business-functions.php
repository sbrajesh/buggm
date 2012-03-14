<?php

/*
 * Business Functions
 */

//ticket related
function buggm_get_the_ticket_post_id(){
    //for now, return current post id
    if(!(in_the_loop()||is_single()||is_singular()))
        return false;
    global $post;
    if(!empty($post))
        return $post->ID;
    return get_the_ID();
}

/*taxonomy functions*/
function buggm_create_taxomonies(){
    BuggMTaxonomy::get_instance();//initialize
}

function buggm_get_all_taxonomies(){
    $taxonomy_helper=BuggMTaxonomy::get_instance();
    return $taxonomy_helper->get_all();
}
function buggm_get_all_taxonomies_info(){
     $taxonomy_helper=BuggMTaxonomy::get_instance();
    return $taxonomy_helper->get_all_info();
}


/*post type*/
function buggm_create_ticket_post_type(){
    BuggMTicketHelper::get_instance();//initialize or make sure It was initialized earlier
}
/**
 * Associate the ticket post type to all the BuggM taxonomies
 */
function buggm_associate_ticket_to_taxomonies(){
   $ticket_helper= BuggMTicketHelper::get_instance();
   $ticket_helper->associate_to_taxonomies();
}

function buggm_get_ticket_post_type(){
    $ticket_helper=BuggMTicketHelper::get_instance();
    return $ticket_helper->post_type;
    
}


?>