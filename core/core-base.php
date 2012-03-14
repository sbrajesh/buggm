<?php
/**
 * Returns the current user id or false
 * @global type $current_user
 * @return boolean|int currently logged user id or false 
 */
function buggm_get_current_user_id(){
    if(!is_user_logged_in())
        return false;
    global $current_user;
    get_currentuserinfo();
    return $current_user->ID;
}
/**
 * Record the modification information in comment meta
 * @param type $comment_id
 * @param type $change_text 
 */
function buggm_record_ticket_change($comment_id,$change_text){
    $settings=buggm_get_settings();
    add_comment_meta($comment_id, $settings->get_updates_key_name(), $change_text);
}
/**
 * Return the list of changes as an array
 * @param type $comment_id
 * @return type 
 */

function buggm_get_ticket_changes($comment_id){
    $settings=buggm_get_settings();
    return get_comment_meta($comment_id, $settings->get_updates_key_name());
}

/*
*'show_option_all' => '', 'show_option_none' => '',
*'orderby' => 'id', 'order' => 'ASC',
*'show_last_update' => 0, 'show_count' => 0,
*'hide_empty' => 1, 'child_of' => 0,
*'exclude' => '', 'echo' => 1,
*'selected' => 0, 'hierarchical' => 0,
*'name' => 'cat', 'id' => '',
*'class' => 'postform', 'depth' => 0,
*'tab_index' => 0, 'taxonomy' => 'category',
*'hide_if_empty' => false
 */
/**
 * List the taxonomy as dropdown
 * @uses wp_dropdown_categories
 * @param type $args
 * @return type 
 */
function buggm_list_terms($args){
    $defaults=array(
        'show_option_all'=>1,
        'selected'=>0,
        'hide_empty'=>false,
        'echo'=>false
        
    );
    $args=wp_parse_args($args,$defaults);
    extract($args);
   
    if($show_option_all){
        $tax=get_taxonomy($taxonomy);
        $show_option_all=sprintf(__('Select %s','buggm'),$tax->labels->singular_name);
    }
    $always_echo=false;
    if(empty($name))
        $name =  'tax_input[' . $taxonomy . ']';
          
    
       $info= wp_dropdown_categories(array('taxonomy'=>$taxonomy,'hide_empty'=>$hide_empty,'name'=>$name,'id'=>'buggm-'.$taxonomy,'selected'=>$selected,'show_option_all'=>$show_option_all,'echo'=>false)) ;
   if($echo)
       echo $info;
   else
       return $info;
    
}
/**
 * return the term id associated with a ticket(Not applicable for keywords as multiple terms may be associate with a ticket)
 * @param type $ticket_id
 * @param type $taxonomy
 * @return int term_id
 */

function buggm_get_term_id($ticket_id,$taxonomy){
    $terms=get_the_terms($ticket_id, $taxonomy);
    
    if(!$terms)//on failure
        return 0;
    
    $term=array_pop($terms);
    
    return $term->term_id;
    
}
/**
 * Return an arry of term ids
 * @param type $ticket_id
 * @param type $taxonomy
 * @return mixed arry of term ids 
 */
function buggm_get_term_ids($ticket_id,$taxonomy){
    $ids=array();
    $terms=get_the_terms($ticket_id, $taxonomy);
    if(!$terms)//on failure
        return $ids;//empty array
    
    
    foreach($terms as $term)
        $ids[]=$term->term_id;
 
    return $ids;
}
/**
 * Conditionals
 */

/**
 * Does the new comment has some data entered or will it be a blank comment?
 * @return boolean(true|false)
 */
function buggm_has_comment_data(){
    if(!empty($_POST['comment']))
       return true;
    return false;
}

/**
 * check if any of the taxonomy other than keywords and resolution has changed
 * @return boolean
 */
function buggm_has_properties_changed(){
     $ticket_id=buggm_get_the_ticket_post_id();
     
     $taxonomies=buggm_get_all_taxonomies();
     $keyword_taxonomy=buggm_get_keywords_taxonomy();
     $resolution_taxonomy=buggm_get_resolution_taxonomy();
     
     $has_changed=false;
    foreach($taxonomies as $taxonomy){
        //we will handle the keyword and resolution separately
        if($taxonomy==$keyword_taxonomy||$taxonomy==$resolution_taxonomy)
            continue;
     
        $old_term_id=buggm_get_term_id($ticket_id, $taxonomy);
        $new_term_id=$_POST['tax_input'][$taxonomy];
         if($old_term_id!=$new_term_id){
             $has_changed=true;
             break;
         }
    }
  return $has_changed;
    
}
/**
 * Checks if resolution has changed
 * @return boolean 
 */
