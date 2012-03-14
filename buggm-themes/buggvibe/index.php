<?php get_header() ;?>
	
	<div id="content"><!-- content starts here-->

		


		<div class="padder" role="main">

			<?php if ( have_posts() ) : ?>

				<?php buggm_pagination_links(); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php get_template_part('entry',  get_post_type());?>

				<?php endwhile; ?>

				<?php buggm_pagination_links(); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buggvibe' ) ?></h2>
				<p class="center"><?php _e( 'Sorry, but you are looking for something that isn\'t here.', 'buggvibe' ) ?></p>

				<?php get_search_form() ?>

			<?php endif; ?>
		</div>

		
                </div>
                <?php get_sidebar() ?>
<div class="clear"></div>

			

<?php get_footer() ?>
