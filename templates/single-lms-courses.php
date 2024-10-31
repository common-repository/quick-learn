<?php
global $post,$wpdb,$current_user;
include('retrivedata.php');
$user_id=get_current_user_id();

wp_register_style('Tbit_lms_single_lms_course_style',  plugins_url( 'assets/css/single-lms-course-style.css?id='.rand(), dirname(__FILE__) ));
wp_enqueue_style('Tbit_lms_single_lms_course_style');

if(isset($_POST['payer_email'])){

	$payer_email = sanitize_text_field($_POST['payer_email']);

		$enableSandbox = tbit_data_retrivedata('gsp_paypal_enable_test_mode');

		$paypalConfig = [

		'email' => tbit_data_retrivedata('gsp_paypal_receiver_email',$wpdb),

		'return_url' => esc_url(home_url('/')).'thankyou/',

		'notify_url' => esc_url(home_url('/')).'thankyou/'

		];

		$paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
		$itemName = get_the_title($post->ID);
		$course_org_price = get_post_meta($post->ID,'lms-course-price',true);
		$course_sale_price = get_post_meta($post->ID,'gsp_sale_price',true);
		if($course_sale_price !='' && $course_sale_price !=0){
			$itemAmount = $course_sale_price;
		} else {
			$itemAmount = $course_org_price;
		}
if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {
    $data = [];
    $_POST['item_number'] = $post->ID;
    $_POST['custom'] = $user_id;
    $_POST['payer_email'] = tbit_data_retrivedata('gsp_paypal_receiver_email',$wpdb);
	if( !session_id() )

	{
	session_start();
	}
    $_SESSION['user_id'] = $user_id;
    $_SESSION['course_id'] = $post->ID;
    foreach ($_POST as $key => $value) {
        $data[$key] = stripslashes($value);
    }
    // Set the PayPal account.

    $data['business'] = $paypalConfig['email'];
    $data['return'] = stripslashes($paypalConfig['return_url']);
    $data['cancel_return'] = stripslashes($paypalConfig['cancel_url']);
    $data['notify_url'] = stripslashes($paypalConfig['notify_url']);
    // Set the details about the product being purchased, including the amount
    // and currency so that these aren't overridden by the form data.
    $data['item_name'] = $itemName;
    $data['amount'] = $itemAmount;
    $data['currency_code'] = tbit_data_retrivedata('gsp_lms_currency',$wpdb);
    $queryString = http_build_query($data);
    header('location:' . $paypalUrl . '?' . $queryString);
    exit();
}
} else {
	if( !session_id() ){
	session_start();
	}
	unset($_SESSION['user_id']);

	unset($_SESSION['course_id']);
}

if(file_exists(get_stylesheet_directory().'/header.php')){
	get_header();
} else {
wp_head();
wp_register_style('Tbit_lms_single_lms_default_style',  plugins_url( 'assets/css/default_style.css?id='.rand(), dirname(__FILE__) ));
wp_enqueue_style('Tbit_lms_single_lms_default_style');
block_template_part('header');
}
$user_id=get_current_user_id();
?>

<?php

$prepare_sql = $wpdb->prepare('SELECT course_id FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
$wishlistdata = $wpdb->get_results($prepare_sql,ARRAY_A);
$wishlist_array = array();
if(count($wishlistdata)>0){
foreach ($wishlistdata as $key => $value) {
	$wishlist_array[] = $value['course_id'];
}
}
?>
<?php 
$url = get_post_meta($post->ID, 'lms_course_banner_image', true); 
if($url){
?>
<div class="main-single-baner">
	<img class="baner-image" src="<?php echo esc_url($url);?>" id="picsrc" />
</div>
<?php } ?>

<?php
$get_contentblock = get_post_meta($post->ID,'gsp_required_enroll',true);

$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."user_payments WHERE course_id=%s AND user_id=%s AND payment_status=%s",$post->ID,$user_id,'Completed');

$access_result = $wpdb->get_results($prepare_sql,ARRAY_A);


$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."user_payments WHERE course_id=%s AND payment_status=%s",$post->ID,'Completed');
$count_user_enrolled = $wpdb->get_results($prepare_sql,ARRAY_A);
?>