function buggm_has_resolution_changed(){
     $ticket_id=buggm_get_the_ticket_post_id();
     $resolution_taxonomy=buggm_get_resolution_taxonomy();
     $taxonomy=buggm_get_resolution_taxonomy();
     $has_changed=false;
     
     $old_term_id=buggm_get_term_id($ticket_id, $resolution_taxonomy);
     $new_term_id=$_POST['tax_input'][$taxonomy];
     if($_POST['buggm_action']=='resolve'&&$old_term_id!=$new_term_id)
         $has_changed=true;
     
     
     return $has_changed;
}
/**
 * check if any of the workflow keywords have changed
 * @return boolean 
 */
function buggm_has_keywords_changed(){
     $ticket_id=buggm_get_the_ticket_post_id();
     $taxonomy=buggm_get_keywords_taxonomy();
     $has_changed=false;
     
     $old_term_ids=buggm_get_term_ids($ticket_id, $taxonomy);//array
     $new_term_ids=$_POST['tax_input'][$taxonomy];//array hopefully
     $diff=array_diff($old_term_ids, (array)$new_term_ids);
     if(($old_term_ids||$new_term_ids)&&!empty($diff))
             $has_changed=true;
     
        return $has_changed;
}
/**
 * Checks if the ticket status has changed
 * needs improvement
 * @return boolean 
 */
function buggm_has_status_changed(){
    $has_changed=false;
    $ticket_id=buggm_get_the_ticket_post_id();
    $current_status=buggm_get_ticket_status($ticket_id,false);
    $action=$_POST['buggm_action'];
    if($action=='leave')
         return false;//we are leaving the ticket as it is
    //and we are dealing with tiket status/ no need to worry about close as it was taken care by resolution
    switch($action){
         case 'resolve':
             $new_status=$current_status;//we do not track it here at all
             
             break;
         case 'reassign':
              $new_status='assigned';
             $assigned_users=buggm_get_ticket_owners($ticket_id);//list of users assigned to
             $assigned_users=explode(',',$assigned_users);
             $new_assigned_users=$_POST['buggm_assign_to'];
             $new_assigned_users=explode(',',$new_assigned_users);
             $diff=array_diff(array_merge($assigned_users,$new_assigned_users), array_intersect($assigned_users,$new_assigned_users));//I guess we are looking for A U B - A Intersecton B
             
             if(!empty($diff))
                 $has_changed=true;
                 ////
                 break;
             break;
         case 'reopen':
              $new_status='reopened';
           
             break;
         case 'accept':
             $new_status='accepted';
             $old_owner=buggm_get_ticket_owner_ids($ticket_id);
             if(empty($old_owner))
                 $has_changed=true;//the above criteria did not match, means it had a different owner
         
             else if(is_array($old_owner)&&!in_array(buggm_get_current_user_id(), $old_owner))
                     $has_changed=true;
                   
           break;
     }
     if(!$has_changed&&$current_status!=$new_status)
         $has_changed=true;
     return $has_changed;
}
/**
 * before creating comment, make sure there are some changes to save
 * @return boolean
 */

function buggm_is_valid_comment(){
    
  //is erlier taxonomy and current taxonomy same
  //is earlier status and current status same
  //is there any change
  //is there a file to upload?
    
   if(($_FILES['ticket_attachment']['error'] != UPLOAD_ERR_NO_FILE)||buggm_has_comment_data()||  buggm_has_properties_changed()||  buggm_has_keywords_changed()||  buggm_has_resolution_changed()||buggm_has_status_changed()||  buggm_has_cc_changed())
       return true;
 
   return false;
     
}
/**
 * Helper functions for various formatting etc
 */
/*
 * time related
 * a copy of bp_core_time_since(Look at http://buddypress.org for more about BuddyPress)
 */
