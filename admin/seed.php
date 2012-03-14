<?php
//seed data
class BuggMSeeder{
  private static $instance;
   
  private function __construct() {
             
    }
    
  public static function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        
        return self::$instance;
        
    }
    
   function get_seed_data(){
        $data=array(
            buggm_get_priority_taxonomy()=>array(__('blocker','buggm'),__('critical','buggm'),__('major','buggm'),__('minor','buggm'),__('trivial','buggm')),
            buggm_get_severity_taxonomy()=>array(__('blocker','buggm'),__('critical','buggm'),__('major','buggm'),__('minor','buggm'),__('trivial','buggm')),
            buggm_get_type_taxonomy()=>array(__('defect','buggm'),__('enhancement','buggm'),__('task','buggm')),
            buggm_get_resolution_taxonomy()=>array(__('fixed','buggm'),__('invalid','buggm'),__('wontfix','buggm'),__('duplicate','buggm'),__('worksforme','buggm')),
            buggm_get_keywords_taxonomy()=>array(__('has-patch','buggm'),__('needs-patch','buggm'))
    );

        $data=  apply_filters('buggm_seed_data',$data);
        return $data;
}    

function seed(){
    $seed_data=$this->get_seed_data();
    foreach($seed_data as $taxonomy=>$terms){
        foreach($terms as $term)
        wp_insert_term($term, $taxonomy);
    }
}

}
/**
 * Retuns an object of BuggmSeeder, call seed() on the object to seed data 
 * @return type 
 */

function buggm_get_seeder(){
    
    return BuggMSeeder::get_instance();
}

?>