<section id="content-box" class="course_single_lmsbox">

	<div class="container">
	<?php
	$course_duration=get_post_meta($post->ID,'duration',true);
	$course_duration_type=get_post_meta($post->ID,'qsde_type',true);
	?>
	<div class="row">
	
	<div class="col-sm-6 autoimg">
	<?php
	$course_id_f1 = $post->ID;
	$heart_active1 = '';
	if(in_array($course_id_f1, $wishlist_array)){
	$heart_active1 = 'heart_active';
	}
	?>
	<span class="gsp-lms gsp-lms-big"><i class="fa fa-heart <?php echo esc_attr($heart_active1); ?> heart_icon" aria-hidden="true" data-id="<?php echo esc_attr($post->ID);?>" data-user_id="<?php echo esc_attr($user_id);?>"></i></span>
	<?php
	if ( has_post_thumbnail() ){
	?>
	<img src="<?php esc_url(the_post_thumbnail_url('medium')); ?>"  class="contextual" alt="" />
	<?php } else {
		$default_image = plugins_url( 'image/default.png', dirname(__FILE__) );
	?>
		<img src="<?php echo esc_url($default_image); ?>"  class="contextual" alt="" />
	<?php }?>
	</div>
	<div class="col-sm-6">
	<div class="big_img_ratingbox">
	<div class="b_reviewandratingbox">
	<?php 
	$result = Tbit_get_courseratings_count_with_average($post->ID);
    	$average = 0;
    	$raverage = 0;
    	$total = 0;
    	if(count($result)>0 && isset($result['average']) && $result['average'] !=''){
    		$average = round($result['average'],2);
    		$raverage = $average;
    	}
    	if(count($result)>0 && isset($result['total']) && $result['total'] !=''){
    		$total = $result['total'];
    	}
    	$datahtml ='<div class="ac_front_list_rminbox reviewpopupbtn">';
    	$datahtml .='<div class="">'. $raverage .' out of 5 </div>';
    	$datahtml .='<div class="ac_front_list_raingbox">';
    	for ($i=1; $i <=5 ; $i++) {
    		$width = 0;
    		if($average>=1){
    			$width = 100;
    			$average = $average-1;
    		} else if($average<1 && $average>0){
    			$width = $average*100;
    			$average = 0;
    		} else if($average<=0){
    			$width = 0;
    		}

    		$datahtml .='<div class="front_main_starbox">';
    		$datahtml .='<i class="fa fa-star front_under_star"></i>';
    		$datahtml .='<i class="fa fa-star front_over_star" style="width:'.$width.'%"></i>';
    		$datahtml .='</div>';
    	}
    	$datahtml .=' <div class="s_c_totaltext"> ('.esc_html($total).')</div>';
    	$datahtml .='</div>';
    	$datahtml .='</div>';
    	echo html_entity_decode(esc_html($datahtml));

	?>
	</div>
	<?php 
	if(count($access_result)<=0 && $get_contentblock){
	} else {
	?>
	<div class="gsp_lms_course_durationbox text-right">
		<i class="fa fa-clock-o"></i>
		<div class="progress-item course-countdown">
		<span class="progress-number" id="course_time"><?php
		echo esc_html($course_duration.' '.Tbit_lms_dutaion_type($course_duration_type));
		?></span>
		</div>
	</div>
	<?php }?>
	</div>
	<h2><?php esc_html(the_title()); ?></h2>
	<p class="ar">
	<?php while ( have_posts() ) : the_post(); echo esc_html(get_the_content()); endwhile; ?>
	</p>
	<?php
	if(count($access_result)<=0 && $get_contentblock){
	?>
	<div class="pricebox">

	<label>Price</label>

	<?php
	$currency = tbit_data_retrivedata('gsp_lms_currency',$wpdb);

	$text_currency = currency_exchange_text($currency);

	

	$course_org_price = get_post_meta($post->ID,'lms-course-price',true);
	$course_sale_price = get_post_meta($post->ID,'gsp_sale_price',true);
	if($course_sale_price !='' && $course_sale_price !=0){
	?>

	<div class="s_p_box oldprice"><?php echo esc_html($text_currency.' '.$course_org_price); ?></div>
	<div class="s_p_box newprice"><?php echo esc_html($text_currency.' '.$course_sale_price); ?></div>

 <?php } else {?>
 	<div class="s_p_box"><?php echo esc_html($text_currency.' '.$course_org_price); ?></div>
 <?php } ?>

	</div>

	<?php
	$qasx = get_post_meta($post->ID,'qasx',true);
	if(count($count_user_enrolled) < (int)$qasx ){
	if(tbit_data_retrivedata('gsp_paypal_enable',$wpdb)=='enable'){ 
		$gsp_paypal_receiver_email = tbit_data_retrivedata( 'gsp_paypal_receiver_email',$wpdb );
	?>

	<form class="paypal" method="post" id="paypal_form">
	<input type="hidden" name="cmd" value="_xclick" />
	<input type="hidden" name="no_note" value="1" />
	<input type="hidden" name="lc" value="UK" />
	<input type="hidden" name="bn" value="PP-BuyNowBF:btn_buynow_LG.gif:NonHostedGuest" />
	<input type="hidden" name="first_name" value="Customer's First Name" />
	<input type="hidden" name="last_name" value="Customer's Last Name" />
	<input type="hidden" name="payer_email" value="<?php echo esc_attr($gsp_paypal_receiver_email); ?>" />
	<input type="hidden" name="item_number" value="123456" / >
	<div class="buynowbtnbox">
	<input type="submit" name="submit" id="paypalbtn" class="btn btn-primary" value="Buy Now" >
	</div>
	</form>

	<?php }
	



	wp_register_style('Tbit_lms_bootstrap', plugins_url( 'assets/css/bootstrap/bootstrap.min.css', __FILE__ ));
	wp_enqueue_style('Tbit_lms_bootstrap');

	wp_register_style('Tbit_lms_checkout', plugins_url( 'assets/css/checkout.css?id='.rand(), dirname(__FILE__) ));
	wp_enqueue_style('Tbit_lms_checkout');

	

	$handle = 'bootstrap';
	$list = 'enqueued';
	if (wp_script_is( $handle, $list )) {

	} else {
	wp_register_script('Tbit_lms_bootstrap', plugins_url( 'assets/js/bootstrap.min.js', dirname(__FILE__) ),'','',false);
	wp_enqueue_script('Tbit_lms_bootstrap');
	}

	if(function_exists('Tbit_quick_stripe_implement_frontend_check')){
		$return_stripe_data = Tbit_quick_stripe_implement_frontend_check();
		echo html_entity_decode(esc_html($return_stripe_data));
	}
	?>

	<?php
	$gsp_stripe_enable = '';
	if(function_exists('Tbit_quick_stripe_check_attribute')){
		$gsp_stripe_enable = Tbit_quick_stripe_check_attribute('gsp_stripe_enable');
	}

	if($gsp_stripe_enable == 'enable' || tbit_data_retrivedata('gsp_paypal_enable',$wpdb)=='enable'){
	?>
	<div class="payment_optionbox">
		<?php 
		if(tbit_data_retrivedata('gsp_paypal_enable',$wpdb)=='enable'){
		?>
		<div class="po_itembox">
			<label><input type="radio" class="payment_method_type" name="payment_method_type" value="paypal" checked="">Paypal</label>
		</div>
		<?php }
		if($gsp_stripe_enable == 'enable'){
	

		if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
				$return_field = Tbit_quick_learn_return_pro_verison_input_field('payment_method_stripe_type');
				echo html_entity_decode(esc_html($return_field));
			}
		}?>
	</div>
	<div class="addtocartbtnbox">
		<button type="button" id="addtocartbtnbox-button" class="btn btn-primary addtocartbtn">Add To cart</button>
	</div>
	<?php } else {?>
	<div class="addtocartbtnbox">
		sorry you are not allowed to buy this course. please try again. if you site owner please enable payment gateway. 
	</div>
	<?php }?>
<?php } else {?>
	<p class="para">You can not enroll this course.The Student Enrolled Limit has been reached.</p>
<?php } ?>
	<?php } ?>
	</div>
	</div>
	</div>
