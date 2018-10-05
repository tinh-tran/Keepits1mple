<article class="entry post-<?php the_ID(); ?>" <?php post_class(); ?>">
					<header class="entry-header">
						<h2 class="entry-title">
							<a href="<?php the_permalink() ?>" title=""><?php the_title(); ?></a>
						</h2> 				 
						<div class="entry-meta">
							<ul>
								<li><?php the_time('Y-n-j H:i') ?></li>
								<span class="meta-sep">&bull;</span>								
								<li><a href="<?php echo $category_detail=get_the_category( $post->ID ); ?>" title="" rel="category tag"><?php the_category( ', ' ); ?></a></li>
								<span class="meta-sep">&bull;</span>
								<?php $author = get_the_author(); ?>
								<li> <?php echo $author?></li>
							</ul>
						</div> 
					</header> 
					<div class="entry-content">
						<p><?php echo the_excerpt(); ?> </p>
					</div> 
</article> <!-- end entry -->