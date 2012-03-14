<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php  buggm_page_title();?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/_inc/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php
	
if ( is_singular() && get_option( 'thread_comments' ) )
    wp_enqueue_script( 'comment-reply' );


wp_head();
?>
</head>

	<body <?php body_class() ?> id="social-vibe">
            <div id="page">
		

		<header id="header"> <!-- header starts here-->
			
			<div class="inner">
				
				<div class="logo alignleft">
                                    <a href="<?php echo site_url();?>"><?php //echo get_bloginfo('name');?> <img src="<?php global $sv_logo;echo $sv_logo;  ?>" alt="logo" />
					</a>
				</div>
				
				
				<div class="search-bar alignright" role="search">
                                   
                                    <form action="<?php echo site_url('/'); ?>" method="get" id="search-form">
                                        <input type="text" id="search-terms" name="s" value="" placeholder="Search..."  />
					<input type="submit" name="search-submit" id="search-submit" value="<?php _e( 'Search', 'buggvibe' ) ?>" />
                                    </form><!-- #search-form -->
					
					
					 <a href="#" id="search_toggle">Advanced search</a>
				</div>
							
				<div class="clear"></div>
				
			</div>

			

		</header><!-- header ends here-->
		
		<div id="navigation" role="navigation">
				
					<nav class="top-nav">
					<div id="smoothmenu1" class="ddsmoothmenu inner">
						<?php wp_nav_menu( array( 'container' => false, 'theme_location' => 'primary' ) ); ?>
					</div>
					</nav>
		</div>
		<div id="sub-navigation">
					<div id="smoothmenu1" class="ddsmoothmenu inner">
					<?php wp_nav_menu( array('container' => false, 'theme_location' => 'secondary', 'fallback_cb' => false ) ); ?>
					</div>
				
		</div>
                <?php locate_template( array( 'topfeatured-area.php' ), true ) ?>
            
	<div id="container">
	<div id="content-bg">  <!--content-bg starts here -->
					    
	<div  id="advance-filter">
                    <?php buggm_search_form();?>  
         </div>	  
         <?php do_action('buggm_template_notices');?>   