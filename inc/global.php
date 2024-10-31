<?php
if(!function_exists('tbit_lms_verification_mail_send')){
	function tbit_lms_verification_mail_send($user_id){
		$user_info = get_userdata($user_id);
		// create md5 code to verify later
		$code = md5(time());
		// make it into a code to send it to user via email
		$string = array('id'=>$user_id, 'code'=>$code);
		// create the activation code and activation status
		update_user_meta($user_id, 'is_activated', 0);
		update_user_meta($user_id, 'activation_code', $code);
		// create the url
		$url = get_site_url(). '/quick-learn-my-account/?act=' .base64_encode( serialize($string));
		$html = 'Please click the following links <br/><br/> <a href="'.$url.'">'.$url.'</a>';
		wp_mail( $user_info->user_email, __('Email Subject','text-domain') , $html);
	}
}
if(!function_exists('tbit_lms_getDuration')){
	function tbit_lms_getDuration($lms_assement_duration,$lms_assement_duration_type){
	if($lms_assement_duration_type=='minute'){
		$minutes=$lms_assement_duration;
		$hours = floor($minutes / 60); // Get the number of whole hours
		$minutes = $minutes % 60; // Get the remainder of the hours
		$seconds = 00;
		return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
		} else if($lms_assement_duration_type=='hour'){
		$minutes = 00;
		$seconds = 00;
		return sprintf ("%02d:%02d:%02d", $lms_assement_duration, $minutes,$seconds);
		} else if($lms_assement_duration_type=='day'){
		$minutes = 00;
		$seconds = 00;
		$hours=$lms_assement_duration*24;
		return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
		} else if($lms_assement_duration_type=='week'){
		$minutes = 00;
		$seconds = 00;
		$hours=($lms_assement_duration*7)*24;
		return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
		}
	}
}
if(!function_exists('tbit_lms_checknext_prev')){
	function tbit_lms_checknext_prev($course_id,$item_id){
		global $wpdb;
		$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s order by item_id DESC",2,$course_id);
		$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

		$i=0;
		$mkey = '-1';
		if(count($get_results)>0){
			foreach ($get_results as $key => $value) {
				if($value['item_id'] == $item_id){
					$mkey = $key;
				}
			$i++;
			}
		}
		$return_data = array();
		if($mkey !='-1'){
			$prev_exits = $mkey-1;
			$next_exits = $mkey+1;
			if(isset($get_results[$prev_exits])){
				$return_data['prev'] = 'yes';
			} else {
				$return_data['prev'] = 'no';
			}
			if(isset($get_results[$next_exits])){
				$return_data['next'] = 'yes';
			} else {
				$return_data['next'] = 'no';
			}
		}

		return $return_data;


	}
}
if(!function_exists('insert_meta_data')){
	function insert_meta_data($meta_key,$meta_value){
		global $wpdb;
		$prepare_sql = $wpdb->prepare("SELECT gsp_setting_id FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",$meta_key);
		$result = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($result)>0){
			$array = array(
				'meta_value' => $meta_value,
			);
			$wpdb->update($wpdb->prefix.'gsp_lms_setting_meta',$array,array('meta_key'=>$meta_key));
		} else {
			$array = array(
				'meta_key' => $meta_key,
				'meta_value' => $meta_value,
			);
			$wpdb->insert($wpdb->prefix.'gsp_lms_setting_meta',$array);
		}
	}
}
if(!function_exists('tbit_data_retrivedata')){
	function tbit_data_retrivedata($meta_key){
		global $wpdb;
		$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",$meta_key);
		$result = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($result)>0){
			return $result[0]['meta_value'];
		} else {
			return '';
		}
	}
}
if(!function_exists('Tbit_lms_require_pro_version_text')){
	function Tbit_lms_require_pro_version_text($value='')
	{
		$text = '';
		if($value !=''){
			$text = '<em><b>'.$value.'</b></em>';
		} else {
			$text = '<a href="'.Tbit_PLUGIN_PRO_URL.'" target="_blank"><em><b>required pro version</b></em></a>';
		}
		return $text;
	}
}
if(!function_exists('Tbit_lms_require_pro_version_html')){
	function Tbit_lms_require_pro_version_html($value='')
	{
		ob_start();
		?>
		<div class="wrap">
		<div class="quick_learn_wrapbox">
		<?php if($value !=''){?>
		<h2><?php echo html_entity_decode(esc_html($value)); ?></h2>
		<?php }?>
		<a class="quick-learn-button-go-pro" target="_blank" href="<?php echo esc_url(Tbit_PLUGIN_PRO_URL); ?>">Upgrade Now</a>
		</div>
		</div>
		<?php
		$content = ob_get_clean();
        return $content;
	}
}
if(!function_exists('Tbit_lms_dutaion_type')){
	function Tbit_lms_dutaion_type($type){
		$return_text = $type;
		if($type == 'minute'){
			$return_text = 'minutes';
		}
		return $return_text;
	}
}
if(!function_exists('Tbit_lms_root_css')){
	function Tbit_lms_root_css(){

		$primary_color = '#337ab7';
		$gsp_primary_color = Tbit_lms_retrivedata('gsp_primary_color');
		if($gsp_primary_color){
			$primary_color = $gsp_primary_color;
		}

		$secondary_color = '#333333';
		$gsp_secondary_color = Tbit_lms_retrivedata('gsp_secondary_color');
		if($gsp_secondary_color){
			$secondary_color = $gsp_secondary_color;
		}

		$button_text_color = '#ffffff';
		$gsp_button_text_color = Tbit_lms_retrivedata('gsp_button_text_color');
		if($gsp_button_text_color){
			$button_text_color = $gsp_button_text_color;
		}
		$button_bc_color = '#007bff';
		$gsp_button_background_color = Tbit_lms_retrivedata('gsp_button_background_color');
		if($gsp_button_background_color){
			$button_bc_color = $gsp_button_background_color;
		}

		$button_hover_text_color = '#ffffff';
		$gsp_button_hover_text_color = Tbit_lms_retrivedata('gsp_button_hover_text_color');
		if($gsp_button_hover_text_color){
			$button_hover_text_color = $gsp_button_hover_text_color;
		}

		$button_hover_bc_color = '#414141';
		$gsp_button_hover_background_color = Tbit_lms_retrivedata('gsp_button_hover_background_color');
		if($gsp_button_hover_background_color){
			$button_hover_bc_color = $gsp_button_hover_background_color;
		}

		$favourite_icon_color = '#007bff';
		$gsp_favourite_icon_color = Tbit_lms_retrivedata('gsp_favourite_icon_color');
		if($gsp_favourite_icon_color){
			$favourite_icon_color = $gsp_favourite_icon_color;
		}

		$favourite_active_icon_color = '#ef4c4c';
		$gsp_favourite_active_icon_color = Tbit_lms_retrivedata('gsp_favourite_active_icon_color');
		if($gsp_favourite_active_icon_color){
			$favourite_active_icon_color = $gsp_favourite_active_icon_color;
		}


		$rootVariables .= ":root {"."\n";
		$rootVariables .= "--gsp-primary-color: ".$primary_color.";"."\n";
		$rootVariables .= "--gsp-secondary-color:".$secondary_color.";"."\n";
		$rootVariables .= "--gsp-button-text-color: ".$button_text_color.";"."\n";
		$rootVariables .= "--gsp-button-background-color: ".$button_bc_color.";"."\n";
		$rootVariables .= "--gsp-button-hover-text-color: ".$button_hover_text_color.";"."\n";
		$rootVariables .= "--gsp-button-hover-background-color: ".$button_hover_bc_color.";"."\n";
		$rootVariables .= "--gsp-favourite-icon-color: ".$favourite_icon_color.";"."\n";
		$rootVariables .= "--gsp-favourite-active-icon-color: ".$favourite_active_icon_color.";"."\n";
		$rootVariables .= "}";
		wp_add_inline_style( 'tbit-quick-learn-css', $rootVariables );
	}
}

