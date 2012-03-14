<?php

class BuggMTaxonomy{
    private static $instance;
    private $taxonomies;//arry of all of our taxonomies
    private function __construct() {
        
        add_action('init',array($this,'init'));
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    
    function init(){
        $this->register();
    }
    function register(){
        
        $settings=buggm_get_settings();
        $taxonomies=$settings->get_taxonomies();
        
        foreach($taxonomies as $taxonomy => $tax_info){
            $tax_info['labels']=self::_get_labels($tax_info['name'],$tax_info['plural_name']);
            self::create_taxonomy($taxonomy,$tax_info);
        }
    }
    
    /**
     * Create taxonomy
     */
    function create_taxonomy($taxonomy,$args){
      
        extract($args);
        if(empty($taxonomy))
            return false;
      $this->taxonomies[$taxonomy]=$args;//let us save for future
      
      register_taxonomy($taxonomy,null,array(
          'hierarchical' => $hierarchical,
          'labels' => $labels,
          'public'=>true,
          'show_in_nav_menus'=>true,
          'show_ui' => true,
          'show_tagcloud'=>true,
          
          'update_count_callback' => '_update_post_term_count',
          'query_var' => true,
          'rewrite' => array(
                        'slug' => $slug,
                        'with_front'=>true,
                        'hierarchical'=>true//show hierarchical urls
                        ),
      ));

    }
    
  //label builder for easy use
   function _get_labels($singualr_name,$plural_name){
       
       $labels=array('name'=>$plural_name,
                    'singular_name'=>$singualr_name,
                    'search_items'=>sprintf(__('Search %s','buggm'),$plural_name),
                    'popular_items'=>  sprintf(__('Popular %s','buggm'),$plural_name),
                    'all_items'=>  sprintf(__('All %s','buggm'),$plural_name),
                    'parent_item'=>  sprintf(__('Parent %s','buggm'),$singualr_name),
                    'parent_item_colon'=>  sprintf(__('Parent %s:','buggm'),$singualr_name),
                    'edit_item'=>  sprintf(__('Edit %s','buggm'),$singualr_name),
                    'update_item'=>  sprintf(__('Update %s','buggm'),$singualr_name),
                    'add_new_item'=>  sprintf(__('Add New %s','buggm'),$singualr_name),
                    'new_item_name'=>  sprintf(__('New %s Name','buggm'),$singualr_name),
                    'separate_items_with_commas'=>  sprintf(__('Separate %s with commas','buggm'),$plural_name),
                    'add_or_remove_items'=>  sprintf(__('Add or Remove %s','buggm'),$plural_name),
                    'choose_from_most_used'=>  sprintf(__('Choose from the most used %s','buggm'),$plural_name)
                    //menu_name=>'' //nah let us leave it default
           
           );
       
       return $labels;
   } 
    
   function get_all(){
       if(!empty($this->taxonomies))
        return array_keys($this->taxonomies);
       return false;
   }
   
   function get_all_info(){
       if(!empty($this->taxonomies))
        return $this->taxonomies;
       return false;
   }
}



?>