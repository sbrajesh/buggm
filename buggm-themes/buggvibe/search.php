<?php get_header() ?>
        <div id="content"><!-- content starts here-->

		
		<div class="padder" id="blog-search" role="main">

			

			<?php if (have_posts()) : ?>

				<h2 class="pagetitle"><?php _e( 'Search Results', 'buggvibe' ) ?></h2>

				<?php buggm_pagination_links();?>

				<?php while (have_posts()) : the_post(); ?>

					

					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

						
						<h2 class="posttitle"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php _e( 'Permanent Link to', 'buggvibe' ) ?> <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
						<div class="post-img">
						<a href="<?php the_permalink();?>" rel="permalink to <?php the_title_attribute();?>" class="post-img"><?php the_post_thumbnail('category-thumb');?></a>
						</div>
						<br class="clear" />
						<div class="entry">
								<?php the_excerpt(); ?>
						</div>
						<a class="readmore" href="<?php the_permalink();?>"> <?php _e(" Read more ","sv");?>&#187;</a>
						
						<div class="post-meta">
						<p><?php printf( _x( 'Posted on %s', 'buggvibe' ), get_the_date() ) ?>
						<?php printf( __( ' | by : <span>%1$s</span> | ', 'buggvibe' ), buggm__get_user_link( $post->post_author ) ); ?>
						<?php comments_popup_link( __( '<span>No Comments &#187;', 'buggvibe' ), __( '1 <span>Comment &#187;</span>', 'buggvibe' ), __( '% <span>Comments &#187;</span>', 'buggvibe' ) ); ?>
						</p>
						
						</div>
						<p class="tags"><?php the_tags(  __( 'Tags: ', 'buggvibe' )); ?> </p>

					</article>

					

				<?php endwhile; ?>

				<?php buggm_pagination_links(); ?>

			<?php else : ?>

				<h2 class="center"><?php _e( 'No posts found. Try a different search?', 'buggvibe' ) ?></h2>
				<?php get_search_form() ?>

			<?php endif; ?>

		</div>

		
	</div><!-- content ends here-->
	

	<?php get_sidebar() ?>
        <div class="clear"></div>			
			
     <?php get_footer();?>