if(!function_exists('Tbit_get_courseratings')){
	function Tbit_get_courseratings($post_id='',$user_id='')
	{
		global $wpdb;
		if(!empty($post_id) && !empty($user_id)){
			$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_rating WHERE post_id=%s AND user_id=%s",$post_id,$user_id);
		}else if(!empty($user_id)){
			$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_rating WHERE user_id=%s",$user_id);
		} else if(!empty($post_id)){
			$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_rating WHERE post_id=%s",$post_id);
		} else {
			$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_rating");
		}
        $result = $wpdb->get_results($prepare_sql,ARRAY_A);
        $return_data = array();
        if(count($result)>0){
        	foreach ($result as $key => $value) {
        		$return_data[] = $value;	
        	}
        }
        return $return_data;
		
	}
}

if(!function_exists('Tbit_get_courseratings_count')){
	function Tbit_get_courseratings_count($post_id='')
	{
		global $wpdb;
		if(!empty($post_id)){
			$prepare_sql = $wpdb->prepare("SELECT COUNT(*) as total FROM ".$wpdb->prefix."gsplms_rating WHERE post_id=%s",$post_id);
		} else {
			$prepare_sql = $wpdb->prepare("SELECT COUNT(*) as total FROM ".$wpdb->prefix."gsplms_rating");
		}
        $result = $wpdb->get_results($prepare_sql,ARRAY_A);

        $return_data = array();
        if(count($result)>0){
        	foreach ($result as $key => $value) {
        		$return_data['total_count'] = $value['total'];
     			
        	}
        }
        return $return_data;
		
	}
}

