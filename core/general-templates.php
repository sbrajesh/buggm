<?php
function buggm_archive_title(){
    echo buggm_get_archive_title();
}
function buggm_get_archive_title(){
    if(is_home())
        $title="";
    else if(is_category())
        $title=sprintf(__('Browsing Category: %s', 'buggm'), '<span class="context-term">'.single_cat_title('',false).'</span>');
    elseif(is_tag())
        $title=sprintf(__('Posts tagged %s', 'buggm'), '<span class="context-term">'.single_tag_title('', false).'</span>');
    elseif(is_day())
        $title= sprintf(__('Archive for %s', 'buggm'), '<span class="context-term">'.get_the_date().'</span>'); 
    elseif(is_month())
        $title=sprintf(__('Archive for %s', 'buggm'), '<span class="context-term">'.get_the_time('F, Y').'</span>');
   elseif(is_year())
        $title=sprintf(__('Archive for year %s', 'buggm'), '<span class="context-term">'.get_the_time('Y').'</span>');
   
   else if(is_tax()){//for custom taxonomies
       $term=get_queried_object();
       $tax=get_taxonomy($term->taxonomy);
       $title=sprintf(__('Browsing %s: %s', 'buggm'),'<span class="context-taxonomy">'.$tax->labels->singular_name.'</span>', '<span class="context-term">'.single_term_title ('',false).'</span>');
       
   }
   else if(is_singular()){
       if(is_singular('ticket'))
           $title=__('Ticket');
   }
   else if(is_author())
       $title="";
   else if(is_404())
       $title="Page Not Found!";
   else if(buggm_is_search())
       $title=__('Tickets Search','buggm');
    else if(is_post_type_archive())
        $title=sprintf(__(' %s', 'buggm'), '<span class="context-term">'.post_type_archive_title ('',false).'</span>');
   else
       $title=__('Blog Archives', 'buggm'); 
   
return apply_filters('buggm_archive_title',$title);
   
}
?>