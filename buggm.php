<?php
/**
 * Plugin Name: BuggM
 * Version:1.0
 * Author: Brajesh Singh
 * Description: WordPress Based Bug Tracker
 */
//core class
class BugManager{
    private static $instance;
    private $path;//
    private $message;
    private $message_type;
    
    private function __construct() {
        
        $this->path=plugin_dir_path(__FILE__);
        $this->init();
        register_theme_directory($this->path. 'buggm-themes' );

        register_activation_hook( __FILE__, array($this,'on_activation' ));
        if(is_multisite())//bypass the network enabling of theme
        add_filter('allowed_themes',array($this,'include_themes'));//fix for multisite
       // add_action('admin_init',array($this,'include_themes'));//fix for multisite
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        
        return self::$instance;
        
    }
    
    function init(){
        $this->load();
        buggm_create_taxomonies();
        buggm_create_ticket_post_type();//create post type, associate to taxonomies, already created
       
        
        //create taxonomy
        
    }
    function include_themes($themes){
        $theme_dir=$this->path. 'buggm-themes/';
        if ($handle = opendir($theme_dir)) {
            while (false !== ($entry = readdir($handle))) {
                if ($entry != "." &&$entry != ".."&&is_dir($theme_dir.$entry))
                        $themes[$entry]=true;
                  
        }
       
        closedir($handle);
}
   return  $themes;
        
    }
    /**
     * 
     */
    function seed(){
        //seed the basic data
        //should we seed here ?
    }
    /**
     * Load the included files
     */
   function load(){
       $files=array(
           'taxonomy/classes.php',
           'tickets/classes.php',
           'tickets/helper.php',
           'tickets/ticket-admin-screen.php',
           'settings/classes.php',
           'core/attachment.php',
           'core/comment.php',
           'core/component.php',
           'core/core-base.php',
           'core/milestone.php',
           'core/permission.php',
           'core/priority.php',
           'core/reporter.php',
           'core/resolution.php',
           'core/severity.php',
           'core/status.php',
           'core/ticket-extra.php',
           'core/type.php',
           'core/user.php',
           'core/link-functions.php',
           'core/version.php',
           'core/workflow-keywords.php',
           'core/search.php',
           'business-functions.php',
           'includes/css-js.php',
           'includes/filters.php',
           'core/general-templates.php',
           'mailer/mailer.php',
           'mailer/template/base.php',
           'filters.php'
       );
       if(is_admin()){
           $files[]='admin/screen.php';
           $files[]='admin/seed.php';
       }    
       foreach ($files as $file)
        require_once $this->path.$file;
   } 
   
   function on_activation(){
           flush_rewrite_rules();//flush the rewrite rules
   }
 function add_message($message){
     $this->message=$message;
 }
 function add_message_type($type){
     $this->message_type=$type;
 }
 
 function get_message(){
     return $this->message;
 }
 function get_message_type(){
     return $this->message_type;
 }

}
BugManager::get_instance();
function buggm_get_bug_manager(){
    return BugManager::get_instance();
}
/*
 * Record new post/comment/modification in properties/status
 */
add_action('template_redirect','buggm_track_ticket_changes');
function buggm_track_ticket_changes(){
    
    $action=$_POST['action'];
   // echo "action".$action;
    if(!empty($action)){
        if($action=='buggm_new_ticket')
            buggm_add_new_ticket ();
        else if($action=='buggm_new_comment')
            buggm_save_comment ();
    }
}
?>