if(!function_exists('Tbit_get_courseratings_count_with_average')){
	function Tbit_get_courseratings_count_with_average($post_id='')
	{
		global $wpdb;
		if(!empty($post_id)){
			$prepare_sql = $wpdb->prepare("SELECT rating FROM ".$wpdb->prefix."gsplms_rating WHERE post_id=%s",$post_id);
		} else {
			$prepare_sql = $wpdb->prepare("SELECT rating FROM ".$wpdb->prefix."gsplms_rating");
		}
        $result = $wpdb->get_results($prepare_sql,ARRAY_A);
        $return_data = array();
        if(count($result)>0){
        	$ratings = array();
        	$onestar = 0;
        	$twostar = 0;
        	$threestar = 0;
        	$fourstar = 0;
        	$fivestar = 0;
        	foreach ($result as $key => $value) {
        		if($value['rating'] == 1){
        			$onestar = $onestar+1;
        		}
        		if($value['rating'] == 2){
        			$twostar = $twostar+1;
        		}
        		if($value['rating'] == 3){
        			$threestar = $threestar+1;
        		}
        		if($value['rating'] == 4){
        			$fourstar = $fourstar+1;
        		}
        		if($value['rating'] == 5){
        			$fivestar = $fivestar+1;
        		}
     			
        	}
        	$ratingsofnumber = array(
        		1 => $onestar,
        		2 => $twostar,
        		3 => $threestar,
        		4 => $fourstar,
        		5 => $fivestar,
        	);

			$max = 0;
			$n = 0;
			foreach ($ratingsofnumber as $rate => $count) {
			$max += $rate * $count;
			$n += $count;
			}
			$return_data['average'] = $max / $n;
			$return_data['total'] = $n;
			$return_data['ratingsofnumber'] = $ratingsofnumber;



        }
        return $return_data;
		
	}
}
if(!function_exists('Tbit_order_mail_html')){
	function Tbit_order_mail_html($order_id,$course_name,$quantity,$price){


		$font_family = "'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif";
		$datahtml ='<table cellspacing="0" cellpadding="6" border="1" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; width: 100%; font-family: '.$font_family.' "><thead><tr><th style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left">Course</th> <th style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left">Quantity</th> <th style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left">Price</th> </tr></thead> <tbody> <tr class="v1order_item"> <td class="v1td" style="text-align: left; vertical-align: middle; font-family: '.$font_family.' ; word-wrap: break-word"> '.$course_name.' </td><td class="v1td" style="text-align: left; vertical-align: middle; font-family: '.$font_family.'"> '.$quantity.' </td><td class="v1td" style="text-align: left; vertical-align: middle; font-family: '.$font_family.'"> <span class="v1woocommerce-Price-amount v1amount"><span class="v1woocommerce-Price-currencySymbol">$</span>'.$price.'</span> </td></tr></tbody> <tfoot> <tr> <th colspan="2" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px"> Subtotal: </th> <td style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px"> <span> <span class="v1woocommerce-Price-amount v1amount"> <span class="v1woocommerce-Price-currencySymbol">$</span>'.$price.' </span> </span> </td></tr><tr> <th colspan="2" style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px"> Total: </th> <td style="color: #636363; border: 1px solid #e5e5e5; vertical-align: middle; padding: 12px; text-align: left; border-top-width: 4px"> <span> <span class="v1woocommerce-Price-amount v1amount"> <span class="v1woocommerce-Price-currencySymbol">$</span>'.$price.' </span> </span> </td></tr></tfoot></table>';
		return $datahtml;
	}
}


