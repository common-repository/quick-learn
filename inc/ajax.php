<?php
add_action('wp_ajax_removerating', 'Tbit_removerating');
if(!function_exists('Tbit_removerating')){
	function Tbit_removerating(){
		global $wpdb;
		$return = 0;
		if(isset($_POST['rating_id']) && !empty($_POST['rating_id'])){
			$rating_id = sanitize_text_field($_POST['rating_id']);	
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;
			if(in_array('administrator',$roles)){
			$response = $wpdb->delete( $wpdb->prefix .'gsplms_rating',[ 'rating_id' => $rating_id ]);
				if($response){
					$return = 1;
				}
			}
		}
		echo esc_html($return);
		wp_die();
	}
}

add_action('wp_ajax_approvedisapproverating', 'Tbit_approvedisapproverating');
if(!function_exists('Tbit_approvedisapproverating')){
	function Tbit_approvedisapproverating(){
		global $wpdb;
		$return = 0;
		if(isset($_POST['rating_id']) && !empty($_POST['rating_id']) && isset($_POST['status']) && !empty($_POST['status'])){
			$rating_id = sanitize_text_field($_POST['rating_id']);
			$status = sanitize_text_field($_POST['status']);

			if($status == 'yes'){
				$status = 1;
			} else {
				$status = 0;
			}
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;
			if(in_array('administrator',$roles)){

			$array = array(
				'status' => $status,
			);

			$response = $wpdb->update( $wpdb->prefix .'gsplms_rating',$array,array('rating_id' => $rating_id));
				if($response){
					$return = 1;
				}
			}
		}
		echo esc_html($return);
		wp_die();
	}
}

add_action('wp_ajax_sendratingandreview', 'Tbit_lms_sendratingandreview');
if(!function_exists('Tbit_lms_sendratingandreview')){
	function Tbit_lms_sendratingandreview(){
		global $wpdb;
		$user_id=get_current_user_id();
		$post_id = 0;
		$rating = 0;
		$comment = '';
		if(isset($_POST['post_id']) && !empty($_POST['post_id'])){
			$post_id = sanitize_text_field($_POST['post_id']);
		}
		if(isset($_POST['rating']) && !empty($_POST['rating'])){
			$rating = sanitize_text_field($_POST['rating']);
		}
		if(isset($_POST['comment']) && !empty($_POST['comment'])){
			$comment = sanitize_textarea_field($_POST['comment']);
		}
		$get_result = Tbit_get_courseratings($post_id,$user_id);
		if(count($get_result)>0){

			$update_array = array(
				'rating' => $rating,
				'comment' => $comment
			);
			$result = $wpdb->update($wpdb->prefix.'gsplms_rating',$update_array,array('user_id' => $user_id, 'post_id' => $post_id  ));

			echo 1;

		} else {
			$insert_array = array(
				'user_id' => $user_id,
				'post_id' => $post_id,
				'rating' => $rating,
				'comment' => $comment,
				'created_on' => date('Y-m-d H:i:s'),
			);

			$result = $wpdb->insert($wpdb->prefix.'gsplms_rating',$insert_array);

			echo 1;
		}
		wp_die();

	}
}


add_action('wp_ajax_getallreviewsbypostid', 'Tbit_getallreviewsbypostid');
if(!function_exists('Tbit_getallreviewsbypostid')){
	function Tbit_getallreviewsbypostid(){
		global $wpdb;
		$return = 0;
		$datahtml = '';
		if(isset($_POST['post_id']) && !empty($_POST['post_id'])){
			$post_id = sanitize_text_field($_POST['post_id']);
			$result = Tbit_get_courseratings($post_id);
			if(count($result)>0){
			foreach ($result as $rk => $rv) {
				$main_rating = $rv['rating'];
				$rating_user = get_user_by('id',$rv['user_id']);
				$user_image = plugin_dir_url( __FILE__ )."../image/default_avater.png";
				$get_attachment_id = get_user_meta($rating_user->ID,'wp_user_avatar',true);
				if($get_attachment_id !=''){
					$user_image = wp_get_attachment_url($get_attachment_id);
				}?>


				<li class="a_r_m_box">
				<div class="rr_customer_name">
				<div class="c_imgbox">
				<img src='<?php echo esc_url($user_image);?>'/>
				</div>
				<div class="c_n_box"><?php echo esc_html($rating_user->display_name) ?></div></div>
				<div class="ratingbox1">
				<?php 
				for ($ali=1; $ali <=5 ; $ali++) { 
					$active_a = '';
				if($main_rating>=$ali){
					$active_a = 'active';
				}
				?>
					
				<i class="fastaricon1 fa fa-star <?php echo esc_attr($active_a); ?>" data-id="<?php echo esc_attr($ali); ?>"></i>
				<?php } ?>
				</div><div>
				<p><?php echo esc_html($rv['comment']); ?></p>
				</div></li>
			<?php }
		}

		}
		wp_die();
	}
}

?>