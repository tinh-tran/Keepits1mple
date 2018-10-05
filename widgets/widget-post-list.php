<?php
/**
 * @package WordPress
 * @Theme TinhDk
 *
 * @author jackymon41@gmail.com
 * @link https://tinhdk.net
 * Tiện ích: Bài viết
 */
class TinhDk_widget_posts_list extends WP_Widget{

	//Cài đặt mặc định
	public $default_instance = array();

	//Khởi tạo
	function __construct(){
		parent::__construct(
			'posts_list',
			'Widget Bài viết' . __( '', 'TinhDk' ),
			array( 'description' => __( 'Theo các cài đặt có thể hiển thị các bài viết khác nhau', 'TinhDk' ) )
		);
		$this->default_instance = array(
			'title'         => __( 'Bài viết', 'TinhDk' ),
			'orderby'       => 'date',
			'descending'    => true,
			'number'        => 5,
			'date_limit'    => 'unlimited',
			'exclude_posts' => array(),
			'exclude_tax'   => array()
		);
	}

	//Nội dung tiện ích
	function widget( $args, $instance ){
		if( empty( $instance ) ) $instance = $this->default_instance;
		$title = apply_filters( 'widget_title', $instance['title'], $instance, $this->id_base );
		echo $args['before_widget'];
			if( !empty( $title ) ) echo '<h3>' . $title . '</h3>';
			$query_args = array(
				'ignore_sticky_posts' => true,
				'orderby'             => $instance['orderby'],
				'order'               => $instance['descending'] ? 'DESC' : 'ASC',
				'posts_per_page'      => $instance['number'],
				'post__not_in'        => $instance['exclude_posts']
			);
			if( $query_args['orderby'] == 'post_views_count' ){
				$query_args['meta_key'] = 'post_views_count';
				$query_args['orderby'] = 'meta_value_num';
			}
			if( $instance['date_limit'] != 'unlimited' ) $query_args['date_query'] = array( 'after' => $instance['date_limit'] );
			if( !empty( $instance['exclude_tax'] ) ){
				$query_args['tax_query'] = array( 'relation' => 'AND' );
				foreach( $instance['exclude_tax'] as $tax => $term ) $query_args['tax_query'][] = array(
					'taxonomy' => $tax,
					'field'    => 'id',
					'terms'    => $term,
					'operator' => 'NOT IN'
				);
			}
			TinhDk_sidebar_posts_list( $query_args );
		echo $args['after_widget'];
	}

	//Lưu các tùy chọn cài đặt
	function update( $new_instance, $old_instance ){
		$instance = array();
		
		//Tiêu đề
		$instance['title'] = strip_tags( $new_instance['title'] );

		//Phân loại bài viết
		$all_orderby = array( 'date', 'comment_count', 'post_views_count', 'rand' );
		$instance['orderby'] = in_array( $new_instance['orderby'], $all_orderby ) ? $new_instance['orderby'] : 'date';

		//trật tự
		$instance['descending'] = !empty( $new_instance['descending'] );

		//Số lượng
		$instance['number'] = absint( $new_instance['number'] );
		if( $instance['number'] === 0 ) $instance['number'] = 1;

		//Giới hạn ngày
		$all_date_limit = array(
			'unlimited',
			'1 day ago',
			'3 day ago',
			'1 week ago',
			'1 month ago',
			'3 month ago',
			'6 month ago',
			'1 year ago',
			'2 year ago',
			'3 year ago'
		);
		$instance['date_limit'] = in_array( $new_instance['date_limit'], $all_date_limit ) ? $new_instance['date_limit'] : 'unlimited';
		$instance['exclude_posts'] = array_map( 'absint', (array) $new_instance['exclude_posts'] );
		if( !empty( $instance['exclude_posts'] ) ) $instance['exclude_posts'] = get_posts( array(
			'post__in'               => $instance['exclude_posts'],
			'nopaging'               => true,
			'post_type'              => 'post',
			'post_status'            => array( 'publish', 'future' ),
			'fields'                 => 'ids',
			'update_post_meta_cache' => false,
			'update_post_term_cache' => false
		) );
		$instance['exclude_tax'] = (array) $new_instance['exclude_tax'];
		foreach( $instance['exclude_tax'] as $tax_name => $tax ){
			if( !taxonomy_exists( $tax_name ) || !is_array( $tax ) || empty( $tax ) ){
				unset( $instance['exclude_tax'][$tax_name] );
				continue;
			}
			$instance['exclude_tax'][$tax_name] = (array) $instance['exclude_tax'][$tax_name];
			foreach( $instance['exclude_tax'][$tax_name] as $key => $term_id ){
				$instance['exclude_tax'][$tax_name][$key] = absint( $term_id );
				if( !term_exists( $instance['exclude_tax'][$tax_name][$key], $tax_name ) ) unset( $instance['exclude_tax'][$tax_name][$key] );
			}
			if( empty( $instance['exclude_tax'][$tax_name] ) ) unset( $instance['exclude_tax'][$tax_name] );
		}

		return $instance;
	}

