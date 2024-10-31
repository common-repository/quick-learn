<?php
if(file_exists(get_stylesheet_directory().'/header.php')){
	get_header();
} else {
wp_head();
wp_register_style('Tbit_lms_single_lms_default_style',  plugins_url( 'assets/css/default_style.css?id='.rand(), dirname(__FILE__) ));
wp_enqueue_style('Tbit_lms_single_lms_default_style');
block_template_part('header');
}

$course_link = home_url();
if(isset($_SESSION['course_id']) && !empty($_SESSION['course_id'])){
	$course_id = sanitize_text_field($_SESSION['course_id']);
	$course_link = get_the_permalink($course_id);
} else if(isset($_GET['course_id']) && !empty($_GET['course_id'])){
	$course_id = sanitize_text_field($_GET['course_id']);
	$course_link = get_the_permalink($course_id);
}

?>
<div class="thankyou_sec">
	<img src="<?php echo esc_url(TBIT_LMS_IMAGE_URL)?>/tick-mark.png" alt="Thank You">
	<div class="headingWrap">
	<h2 class="subtitle">Thank you!</h2>

	<p class="para center">
	We have received your contact information successfully. Our business head will get in touch with you shortly.
	</p>
	</div>
	<a href="<?php echo esc_url($course_link);?>" class="getintouch-btn ">Explore Course <i class="fa fa-long-arrow-right" style="margin-left: 8px;"></i></a>
</div>

<?php 
if(file_exists(get_stylesheet_directory().'/footer.php')){
	get_footer();
} else {
wp_footer();
block_template_part('footer');
}
?>