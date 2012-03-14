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

<body <?php body_class(); ?>>
<div id="htop"></div><!-- decorative top -->
<div id="page">
    
    <header id="top">
             
        <div id="logo">
            <hgroup>
                <h1><a href="<?php echo esc_url(site_url());?>"><img src="<?php echo get_template_directory_uri() ?>/logo.png" alt="Logo" /><?php //bloginfo('name');?></a></h1>
                <h3> <?php echo bloginfo('description');?></h3>
            </hgroup>
        </div>
        
        <div id="search">
            <?php get_search_form(); ?>
        </div>
        <div class="clear"></div>
    </header>
    
    <nav id="main-menu">
        <?php wp_nav_menu( array( 'theme_location' => 'primary','container'=>'' ) ); ?>
        <div class="clear"></div>
    </nav>
    
    <div id="advance-filter">
          <?php buggm_search_form();?>      
    </div>
   <?php do_action('buggm_template_notices');?>