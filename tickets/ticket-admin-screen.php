<?php
/**
 * Manages Ticket Admin Screen In wordpress Backend
 * 
 */

class BuggMTicketAdminUI{
    
    
    private static $instance;
    
    private function __construct() {
        add_action('init',array($this,'init'));
        //$this->init();
    }
    
    function get_instance(){
        if(!isset(self::$instance))
                self::$instance=new self();
        return self::$instance;
    }
    function is_ticket_type(){
      
       $screen = get_current_screen();
       if ( 'ticket' === $screen->post_type )
            return true;
        return false;
    }
    function is_ticket_edit(){
        $post_id=$_GET['post'];
        if(empty($post_id))
            return false;
        $post=get_post($post_id);
        if($post->post_type=='ticket')
            return true;
        return false;
    }
    function init(){
        //we need to take these actions only on ticket post type
       //if(!$this->is_ticket_type())
         //  return false;
        //add
        $pages=array('post.php','post-new.php');
        foreach($pages as $page){
            add_action("load-{$page}" , array($this,'add_remove_metaboxes' ));
            add_action("admin_head-{$page}", array($this,'generate_css'));
        }

    }
    function add_remove_metaboxes(){
        //remove metaboxes
        add_action('add_meta_boxes',array($this,'remove_metaboxes'));
        add_action('add_meta_boxes',array($this,'add_metaboxes'));
    }
    //make it clutter free
    function remove_metaboxes(){
         // remove_meta_box( 'tagsdiv-keywords', 'ticket', 'side' );
        remove_meta_box( 'versiondiv', 'ticket', 'side' );
        remove_meta_box( 'milestonediv', 'ticket', 'side' );
        remove_meta_box( 'componentdiv', 'ticket', 'side' );
        remove_meta_box( 'prioritydiv', 'ticket', 'side' );
        remove_meta_box( 'severitydiv', 'ticket', 'side' );
        remove_meta_box( 'ticket_typediv', 'ticket', 'side' );
        remove_meta_box( 'resolutiondiv', 'ticket', 'side' );
        //remove_meta_box( 'severitydiv', 'ticket', 'side' );
        //remove_meta_box( 'severitydiv', 'ticket', 'side' );
    }
    
    //add meta boxes
    function add_metaboxes(){
        $taxonomies=buggm_get_all_taxonomies_info();
       unset($taxonomies['keywords']);
       if(!self::is_ticket_edit())
       unset($taxonomies['resolution']);
       
        foreach($taxonomies as $taxonomy => $info)
            $this->add_metabox ($taxonomy,$info);
    }
    
    function add_metabox($taxonomy,$info){
      
        add_meta_box(
		'buggm-'.$taxonomy,	// Unique ID
		$info['name'],		// Title
		array($this,'generate_meta_box'),// Callback function
		'ticket',	// Admin 
		'side',		// Context
		'default',	// Priority
                array('taxonomy'=>$taxonomy)    //Callback args
	);
    }
    
  //generate meta boxes
    
    function generate_meta_box($post,$info){
       $tax_info=$info['args'];
      
        $taxonomy=$tax_info['taxonomy'];
       
	$tax = get_taxonomy($taxonomy);
        //tax_input[milestone][]
        $name="tax_input[{$taxonomy}][]";
      
        $selected=wp_get_object_terms($post->ID, $taxonomy,array('fields' => 'ids'));
        $selected=  array_pop($selected);
	?>
	<div id="taxonomy-<?php echo $taxonomy; ?>" class="categorydiv buggm-taxonomy">
		<ul id="<?php echo $taxonomy; ?>-tabs" class="category-tabs">
			<li class="tabs"><a href="#<?php echo $taxonomy; ?>-all" tabindex="3"><?php echo $tax->labels->all_items; ?></a></li>
			
		</ul>

		
		<div id="<?php echo $taxonomy; ?>-all" class="tabs-panel">
			<?php
            $name = ( $taxonomy == 'category' ) ? 'post_category' : 'tax_input[' . $taxonomy . ']';
            echo "<input type='hidden' name='{$name}[]' value='0' />"; // Allows for an empty term set to be sent. 0 is an invalid Term ID and will be ignored by empty() checks.
            ?>
			<ul id="<?php echo $taxonomy; ?>checklist" class="list:<?php echo $taxonomy?> categorychecklist form-no-clear">
				<?php  wp_dropdown_categories(array('taxonomy'=>$taxonomy,'hide_empty'=>false,'name'=>$name,'id'=>'buggm'-$taxonomy,'selected'=>$selected,'show_option_all'=>sprintf('Select %s',$tax->labels->singular_name))) ;
                                //
                                ////wp_terms_checklist($post->ID, array( 'taxonomy' => $taxonomy, 'popular_cats' => $popular_ids ) ) ?>
			</ul>
		</div>
	
	</div>
	<?php
    }
    
    function generate_css(){
        global $post_type;
       
        if(!($_GET['post_type']=='ticket'||$post_type=='ticket'))
            return;
            
        ?>
<style type='text/css'>
    .buggm-taxonomy div.tabs-panel{
        height:32px;
    }
</style>
<?php
    }
}

BuggMTicketAdminUI::get_instance();
?>