<?php
/**
 * The benefit of using a singleton class is reduced lookups for the various conditionals here
 */
class BuggMSearchHelper{
    private $is_search;//where it is search page or not
    private $search_labels;
    //we may want to accumulate various search parameters here too, but I am leaving that for another version
    
    private static $instance;
    
    private function __construct(){
        add_filter('posts_clauses', array($this,'filter_posts_clauses'), 20, 1 );
        add_filter('pre_get_posts', array($this,'update_query_params') );
        add_filter('wp',array($this,'remove_redirect'));//do not allow cannonical redirect on our search page
    }
    
    public static function get_instance(){
        if(!isset(self::$instance)){
            self::$instance=new self();
        }
        return self::$instance;
    }
    
    function is_search(){
        if(isset ($this->is_search))
                return $this->is_search;
        
        $this->is_search=false;//assume
        
        //if that variable is not set, let us find it for one time
        $is_ticket_archive=is_post_type_archive('ticket');
        
        if(!$is_ticket_archive)
            return $this->is_search; //it is false my dear
        //if we are on ticket post type archive page, let us inspect further
        //if there is one taxonomy term set in the query, it is true
        $is_tax=false;
        $tax_inputs=$_REQUEST['tax_input'];//should be array
        
        if(!empty($tax_inputs)){
               foreach($tax_inputs as $tax=>$tax_search){
                    if(!empty($tax_search)){
                        $is_tax=true; 
                        break;
                    }
                }
        }
        //make sure we are on tickets archive page and some of the search terms are selected
        $is_search=(!empty($_REQUEST['search_title'])||!empty($_REQUEST['ticket_owner'])||!empty($_REQUEST['ticket_reporter'])||!empty($_REQUEST['ticket_cc'])||!empty($_REQUEST['ticket_status']));

        $this->is_search=$is_ticket_archive&&($is_tax||$is_search); 
        
        return $this->is_search;
    }
    
    /**
     * Remove Cannonical redirect 
     */
      function remove_redirect(){
          if(buggm_is_search())
              remove_action('template_redirect', 'redirect_canonical');

      }
   /**
    * Filter posts clauses but only if it is a ticket search query
    * @global type $wpdb
    * @param array $clauses
    * @return type 
    */ 
   function filter_posts_clauses($clauses){
        if(!buggm_is_search()||empty($_REQUEST['search_title']))
            return $clauses;
      
        $where=$clauses['where'];
        
        global $wpdb;
        $search_term=esc_html($_REQUEST['search_title']);
        $search_term=like_escape($search_term);
        
        //allow search in title/description, we may want to use separate search variables in fuuture to give more control to user
        $where.=" AND ({$wpdb->posts}.post_title LIKE '%{$search_term}%' OR {$wpdb->posts}.post_content LIKE '%{$search_term}%' )";
        $clauses['where']=$where;
   
        return $clauses;
    
    }
    
/**
 * show ticket post type on home page/Author page
 * Filter query for ticket search and update query
 */

