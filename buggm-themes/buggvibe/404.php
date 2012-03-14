<?php get_header() ?>
        <div id="content one-column"><!-- content starts here-->
	<div class="padder one-column">
            <article id="post-0" class="post-item post page-404 error404 not-found" role="main">
                <header>
                      <h1><?php _e( "Page not found", 'buggvibe' ); ?></h1>
                </header>

                    <p><?php _e( "We're sorry, but we can't find the page that you're looking for. Perhaps searching will help.", 'buggvibe' ); ?></p>
                    <?php get_search_form(); ?>
            </article>

	</div><!-- content ends here-->
	
        <div class="clear"></div>
				
	</div>  <!--content-bg ends here -->

<?php get_footer() ?>