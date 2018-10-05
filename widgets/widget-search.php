<?php
/**
 * @package WordPress
 * @Theme TinhDk
 *
 * @author jackymon41@gmail.com
 * @link https://tinhdk.net
 * Tiện ích: Bài viết
 */
class TinhDk_widget_search extends WP_Widget{

	//Cài đặt mặc định
	public $default_instance = array();

	//Khởi tạo
	function __construct(){
		parent::__construct(
			'search',
			'Tìm kiếm bài viêt' . __( '', 'TinhDk' ),
			array( 'description' => __( 'Theo các cài đặt có thể hiển thị các bài viết khác nhau', 'TinhDk' ) )
		);
		$this->default_instance = array(
			'title'         => __( 'Tìm kiếm', 'TinhDk' )
		);
	}

	//Nội dung tiện ích
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
		 if( !empty( $title ) ) echo '<h3>' . $title . '</h3>';
                          get_search_form();
		echo $args['after_widget'];
	}
	
    function update( $new_instance, $old_instance ) {
                    return;
            $instance = $old_instance;
                    $new_instance = wp_parse_args((array) $new_instance, array( 'title' => ''));
                    $instance['title'] = strip_tags($new_instance['title']);
                    return $instance;
     }
}
register_widget( 'TinhDk_widget_search' );

//End of page.