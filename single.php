<?php
/**
 *
 * @package WordPress
 * @Theme TinhDk
 *
 * @author tranluclongtinh.com
 * @link https://tinhdk.net
 *
 * Template Post Type: status, tinhdk
 */
	get_header();
	setPostViews(get_the_ID());
?>
   <!-- Content
   ================================================== -->
   <div id="content-wrap">

   	<div class="row">

   		<div id="main" class="eight columns">
		<?php if (have_posts()) : the_post(); update_post_caches($posts); ?>
   			<article class="entry">

					<header class="entry-header">

						<h2 class="entry-title">
							<?php the_title(); ?>
						</h2> 				 
				
						<div class="entry-meta">
							<ul>
								<li><?php the_time('Y-n-j H:i'); ?></li>
								<span class="meta-sep">&bull;</span>							
								<li>
									<?php the_category( ', ' ); ?>
								</li>
								<span class="meta-sep">&bull;</span>
								<li><?php the_author(); ?></li>
							</ul>
						</div> 
				 
					</header> 
					<?php if ( has_post_thumbnail() ) { ?>
					<div class="entry-content-media">
						<div class="post-thumb">
							<?php the_post_thumbnail('full'); ?>
						</div> 
					</div>
					<?php } ?>
					<div class="entry-content">
						 <?php the_content(); ?>
					</div>

					<p class="tags">
  			         <span>Tagged in </span>:
  				      <?php the_tags('', ', ', ''); ?>
  			       </p> 

  			       <ul class="post-nav group">
  			            <li class="prev"><a rel="prev"><?php if (get_previous_post()) { previous_post_link('<strong>Trước</strong> %link','%title',false);} else { echo "Đây là bài viết cuối cùng";} ?></li>
  				         <li class="next"><a rel="next"><?php if (get_next_post()) { next_post_link('<strong>Sau</strong> %link','%title',false);} else { echo "Đây là bài viết mới nhất";} ?></li>
  			        </ul>
				</article>
			<?php endif; ?>
			<?php comments_template()?>
   		</div> <!-- main End -->

   		
   		<div id="sidebar" class="four columns">
   			<?php get_sidebar() ?>
   		</div> <!-- end sidebar -->

  		</div> <!-- end row -->

 </div> <!-- end content-wrap -->   
 <?php get_footer() ?>