<?php


class BuggMTicket{
    private static $instance;
    
    private function __construct() {
        
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    
    function register(){
    
        //register all the taxonomies
        
    }
    //post status?
    function register_status(){
        
    }
    
    
    
    
}

?>