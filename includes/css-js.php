<?php
class BuggMAssetHelper{
    
    private static $instance;
    private $plugin_url;
    
    private function __construct() {
        $this->plugin_url=plugin_dir_url(__FILE__);
        
        add_action('wp_enqueue_scripts',array($this,'load_js'));
        add_action('wp_print_styles',array($this,'load_css'));
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        
        return self::$instance;
        
    }
    
    function load_js(){
        wp_enqueue_script('buggmanager', $this->plugin_url.'/assets/buggm.js',array('jquery'));
        
    }
    
    function load_css(){
        wp_enqueue_script('buggmanager-css', $this->plugin_url.'/assets/buggm.css');
        
    }
    
    
    
}
?>