	//Thiết lập biểu mẫu
	function form( $instance ){
		$instance = wp_parse_args( $instance, $this->default_instance );

		$orderby = array(
			'date'          => __( 'Thời gian public', 'TinhDk' ),
			'comment_count' => __( 'Số lượng nhận xét', 'TinhDk' ),
			'post_views_count'         => __( 'Lượt xem', 'TinhDk' ),
			'rand'          => __( 'Sắp xếp ngẫu nhiên', 'TinhDk' )
		);

		$date_limit = array(
			'unlimited'   => __( 'Không giới hạn', 'TinhDk' ),
			'1 day ago'   => __( 'Trong một ngày', 'TinhDk' ),
			'3 day ago'   => __( 'Trong vòng ba ngày', 'TinhDk' ),
			'1 week ago'  => __( 'Trong vòng một tuần', 'TinhDk' ),
			'1 month ago' => __( 'Trong vòng một tháng', 'TinhDk' ),
			'3 month ago' => __( 'Trong vòng ba tháng', 'TinhDk' ),
			'6 month ago' => __( 'Trong vòng 6 tháng', 'TinhDk' ),
			'1 year ago'  => __( 'Trong vòng một năm', 'TinhDk' ),
			'2 year ago'  => __( 'Trong vòng 2 năm', 'TinhDk' ),
			'3 year ago'  => __( 'Trong vòng 3 năm', 'TinhDk' )
		);
?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Tiêu đề:', 'TinhDk' ); ?></label>
			<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" value="<?php echo esc_attr( $instance['title'] ); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>"><?php _e( 'Phân loại sắp xếp:', 'TinhDk' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'orderby' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'orderby' ) ); ?>">
				<?php foreach( $orderby as $orderby_name => $orderby_title ): ?>
					<option value="<?php echo $orderby_name; ?>"<?php selected( $instance['orderby'], $orderby_name ); ?>><?php echo $orderby_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>"><?php _e( 'Thứ tự', 'TinhDk' ); ?></label>
			<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'descending' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'descending' ) ); ?>" value="1"<?php checked( $instance['descending'] ); ?> />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>"><?php _e( 'Số bài viết:', 'TinhDk' ); ?></label>
			<input type="number" id="<?php echo esc_attr( $this->get_field_id( 'number' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'number' ) ); ?>" value="<?php echo $instance['number']; ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>"><?php _e( 'Giới hạn ngày:', 'TinhDk' ); ?></label>
			<select id="<?php echo esc_attr( $this->get_field_id( 'date_limit' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'date_limit' ) ); ?>">
				<?php foreach( $date_limit as $date_code => $date_title ): ?>
					<option value="<?php echo $date_code; ?>"<?php selected( $instance['date_limit'], $date_code ); ?>><?php echo $date_title; ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>"><?php _e( 'Loại trừ các bài viết：', 'TinhDk' ); ?></label>
			<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_posts' ) ); ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_posts' ) ); ?>[]">
				<?php foreach( get_posts( 'nopaging=1&post_status=publish,future' ) as $post ): ?>
					<option value="<?php echo esc_attr( $post->ID ); ?>"<?php if( in_array( $post->ID, $instance['exclude_posts'] ) ) echo ' selected="selected"'; ?>><?php echo get_the_title( $post ); ?></option>
				<?php endforeach; ?>
			</select>
		</p>
		<?php
		foreach( get_taxonomies( array( 'show_tagcloud' => true ), false ) as $tax_name => $tax ):
			if ( empty( $tax->labels->name ) || !in_array( 'post', $tax->object_type ) ) continue;
			$trems = get_terms( $tax_name, 'hide_empty=0' );
			if( is_wp_error( $trems ) ) continue;
			if( empty( $instance['exclude_tax'][$tax_name] ) ) $instance['exclude_tax'][$tax_name] = array();
		?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'exclude_tax' ) ) . "[$tax_name]"; ?>"><?php printf( __( 'Loại trừ%s：', 'TinhDk' ), $tax->labels->name ); ?></label>
				<select class="widefat" multiple="multiple" id="<?php echo esc_attr( $this->get_field_id( 'exclude_tax' ) ) . "[$tax_name]"; ?>[]" name="<?php echo esc_attr( $this->get_field_name( 'exclude_tax' ) . "[$tax_name]" ); ?>[]">
					<?php foreach( $trems as $trem ): ?>
						<option value="<?php echo esc_attr( $trem->term_id ); ?>"<?php if( in_array( $trem->term_id, $instance['exclude_tax'][$tax_name] ) ) echo ' selected="selected"'; ?>><?php echo $trem->name; ?></option>
					<?php endforeach; ?>
				</select>
			</p>
		<?php endforeach; ?>
<?php
	}

}
register_widget( 'TinhDk_widget_posts_list' );

//End of page.