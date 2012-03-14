<?php


class BuggMSettings{
    private $is_milestone_enabled=false;
    private $is_version_enabled=false;
    private $is_status_enabled=false;
    private $is_components_enabled=false;
    private $is_priorities_enabled=false;
    private $is_severities_enabled=false;
    private $is_workflow_keywords_enabled=false;
    
    private $taxonomies;
    
    private static $instance;
    
    
    private function __construct() {
        $this->taxonomies=array(
                        'milestone'=>array('slug'=>'milestone','name'=>__('Milestone','buggm'),'plural_name'=>__('Milestones','buggm'),'hierarchical'=>true),
                        'version'=>array('slug'=>'version','name'=>__('Version','buggm'),'plural_name'=>__('Versions','buggm'),'hierarchical'=>true),
                        'component'=>array('slug'=>'component','name'=>__('Component','buggm'),'plural_name'=>__('Components','buggm'),'hierarchical'=>true),
                        'priority'=>array('slug'=>'priority','name'=>__('Priority','buggm'),'plural_name'=>__('Priorities','buggm'),'hierarchical'=>true),
                        'severity'=>array('slug'=>'severity','name'=>__('Severity','buggm'),'plural_name'=>__('Severities','buggm'),'hierarchical'=>true),
                        'ticket_type'=>array('slug'=>'ticket_type','name'=>__('Ticket Type'),'plural_name'=>__('Ticket Types','buggm'),'hierarchical'=>true),
                        'resolution'=>array('slug'=>'resolution','name'=>__('Resolution','buggm'),'plural_name'=>__('Resolutions','buggm'),'hierarchical'=>true),
                        'keywords'=>array('slug'=>'keywords','name'=>__('Workflow Keyword','buggm'),'plural_name'=>__('Workflow Keywords','buggm'),'hierarchical'=>false),
            
                );
        
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    function get_taxonomy($name){
            //for now, just return the name, in future, we will think about separating the name from actual taxonomy
        return $name;
            
    }
    
    
    
    function get_taxonomies(){
            return $this->taxonomies;
    }
    
    function is_enabled($taxonomy){
        if(!empty($this->taxonomies[$taxonomy]))
                return true;
        return false;
    }
    //we will use to remove the many hardcoded instance of ticket
    function get_post_type(){
        return 'ticket';
    }
    
    function get_key($name){
        
    }
    /**
     * for meta key names
     * 
     */
    function get_cc_key_name(){
        return 'ticket_cc';
    }
    function get_owners_key_name(){
        return 'ticket_owners';
    }
    function get_status_key_name(){
        return 'ticket_status';
    }
    
    function get_updates_key_name(){
        return 'ticket_updates';
    }
}

/*
 */
//return a settings object
function buggm_get_settings(){
    return BuggMSettings::get_instance();
}


?>