</section>
<section class="tab_section_box">
	<?php 
	if($get_contentblock && count($access_result)<=0){?>
		<div class="container text-center">
			Sorry, Course content will be visiable after buy the course.
		</div>
	<?php } else {

	$item_ids=array();
	
	$prepare_sql_main = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s",1,$post->ID);

	$prepare_sql = $wpdb->prepare("SELECT videoid FROM ".$wpdb->prefix."completed_lesson WHERE userid=%s AND course_id=%s",$user_id,$post->ID);
	$get_user_complete = $wpdb->get_results($prepare_sql,ARRAY_A);
	$get_user_complete1 = $get_user_complete;

	$get_user_complete = [];
	if(count($get_user_complete1)>0){
	foreach ($get_user_complete1 as $key => $value) {
	$get_user_complete[] = $value['videoid'];
	} 
	}

	$get_results=$wpdb->get_results($prepare_sql_main,ARRAY_A);
	if(count($get_results)>0){
	foreach ($get_results as $key => $value) {
	$item_ids[]=$value['item_id'];
	}
	}

	
	$lession_allcomplete = 'disabled';
	if(count($get_user_complete) >= count($item_ids)){
		$lession_allcomplete = '';
	}



	?>

	<div class="container">
	<ul class="tab_buttonbox">
	
	<li class="tb_tab tb_tab_lessons active_tab" data-tab="lessons_tab">Lessons</li>
	<li class="tb_tab tb_tab_assesments <?php echo esc_attr($lession_allcomplete); ?>" data-tab="assesments_tab">Assesments</li>
	</ul>
	
	
	<div class="lessons_tab tab_contents active_tab_content">
	<div class="row tab-bar">
	<?php
	if(count($item_ids)>0){
	?>
	<div class="col-sm-12">
	<div class="tab" id="lessonsec">
	<?php
	if(count($item_ids)>0){
	$i=0;
	$co = 1;
	$nextactive=0;
	$disabled ='';
	$icount = count($item_ids);
	$ccount = 0;
	foreach ($item_ids as $key => $value) {
		if(in_array($value, $get_user_complete)){
			$ccount = $ccount+1;
		}
	}
	foreach ($item_ids as $key => $value) {
	$disabled ='';
	$active='';
	$title=get_the_title($value);
	if($i==0){
	$disabled = '';
	$active='active';
	if(in_array($value, $get_user_complete)){
	$nextactive=1;
	$active='';
	}
	} else if(in_array($value, $get_user_complete)){
	$nextactive=1;
	$disabled = '';
	$active='';
	} else if($nextactive==1) {
	$disabled = '';
	$nextactive = 0;
	$active='active';
	} else {
	$nextactive = 0;
	$disabled = 'disabled';
	$active='';
	}
	if($ccount == $icount && $i==0){
		$active='active';
	}
	?>
	<button class="tablinks <?php echo esc_attr($active);?> <?php echo esc_attr($disabled);?>" data-id="<?php echo esc_attr('tab_'.$value);?>" onclick="openCity(event, '<?php echo esc_attr('tab_'.$value);?>')">
	<?php echo esc_html($co.'. '.$title);?> 
	<?php if(in_array($value, $get_user_complete)){?>
	<i class="fa fa-check lession_completed"></i>
	<?php }?>
	</button>
	<?php $co++; ?>
	<?php $i++; }
	}
	?>
	</div>
	<?php
	if(count($item_ids)>0){
	$j=0;
	$prev='';
	$next='';
	$i=0;
	$nextactive=0;
	$disabled ='';
	foreach($item_ids as $key => $value) {
	$next='';
	$next_id_g = $key+1;
	if(isset($item_ids[$next_id_g]) && $item_ids[$next_id_g] !=''){
		$next= $item_ids[$next_id_g];
	}
	$active='';
	$title=get_the_title($value);
	if($i==0){
	$style='style="display: block;"';
	if(in_array($value, $get_user_complete)){
	$nextactive=1;
	$style='style="display: none;"';
	}

	} else if(in_array($value, $get_user_complete)){

	$nextactive=1;
	$style='style="display: none;"';

	} else if($nextactive==1) {

	$nextactive = 0;
	$style='style="display: block;"';

	} else {

	$nextactive = 0;
	$style='style="display: none;"';

	}

	if($ccount == $icount && $i==0){
		$style='style="display: block;"';
	}


	?>

	<div id="<?php echo esc_attr('tab_'.$value);?>" class="tabcontent" <?php echo html_entity_decode(esc_html($style));?> >

	<?php 

	$getdata=get_post_meta($value,'youtube_url',true);

	?>

	<?php

	if($getdata !=''){

	preg_match_all("#(?<=v=|v\/|vi=|vi\/|youtu.be\/|embed\/)[a-zA-Z0-9_-]{11}#", 

	$getdata, $matches); 

	if(count($matches)>0){

	$getdata=$matches[0][0];

	}

	?>

	<div class="s_y_box">

	<iframe src="https://www.youtube.com/embed/<?php echo esc_attr($getdata);?>?modestbranding=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen="" width="1920" height="1080"></iframe>
	</div>
	<?php }?>
	<h3><?php echo esc_html(get_the_title($value))?></h3>
	<p><?php 
	echo esc_html(get_post_field('post_content', $value));?></p>

	<?php if(in_array($value, $get_user_complete)){?>

	<div class="" data-id="" ><button id="complete-button" class="btn disabled" data-id="<?php echo esc_attr($value);?>">Completed</button></div>

	<div class="navigationbox">

		<?php if($j!=0){?>

			<div class="prevbtn">Prev</div>

		<?php }?>

		<div class="nxtbtn" data-id="">Next</div>

	</div>

	<?php } else {?>

	<div class="completedbtn" data-id=""><button class="btn btn-success btn-complete" data-course_id="<?php echo esc_attr($post->ID);?>" data-id="<?php echo esc_attr($value);?>">Complete</button></div>

	<?php }?>

	</div>
	<?php
	 $i++; 
	?>
	<?php $j++; } 

	} ?>	

	</div>
	<?php
	} else {?>
		<div class="text-center">No Lesson</div>
	<?php }
	?>
	</div><!-- End row tab-bar -->

	</div>

	<div class="assesments_tab tab_contents">

		<?php

	global $wpdb;

	$item_ids=array();

	$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s order by item_id DESC",2,$post->ID);

	$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

	$quiz_ids = array();

	if(count($get_results)>0){?>

		<div class="quiestion_leftbox">

		<?php

		$oo =1;

		$quiz_id = 0;

		$next_row_active = '';
		
		$all_get_results = array();
		foreach ($get_results as $key => $value) {
			$quiz_id = $value['item_id'];
			$question_count_of_assesment = getquizquestionscount($quiz_id);
			if($question_count_of_assesment == 0){
				continue;
			}

			$all_get_results[] = $value;
		}
		$current_assesment_id = 0;
		foreach ($all_get_results as $key => $value) {

			$quiz_id = $value['item_id'];

			$quiz_ids[] = $value['item_id'];

			$title = get_the_title($quiz_id);

			$getquizstatus = getquizstatus($quiz_id,$user_id,$post->ID);

			$activequ = '';

			$html = '';
			$activequ111 = '';
			if($getquizstatus==1){
				$activequ = 'active1';
				$next_row_active = 'yes';
				$html = '<i class="fa fa-check lession_completed"></i>';
				$current_assesment_id = $quiz_id;
			} else if( $getquizstatus==2 ) {
				$current_assesment_id = $quiz_id;
				$activequ = 'active active1';
				$next_row_active = 'no';
			} else if($getquizstatus==0){
				if($next_row_active=='yes'){
					$current_assesment_id = $quiz_id;
					$activequ111 = 'active active1';
					$next_row_active = 'no';
				} else if($next_row_active == ''){
					$next_row_active = 'no';
					$activequ = 'active active1';
					$current_assesment_id = $quiz_id;
				}
			} else {
				if($oo == 1){
					$activequ = 'active active1';
					$current_assesment_id = $quiz_id;
				}
			}

			echo '<div class="title_heading quiz_id_click '.esc_attr($activequ).' '.esc_attr($activequ111).'" data-item_id="'.esc_attr($quiz_id).'" data-course_id="'.esc_attr($post->ID).'">'.esc_html($oo).'. '.esc_html($title).' '.$html.'</div>';

			$oo++;

		} ?>

		</div>

		<div class="quiestion_rightbox">

			<?php

				$item_id = $current_assesment_id;

				$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsp_user_items WHERE user_id=%s AND item_id=%s AND ref_type=%s AND ref_id=%s",$user_id,$item_id,'lms-assesments',$post->ID);

				$user_data=$wpdb->get_results($prepare_sql,ARRAY_A);

					$lms_assement_duration=get_post_meta($item_id,'lms_assement_duration',true);

					$lms_assement_duration_type=get_post_meta($item_id,'lms_assement_duration_type',true);

					$lms_assement_retake=get_post_meta($item_id,'lms_assement_retake',true);

					$lms_assement_passing_grade=get_post_meta($item_id,'lms_assement_passing_grade',true);

				    
				    $prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$item_id);

					$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

					

					$question_ids=array();

					if(count($get_results)>0){

					foreach ($get_results as $key => $value111) {

					$question_ids[]=$value111['question_id'];

					}

					}                                                              

					$question_ids=implode(',', $question_ids);	



					
					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_status=%s AND ID IN($question_ids)",'publish');
					$qget_results=$wpdb->get_results($prepare_sql,ARRAY_A);

				if(count($user_data)<=0){?>

					<ul class="quiz-intro">

					<li>

					<span class="mpqi_vlable">Attempts allowed &nbsp;&nbsp;</span>

					<span class="mpqi_alable">

					<?php

					if($lms_assement_retake==0){

					echo 'No';

					} else {

					echo esc_html($lms_assement_retake);

					}

					?>

					</span>

					</li>

					<li>

					<span class="mpqi_vlable">Duration</span>

					<span class="mpqi_alable"><?php 

					

					if($lms_assement_duration==''){

						$lms_assement_duration = '00:00:00';

					}

					echo esc_html(getDuration($lms_assement_duration,$lms_assement_duration_type));



					?></span>

					</li>

					<li>

					<span class="mpqi_vlable">Passing grade</span>

					<span class="mpqi_alable"><?php echo esc_html($lms_assement_passing_grade);?>%</span>

					</li>

					<li>

					<span class="mpqi_vlable">Questions</span>

					<span class="mpqi_alable"><?php echo esc_html(count($qget_results));?></span>

					</li>

					</ul>

					<form method="post" action="">

					<input type="hidden" name="start_assesment" value="yes">

					<input type="hidden" name="item_id" value="<?php echo esc_attr($item_id);?>">

					<input type="hidden" name="ref_id" value="<?php echo esc_attr($post->ID);?>">

					<input type="hidden" name="ref_type" value="lms-assesments">

					<input type="hidden" name="status" value="started">

					<div class="mp_startbtn">

						<button 

						type="button" 

						class="button btn btn-success quiz_start_btn"

						data-ref_type="lms-assesments"

						data-ref_id="<?php echo esc_attr($post->ID);?>"

						data-item_id="<?php echo esc_attr($item_id);?>"

						data-status="started"

						 >

							Start

						</button>

					</div>

				<?php } else if(isset($user_data[0]['status']) && ($user_data[0]['status'] == 'completed' || $user_data[0]['status'] == 'succeeded') ){
				$course_id = $user_data[0]['ref_id'];
				$main_item_id = $user_data[0]['item_id'];
				$user_item_id = $user_data[0]['user_item_id'];

				$get_course_next_prev = tbit_lms_checknext_prev($course_id,$main_item_id);

				$user_start_time = $user_data[0]['start_time'];
				$user_end_time = $user_data[0]['end_time'];

				$dateTimeObject1 = date_create($user_end_time); 
				$dateTimeObject2 = date_create($user_start_time); 
				$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
				$hours = $difference->days * 24;
				$hours += $difference->h;
				$minutes = $difference->i;
				$seconds = $difference->s;
				$user_used_time = sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);


				$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_retakemeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'retaken_count');

				$r_result = $wpdb->get_results($prepare_sql,ARRAY_A);
				if(count($r_result)>0 && isset($r_result[0]['meta_value']) && $r_result[0]['meta_value'] !=''){
				$retake_count = $r_result[0]['meta_value'];
					$ac_r_count = (int)$lms_assement_retake - (int)$retake_count;
				} else {
					$ac_r_count = $lms_assement_retake;
				}
				$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_itemmeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'results');

				$user_data_result=$wpdb->get_results($prepare_sql,ARRAY_A);

				$unserialize = unserialize($user_data_result[0]['meta_value']);

				$datahtml .= '<div id="content-item-quiz" class="content-item-summary">';

				$datahtml .= '<h3 class="course-item-title quiz-title">'.esc_html(get_the_title($main_item_id)).'</h3>';

				$datahtml .= '<div class="quiz-result passed">';

				$datahtml .= '<h3>Your Result</h3>';

				$datahtml .= '<div class="result-grade"><span class="result-achieved" style="font-size: 30px;color: #007bff;">'.esc_html($unserialize['result']).'%</span><p class="result-message">Your grade is <strong>'.esc_html($unserialize['grade_text']).'</strong> </p></div>';

				$datahtml .= ' <ul class="result-statistic">';

				$datahtml .= '<li class="result-statistic-field"><strong>Time spend</strong><p>'.esc_html($user_used_time).'</p></li>';

				$datahtml .= '<li class="result-statistic-field"><strong>Questions</strong><p>'.esc_html($unserialize['question_count']).'</p></li>';

				$datahtml .= '<li class="result-statistic-field"><strong>Correct</strong><p>'.esc_html($unserialize['question_correct']).'</p></li>';

				$datahtml .= '<li class="result-statistic-field"><strong>Wrong</strong><p>'.esc_html($unserialize['question_wrong']).'</p></li>';

				$datahtml .= '</ul>';

				if($ac_r_count != '' && $ac_r_count != 0){
				$datahtml .= '<div class="retake_button"><button class="btn btn_retake" data-id="'.esc_attr($main_item_id).'" data-course_id="'.esc_attr($course_id).'" > Retake('.esc_html($ac_r_count).')</button></div>';
				}

				$datahtml .= '<div class="navigationbox_quiz dd">';
				if($get_course_next_prev['prev'] == 'yes'){
					$datahtml .= '<div class="prev_quiz" data-id="'.esc_attr($main_item_id).'">Prev</div>';
				}
				if($get_course_next_prev['next'] == 'yes'){
					$datahtml .= '<div class="nxt_quiz" data-id="'.esc_attr($main_item_id).'">Next</div>';
				}
				$datahtml .= '</div>';



				$datahtml .= '</div>';

				$datahtml .= '</div>';

				echo html_entity_decode(esc_html($datahtml));


				?>


				<?php } else if(isset($user_data[0]['status']) && $user_data[0]['status'] == 'started' ){
				
				$user_id=get_current_user_id();
				$item_id = $user_data[0]["item_id"];
				$course_id = $post->ID;

				require(dirname(__FILE__).'/single_lms_startquiz.php');
				}?>


		</div>

		<?php } else {

			echo '<div class="text-center width100">No Asseement</div>';

		} ?>

	</div>
	</div>
	<?php } ?>