function buggm_time_since( $older_date, $newer_date = false ) {

	// Setup the strings
	$unknown_text   = apply_filters( 'bp_core_time_since_unknown_text',   __( 'sometime',  'buggm' ) );
	$right_now_text = apply_filters( 'bp_core_time_since_right_now_text', __( 'right now', 'buggm' ) );
	$ago_text       = apply_filters( 'bp_core_time_since_ago_text',       __( '%s ago',    'buggm' ) );

	// array of time period chunks
	$chunks = array(
		array( 60 * 60 * 24 * 365 , __( 'year',   'buggm' ), __( 'years',   'buggm' ) ),
		array( 60 * 60 * 24 * 30 ,  __( 'month',  'buggm' ), __( 'months',  'buggm' ) ),
		array( 60 * 60 * 24 * 7,    __( 'week',   'buggm' ), __( 'weeks',   'buggm' ) ),
		array( 60 * 60 * 24 ,       __( 'day',    'buggm' ), __( 'days',    'buggm' ) ),
		array( 60 * 60 ,            __( 'hour',   'buggm' ), __( 'hours',   'buggm' ) ),
		array( 60 ,                 __( 'minute', 'buggm' ), __( 'minutes', 'buggm' ) ),
		array( 1,                   __( 'second', 'buggm' ), __( 'seconds', 'buggm' ) )
	);

	if ( !empty( $older_date ) && !is_numeric( $older_date ) ) {
		$time_chunks = explode( ':', str_replace( ' ', ':', $older_date ) );
		$date_chunks = explode( '-', str_replace( ' ', '-', $older_date ) );
		$older_date  = gmmktime( (int)$time_chunks[1], (int)$time_chunks[2], (int)$time_chunks[3], (int)$date_chunks[1], (int)$date_chunks[2], (int)$date_chunks[0] );
	}

	/**
	 * $newer_date will equal false if we want to know the time elapsed between
	 * a date and the current time. $newer_date will have a value if we want to
	 * work out time elapsed between two known dates.
	 */
	$newer_date = ( !$newer_date ) ? strtotime( current_time( 'mysql', true ) ) : $newer_date;

	// Difference in seconds
	$since = $newer_date - $older_date;

	// Something went wrong with date calculation and we ended up with a negative date.
	if ( 0 > $since ) {
		$output = $unknown_text;

	/**
	 * We only want to output two chunks of time here, eg:
	 * x years, xx months
	 * x days, xx hours
	 * so there's only two bits of calculation below:
	 */
	} else {

		// Step one: the first chunk
		for ( $i = 0, $j = count( $chunks ); $i < $j; ++$i ) {
			$seconds = $chunks[$i][0];

			// Finding the biggest chunk (if the chunk fits, break)
			if ( ( $count = floor($since / $seconds) ) != 0 ) {
				break;
			}
		}

		// If $i iterates all the way to $j, then the event happened 0 seconds ago
		if ( !isset( $chunks[$i] ) ) {
			$output = $right_now_text;

		} else {

			// Set output var
			$output = ( 1 == $count ) ? '1 '. $chunks[$i][1] : $count . ' ' . $chunks[$i][2];

			// Step two: the second chunk
			if ( $i + 2 < $j ) {
				$seconds2 = $chunks[$i + 1][0];
				$name2 = $chunks[$i + 1][1];

				if ( ( $count2 = floor( ( $since - ( $seconds * $count ) ) / $seconds2 ) ) != 0 ) {
					// Add to output var
					$output .= ( 1 == $count2 ) ? _x( ',', 'Separator in time since', 'buggm' ) . ' 1 '. $chunks[$i + 1][1] : _x( ',', 'Separator in time since', 'buggm' ) . ' ' . $count2 . ' ' . $chunks[$i + 1][2];
				}
			}

			// No output, so happened right now
			if ( !(int)trim( $output ) ) {
				$output = $right_now_text;
			}
		}
	}

	// Append 'ago' to the end of time-since if not 'right now'
	if ( $output != $right_now_text ) {
		$output = sprintf( $ago_text, $output );
	}

	return $output;
}
/**
 * Feedbak functions
 * modeled on buddypress's bp_core_add_message (bp-core/bp-core-functions.php) 
 * credit goes to BuddyPress core devs (http://buddypress.org)
 * 
 */

/**
 * Adds a feedback (error/success) message to the WP cookie so it can be
 * displayed after the page reloads.
 *
 * 
 *
 * @param str $message Feedback to give to user
 * @param str $type updated|success|error|warning
 */
function buggm_add_user_feedback( $message, $type = '' ) {
	

	// Success is the default
	if ( empty( $type ) )
		$type = 'success';

	// Send the values to the cookie for page reload display
	@setcookie( 'buggm-message',      $message, time() + 60 * 60 * 24, COOKIEPATH );
	@setcookie( 'buggm-message-type', $type,    time() + 60 * 60 * 24, COOKIEPATH );

	/***
	 * Send the values to the $bp global so we can still output messages
	 * without a page reload
	 */
        //get the singleton instance and set message type/message
        $bm=buggm_get_bug_manager();
	$bm->add_message($message);
	$bm->add_message_type($type);
}

/**
 * Checks if there is a feedback message in the WP cookie, if so, adds a
 * "buggm_template_notices" action so that the message can be parsed into the template
 * and displayed to the user.
 *
 * After the message is displayed, it removes the message vars from the cookie
 * so that the message is not shown to the user multiple times.
 *
 */
