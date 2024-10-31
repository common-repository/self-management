<?php
/**
 * Template Name: Task-List Template
 */

get_header(); 
?>

		<div id="primary">
			<div id="content" role="main">
			
				<?php 
				query_posts( 'post_type=to_do_list' ); // choose only 'to-do-list' type posts
				
				while ( have_posts() ) : the_post();

					get_template_part( 'content', get_post_format() );

				endwhile; // end of the loop.
				
				wp_reset_query(); 
				?>

			</div><!-- #content -->
		</div><!-- #primary -->

<?php get_footer(); ?>