</section>



</div>

</div>

</div>

</section>

<?php

function getquizquestionscount($quiz_id){
global $wpdb;
$sql_prepare = $wpdb->prepare("SELECT COUNT(quiz_assesment_id) as totalquestion FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",array($quiz_id));
$u_result= $wpdb->get_results($sql_prepare,ARRAY_A);
$totalquestions = 0;
if(count($u_result)>0 && isset($u_result[0]['totalquestion']) && !empty($u_result[0]['totalquestion'])){
	 $totalquestions = $u_result[0]['totalquestion'];
}
return $totalquestions;


}

function getquizstatus($quiz_id,$user_id,$course_id){

global $wpdb;

$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsp_user_items WHERE user_id=%s AND item_id=%s AND ref_type=%s AND ref_id=%s ",$user_id,$quiz_id,'lms-assesments',$course_id);
$user_data11=$wpdb->get_results($prepare_sql,ARRAY_A);

if(isset($user_data11[0]['status']) && $user_data11[0]['status'] == 'completed'){

	return 1;

} else if(isset($user_data11[0]['status']) && $user_data11[0]['status'] == 'started') {

	return 2;

} else {

	return 0;

}





}

function getDuration($lms_assement_duration,$lms_assement_duration_type){

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

?>

<?php
$args = array(

"post_type" => "lms-courses",

"post_status" => "publish",

"posts_per_page" => "3",

"orderby" => "date",

"order" => "ASC",

'paged' => 1,

'post__not_in'   => array( get_queried_object_id() ),
);

$query = new WP_Query($args);
if ($query->have_posts()){
?>
<section class="comn-sec grey-bg latest_course_single_lms">
<div class="container">
<div class="row">
<div class="main-heading">
<h4>Latest Courses</h4>
</div>
</div>
<div class="row lat-cours">
<?php
while ($query->have_posts()) : 
$query->the_post();
?>
<?php
$course_id_f = get_the_ID();
$heart_active = '';

if(in_array($course_id_f, $wishlist_array)){
$heart_active = 'heart_active';
}
?>
<div class="col-sm-4">
<a href="<?php esc_url(the_permalink()); ?>" class="s_p_l_a_t_item">
<span class="gsp-lms top_fav_icon"><i class="fa fa-heart <?php echo esc_attr($heart_active); ?> heart_icon" aria-hidden="true" data-id="<?php echo esc_attr(get_the_ID());?>" data-user_id="<?php echo esc_attr($user_id);?>"></i></span>
<?php
if ( has_post_thumbnail() ){
$thumbnail_url = wp_get_attachment_image_src(get_post_thumbnail_id(get_the_ID()), 'thumbnail', true );
?>
<img src="<?php echo esc_url($thumbnail_url[0]);?>">
<?php } else {
$default_image = plugins_url( 'image/default.png', dirname(__FILE__) );
?>
	<img src="<?php echo esc_url($default_image);?>">
<?php }?>
</a>

<h3>

<a href="<?php esc_url(the_permalink()); ?>">

<?php esc_html(the_title()); ?>

</a>

</h3>

<p><?php echo html_entity_decode(esc_html(wp_trim_words(get_the_excerpt(), 20))); ?></p>
<div class="all_coursesbox">
<a href="<?php esc_url(the_permalink()); ?>" class="creat-btn">Start Now</a>
<?php
$result = Tbit_get_courseratings_count_with_average($course_id_f);
$average = 0;
$raverage = 0;
$total = 0;
if(count($result)>0 && isset($result['average']) && $result['average'] !=''){
$average = round($result['average'],2);
$raverage = $average;
}
if(count($result)>0 && isset($result['total']) && $result['total'] !=''){
$total = $result['total'];
}
$datahtml ='<div class="ac_front_list_rminbox">';
$datahtml .='<div class="">'. $raverage .' out of 5 </div>';
$datahtml .='<div class="ac_front_list_raingbox">';
for ($i=1; $i <=5 ; $i++) {
$width = 0;
if($average>=1){
$width = 100;
$average = $average-1;
} else if($average<1 && $average>0){
$width = $average*100;
$average = 0;
} else if($average<=0){
$width = 0;
}

$datahtml .='<div class="front_main_starbox">';
$datahtml .='<i class="fa fa-star front_under_star"></i>';
$datahtml .='<i class="fa fa-star front_over_star" style="width:'.$width.'%"></i>';
$datahtml .='</div>';
}
$datahtml .=' <div class="s_c_totaltext"> ('.esc_html($total).')</div>';
$datahtml .='</div>';
$datahtml .='</div>';
echo html_entity_decode(esc_html($datahtml));
?>
</div>
</div>

<?php endwhile; ?>
</div>
</div>
</section>
<?php
}
function getDurationforcourse($lms_assement_duration,$lms_assement_duration_type){

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
?>
<?php

wp_reset_query();

?>
<div class="reviewratingpopupbox rr_fade">
  <div class="rr_modal_dialog">
    <div class="rr_modal_content">
      <div class="rr_modal_header">
      	<h3 class="nomargin float_left">Student Reviews</h3>
        <button type="button" class="rr_close" data-dismiss="modal">&times;</button>
        <div class="clear"></div>
      </div>
      <div class="rr_modal_body">
		<ul class="allreviewss_lmsbox">
		<?php
		$get_results = Tbit_get_courseratings($post->ID);
		if(count($get_results)>0){
			foreach ($get_results as $rk => $rv) {
				$main_rating = $rv['rating'];
				$rating_user = get_user_by('id',$rv['user_id']);
				$user_image = esc_url( plugin_dir_url( __FILE__ )."../image/default_avater.png");
				$get_attachment_id = get_user_meta($rating_user->ID,'wp_user_avatar',true);
				if($get_attachment_id !=''){
					$user_image = wp_get_attachment_url($get_attachment_id);
				}

				?>
				<li class="a_r_m_box">
					<div class="rr_customer_name">
						<div class="c_imgbox">
							<img src="<?php echo esc_url($user_image);?>" />
						</div>
						<div class="c_n_box">
							<?php
								
								echo esc_html($rating_user->display_name);
							?>
						</div>
					</div>
					<div class="ratingbox1">
					<?php
					for ($ali=1; $ali <=5 ; $ali++) { 
					$active_a = '';
					if($main_rating>=$ali){
					$active_a = 'active';
					}
					?>
					<i class="fastaricon1 fa fa-star <?php echo esc_attr($active_a); ?>" data-id="<?php echo esc_attr($ali); ?>"></i>
					<?php }
					?>
					</div>
					<div>
						<p><?php echo esc_html($rv['comment']);?></p>
					</div>
				</li>
			<?php }
		} else {
			echo '<li>No reviews yet</li>';
		}
		?>
		</ul>


	<?php
	if(count($access_result)<=0 && $get_contentblock){
	} else {
	$result = Tbit_get_courseratings($post->ID,$user_id);
	$rating = 0;
	$comment = '';
	if(count($result)>0 && isset($result[0]['rating']) && $result[0]['rating'] !=''){
	$rating = $result[0]['rating'];
	}
	if(count($result)>0 && isset($result[0]['comment']) && $result[0]['comment'] !=''){
	$comment = $result[0]['comment'];
	}
	$rating_user = get_user_by('id',$user_id);
	$user_image = esc_url( plugin_dir_url( __FILE__ )."../image/default_avater.png");
	$get_attachment_id = get_user_meta($rating_user->ID,'wp_user_avatar',true);
	if($get_attachment_id !=''){
	$user_image = wp_get_attachment_url($get_attachment_id);
	}
	?>
	<div class="star_ratingbox">
	
	<div class="rating_commentbox">
		
		<div class="rating_commentboxtextarea" data-id="<?php echo esc_attr($post->ID);?>">
		<br />
		<h3>Review this course</h3>
		<div class="s_c_b_userbox">
			<div class="sc_imgbox">
				<img src="<?php echo esc_url($user_image);?>" class="sc_img">
			</div>
			<span><?php echo esc_html($rating_user->display_name);?></span>
		</div>
		<div class="ratingbox">
		<input type="hidden" name="rating" value="<?php echo esc_attr($rating); ?>">
		<?php
		for ($ooo=1; $ooo <=5 ; $ooo++) { 
		$activeqqq = 'fa-star-o';
		if($rating>=$ooo){
			$activeqqq = 'fa-star active';
		}
		?>
			<i class="fastaricon fa <?php echo esc_attr($activeqqq); ?>" data-id="<?php echo esc_attr($ooo); ?>"></i>
		<?php }
		?>
	</div>
			<textarea cols="40" rows="3" placeholder="Enter comments" id="rating_commentboxtextarea"><?php echo esc_html($comment);?></textarea>
		</div>
		
		<div class="rr_submitbtnbox">
			<button type="button" class="creat-btn noborder commentsendbtn">Submit</button>
		</div>
	</div>
	</div>
	<?php }?>
	
      </div>
    </div>

  </div>
</div>
<div class="rr_modal_backdrop rr_fade"></div>
<?php 
if(file_exists(get_stylesheet_directory().'/footer.php')){
	get_footer();
} else {
wp_footer();
block_template_part('footer');
}
?>