function buggm_setup_feedback_message() {
	$bm=buggm_get_bug_manager();
	$message=$bm->get_message();
	$type=$bm->get_message_type();

	if ( empty( $message ) && isset( $_COOKIE['buggm-message'] ) )
		$bm->add_message( $_COOKIE['buggm-message']);

	if ( empty( $type) && isset( $_COOKIE['buggm-message-type'] ) )
		$bm->add_message_type($_COOKIE['buggm-message-type']);

	add_action( 'buggm_template_notices', 'buggm_render_feedback_message' );

	@setcookie( 'buggm-message',      false, time() - 1000, COOKIEPATH );
	@setcookie( 'buggm-message-type', false, time() - 1000, COOKIEPATH );
}
add_action( 'wp', 'buggm_setup_feedback_message', 20 );

/**
 * Renders a feedback message (either error or success message) to the theme template.
 * The hook action 'buggm_template_notices' is used to call this function, it is not called directly.
 *
 *
 */
function buggm_render_feedback_message() {
	
        $bm=buggm_get_bug_manager();
	$message=$bm->get_message();
	$type=$bm->get_message_type();
        
	if ( !empty($message ) && $message ) :
		$type = ( 'success' == $type) ? 'updated' : 'error'; ?>

		<div id="buggm-message" class="<?php echo $type; ?>">
			<p><?php echo stripslashes( esc_attr( $message ) ); ?></p>
		</div>

	<?php

		do_action( 'buggm_render_feedback_message' );

	endif;
}

/**
 * Keep change updates
 */
function buggm_prepare_change_info($comment_id,$new_term_id,$old_term_id,$taxonomy){
      
     if(empty($new_term_id)&&empty($old_term_id)||($new_term_id==$old_term_id))//no change
         return false;//nothing we have
     
     $tax=get_taxonomy($taxonomy);
     if(!empty($new_term_id))
          $new_term=get_term( $new_term_id, $taxonomy );
     if(!empty($old_term_id))
         $old_term=get_term ($old_term_id, $taxonomy);
    
     //we are setting the term for the first time
     if(empty($old_term_id)){
         $info= sprintf(__('<strong>%s</strong> set to %s','buggm'),$tax->labels->singular_name,$new_term->name);
     }
     else if(empty($new_term_id)){
         //delete
         $info= sprintf(__('<strong>%s</strong>  %s deleted','buggm'),$tax->labels->singular_name,$old_term->name);
         
     }
     else{
         //we are sure that the old/new both are set
         $info= sprintf(__('<strong>%s</strong> changed from %s to %s','buggm'),$tax->labels->singular_name,$old_term->name,$new_term->name);
         
     }
    return $info;
}
/*do the current page needs paginations*/
function buggm_needs_pagination(){
    global $wp_query;
    $total = $wp_query->max_num_pages;
    if($total > 1)
        return $total;
    
    return false;
}
/**
 * Generate pagination links as unordered list
 * We handle the pagination for ticket seahc differently
 */
function buggm_pagination_links(){
   
// Does the result needs pagination?
if ($total=buggm_needs_pagination() )  {
     // get the current page
     if ( !$current_page = get_query_var('paged') )
          $current_page = 1;
     
     
     //we handle the base and format differently in the case of buggm ticket search page
     if(buggm_is_search()){
        
        $search=buggm_get_search_helper();
        $query=$search->build_query();
        
        $settings=buggm_get_settings();
        
        $format = '&page=%#%';
        $base= get_post_type_archive_link($settings->get_post_type()).'?'.$query.'%_%';
        
        //should we build our own query string from the url ?
     }
    else {
      $permalink=get_option('permalink_structure');
      $format=empty( $permalink ) ? '&page=%#%' : 'page/%#%/';
      $base=get_pagenum_link(1) . '%_%';
    }
      
     echo paginate_links(array(
          'base' => $base,
          'format' => $format,
          'current' => $current_page,
          'total' => $total,
          'mid_size' => 10,
          'type' => 'list'
     ));
}

}

function buggm_page_title(){
    echo buggm_get_page_title();
}
//taken from twentyeleven theme, slightly modified and needs a lot of modification for future
function buggm_get_page_title($separator="|"){
        
	global $page, $paged;
	

	// Add the blog name.
	 $title[]=wp_title( '', false );
	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		$title[]= $site_description;

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		$title[]= sprintf( __( 'Page %s', 'buggm' ), max( $paged, $page ) );
        if(is_singular()){
            global $post;
            $post_type=get_post_type($post);
            if(!empty($post_type)&&($post_type!='posts'&&$post_type!='page')){
                
                $post_type_object=get_post_type_object($post_type);
                $title[]=$post_type_object->labels->name;//plural
            }
                
        }
        /*else if(is_archive()){
            $title[]=single_term_title();
        }*/
       
        $title[]=get_bloginfo( 'name' );

        $title=array_reverse($title);
	return apply_filters('buggm_page_title',join(" {$separator} ",$title));
}
?>