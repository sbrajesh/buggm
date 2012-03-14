<?php
/**
 * Reporter User related
 */
function buggm_the_reporter_id(){
    echo buggm_get_the_reporter_id();
}

function buggm_get_the_reporter_id(){
    global $authordata;
    return $authordata->ID;
}

function buggm_the_reporter_name(){
    echo buggm_get_the_reporter_name();
}
function buggm_get_the_reporter_name(){
    return get_the_author();
}

//can be used outside the loop

function buggm_get_reporter_name($reporter_id){
   return buggm_get_user_name($reporter_id);
}

function buggm_get_reporter_link($user_id){
    return buggm_get_user_link($user_id);
}
function buggm_get_reporter_url($reporter_id) {
	return buggm_get_user_url($reporter_id);
}


?>