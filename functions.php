<?php
if (! function_exists('s1mple_setup')) : 
function s1mple_setup()
{
// Hide admin bar
add_filter('show_admin_bar', '__return_false');
add_theme_support('post-thumbnails');
register_nav_menus(array(
        'primary' => __('Primary Menu'),
    ));
register_nav_menus(array(
        'footer' => __('Footer Menu'),
    ));
add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    // Set up the WordPress core custom background feature.
    add_theme_support('custom-background', apply_filters('custom_background_args', array(
        'default-color' => 'ffffff',
        'default-image' => '',
    )));

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    add_post_type_support( 'page', 'excerpt' );

    add_theme_support( 'custom-logo', array(
	'height'      => 100,
	'width'       => 400,
	'flex-height' => true,
	'flex-width'  => true,
	'header-text' => array( 'site-title', 'site-description' ),
) );

}
endif;
add_action('after_setup_theme', 's1mple_setup');
function blog_script ()
	{  
		wp_enqueue_script('Google-jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', false);
        wp_enqueue_style('FontAwesome', get_template_directory_uri() .'/css/font-awesome/css/font-awesome.min.css', false);
			//layout
		wp_enqueue_style('layout', get_template_directory_uri() . '/css/layout.css', array(), 'all');
		wp_enqueue_style('style', get_template_directory_uri() . '/style.css', array(), 'all');
			//media-queries
		wp_enqueue_style('media-queries', get_template_directory_uri() . '/css/media-queries.css', array(), 'all');
			
		wp_enqueue_script('modernizr-js', get_template_directory_uri() . '/js/modernizr.js', array(), true);

		wp_enqueue_script('jquery-js', get_template_directory_uri() . '/js/jquery-1.10.2.min.js', array('jquery') ,true);

		wp_enqueue_script('jQuery-migrate-js', get_template_directory_uri() . '/js/jquery-migrate-1.2.1.min.js', array() ,  true);

		wp_enqueue_script('main-js', get_template_directory_uri() . '/js/main.js', array(), true);

		}
add_action('wp_enqueue_scripts', 'blog_script');

define('APP_PATH',dirname(__FILE__));

include APP_PATH.'/inc/wp_nav_menu.php';

add_action( 'widgets_init', 's1mple_widgets_init' );
function s1mple_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Primary SideBar', 's1mple' ),
        'id' => 'primary-sidebar',
        'name-class' => 'four columns',
        'description' => __( 'Widgets in this area will be shown on all posts and pages.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
        'before_title' => '<h3">',
        'after_title' => '</h3>',       
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 1 SideBar', 's1mple' ),
        'id' => 'footer-about-sidebar',
        'name-class' => 'six columns info',
        'description' => __( 'About SideBar.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="six columns info">',
        'after_widget'  => '</div>',
        'before_title' => '<h3">',
        'after_title' => '</h3>',       
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 2 SideBar', 's1mple' ),
        'id' => 'footer-photo-sidebar',
        'name-class' => 'four columns',
        'description' => __( 'About SideBar.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="four columns">',
        'after_widget'  => '</div>',
        'before_title' => '<h3 class="social">',
        'after_title' => '</h3>',       
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 3 SideBar', 's1mple' ),
        'id' => 'footer-menu-sidebar',
        'name-class' => 'two columns',
        'description' => __( 'About SideBar.', 'theme-slug' ),
        'before_widget' => '<div id="%1$s" class="two columns">',
        'after_widget'  => '</div>',
        'before_title' => '<h3">',
        'after_title' => '</h3>',       
    ) );
    foreach( glob( get_template_directory() . '/widgets/widget-*.php' ) as $file_path )
        include( $file_path );
        $unregister_widgets = array(
            'Tag_Cloud',
            'Recent_Comments',
            'Recent_Posts'
        );
        foreach( $unregister_widgets as $widget )
            unregister_widget( 'WP_Widget_' . $widget );
}

//check list bai viet
if ( !function_exists( 'TinhDk_sidebar_posts_list' ) ) :
    /**
     * Danh sách bài viết về Sidebar
     */
    function TinhDk_sidebar_posts_list( $query_args ){
        $query_args['post_type']='post';
        $query = new WP_Query( $query_args );
        if( $query->have_posts() ):
            echo '<div class="widget widget_popular">';
                while( $query->have_posts() ):
                    $query->the_post();
                    TinhDk_sidebar_posts_list_loop();
                endwhile;
                wp_reset_postdata();
            echo '</div>';
        else:
    ?>
            <div class="empty-sidebar-posts-list">
                <p><?php _e( 'Không có gì ở đây, bạn có thể sử dụng chức năng tìm kiếm để tìm thấy những gì bạn cần:' ); ?></p>
                <?php get_search_form(); ?>
            </div>
    <?php
        endif;
    }
endif;
if ( !function_exists( 'TinhDk_sidebar_posts_list_loop' ) ) :
    /**
     * Phong cách bài viết sidebar
     */
    function TinhDk_sidebar_posts_list_loop(){
    ?>
        <ul class="link-list" >
                <?php the_title( '<li><a href="' . esc_url( get_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a>' ); ?>        
        </ul>
    <?php
    }
endif;
//get post view

// Lượt xem bài viết
function getPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0";
    }
    return $count;
}
function setPostViews($postID) {
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}
// form search
function my_search_form( $form ) {
   $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" >
    <input type="text" class="text-search" value="' . get_search_query() . '" name="s" id="s" placeholder="'.esc_attr__('Search the Site...','s1mple').'" />
    <input type="submit" value="" class="submit-search" alt="'. esc_attr__('') .'" >
    </form>';
    return $form;
}

add_filter( 'get_search_form', 'my_search_form', 100 );

function s1mple_comment($comment, $args, $depth)
{
   $GLOBALS['comment'] = $comment;
?>
   <li class="depth-1" id="li-comment-<?php comment_ID(); ?>">
        <div class="avatar">
            <?php if (function_exists('get_avatar') && get_option('show_avatars')) { 
                if (get_comment_author_url()!=null) { ?>
                    <a href="<?php echo get_comment_author_url(); ?>" target="_blank">
                <?php } 
                echo get_avatar($comment, 50);
                if (get_comment_author_url()!=null) { ?>
                </a>
                <?php } 
                } 
                comment_reply_link(array_merge( $args, array('reply_text' => 'Trả lời','depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
        </div>
        <div class="comment-content" id="comment-<?php comment_ID(); ?>">
            <div class="comment-info"> <cite><?php printf(__('<strong class="author_name">%s</strong>'), get_comment_author_link()); ?></cite>
                <?php if ($comment->user_id == '1' or $comment->comment_author_email == get_the_author_meta('user_email',1)) {
                        echo '<span>Blogger Nổi bậc</span>';
                    }else{
                        echo get_author_class($comment->comment_author_email,$comment->user_id);
                    }
                ?>
                <div class="comment-meta"><time class="comment-time" datetime="2014-07-12T23:05"><?php echo get_comment_time('Y-m-d H:i'); ?></time>
                </div>
            </div>
                <div class="comment-text">
                <?php if ($comment->comment_approved == '0') : ?><p>
Nhận xét của bạn đang được xem xét và sẽ được hiển thị sau!</p><?php endif; ?>
                <?php comment_text(); ?>
                </div>
            </div>
        </li>
<?php }