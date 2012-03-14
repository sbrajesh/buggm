<?php

class BuggMAdmin{
    
    private static $instance;
    private $page_title= '';
    private $menu_title= '';
    private $option_name='';
    private $section_name='general';
    private $cap='manage_options';
    private $slug='buggm-settings';
    
    function __construct() {
        
        $this->page_title=__('BuggM Settings','buggm');;
        $this->menu_title=__('BuggM Settings','buggm');
        $this->section_title=__('Import BuggM default Settings','buggm');
        $this->option_title=__('Help','buggm');
        $this->option_name=  'import_data';
        add_action('admin_init',array($this,'register_settings'));
        add_action('admin_menu',array($this,'add_menu'));
        
        }
    
    public static function get_instance(){
        if(!isset (self::$instance))
                self::$instance=new self($settings);
        return self::$instance;
    }
    
    function add_menu(){
        add_options_page($this->page_title,$this->menu_title, $this->cap, $this->slug, array($this,'render_settings'));
           
    }
    
    function register_settings(){
        register_setting($this->option_name, $this->option_name,array($this,'validate'));
        add_settings_section($this->section_name, $this->section_title, array($this,'description'),$this->slug);
       // add_settings_field('buggm-help', __('BuggM: How to ','buggm'), array($this,'description_help'), $this->slug, $this->section_name);
        add_settings_field($this->option_name, $this->option_title, array($this,'description_field'), $this->slug, $this->section_name);
        

    }
  function validate($input){
     //let us save global data
     //update_site_option('bpdev_banned_domains_list', $input); 
      return $input;
      
  }
  function description(){
      if(!$this->had_imported())
      _e('<p>Import/seed The Bugg Manager data. If you check this box and click on Import data, It will import basic settings data for Resolution,Ticket Type, Priority, severity etc. Please do not reseed if you have earlier done so.</p>','buggm');
      
      
  }
  function description_field(){
      if(!$this->had_imported()):?>
    <p><?php _e('To Import The default settings for Buggm, Please click on Import button Below.','buggm');?></p>      
    <label for="<?php echo $this->option_name;?>" ><input id="<?php echo $this->option_name;?>" type="checkbox" name="<?php echo $this->option_name;?>" tabindex="1"><?php _e("Yes Import the default Settings",'buggm');?></label>
   <?php
   else:
       _e('You have already Imported the settings. It will be a bad idea to reimport.','buggm');//I know I should allow users to reimport
   endif;
  }  
   
 
  function update(){
      if(!empty($_POST['submit'])&&  current_user_can($this->cap)&&  wp_verify_nonce($_POST['_wpnonce'],$this->option_name."-options")){
          if(!empty($_POST['import_data'])){
              $seeder=buggm_get_seeder();
              $seeder->seed();
              update_option('buggm_has_imported', 1);
          }
              
             
      ?>
    <div class='updated'><p><?php _e('Settings updated','buggm');?></p></div>
    <?php
      }
    else if(isset($_POST['submit'])){
       wp_die(__('Epic Fail! The sky is falling!','buggm'));
  }
  
  
  }
  function had_imported(){
      return get_option('buggm_has_imported');
  }
  function render_settings(){
      ?>
 <div class="wrap">
     <?php screen_icon();?>
     <h2><?php echo esc_html( $this->menu_title ); ?></h2>
     <?php $this->update();?>
     <form method='post' action="">
             <?php settings_fields( $this->option_name ); ?>
             <?php do_settings_sections( $this->slug ); ?>
           
           
           
            <?php submit_button(__('Import','buggm')); ?>
        </form>
    </div>
      <?php
  }
}

BuggMAdmin::get_instance();
?>