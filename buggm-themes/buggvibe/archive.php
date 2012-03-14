<?php get_header(); ?>
    <div id="content"><!-- content starts here-->
	<div class="padder" id="blog-archives" role="main">
            <h2 class="pagetitle"><?php buggm_archive_title(); ?></h2>

			
			<?php if ( have_posts() ) : ?>

				<?php buggm_pagination_links(); ?>

				<?php while (have_posts()) : the_post(); ?>

					<?php get_template_part('entry',  get_post_type());?>
					

				<?php endwhile; ?>

				<?php buggm_pagination_links(); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'Not Found', 'buggm' ) ?></h2>
				<?php get_search_form() ?>

			<?php endif; ?>

		</div>

	</div><!-- content ends here-->
	
	<?php get_sidebar() ?>
 <div class="clear"></div>

<?php get_footer(); ?>
