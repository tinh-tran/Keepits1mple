<?php
/**
 * @package WordPress
 * @Theme TinhDk
 *
 * @author jackymon41@gmail.com
 * @link https://tinhdk.net
 */
if (isset($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Xin vui lòng không mở mô-đun nhận xét trực tiếp!');
?>
			<!-- Comments
            ================================================== -->
            <div id="comments">
            	<h3><?php comments_popup_link('0', '1', '%', '', '<a>0</a>'); ?> Comments</h3>
 			<!-- commentlist -->
 			<ol class="commentlist">
	           <?php
		    	if ( !comments_open() ) {
					?>
						<h3>Chức năng nhận xét đã bị đóng!</h3>>
					<?php
				    	} else if ( !have_comments() ) {
					?>
						<h3>Không có bất kỳ bình luận nào!</h3>
					<?php
				    	} else {
				       		wp_list_comments('type=comment&callback=s1mple_comment');
				    	}
					?>	
               </ol> <!-- Commentlist End -->
               <!-- respond -->
               <div class="respond">
                  <h3>Leave a Comment</h3>

                  <!-- form -->
                  <form name="comment-form" id="comment-form" method="post" action="<?php echo get_option('siteurl'); ?>/wp-comments-post.php">
  					   <fieldset>

                     <div class="group">
  						      <label for="cName">Name <span class="required">*</span></label>
  						      <input name="cName" type="text" id="cName" size="35" value="" />
                     </div>

                     <div class="group">
  						      <label for="cEmail">Email <span class="required">*</span></label>
  						      <input name="cEmail" type="text" id="cEmail" size="35" value="" />
                     </div>

                     <div class="group">
  						      <label for="cWebsite">Website</label>
  						      <input name="cWebsite" type="text" id="cWebsite" size="35" value="" />
                     </div>

                     <div class="message group">
                        <label  for="cMessage">Message <span class="required">*</span></label>
                        <textarea name="cMessage"  id="cMessage" rows="10" cols="50" ></textarea>
                     </div>

                     <button type="submit" class="submit">Submit</button>

  					</fieldset>
  					<?php comment_id_fields(); ?>
	    			<?php do_action('comment-form', $post->ID); ?>
  				     </form> <!-- Form End -->
               </div> <!-- Respond End -->
            </div>  <!-- Comments End -->