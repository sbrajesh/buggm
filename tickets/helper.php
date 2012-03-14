<?php
/**
 * Helper for Ticket CPT
 */

class BuggMTicketHelper{
    
    private static $instance;
    private $post_type='ticket';
    private function __construct() {
        
        add_action('init',array($this,'register'));
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    
    function register(){
        $args=array();
        $labels=array(
                'name'=>__('Tickets','buggm'),
                'singular_name'=>__('Ticket','buggm'),
                'add_new'=>__('Add New','buggm'),
                'add_new_item'=>_x('Add New Ticket','buggm','buggm'),
                'edit_item'=>_x('Edit Ticket','buggm','buggm'),
                'new_item'=>_x('New Ticket','buggm','buggm'),
                'view_item'=>_x('View Ticket','buggm','buggm'),
                'search_items'=>_x('Search Tickets','buggm','buggm'),
                'not_found'=>_x('No Tickets Found','buggm','buggm'),
                'not_found_in_trash'=>_x('No Tickets Found in Trash','buggm','buggm'),
                'menu_name'=>_x('Tickets','buggm','buggm'),
                
            
                        
        );
        //supports
        $supports=array(
                    'title',
                    'editor',
                    'author',
                    'custom-fields',
                    'comments',
                    'revisions',
                    
        );
        
        $rewrite=array(
                    'slug'=>'tickets',
                    'with_front'=>true
                    
        );
        $args=array(
                    'label'=>  _x('Tickets', 'ticket post type label', 'buggm'),
                    'labels'=>$labels,
                    'description'=>_x('Create Tickets for the bug tracking system','buggm'),
                    'public'=>true,
                    'publicly_queryable'=>true,
                    'exclude_from_search'=>false,
                    'show_ui'=>true,
                    'show_in_menu'=>true,
                    'menu_position'=>3,
                    'menu_icon'=>null,//sorry I don't have one
                    'capability_type'=>'post',
                    'has_archive'=>'tickets',
                    'rewrite'=>$rewrite,
                    'supports'=>$supports,
                    
                    
                    
                    );
        register_post_type($this->post_type, $args);
        //decouple later, let us keep it here for now
        $this->associate_to_taxonomies();
        
    }
    //may be deprectade in future when decoupling 
    function associate_to_taxonomies(){
        
        $taxonomies=buggm_get_all_taxonomies();
        foreach($taxonomies as $taxonomy)
            register_taxonomy_for_object_type ($taxonomy, $this->post_type);
    }
    
    function __get($name) {
        if(isset($this->{$name}))
            return $this->{$name};
        
        return false;    
    }
}

//BuggMTicketHelper::get_instance();//initialize

?>