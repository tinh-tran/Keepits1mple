<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package s1mple
 */
get_header(); ?>
   <!-- Content
   ================================================== -->
   <div id="content-wrap">

   	<div class="row">

   		<div id="main" class="eight columns">
		<?php 
			if ( have_posts() ) :
				while ( have_posts() ) : the_post();
					get_template_part( 'template-parts/content', get_post_format() );
				endwhile;
			endif;
			?>
   		</div> <!-- end main -->

   		<div id="sidebar" class="four columns">
   			<?php get_sidebar() ?>
   		</div> <!-- end sidebar -->

   	</div> <!-- end row -->

   </div> <!-- end content-wrap -->
<?php get_footer() ?>