    function update_query_params( $query ) {
        $tax_query=array();
        
        $meta_query=array();//2-dimensional array in future
	
        if ( (is_home()||is_front_page()||is_author()) && false == $query->query_vars['suppress_filters'] ||  is_feed())
		$query->set( 'post_type',   array('post', 'ticket'  ));//we may want to first get the type and then add our ticket type, let us experiment for now
  
        if(buggm_is_search()){
              $post_types=(array)$query->get('post_type');  
            if(in_array('nav_menu_item',$post_types))
                    return $query;//do not cause troubles with menu on the search page
            
            if($_REQUEST['page'])
                $query->set('paged',intval($_REQUEST['page']));
            
            $settings=buggm_get_settings();
            //let us filter the search
            //for taxonomies
            $taxonomies=buggm_get_all_taxonomies();
            foreach($taxonomies as $taxonomy){
                //check if the taxonomy is set
                $tax_terms=$_REQUEST['tax_input'][$taxonomy];//need to clean
                if(!empty($tax_terms))
                    $tax_query[]=array(
                                'taxonomy'=>$taxonomy,
                                'field'=>'id',
                                'terms'=>$tax_terms,
                                'operator'=>'IN'
                        );
            }
           
        if(count($tax_query)>1)
                $tax_query['relation']='AND';
              
        if(!empty($tax_query))
           $query->set('tax_query',$tax_query);
        
        if(!empty($_REQUEST['ticket_owner'])){
            //assuming that multiple owners are selected
            $owners=explode(',',esc_html($_REQUEST['ticket_owner']));
            $user_ids=buggm_get_user_ids_from_user_names($owners);
            //this is infact a custom meta search
            $meta_query[]=array('key'=>$settings->get_owners_key_name(),'value'=>$user_ids,'compare'=>'IN');
        }
         if(!empty($_REQUEST['ticket_cc'])){
            //assuming that multiple owners are selected
            $owners=explode(',',esc_html($_REQUEST['ticket_cc']));
            $user_ids=buggm_get_user_ids_from_user_names($owners);
            //this is infact a custom meta search
            $meta_query[]=array('key'=>$settings->get_cc_key_name(),'value'=>$user_ids,'compare'=>'IN');
        }
        
        //status filter
        if(!empty($_REQUEST['ticket_status'])){
            //assuming that multiple owners are selected
            $status=$_REQUEST['ticket_status'];//);
            if(buggm_is_valid_ticket_status($status)){
                    $meta_query[]=array('key'=>$settings->get_status_key_name(),'value'=>$status,'compare'=>'=');
      
            }
        }
        if(!empty($meta_query)){
           
            $query->set('meta_query',$meta_query);
        }
        if(!empty($_REQUEST['ticket_reporter'])){
            //assuming that multiple owners are selected
            $reporters=explode(',',esc_html($_REQUEST['ticket_reporter']));
            $user_ids=buggm_get_user_ids_from_user_names($reporters);
            //reporters are authors
            if(!empty($user_ids))
                $query->set('author',join(',',$user_ids));
        }
        
       }
    
	return $query;
    }
    /**
     * Build Query from the current search parameters in request
     * @return type 
     */
    function build_query(){
    //get current page url and build the query
        $is_ticket_archive=is_post_type_archive('ticket');
        
        if(!$is_ticket_archive)
            return ''; //it is false my dear
          
        
       
        $query[]=array();
        //check for the search query params
        if(!empty($_REQUEST['search_title']))
            $query['search_title']=esc_html($_REQUEST['search_title']);
        if(!empty($_REQUEST['ticket_owner']))
            $query['ticket_owner']=esc_html($_REQUEST['ticket_owner']);
        if(!empty($_REQUEST['ticket_reporter']))
            $query['ticket_reporter']=esc_html($_REQUEST['ticket_reporter']);
        if(!empty($_REQUEST['ticket_cc']))
            $query['ticket_cc']=esc_html($_REQUEST['ticket_cc']);
        if(!empty($_REQUEST['ticket_status']))
            $query['ticket_status']=esc_html($_REQUEST['ticket_status']);
        //instead, we could have just stripped the empty vars and map array
        
        //search for taxonomy params
         $tax_inputs=$_REQUEST['tax_input'];
        $taxq=array();
        if(!empty($tax_inputs)){
               foreach($tax_inputs as $tax=>$tax_search){
                    if(!empty($tax_search)){
                        
                        $query["tax_input"][$tax]=intval($tax_search);//because wer are passing the term_id 
                        
                    }
                }
        }
        
        return http_build_query($query);
}
   
}//end of BuggMSearchHelper class

//initialize it, just in case
   BuggMSearchHelper::get_instance(); 
  

/**
 * return BuggMSearchHelper Singleton Instance
 * Just a convenience function
 * @return BuggmSearchHelper 
 */

function buggm_get_search_helper(){
    return BuggMSearchHelper::get_instance();
}
/**
 * Check if we are currently searching for Tickets
 * @return bool true|false
 */
function buggm_is_search(){
  $helper=buggm_get_search_helper();
  return $helper->is_search();
}