if(!function_exists('Tbit_mail_with_html')){
	function Tbit_mail_with_html($html){
		$message = $html;
		return $message;
	}
}


if(!function_exists('Tbit_lms_order_items_table')){
	function Tbit_lms_order_items_table($order_id){
		global $wpdb;
		$return_data = array();
		$return_data['order_items_table'] = '';
		$return_data['order_date'] = '';
		$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."user_payments WHERE order_id=%s",$order_id);
		$result = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($result)>0 && isset($result[0]['subscribed_date'])){
			$date_create = date_create($result[0]['subscribed_date']);
			$course_name = get_the_title($result[0]['course_id']);
			$quantity = 1;
			$price = $result[0]['amount'];
			$return_data['order_items_table'] = stripslashes(Tbit_order_mail_html($order_id,$course_name,$quantity,$price));
			$return_data['order_date'] = date_format($date_create,'M dS Y H:i:s');
		}

		return $return_data;
	}
}

if(!function_exists('Tbit_lms_order_generate_html')){
	function Tbit_lms_order_generate_html($html,$user_id,$order_id){
		$user_data = get_user_by('id',$user_id);
		$admin_email = get_bloginfo( 'admin_email' );
		$admin_data = get_user_by('email',$admin_email);

		$order_data = Tbit_lms_order_items_table($order_id);

		$array = array(
			'{{site_url}}' => site_url(),
			'{{site_title}}' => get_bloginfo( 'name' ),
			'{{site_admin_email}}' => $admin_email,
			'{{site_admin_name}}' => $admin_data->first_name. ' ' . $admin_data->last_name,
			'{{request_email}}' => $user_data->user_email,
			'{{login_url}}' => wp_login_url(),
			'{{username}}' => $user_data->user_login,
			'{{order_id}}' => '#'.$order_id,
			'{{order_user_id}}' => $user_id,
			'{{order_user_name}}' => $user_data->first_name. ' ' .$user_data->last_name,
			'{{order_items_table}}' => $order_data['order_items_table'],
			'{{order_date}}' => $order_data['order_date'],

		);
		$datahtml = $html;
		foreach ($array as $key => $value) {
			$find_str = $key;
			$replace_with = $value;
			$change_html = $datahtml;
			$datahtml = str_replace($key,$value,$change_html);

		}

		return $datahtml;


	}
}

if(!function_exists('Tbit_become_an_instructor_mail_html')){
	function Tbit_become_an_instructor_mail_html($html,$user_id){
		$user_data = get_user_by('id',$user_id);

		$admin_email = get_bloginfo( 'admin_email' );
		$admin_data = get_user_by('email',$admin_email);
		$array = array(
			'{{site_url}}' => site_url(),
			'{{site_title}}' => get_bloginfo( 'name' ),
			'{{site_admin_email}}' => $admin_email,
			'{{site_admin_name}}' => $admin_data->first_name. ' ' . $admin_data->last_name,
			'{{request_email}}' => $user_data->user_email,
			'{{login_url}}' => wp_login_url(),
			'{{username}}' => $user_data->user_login,
		);
		$datahtml = $html;
		foreach ($array as $key => $value) {
			$find_str = $key;
			$replace_with = $value;
			$change_html = $datahtml;
			$datahtml = str_replace($key,$value,$change_html);

		}

		return $datahtml;


	}
}

if(!function_exists('Tbit_mail_send')){
	function Tbit_mail_send($from,$to,$subject,$message,$name=''){

		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

		$message = nl2br("$message");

		// More headers
		$headers .= 'From: '.$name.' <'.$from.'>' . "\r\n";
		$response_mail = wp_mail($to,$subject,$message,$headers);

		if($response_mail){
			return 1;
		} else {
			return 0;
		}
	}
}
if(!function_exists('Tbit_lms_retrivedata')){
	function Tbit_lms_retrivedata($meta_key){
	global $wpdb;
	$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",$meta_key);
	$result = $wpdb->get_results($prepare_sql,ARRAY_A);
	if(count($result)>0){
	return $result[0]['meta_value'];
	} else {
	return '';
	}
	}
}

