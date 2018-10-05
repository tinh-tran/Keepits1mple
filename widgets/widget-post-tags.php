<?php 
/**
 * @package WordPress
 * @Theme TinhDk
 *
 * @author jackymon41@gmail.com
 * @link https://tinhdk.net
 * Tiện ích: Gắn thẻ 
 */
class TinhDk_widget_tag_cloud extends WP_Widget{

	//Cài đặt mặc định
	public $default_instance = array();

	//Khởi tạo
	function __construct(){
		parent::__construct(
			'tag_cloud',
			'Widget Tag Clouds' . __( '', 'TinhDk' ),
			array( 'description' => __( 'Hiển thị các điều khoản', 'TinhDk' ) )
		);
		$this->default_instance = array(
			'title'      => __( 'Tag cloud', 'TinhDk' ),
			'number'     => 100,
			'taxonomy'   => 'post_tag',
			'orderby'    => 'name',
			'order'      => 'DESC'
		);
	}

	//Nội dung tiện ích
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo '<h3>' . $title . '</h3>';
			ob_start();
				wp_tag_cloud( array(
					'taxonomy' => $this->_get_current_taxonomy( $instance ),
					'number'   => $instance['number'],
					'unit'     => 'px',
					'smallest' => 10,
					'largest'  => 15,
					'orderby'  => $instance['orderby'],
					'order'    => $instance['order']
				) );
			$tag_cloud_code = ob_get_clean();
			echo empty( $tag_cloud_code ) ? '<ul>' . __( 'Nhãn không có, nhanh chóng tạo ra nó！' ) . '</ul>' : '<div class="tagcloud group">' .$tag_cloud_code. '</div>';
		echo $args['after_widget'];
	}

	//Lưu các tùy chọn cài đặt
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//Tiêu đề
		$instance['title'] = strip_tags( $new_instance['title'] );

		//Số lượg
		$instance['number'] = absint( $new_instance['number'] );

		//Phân loại
		$instance['taxonomy'] = $this->_get_current_taxonomy( $new_instance );

		//Sắp xếp các nhãn
		$all_orderby = array( 'name', 'count' );
		$instance['orderby'] = in_array( $new_instance['orderby'], $all_orderby ) ? $new_instance['orderby'] : 'name';

		//Quy tắc phân loại
		$all_order = array( 'ASC', 'DESC', 'RAND' );
		$instance['order'] = in_array( $new_instance['order'], $all_order ) ? $new_instance['order'] : 'DESC';

		return $instance;
	}

	//Thiết lập biểu mẫu
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );

		$taxonomy = $this->_get_current_taxonomy( $instance );

		$orderby = array(
			'name'   => __( 'Tên thẻ', 'TinhDk' ),
			'count'  => __( 'Số lượng bài viết', 'TinhDk' )
		);

		$order = array(
			'ASC'   => __( 'Sắp xếp theo', 'TinhDk' ),
			'DESC'  => __( 'Trật tự', 'TinhDk' ),
			'RAND'  => __( 'Ngẫu nhiên', 'TinhDk' )
		);
	?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Tiêu đề:', 'TinhDk' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p title="<?php esc_attr_e( 'Đặt thành 0 tất cả được hiển thị', 'TinhDk' ); ?>">
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Số nhãn:', 'TinhDk' ); ?></label>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>"><?php _e( 'Phân loại:', 'TinhDk' ); ?></label>
			<select class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'taxonomy' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'taxonomy' ) ); ?>">
				<?php
				foreach( get_taxonomies( array( 'show_tagcloud' => true ), false ) as $tax ):
					if ( empty( $tax->labels->name ) ) continue;
				?>
					<option value="<?php echo esc_attr( $tax->name ); ?>"<?php selected( $taxonomy, $tax->name ); ?>><?php echo $tax->labels->name; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Sắp xếp theo thẻ:', 'TinhDk' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php foreach( $orderby as $orderby_name => $orderby_title ): ?>
					<option value="<?php echo $orderby_name; ?>"<?php selected( $instance['orderby'], $orderby_name ); ?>><?php echo $orderby_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>"><?php _e( 'Quy tắc phân loại:', 'TinhDk' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'order' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'order' ) ); ?>">
				<?php foreach( $order as $order_name => $order_title ): ?>
					<option value="<?php echo $order_name; ?>"<?php selected( $instance['order'], $order_name ); ?>><?php echo $order_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
<?php
	}

	//Hệ thống phân loại hiện tại
	function _get_current_taxonomy( $instance ){
		$taxonomy = stripslashes( $instance['taxonomy'] );
		return !empty( $taxonomy ) && taxonomy_exists( $taxonomy ) ? $taxonomy : 'post_tag';
	}

}
register_widget( 'TinhDk_widget_tag_cloud' );

//End of page.