function buggm_get_ticket_search_filters(){
    //check for taxonomy query
    $search_labels=array();
   
    //title
    if(!empty($_REQUEST['search_title']))
        $search_labels[]="<span class='context-search-type'>".__('Title:','buggm')."</span><span class='context-term'>{$_REQUEST['search_title']}</span>";
    
    if(!empty($_REQUEST['tax_input'])){
        $tax_inputs=$_REQUEST['tax_input'];
        foreach($tax_inputs as $tax=>$tax_search){
            if(empty($tax_search))
                continue;
            $taxonomy=get_taxonomy($tax);
            $term=get_term($tax_search, $tax);
            $search_labels[]="<span class='context-search-type'>{$taxonomy->labels->singular_name}:</span><span class='context-term'>{$term->name}</span>";
        }
        
        
    }
    //ticket status
    $ticket_status=$_REQUEST['ticket_status'];
   if(!empty($ticket_status)&&  buggm_is_valid_ticket_status($ticket_status)){
       
       $search_labels[]="<span class='context-search-type'>".__('Ticket Status:','buggm')."</span><span class='context-term'>{$ticket_status}</span>";
   }
    
    //ticket owner
   if(!empty($_REQUEST['ticket_owner'])){
       $users=$_REQUEST['ticket_owner'];
       $search_labels[]="<span class='context-search-type'>".__('Owned by:','buggm')."</span><span class='context-term'>{$users}</span>";
   }
   
   //ticket cc
   
   if(!empty($_REQUEST['ticket_cc'])){
       $users=$_REQUEST['ticket_cc'];
       $search_labels[]="<span class='context-search-type'>".__('CC:','buggm')."</span><span class='context-term'>{$users}</span>";
   }
   
   //ticket_reporter
   if(!empty($_REQUEST['ticket_reporter'])){
       $users=$_REQUEST['ticket_reporter'];
       $search_labels[]="<span class='context-search-type'>".__('Reported by:','buggm')."</span><span class='context-term'>{$users}</span>";
   }
   
   return join(' | ',$search_labels);
}

function buggm_search_form(){
    ?>
<form method="get" id="searchform" class="buggm_form" action="<?php echo buggm_get_ticket_base_url(); ?>">
    <fieldset>
            <legend><?php _e('Filter');?></legend>
                        
		<br/>
                <a href="#" id="search_toggle-advance"><?php _e('Hide[X]','buggm');?></a>
                
                     <table>
                         <tr>
                             <th><?php _e('Summary','buggm');?></th><td colspan="3"><input type="text" name="search_title" /></td>
                                 
                            </tr>
                            <tr>
                                <th><?php _e('Type','buggm');?></th><td><?php buggm_list_ticket_type_dd();?></td>
                                <th><?php _e('Priority','buggm');?></th><td><?php buggm_list_ticket_priority_dd();?></td>
                                
                            </tr>
                            <tr>
                                <th><?php _e('Milestone:','buggm');?></th><td><?php buggm_list_ticket_milestone_dd();?></td>
                                <th><?php _e('Component:','buggm');?></th><td><?php buggm_list_ticket_component_dd();?></td>
                                
                            </tr>
                            <tr>
                                <th><?php _e('Version:','buggm');?></th><td><?php buggm_list_ticket_version_dd();?></td>
                                <th><?php _e('Severity:','buggm');?></th><td><?php buggm_list_ticket_severity_dd();?></td>
                                
                            </tr>
                             <tr>
                                 <th><?php _e('Owner:','buggm');?></th><td><input type='text' name="ticket_owner" value="" /></td>
                                 <th><?php _e('Cc:','buggm');?></th><td><input type='text' name="ticket_cc"  value=""/></td>
                                
                            </tr>
                             <tr>
                                 <th><?php _e('Workflow Keywords:','buggm');?></th><td><?php buggm_list_ticket_keywords_dd();?></td>
                                <th> &nbsp;</th><td>&nbsp;</td>
                                
                            </tr>
                             <tr>
                                <td colspan="4">
                                    <span class="buggm-keywords-holder"><?php buggm_list_ticket_keywords_editable(false,$_REQUEST['tax_input'][buggm_get_keywords_taxonomy()]);?></span>
                                </td>
                            </tr>
                        </table>
		<input type="submit" value="<?php _e('Search','buggm');?>" />
		</fieldset>
</form>
<?php 
}

?>