if(!function_exists('Tbit_lms_instructor_approve_disapprove')){
	function Tbit_lms_instructor_approve_disapprove($user_id,$type=''){

		$gsp_from_name = Tbit_lms_retrivedata('gsp_from_name');
		$gsp_from_email = Tbit_lms_retrivedata('gsp_from_email');
		$admin_email = get_bloginfo( 'admin_email' );
		$userdata = get_userdata($user_id);
   		$roles = $userdata->roles;

   		

		if($type !=''){

			if($type == 'approved'){
				if(in_array('instructor',$roles)){

				$gsp_lms_email_become_an_instructor_accepted = Tbit_lms_retrivedata('gsp_lms_email_become_an_instructor_accepted');	



				if($gsp_lms_email_become_an_instructor_accepted !=''){

					$json_decode_become_instructor_accepted = json_decode($gsp_lms_email_become_an_instructor_accepted,true);

					if(isset($json_decode_become_instructor_accepted['enable']) && $json_decode_become_instructor_accepted['enable'] == 1){

					$gsp_lms_email_become_an_instructor_accepted_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_instructor_accepted_email_content_html');
					if($gsp_lms_email_become_an_instructor_accepted_email_content_html !=''){
					$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_instructor_accepted_email_content_html),$user_id);

					$message = Tbit_mail_with_html($return_message);

					$subject = Tbit_become_an_instructor_mail_html($json_decode_become_instructor_accepted['subject'],$user_id);

					$mailsend = Tbit_mail_send($gsp_from_email,$userdata->user_email,$subject,$message,$gsp_from_name);
					}
					}

				} /* gsp_lms_email_become_an_instructor_accepted end code  */


				} else if(in_array('student',$roles)){


				$gsp_lms_email_become_an_student_accepted = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_accepted');	

				if($gsp_lms_email_become_an_student_accepted !=''){

					$json_decode_become_student_accepted = json_decode($gsp_lms_email_become_an_student_accepted,true);

					if(isset($json_decode_become_student_accepted['enable']) && $json_decode_become_student_accepted['enable'] == 1){

					$gsp_lms_email_become_an_student_accepted_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_accepted_email_content_html');
					if($gsp_lms_email_become_an_student_accepted_email_content_html !=''){
					$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_student_accepted_email_content_html),$user_id);

					$message = Tbit_mail_with_html($return_message);

					$subject = Tbit_become_an_instructor_mail_html($json_decode_become_student_accepted['subject'],$user_id);

					$mailsend = Tbit_mail_send($gsp_from_email,$userdata->user_email,$subject,$message,$gsp_from_name);
					}
					}

				} /* gsp_lms_email_become_an_student_accepted end code  */


				}

			} else if($type == 'disapproved'){

				if(in_array('instructor',$roles)){
				$gsp_lms_email_become_an_instructor_denied = Tbit_lms_retrivedata('gsp_lms_email_become_an_instructor_denied');	

				if($gsp_lms_email_become_an_instructor_denied !=''){
					$json_decode_become_instructor_denied = json_decode($gsp_lms_email_become_an_instructor_denied,true);
					if(isset($json_decode_become_instructor_denied['enable']) && $json_decode_become_instructor_denied['enable'] == 1){
					$gsp_lms_email_become_an_instructor_denied_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_instructor_denied_email_content_html');
					if($gsp_lms_email_become_an_instructor_denied_email_content_html !=''){
					$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_instructor_denied_email_content_html),$user_id);

					$message = Tbit_mail_with_html($return_message);

					$subject = Tbit_become_an_instructor_mail_html($json_decode_become_instructor_denied['subject'],$user_id);

					$mailsend = Tbit_mail_send($gsp_from_email,$userdata->user_email,$subject,$message,$gsp_from_name);
					}
					}
				} /* gsp_lms_email_become_an_instructor_denied end code  */


				} else if(in_array('student',$roles)){

					$gsp_lms_email_become_an_student_denied = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_denied');	

				if($gsp_lms_email_become_an_student_denied !=''){
					$json_decode_become_student_denied = json_decode($gsp_lms_email_become_an_student_denied,true);
					if(isset($json_decode_become_student_denied['enable']) && $json_decode_become_student_denied['enable'] == 1){
					$gsp_lms_email_become_an_student_denied_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_denied_email_content_html');
					if($gsp_lms_email_become_an_student_denied_email_content_html !=''){
					$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_student_denied_email_content_html),$user_id);

					$message = Tbit_mail_with_html($return_message);

					$subject = Tbit_become_an_instructor_mail_html($json_decode_become_student_denied['subject'],$user_id);

					$mailsend = Tbit_mail_send($gsp_from_email,$userdata->user_email,$subject,$message,$gsp_from_name);
					}
					}
				} /* gsp_lms_email_become_an_student_denied end code  */

				}

			}
		}
	}
}

