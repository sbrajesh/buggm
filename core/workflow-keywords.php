<?php

/*
 *Workflow Keywords related
 */
function buggm_get_keywords_taxonomy(){
    $settings=buggm_get_settings();
    $taxonomy=$settings->get_taxonomy('keywords');
    return $taxonomy;
}


function buggm_get_ticket_keywords($ticket_id=false){
    //get current ticket post id
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id();
    
    return  get_the_term_list( $ticket_id, buggm_get_keywords_taxonomy(), '', ',', '' );
}


function  buggm_list_ticket_keywords_dd($ticket_id=false){
    //if ticket id is vine, the last selected term should be selected
    $selected=0;
    $taxonomy=buggm_get_keywords_taxonomy();
    
    if($ticket_id){
        $selected=wp_get_object_terms($ticket_id, $taxonomy,array('fields' => 'ids'));
        $selected=  array_pop($selected);
    }
    echo buggm_list_terms(array('taxonomy'=>$taxonomy,'selected'=>$selected,'name'=>'new_tax_input'));
 }
 function buggm_list_ticket_keywords_editable($ticket_id=false,$current_terms=array()){
    if(!$ticket_id)
        $ticket_id=buggm_get_the_ticket_post_id ();
    
    $taxonomy=buggm_get_keywords_taxonomy();
   
    if($ticket_id&&empty($current_terms)){
        $terms=wp_get_object_terms($ticket_id, $taxonomy,array('fields' => 'all'));//we have all the terms here
        if(is_wp_error($terms))
            return;
      
    }
    else if(!empty($current_terms)){
        //we have tax ids
        foreach($current_terms as $term_id)
        $terms[]=get_term($term_id,$taxonomy);
    }
    if(!empty($terms))
     foreach($terms as $term)
            echo "<input type='hidden' name='tax_input[keywords][]' id='hidden-keywords-".$term->term_id."' value='".$term->term_id."' /><span id='list-keywords-".$term->term_id."' class='kw-selected'>{$term->name}<span class='kw-remove'>X</span></span>";
    
 }
   //record keywords change, this is  special case
 
   add_action('buggm_new_comment','buggm_record_keywords_change');
  
 function buggm_record_keywords_change($comment_id){
     $comment=get_comment($comment_id);
     $ticket_id=$comment->comment_post_ID;
     
     $taxonomy=buggm_get_keywords_taxonomy();
   
     //get old keywords ids
     $old_term_ids=buggm_get_term_ids($ticket_id, $taxonomy);//array
     //get new keywords ids
     $new_term_ids=$_POST['tax_input'][$taxonomy];//array hopefully
     //if new ids are null, convert to array in all other cases, it will be array
     if(!is_array($new_term_ids))
         $new_term_ids=array();
     //find the difference between the two
     $diff=array_diff(array_merge($old_term_ids,$new_term_ids), array_intersect($old_term_ids, $new_term_ids));//I guess we are looking for A U B - A Intersecton B
     //if either of the term ids are not empty and the diff is not empty
     if(($old_term_ids||$new_term_ids)&&!empty($diff)){
         //consider the changes/differences
                 
         
         $deleted=array_diff($old_term_ids,$new_term_ids);
         //find added terms
         $added=array_diff($new_term_ids,$old_term_ids);
         if(!empty($deleted)){
             foreach($deleted as $term_id){
                 $term=get_term($term_id, $taxonomy);
                 $deleted_terms[]=$term->name;
              
             }
           $info[]=sprintf(__("%s removed",'buggm'),join(',',$deleted_terms));   
         }
         //find added terms
         if(!empty($added)){
             foreach($added as $term_id){
                 $term=get_term($term_id, $taxonomy);
                 $added_terms[]=$term->name;
             }
         $info[]=sprintf("%s added",join(',',$added_terms));
         }
         //build an information text
         if(!empty($info))
             $info_text=__("<strong>Keywords</strong> ",'buggm').join('; ',$info);
     }
    
    //I don't understand why but wp does not take it kindly when passing the values coming from form as terms array
     $new_term_ids=array_map('intval', $new_term_ids);
     wp_set_object_terms($ticket_id, $new_term_ids, $taxonomy);     
    //call record function
     if(!empty($info_text))
        buggm_record_ticket_change($comment_id, $info_text);
 }
?>