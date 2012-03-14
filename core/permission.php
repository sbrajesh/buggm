<?php
function buggm_get_all_caps(){
    return array('buggm_create_ticket'=>true,'buggm_add_comment'=>true,'buggm_upload_file'=>true);
}
//mix roles
add_filter('user_has_cap','buggm_user_caps',10,3);
function buggm_user_caps($allcaps,$caps,$args){
    if(!is_user_logged_in())
        return $allcaps;
    //allow all non logged in user to 
    $buggm_caps=buggm_get_all_caps();   
    $allcaps=array_merge($allcaps,$buggm_caps);
   
    return $allcaps;
}



?>