if(!function_exists('Tbit_lms_order_mail')){
	function Tbit_lms_order_mail($order_id,$course_id,$user_id){
		$author_id = get_post_field ('post_author', $course_id);
		$instructor_data = get_user_by('id',$author_id);
		$user_data = get_user_by('id',$user_id);


		$gsp_from_name = Tbit_lms_retrivedata('gsp_from_name');
		$gsp_from_email = Tbit_lms_retrivedata('gsp_from_email');
		$admin_email = get_bloginfo('admin_email');

		$gsp_lms_email_order_admin = Tbit_lms_retrivedata('gsp_lms_email_order_admin');
		if($gsp_lms_email_order_admin !=''){
		$json_decode_order_admin = json_decode($gsp_lms_email_order_admin,true);
		if(isset($json_decode_order_admin['enable']) && $json_decode_order_admin['enable'] == 1){
		$gsp_lms_emails_new_order_admin_email_content_html = Tbit_lms_retrivedata('gsp_lms_emails_new_order_admin_email_content_html');
		if($gsp_lms_emails_new_order_admin_email_content_html !=''){
		$return_message = Tbit_lms_order_generate_html(stripslashes($gsp_lms_emails_new_order_admin_email_content_html),$user_id,$order_id);

		$message = Tbit_mail_with_html($return_message);

		$subject = Tbit_lms_order_generate_html($json_decode_order_admin['subject'],$user_id,$order_id);

		$mailsend = Tbit_mail_send($gsp_from_email,$admin_email,$subject,$message,$gsp_from_name);
		}
		}
		} /* gsp_lms_email_order_admin end code  */


		$gsp_lms_email_order_instructor = Tbit_lms_retrivedata('gsp_lms_email_order_instructor');
		if($gsp_lms_email_order_instructor !='' && $admin_email != $instructor_data->user_email){
		$json_decode_order_instructor = json_decode($gsp_lms_email_order_instructor,true);
		if(isset($json_decode_order_instructor['enable']) && $json_decode_order_instructor['enable'] == 1){
		$gsp_lms_emails_new_order_instructor_email_content_html = Tbit_lms_retrivedata('gsp_lms_emails_new_order_instructor_email_content_html');
		if($gsp_lms_emails_new_order_instructor_email_content_html !=''){
		$return_message = Tbit_lms_order_generate_html(stripslashes($gsp_lms_emails_new_order_instructor_email_content_html),$user_id,$order_id);

		$message = Tbit_mail_with_html($return_message);

		$subject = Tbit_lms_order_generate_html($json_decode_order_instructor['subject'],$user_id,$order_id);

		$mailsend = Tbit_mail_send($gsp_from_email,$instructor_data->user_email,$subject,$message,$gsp_from_name);
		}
		}
		} /* gsp_lms_email_order_instructor end code  */


		$gsp_lms_email_order_student = Tbit_lms_retrivedata('gsp_lms_email_order_student');
		if($gsp_lms_email_order_student !=''){
		$json_decode_order_student = json_decode($gsp_lms_email_order_student,true);
		if(isset($json_decode_order_student['enable']) && $json_decode_order_student['enable'] == 1){
		$gsp_lms_emails_new_order_student_email_content_html = Tbit_lms_retrivedata('gsp_lms_emails_new_order_student_email_content_html');
		if($gsp_lms_emails_new_order_student_email_content_html !=''){
		$return_message = Tbit_lms_order_generate_html(stripslashes($gsp_lms_emails_new_order_student_email_content_html),$user_id,$order_id);

		$message = Tbit_mail_with_html($return_message);

		$subject = Tbit_lms_order_generate_html($json_decode_order_student['subject'],$user_id,$order_id);

		$mailsend = Tbit_mail_send($gsp_from_email,$user_data->user_email,$subject,$message,$gsp_from_name);
		}
		}
		} /* gsp_lms_email_order_student end code  */
	}
}

?>