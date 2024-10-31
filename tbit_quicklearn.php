<?php
/**
* Plugin Name: Quick Learn
* Plugin URI: 
* Description: 
* Version: 1.0
* Author: gsp
* Author URI: 
*/
/**
* Register a custom menu page.
*/
defined( 'ABSPATH' ) || exit;
define( 'Tbit_ROOT' , dirname(__FILE__) );
define( 'Tbit_PLUGIN_URL' , plugins_url() );
define( 'Tbit_PLUGIN_PRO_URL' , 'https://wp-audio-editor.com/' );
define('TBIT_LMS_DIR', dirname(__FILE__));
define('TBIT_LMS_IMAGE_URL', plugin_dir_url(__FILE__).'/image');

@ini_set( 'upload_max_size' , '64M' );
@ini_set( 'post_max_size', '64M');
@ini_set( 'max_execution_time', '300' );
require('inc/gsp-functions.php');
require('inc/function_config.php');
require('inc/global.php');
require('inc/ajax.php');

require('html2pdf/vendor/autoload.php');
use Spipu\Html2Pdf\Html2Pdf;
use Spipu\Html2Pdf\Exception\Html2PdfException;
use Spipu\Html2Pdf\Exception\ExceptionFormatter;

if(!session_id()){
   session_start();
}




if( !function_exists('Tbit_lms_activation_function')){
	function Tbit_lms_activation_function() {
	global $wpdb;
	$wpdb->hide_errors();
	$collate = '';
	 if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$queries = array();
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}user_payments (
		`order_id` bigint(20)  AUTO_INCREMENT,
		`transaction_id` varchar(250) NULL,
		`amount` varchar(250) NULL,
		`transaction_type` varchar(250) NULL,
		`subscribed_date` datetime NULL,
		`user_id` bigint(20) NULL,
		`payment_status` varchar(25) NULL,
		`payer_id` varchar(25) NULL,
		`course_id` varchar(45) NULL,
		`admin_commission` varchar(20) NULL,PRIMARY KEY  (`order_id`)
		) {$collate}");


		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsplms_rating (
		`rating_id` int(11) AUTO_INCREMENT,
		`user_id` int(11) NULL,
		`post_id` int(11) NULL,
		`rating` varchar(25) NULL,
		`comment` longtext NULL,
		`status` int(11) DEFAULT 1,
		`created_on` datetime NULL,PRIMARY KEY  (`rating_id`)
		) {$collate}");

		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_instructor_payment (
		`payment_id` bigint(20)  AUTO_INCREMENT,
		`amount` varchar(250) NULL,
		`transaction_id` varchar(250) NULL,
		`payment_method` varchar(250) NULL,
		`instructor_id` int(11) NULL,
		`payment_date` timestamp,
		`from_user_id` bigint(20) NULL,PRIMARY KEY  (`payment_id`)
		) {$collate}");

		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_lms_wishlist (
		`wishlist_id` int(11) NOT NULL AUTO_INCREMENT,
		`course_id` int(11) NOT NULL,
		`user_id` int(11) NOT NULL,PRIMARY KEY  (`wishlist_id`)
		) {$collate}");

		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsplms_section_items (
		`section_item_id` int(11) NOT NULL AUTO_INCREMENT,
		`section_id` int(11) NOT NULL,
		`course_id` int(11) NULL,
		`item_id` int(11) NULL,
		`item_order` int(11) NULL,
		`item_type` varchar(250) NULL, PRIMARY KEY  (`section_item_id`)
		) {$collate}");
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsplms_quiz_questions (
		`quiz_assesment_id` int(11) NOT NULL AUTO_INCREMENT,
		`quiz_id` int(11) NOT NULL,
		`question_id` int(11) NULL,PRIMARY KEY  (`quiz_assesment_id`)
		) {$collate}");
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsplms_question_answers (

		`question_answer_id` bigint(20) NOT NULL AUTO_INCREMENT,

		`question_id` bigint(20) NOT NULL,

		`answer_data` text NULL,PRIMARY KEY  (`question_answer_id`)

		) {$collate}");

		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsplms_setting (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`course_id` int(11) NULL,

		`meta_key` text NULL,

		`meta_value` text NULL,PRIMARY KEY  (`id`)

		) {$collate}");
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_lms_setting_meta (

		`gsp_setting_id` int(11) NOT NULL AUTO_INCREMENT,

		`meta_key` varchar(255) NULL,

		`meta_value` text NULL,PRIMARY KEY  (`gsp_setting_id`)

		) {$collate}");
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}completed_lesson (

		`id` int(11) NOT NULL AUTO_INCREMENT,

		`userid` int(11) NULL,

		`postid` int(11) NULL,

		`videoid` int(11) NULL,

		`course_id` int(11) NULL,PRIMARY KEY  (`id`)

		) {$collate}");
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}completed_course (

		`id` int(11) NOT NULL AUTO_INCREMENT,

		`courseid` varchar(250) NULL,

		`userid` varchar(250) NULL,PRIMARY KEY  (`id`)

		) {$collate}");



		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_user_itemmeta (

		`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,

		`gsp_user_item_id` bigint(20) NULL,

		`meta_key` varchar(250) NULL,

		`meta_value` text NULL,PRIMARY KEY  (`meta_id`)

		) {$collate}");


		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_user_retakemeta (

		`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,

		`gsp_user_item_id` bigint(20) NULL,

		`meta_key` varchar(250) NULL,

		`meta_value` text NULL,

		`extra_value` longtext NULL,PRIMARY KEY  (`meta_id`)

		) {$collate}");

		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_user_items (

		`user_item_id` bigint(20) NOT NULL AUTO_INCREMENT,

		`user_id` bigint(20) NULL,

		`item_id` bigint(20) NULL,

		`start_time` datetime NULL,

		`end_time` datetime NULL,

		`status` varchar(45) NULL,

		`ref_id` bigint(20) NULL,

		`ref_type` varchar(45) NULL,

		`parent_id` bigint(20) NULL,PRIMARY KEY  (`user_item_id`)

		) {$collate}");



		foreach ($queries as $key => $sql) {

		dbDelta( $sql );

		}

	 }


	 if(get_page_by_title('Qucik Learn My Account') == NULL){

	  $my_post = array(
      'post_title'    => wp_strip_all_tags( 'Quick Learn My Account' ),
      'post_content'  => '[my-account]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );


    // Insert the post into the database
    wp_insert_post( $my_post );
	}
	if(get_page_by_title('Student Register') == NUll){
    $my_post = array(
      'post_title'    => wp_strip_all_tags( 'Student Register' ),
      'post_content'  => '[register-user-as-student]',
      'post_status'   => 'publish',
      'post_author'   => 1,
      'post_type'     => 'page',
    );
    wp_insert_post( $my_post );
	}
	

	$array = array(
		'meta_key'=>'gsp_certificate_website_name',
		'meta_value' => 'Quick Learn',
	);
	$wpdb->insert($wpdb->prefix.'gsp_lms_setting_meta',$array);

	$c_datahtml = 'has earned <br />';
	$c_datahtml .= '<b>{{assesmentname}}</b> <br />';
	$c_datahtml .= 'while completing the training course entitled<br />';
	$c_datahtml .= '<b>{{cousename}}</b> <br />';
	$array = array(
		'meta_key'=>'gsp_certificate_conetnt',
		'meta_value' => $c_datahtml,
	);
	$wpdb->insert($wpdb->prefix.'gsp_lms_setting_meta',$array);
}
}
register_activation_hook( __FILE__, 'Tbit_lms_activation_function');

add_action('init', 'Tbit_lms_custom_author_urlbase');
if( !function_exists('Tbit_lms_custom_author_urlbase')){

   function Tbit_lms_custom_author_urlbase() {
      global $wp_rewrite;

			if(isset($_GET['ceriticate_download']) && $_GET['ceriticate_download'] == 'yes' && isset($_GET['user_item_id']) && !empty($_GET['user_item_id'])){
				$user_item_id = sanitize_text_field($_GET['user_item_id']);

				try {
				$html2pdf = new Html2Pdf('P', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
				$html2pdf->pdf->SetDisplayMode('fullpage');
				ob_start();
				require ('inc/gsp-downloadpdf.php');
				$content = ob_get_clean();

				$html2pdf->writeHTML($content);
				$html2pdf->output('certificate.pdf', 'D');
				} catch (Html2PdfException $e) {
				$html2pdf->clean();
				$formatter = new ExceptionFormatter($e);
				echo html_entity_decode(esc_html($formatter->getHtmlMessage()));
				}
			} 


      $author_slug = 'instructor';
      $wp_rewrite->author_base = $author_slug;
   }
}

if( !function_exists('Tbit_lms_load_admin_scripts')){
function Tbit_lms_load_admin_scripts(){ 
    wp_register_script('sunset-admin-script',plugin_dir_url( __FILE__ ) .'/assets/js/uploadimagae.js?id='.rand(), array('jquery'), rand(), true);
    wp_enqueue_script('sunset-admin-script'); 

}
}

add_action( 'admin_enqueue_scripts', 'Tbit_lms_load_admin_scripts' );

if( !function_exists('Tbit_lms_adding_scripts')){
function Tbit_lms_adding_scripts() {

    wp_register_script('my_amazing_script', plugin_dir_url( __FILE__ ) . '/assets/js/checkedvision.js', array('jquery'),'1.1', true);

    wp_enqueue_script('my_amazing_script');

} 

}

add_action( 'wp_enqueue_scripts', 'Tbit_lms_adding_scripts', 999 ); 

add_action('wp_ajax_addnewsection', 'add_new_sction_function');

if( !function_exists('Tbit_lms_add_new_sction_function')){

function Tbit_lms_add_new_sction_function(){

	if(isset($_POST['section_name']) && $_POST['section_name'] !=''){

		$section_name = sanitize_title($_POST['section_name']);
		$section_course_id = '';
		$section_order = '';
		if(isset($_POST['section_course_id']) && !empty($_POST['section_course_id'])){
			$section_course_id = sanitize_title($_POST['section_course_id']);
		}

		if(isset($_POST['section_order']) && !empty($_POST['section_order'])){
			$section_order = sanitize_title($_POST['section_order']);
		}


		global $wpdb;

		$tablename=$wpdb->prefix.'gsplms_sections';

		$wpdb->insert($tablename,array(

			'section_name' => $section_name,

			'section_course_id' => $section_course_id,

			'section_order' =>  $section_order,

			'section_description' => '',

		));

	}

	$lastid = sanitize_title($wpdb->insert_id);

	$data=require_once('inc/admin/template-part/course_newsection.php');

	die;
}
}

add_action('wp_ajax_updatesectiondata', 'Tbit_lms_update_section_data_function');
if( !function_exists('Tbit_lms_give_my_posts_templates')){
function Tbit_lms_give_my_posts_templates(){
  add_post_type_support( 'post', 'page-attributes' );
}
}
add_action( 'init', 'Tbit_lms_give_my_posts_templates' );
if( !function_exists('Tbit_lms_create_new_role')){
function Tbit_lms_create_new_role(){
add_role('instructor', __(

   'Instructor'),

   array(

       'read'            => true, // Allows a user to read

       'edit_posts'        => true, // Allows user to edit their own posts

       )

);

add_role('student', __(

   'Student'),

   array(

       'read'            => false, // Allows a user to read

       'edit_posts'        => false, // Allows user to edit their own posts

       )

);

}
}

if( !function_exists('Tbit_lms_posts_for_current_author')){
function Tbit_lms_posts_for_current_author($query) {
    global $pagenow;
 
    if( 'edit.php' != $pagenow || !$query->is_admin )
        return $query;
 
    if( !current_user_can( 'edit_others_posts' ) ) {
        global $user_ID;
        $query->set('author', $user_ID );
        add_filter('views_edit-lms-courses', 'Tbit_lms_fix_post_counts_course');
        add_filter('views_edit-lms-lessons', 'Tbit_lms_fix_post_counts_lessons');
        add_filter('views_edit-lms-assesments', 'Tbit_lms_fix_post_counts_assesments');
        add_filter('views_edit-lms-question', 'Tbit_lms_fix_post_counts_question');
    }
    return $query;
}
}


if( !function_exists('Tbit_lms_restrict_media_library')){
function Tbit_lms_restrict_media_library( $wp_query_obj ) {
    global $current_user, $pagenow;

    $current_user_role = $current_user->roles;
    if(in_array('administrator',$current_user_role)){
    	return;
    }


    if( !is_a( $current_user, 'WP_User') )
    return;
    if( 'admin-ajax.php' != $pagenow || $_REQUEST['action'] != 'query-attachments' )
    return;
    if( !current_user_can('manage_media_library') )
    $wp_query_obj->set('author', $current_user->ID );
    return;
}
}
add_action('pre_get_posts','Tbit_lms_restrict_media_library');
add_filter('pre_get_posts', 'Tbit_lms_posts_for_current_author');

if( !function_exists('Tbit_lms_fix_post_counts_course')){
	function Tbit_lms_fix_post_counts_course($views){
		return Tbit_lms_fix_post_counts($views,'lms-courses');
	}
}

if( !function_exists('Tbit_lms_fix_post_counts_lessons')){
	function Tbit_lms_fix_post_counts_lessons($views){
		return Tbit_lms_fix_post_counts($views,'lms-lessons');
	}
}

if( !function_exists('Tbit_lms_fix_post_counts_assesments')){
	function Tbit_lms_fix_post_counts_assesments($views){
		return Tbit_lms_fix_post_counts($views,'lms-assesments');
	}
}


if( !function_exists('Tbit_lms_fix_post_counts_question')){
	function Tbit_lms_fix_post_counts_question($views){
		return Tbit_lms_fix_post_counts($views,'lms-question');
	}
}


if( !function_exists('Tbit_lms_fix_post_counts')){
function Tbit_lms_fix_post_counts($views,$post_type) {

    global $current_user, $wp_query;
    unset($views['mine']);
    $types = array(
        array( 'status' =>  NULL ),
        array( 'status' => 'publish' ),
        array( 'status' => 'draft' ),
        array( 'status' => 'pending' ),
        array( 'status' => 'trash' )
    );
    foreach( $types as $type ) {
        $query = array(
            'author'      => $current_user->ID,
            'post_type'   => $post_type,
            'post_status' => $type['status']
        );
        $result = new WP_Query($query);
        if( $type['status'] == NULL ):
            $class = ($wp_query->query_vars['post_status'] == NULL) ? ' class="current"' : '';
            $views['all'] = sprintf(__('<a href="%s"'. $class .'>All <span class="count">(%d)</span></a>', 'all'),
                admin_url('edit.php?post_type='.$post_type),
                $result->found_posts);
        elseif( $type['status'] == 'publish' ):
            $class = ($wp_query->query_vars['post_status'] == 'publish') ? ' class="current"' : '';
            $views['publish'] = sprintf(__('<a href="%s"'. $class .'>Published <span class="count">(%d)</span></a>', 'publish'),
                admin_url('edit.php?post_status=publish&post_type='.$post_type),
                $result->found_posts);
        elseif( $type['status'] == 'draft' ):
            $class = ($wp_query->query_vars['post_status'] == 'draft') ? ' class="current"' : '';
            $views['draft'] = sprintf(__('<a href="%s"'. $class .'>Draft'. ((sizeof($result->posts) > 1) ? "s" : "") .' <span class="count">(%d)</span></a>', 'draft'),
                admin_url('edit.php?post_status=draft&post_type='.$post_type),
                $result->found_posts);
        elseif( $type['status'] == 'pending' ):
            $class = ($wp_query->query_vars['post_status'] == 'pending') ? ' class="current"' : '';
            $views['pending'] = sprintf(__('<a href="%s"'. $class .'>Pending <span class="count">(%d)</span></a>', 'pending'),
                admin_url('edit.php?post_status=pending&post_type='.$post_type),
                $result->found_posts);
        elseif( $type['status'] == 'trash' ):
            $class = ($wp_query->query_vars['post_status'] == 'trash') ? ' class="current"' : '';
            $views['trash'] = sprintf(__('<a href="%s"'. $class .'>Trash <span class="count">(%d)</span></a>', 'trash'),
                admin_url('edit.php?post_status=trash&post_type='.$post_type),
                $result->found_posts);
        endif;
    }
    return $views;
}
}
add_action( 'admin_menu', 'Tbit_lms_add_users_assements_menu' );
if( !function_exists('Tbit_lms_add_users_assements_menu')){
function Tbit_lms_add_users_assements_menu(){
	add_menu_page( 'User Assemensts', 'User Assemensts', 'manage_options', 'user_assement', 'Tbit_lms_user_assement_block', 'dashicons-welcome-widgets-menus', 90 );
	add_submenu_page( 'lms-settings1', 'Settings', 'Settings',
    'manage_options', 'allshortcode','Tbit_lms_allshortcode_function');
    add_submenu_page( 'lms-settings1', 'Sales Report', 'Sales Report',
    'manage_options', 'sales_report','Tbit_lms_sale_course_report');
    add_submenu_page( 'lms-settings1', 'Import Demo', 'Import Demo',
    'manage_options', 'import_demo','Tbit_lms_demo_course_import');
}
}

if(!function_exists('Tbit_lms_demo_course_import')){
	function Tbit_lms_demo_course_import(){
		global $wpdb;
		$user_id=get_current_user_id();
		$msg = '';
		wp_register_style('Tbit_lms_admin_user_table',  plugins_url( 'assets/css/admin_user_table.css?id=88', __FILE__ ));
		wp_enqueue_style('Tbit_lms_admin_user_table');
		if(isset($_POST['demo_course_import']) && !empty($_POST['demo_course_import']) && $_POST['demo_course_import'] == 'yes'){
			$coursecsv = Tbit_ROOT.'/import/courses.csv';
			$file = fopen($coursecsv, "r");
			$j = 0;
			 while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
           {
           	if($j>0){
           	$course_name = '';
           	$category_name = '';
           	$c_duration = 10;
           	$c_duration_type= 'minute';
           	$student_can_enroll = 1000;
           	$student_enrolled = 0;
           	$course_featured = 0;
           	$course_orgprice = 80;
           	$course_saleprice = '';
           	$compulsory_course = 0;
           	$course_background_img = '';
           	$course_featured_img = '';
           	$post_content = '';
           	if(isset($getData[0]) && !empty($getData[0])){
           		$course_name = sanitize_text_field($getData[0]);
           	}
           	if(isset($getData[1]) && !empty($getData[1])){
           		$category_name = sanitize_text_field($getData[1]);
           	}
           	if(isset($getData[2]) && !empty($getData[2])){
           		$c_duration = sanitize_text_field($getData[2]);
           	}
           	if(isset($getData[3]) && !empty($getData[3])){
           		$c_duration_type = sanitize_text_field($getData[3]);
           	}
           	if(isset($getData[4]) && !empty($getData[4])){
           		$student_can_enroll = sanitize_text_field($getData[4]);
           	}
           	if(isset($getData[5]) && !empty($getData[5])){
           		$student_enrolled = sanitize_text_field($getData[5]);
           	}
           	if(isset($getData[6]) && !empty($getData[6])){
           		$course_featured = sanitize_text_field($getData[6]);
           	}
           	if(isset($getData[7]) && !empty($getData[7])){
           		$course_orgprice = sanitize_text_field($getData[7]);
           	}
           	if(isset($getData[8]) && !empty($getData[8])){
           		$course_saleprice = sanitize_text_field($getData[8]);
           	}
           	if(isset($getData[9]) && !empty($getData[9])){
           		$compulsory_course = sanitize_text_field($getData[9]);
           	}
           	if(isset($getData[10]) && !empty($getData[10])){
           		$course_background_img = sanitize_text_field($getData[10]);
           	}
           	if(isset($getData[11]) && !empty($getData[11])){
           		$course_featured_img = sanitize_text_field($getData[11]);
           	}
           	if(isset($getData[12]) && !empty($getData[12])){
           		$post_content = sanitize_text_field($getData[12]);
           	}

           	$array = array(
           		'post_title' => $course_name,
           		'post_author' => $user_id,
           		'post_content' => $post_content,
           		'post_status' => 'publish',
           		'post_type' => 'lms-courses',
           	);
           	$return_course_id = wp_insert_post($array);
           	if($return_course_id){
           		update_post_meta($return_course_id,'duration',$c_duration);
           		update_post_meta($return_course_id,'qsde_type',$c_duration_type);
           		update_post_meta($return_course_id,'qasx',$student_can_enroll);
           		update_post_meta($return_course_id,'lms_featured',$course_featured);
           		update_post_meta($return_course_id,'lms-course-price',$course_orgprice);
           		update_post_meta($return_course_id,'gsp_sale_price',$course_saleprice);
           		update_post_meta($return_course_id,'gsp_required_enroll',$compulsory_course);
           		if($course_featured_img){
           		$imageurl = Tbit_ROOT.'/import/image/'.$course_featured_img;
				$imagetype = end(explode('/', getimagesize($imageurl)['mime']));
				$uniq_name = date('dmY').''.(int) microtime(true); 
				$filename = $uniq_name.'.'.$imagetype;
				$uploaddir = wp_upload_dir();
				$uploadfile = $uploaddir['path'] . '/' . $filename;
				$contents= file_get_contents($imageurl);
				$savefile = fopen($uploadfile, 'w');
				fwrite($savefile, $contents);
				fclose($savefile);
				$wp_filetype = wp_check_filetype(basename($filename), null );
				$attachment = array(
				'post_mime_type' => $wp_filetype['type'],
				'post_title' => $filename,
				'post_content' => '',
				'post_status' => 'inherit'
				);
				$attach_id = wp_insert_attachment( $attachment, $uploadfile );
				$imagenew = get_post( $attach_id );
				$fullsizepath = get_attached_file( $imagenew->ID );
				$attach_data = wp_generate_attachment_metadata( $attach_id, $fullsizepath );
				wp_update_attachment_metadata( $attach_id, $attach_data ); 
				set_post_thumbnail($return_course_id, $attach_id);
				}
				if($course_background_img){
           		$background_img_imageurl = Tbit_ROOT.'/import/image/'.$course_background_img;
				$background_img_imagetype = end(explode('/', getimagesize($background_img_imageurl)['mime']));
				$background_img_uniq_name = date('dmY').''.(int) microtime(true); 
				$background_img_filename = $background_img_uniq_name.'.'.$background_img_imagetype;
				$background_img_uploaddir = wp_upload_dir();
				$background_img_uploadfile = $background_img_uploaddir['path'] . '/' . $background_img_filename;
				$background_img_contents= file_get_contents($background_img_imageurl);
				$background_img_savefile = fopen($background_img_uploadfile, 'w');
				fwrite($background_img_savefile, $background_img_contents);
				fclose($background_img_savefile);

				$background_img_wp_filetype = wp_check_filetype(basename($background_img_filename), null );
				$background_img_attachment = array(
				'post_mime_type' => $background_img_wp_filetype['type'],
				'post_title' => $background_img_filename,
				'post_content' => '',
				'post_status' => 'inherit'
				);

				$background_img_attach_id = wp_insert_attachment( $background_img_attachment, $background_img_uploadfile );
				$background_img_imagenew = get_post( $background_img_attach_id );
				$background_img_fullsizepath = get_attached_file( $background_img_imagenew->ID );
				$background_img_attach_data = wp_generate_attachment_metadata( $background_img_attach_id, $background_img_fullsizepath );
				wp_update_attachment_metadata( $background_img_attach_id, $background_img_attach_data ); 
				$background_img_url = wp_get_attachment_url($background_img_attach_id);
				update_post_meta($return_course_id,'lms_course_banner_image',$background_img_url);

				}

           	}
           }
           $j++;
           }


           $lessoncsv = Tbit_ROOT.'/import/lessons.csv';
			$lesson_file = fopen($lessoncsv, "r");
			$l = 0;
			 while (($lgetData = fgetcsv($lesson_file, 10000, ",")) !== FALSE)
           {

           	if($l>0){
           	$course_name = '';
           	$lesson_name = '';
           	$youtube_url = '';
           	if(isset($lgetData[0]) && !empty($lgetData[0])){
           		$course_name = sanitize_text_field($lgetData[0]);
           	}
           	if(isset($lgetData[1]) && !empty($lgetData[1])){
           		$lesson_name = sanitize_text_field($lgetData[1]);
           	}
           	if(isset($lgetData[2]) && !empty($lgetData[2])){
           		$youtube_url = sanitize_text_field($lgetData[2]);
           	}
           	$larray = array(
           		'post_title' => $lesson_name,
           		'post_author' => $user_id,
           		'post_content' => '',
           		'post_status' => 'publish',
           		'post_type' => 'lms-lessons',
           	);
           	$return_lesson_id = wp_insert_post($larray);
           	if($return_lesson_id){
           	update_post_meta($return_lesson_id,'youtube_url',$youtube_url);
           	if($course_name){
           		$course_id = '';

           		$explode = explode(',',$course_name);
           		if(count($explode)>0){
           		foreach ($explode as $ek => $ev) {
           		$course = get_page_by_title($ev,OBJECT,'lms-courses');
           		if(isset($course->ID) && !empty($course->ID)){
           			$course_id = $course->ID;
           				$section_id=1;
						$wpdb->insert($wpdb->prefix.'gsplms_section_items',array(
						'section_id' => $section_id,
						'item_id' => $return_lesson_id,
						'item_order' => 0,
						'item_type' => 'lms-lessons',
						'course_id' =>$course_id,
						)
					);
           		}
           	}
           }


           	}
           }
           	}
           	$l++;
           }


           $assesmentscsv = Tbit_ROOT.'/import/assesments.csv';
			$assesments_file = fopen($assesmentscsv, "r");
			$as = 0;
			 while (($asgetData = fgetcsv($assesments_file, 10000, ",")) !== FALSE)
           {
           	if($as>0){
           	$course_name = '';
           	$assesment_name = '';
           	$a_duration = 2;
           	$a_duration_type = 'minute';
           	$wrong_minus_point = 0;
           	$skip_minus_point = 0;
           	$passing_grade = 80;
           	$retake = 0;
           	if(isset($asgetData[0]) && !empty($asgetData[0])){
           		$course_name = sanitize_text_field($asgetData[0]);
           	}
           	if(isset($asgetData[1]) && !empty($asgetData[1])){
           		$assesment_name = sanitize_text_field($asgetData[1]);
           	}
           	if(isset($asgetData[2]) && !empty($asgetData[2])){
           		$a_duration = sanitize_text_field($asgetData[2]);
           	}
           	if(isset($asgetData[3]) && !empty($asgetData[3])){
           		$a_duration_type = sanitize_text_field($asgetData[3]);
           	}
           	if(isset($asgetData[4]) && !empty($asgetData[4])){
           		$wrong_minus_point = sanitize_text_field($asgetData[4]);
           	}
           	if(isset($asgetData[5]) && !empty($asgetData[5])){
           		$skip_minus_point = sanitize_text_field($asgetData[5]);
           	}
           	if(isset($asgetData[6]) && !empty($asgetData[6])){
           		$passing_grade = sanitize_text_field($asgetData[6]);
           	}
           	if(isset($asgetData[7]) && !empty($asgetData[7])){
           		$retake = sanitize_text_field($asgetData[7]);
           	}

           	$aarray = array(
           		'post_title' => $assesment_name,
           		'post_author' => $user_id,
           		'post_content' => '',
           		'post_status' => 'publish',
           		'post_type' => 'lms-assesments',
           	);

           	$return_assesment_id = wp_insert_post($aarray);
           	if($return_assesment_id){
           	update_post_meta($return_assesment_id,'lms_assement_duration',$a_duration);
           	update_post_meta($return_assesment_id,'lms_assement_duration_type',$a_duration_type);
           	update_post_meta($return_assesment_id,'lms_assement_minus_point',$wrong_minus_point);
           	update_post_meta($return_assesment_id,'lms_assement_minus_skip_point',$skip_minus_point);
           	update_post_meta($return_assesment_id,'lms_assement_passing_grade',$passing_grade);
           	update_post_meta($return_assesment_id,'lms_assement_retake',$retake);
           	if($course_name){
           		$course_id = '';

           		$explode = explode(',',$course_name);
           		if(count($explode)>0){
           		foreach ($explode as $ek => $ev) {


           		$course = get_page_by_title($ev,OBJECT,'lms-courses');
           		if(isset($course->ID) && !empty($course->ID)){
           			$course_id = $course->ID;
           				$section_id=2;
						$wpdb->insert($wpdb->prefix.'gsplms_section_items',array(
						'section_id' => $section_id,
						'item_id' => $return_assesment_id,
						'item_order' => 0,
						'item_type' => 'lms-assesments',
						'course_id' =>$course_id,
						)
					);
           		}
           	}
           }
           	}
           }
           	}
           	$as++;
           }



           $questioncsv = Tbit_ROOT.'/import/questions.csv';
			$question_file = fopen($questioncsv, "r");
			$q = 0;
			 while (($qgetData = fgetcsv($question_file, 10000, ",")) !== FALSE)
           {
           	if($q>0){
           	$assesment_name = '';
           	$question_name = '';
           	$question_type = '';
           	$question_option = array();
           	$question_answer = '';
           	$q_mark = 1;
           	if(isset($qgetData[0]) && !empty($qgetData[0])){
           		$assesment_name = sanitize_text_field($qgetData[0]);
           	}
           	if(isset($qgetData[1]) && !empty($qgetData[1])){
           		$question_name = sanitize_text_field($qgetData[1]);
           	}
           	if(isset($qgetData[2]) && !empty($qgetData[2])){
           		$question_type = sanitize_text_field($qgetData[2]);
           	}
           	if(isset($qgetData[3]) && !empty($qgetData[3])){
           		$question_option = explode(',',$qgetData[3]);
           	}
           	if(isset($qgetData[4]) && !empty($qgetData[4])){
           		$question_answer = sanitize_text_field($qgetData[4]);
           	}
           	if(isset($qgetData[5]) && !empty($qgetData[5])){
           		$q_mark = sanitize_text_field($qgetData[5]);
           	}

           	$qarray = array(
           		'post_title' => $question_name,
           		'post_author' => $user_id,
           		'post_content' => '',
           		'post_status' => 'publish',
           		'post_type' => 'lms-question',
           	);

           	$return_question_id = wp_insert_post($qarray);
           	if($return_question_id){
           	update_post_meta($return_question_id,'gsplmsq_type',$question_type);
           	update_post_meta($return_question_id,'lms_question_mark',$q_mark);
           	if($assesment_name){
           		$assesment_id = '';
           		$assesments = get_page_by_title($assesment_name,OBJECT,'lms-assesments');
           		if(isset($assesments->ID) && !empty($assesments->ID)){
           			$assesment_id = $assesments->ID;

           			$wpdb->insert($wpdb->prefix.'gsplms_quiz_questions',array(
					'quiz_id' => $assesment_id,
					'question_id' => $return_question_id,
					));

           			if(count($question_option)>0){
           			foreach ($question_option as $qk => $qv) {
           			$question_answer = strtolower(str_replace(' ','',$question_answer));
           			$v = strtolower(str_replace(' ','',$qv));
           			$is_true = '';
           			if($v == $question_answer){
           				$is_true = 'yes';
           			}

					$addnew=array(
					'text' => $qv,
					'value' => $v,
					'is_true' => $is_true
					);

					$wpdb->insert($wpdb->prefix.'gsplms_question_answers',array(

					'question_id' => $return_question_id,

					'answer_data' => serialize($addnew),

					));

					}
				}


           		}
           	}
           }
           	}
           	$q++;
           }
          $msg = 'Successfully Imported';
       }
	?>

		<div class="table_userbox">
			<div class="my-box-bg">
				<h2 class="heading-cont nomargin">Import Courses, Lessons, Assessments and Questions</h2>
				<!-- Tab panes -->
				<div class="tab-content1">
				<?php
				if($msg){?>
				<div class="custom_success_msg"><?php echo esc_html($msg);?></div>
				<?php }
				?>
				<form method="post">
				<input type="hidden" name="demo_course_import" value="yes">
				<button type="submit" class="course_import_btn">Import Demo</button>
				</form>
				</div>
			</div>
		</div>
	<?php }
}

if( !function_exists('Tbit_lms_sale_course_report')){
function Tbit_lms_sale_course_report(){
global $wpdb;
wp_register_style('Tbit_lms_admin_user_table',  plugins_url( 'assets/css/admin_user_table.css?id='.rand(), __FILE__ ));
wp_enqueue_style('Tbit_lms_admin_user_table');

$sales_report = '';
$payments= '';
$tab = 'sales_report';
if(isset($_GET['tab']) && !empty($_GET['tab'])){
	$tab = $_GET['tab'];
}

if($tab == 'sales_report'){
	$sales_report = 'active';
} else if($tab == 'payments'){
	$payments = 'active';
}

if(isset($_GET['v_action']) && isset($_GET['order_id']) && isset($_GET['order_id']) && $_GET['v_action'] == 'delete' && !empty($_GET['order_id'])){
        $order_id = sanitize_text_field($_GET['order_id']);
        $table = $wpdb->prefix.'user_payments';
        $response = $wpdb->delete( $table, array( 'order_id' => $order_id ) );
       if($response){
        $_SESSION['payment_status_success'] = 'successfully Delete!';
       }
    }

?>


	<div class="instructor_tablebox margintop50">
		<?php
		if(isset($_SESSION['payment_status_success']) && !empty($_SESSION['payment_status_success'])){?>
		<div class="custom_success_msg"><?php echo esc_html($_SESSION['payment_status_success']); ?></div>
		<?php 
		unset($_SESSION['payment_status_success']);
		}
		?>
        <div class="my-box-bg">
        	<div class="sales_reportbox">
        		<ul>
        			<li class="<?php echo esc_attr($sales_report);?>" data-id="sales_report">Sales Report</li>
        			<li class="<?php echo esc_attr($payments);?>" data-id="payments">Payments</li>
        			<div class="clear"></div>
        		</ul>
        	</div>
            <div class="tab-content nopadding noborder">
            <div id="sales_report" class="tab-pane <?php echo esc_attr($sales_report);?> nopadding sales_reportitembox">
                <table class="wp-list-table widefat fixed striped table-view-list users">
                <thead>
                <tr>
                <th scope="col" id="Course" class="manage-column column-Course column-primary sortable desc">
                <span>Course</span>
                </th>
                <th scope="col" id="Date" class="manage-column column-Date">Date</th>
                <th scope="col" id="PaymentStatus" class="manage-column column-PaymentStatus sortable desc">
                <span>Payment Status</span>
                </th>
                <th scope="col" id="Customer" class="manage-column column-Customer sortable desc">
                <span>Customer</span>
                </th>
                <th scope="col" id="Amount" class="manage-column column-Amount sortable desc">
                <span>Amount</span>
                </th>
                <th scope="col" id="PaymentType" class="manage-column column-PaymentType sortable desc">
                <span>Payment Type</span>
                </th>
                <th class="text-center">Action</th>
                </tr>

                </thead>
                <tbody id="the-list" data-wp-lists="list:user">
						<?php
					$sql="SELECT up.*,u.display_name FROM ".$wpdb->prefix."user_payments up LEFT JOIN ".$wpdb->prefix."users u ON up.user_id=u.ID";
					$get_results=$wpdb->get_results($sql,ARRAY_A);
					if(count($get_results)>0){
					foreach ($get_results as $key => $value) {
					$course_id = $value['course_id'];
					$subsribe_date = $value['subscribed_date'];
					$date=date_create($subsribe_date);
					$date_formate = date_format($date,"M d, Y");
					?>
					<tr>
					<td class="column-course"><a href="<?php echo esc_url(get_permalink($course_id));?>"><?php echo esc_html(get_the_title($course_id));?></a></td>
					<td class="column-date"><?php echo esc_html($date_formate);?></td>
					<td class="column-quiz column-quiz-1194">
						<?php
						$payment_status = $value['payment_status'];
						$status_array = array(
							'Pending',
							'Processing',
							'Completed',
						);
						?>
						<select name="sales_payment_status" data-order_id="<?php echo esc_attr($value['order_id']);?>">
							<?php 
							foreach($status_array as $row){
							$selected = '';
							if($payment_status == $row){
								$selected = 'selected';
							}
							?>
							<option value="<?php echo esc_attr($row); ?>" <?php echo esc_attr($selected);?>><?php echo esc_html($row); ?></option>
							<?php }?>
						</select>	
					</td>
					<td class="column-status"><?php echo esc_html($value['display_name']);?></td>
					<td class="column-time-interval"><?php echo esc_html($value['amount']); ?></td>
					<td class="column-time-interval"><?php echo esc_html($value['transaction_type']); ?></td>
					<td class="column-time-interval text-center"><a  href="<?php echo esc_url(admin_url());?>/admin.php?page=sales_report&order_id=<?php echo esc_attr($value['order_id']); ?>&v_action=delete" onclick="return confirm('Are you sure?');" class="btn btn-danger">Delete</a> </td>
					</tr>
					<?php } } else {?> 
					<tr>
					<td colspan="7" class="text-center"> No Data </td>
					</tr>
					<?php } ?>
                </tbody>
                </table>
            </div> <!--- sales_report --->
            <div id="payments" class="tab-pane nopadding <?php echo esc_attr($payments);?> sales_reportitembox">
				<?php 
				if(function_exists('Tbit_admin_transcation_history')){
					echo html_entity_decode(esc_html(Tbit_admin_transcation_history()));
				} else {
					echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Transcation History')));
				}
				?>
            </div> <!--- payments --->
        </div>
    </div>
</div>
<?php }
}
if( !function_exists('Tbit_lms_allshortcode_function')){
function Tbit_lms_allshortcode_function(){
	global $wpdb;
	wp_register_style('Tbit_lms_bootstrap', plugins_url( 'assets/css/bootstrap/bootstrap.min.css?id=9', __FILE__ ));
	wp_enqueue_style('Tbit_lms_bootstrap');
	wp_register_script('Tbit_lms_bootstrap', plugins_url( 'assets/js/bootstrap.min.js?id=99',__FILE__ ),'','',false);
	wp_enqueue_script('Tbit_lms_bootstrap');
	wp_register_style('Tbit_lms_admin_setting',  plugins_url( 'assets/css/admin_setting.css?id='.rand(), __FILE__ ));
	wp_enqueue_style('Tbit_lms_admin_setting');


	if (!isset($_POST['gsp_paypal_enable']) && isset($_POST['gsp_paypal_receiver_email'])) {
		insert_meta_data('gsp_paypal_enable','');
	}
	if (isset($_POST['gsp_paypal_enable'])) {
		$gsp_paypal_enable = sanitize_text_field($_POST['gsp_paypal_enable']);
		insert_meta_data('gsp_paypal_enable',$gsp_paypal_enable);
	}

	if (!isset($_POST['gsp_paypal_enable_test_mode']) && isset($_POST['gsp_paypal_receiver_email'])) {
		insert_meta_data('gsp_paypal_enable_test_mode','');
	}

	if (isset($_POST['gsp_paypal_enable_test_mode'])) {
		$gsp_paypal_enable_test_mode = sanitize_text_field($_POST['gsp_paypal_enable_test_mode']);
		insert_meta_data('gsp_paypal_enable_test_mode',$gsp_paypal_enable_test_mode);
	}


	if (!isset($_POST['gsp_stripe_enable']) && isset($_POST['gsp_paypal_receiver_email'])) {
		insert_meta_data('gsp_stripe_enable','');
	}
	if (isset($_POST['gsp_stripe_enable'])) {
		$gsp_stripe_enable = sanitize_text_field($_POST['gsp_stripe_enable']);
		insert_meta_data('gsp_stripe_enable',$gsp_stripe_enable);
	}
	if (!isset($_POST['gsp_stripe_test_mode_enable']) && isset($_POST['gsp_paypal_receiver_email'])) {
		insert_meta_data('gsp_stripe_test_mode_enable','');
	}
	if (isset($_POST['gsp_stripe_test_mode_enable'])) {
		$gsp_stripe_test_mode_enable = sanitize_text_field($_POST['gsp_stripe_test_mode_enable']);
		insert_meta_data('gsp_stripe_test_mode_enable',$gsp_stripe_test_mode_enable);
	}
	if (isset($_POST['gsp_paypal_receiver_email'])) {
		$gsp_paypal_receiver_email = sanitize_text_field($_POST['gsp_paypal_receiver_email']);
		insert_meta_data('gsp_paypal_receiver_email',$gsp_paypal_receiver_email);
	}

	if (isset($_POST['gsp_stripe_secret_key'])) {
		$gsp_stripe_secret_key = sanitize_text_field($_POST['gsp_stripe_secret_key']);
		insert_meta_data('gsp_stripe_secret_key',$gsp_stripe_secret_key);
	}

	if (isset($_POST['gsp_stripe_publishable_key'])) {
		$gsp_stripe_publishable_key = sanitize_text_field($_POST['gsp_stripe_publishable_key']);
		insert_meta_data('gsp_stripe_publishable_key',$gsp_stripe_publishable_key);
	}

	if (isset($_POST['gsp_stripe_live_secret_key'])) {
		$gsp_stripe_live_secret_key = sanitize_text_field($_POST['gsp_stripe_live_secret_key']);
		insert_meta_data('gsp_stripe_live_secret_key',$gsp_stripe_live_secret_key);
	}

	if (isset($_POST['gsp_stripe_live_publishable_key'])) {
		$gsp_stripe_live_publishable_key = sanitize_text_field($_POST['gsp_stripe_live_publishable_key']);
		insert_meta_data('gsp_stripe_live_publishable_key',$gsp_stripe_live_publishable_key);
	}
	
	if (isset($_POST['gsp_lms_currency'])) {
		$gsp_lms_currency = sanitize_text_field($_POST['gsp_lms_currency']);
		insert_meta_data('gsp_lms_currency',$gsp_lms_currency);
	}
	if (isset($_POST['gsp_certificate_website_name'])) {
		$gsp_certificate_website_name = sanitize_text_field($_POST['gsp_certificate_website_name']);
		insert_meta_data('gsp_certificate_website_name',$gsp_certificate_website_name);
	}
	if (isset($_POST['gsp_certificate_conetnt'])) {
		$gsp_certificate_conetnt = sanitize_textarea_field($_POST['gsp_certificate_conetnt']);
		insert_meta_data('gsp_certificate_conetnt',$_POST['gsp_certificate_conetnt']);
	}
	if (isset($_POST['gsp_commission']) && !empty($_POST['gsp_commission'])) {
		$gsp_commission = sanitize_text_field($_POST['gsp_commission']);
		insert_meta_data('gsp_commission',$gsp_commission);
	} else if(isset($_POST['gsp_commission']) && empty($_POST['gsp_commission'])) {
		insert_meta_data('gsp_commission',10);
	}

	if (isset($_POST['gsp_certificate_logo'])) {
		$gsp_certificate_logo = sanitize_text_field($_POST['gsp_certificate_logo']);
		insert_meta_data('gsp_certificate_logo',$gsp_certificate_logo);
	}

	if (isset($_POST['gsp_from_email'])) {
		$gsp_from_email = sanitize_text_field($_POST['gsp_from_email']);
		insert_meta_data('gsp_from_email',$gsp_from_email);
	}

	if (isset($_POST['gsp_from_name'])) {
		$gsp_from_name = sanitize_text_field($_POST['gsp_from_name']);
		insert_meta_data('gsp_from_name',$gsp_from_name);
	}

	if (isset($_POST['gsp_lms_email_order_admin']) && count($_POST['gsp_lms_email_order_admin'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_order_admin'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_order_admin',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_emails_new_order_admin_email_content_html'])) {
		$gsp_lms_emails_new_order_admin_email_content_html = sanitize_textarea_field($_POST['gsp_lms_emails_new_order_admin_email_content_html']);
		insert_meta_data('gsp_lms_emails_new_order_admin_email_content_html',$gsp_lms_emails_new_order_admin_email_content_html);
	}


	if (isset($_POST['gsp_lms_email_order_instructor']) && count($_POST['gsp_lms_email_order_instructor'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_order_instructor'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_order_instructor',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_emails_new_order_instructor_email_content_html'])) {
		$gsp_lms_emails_new_order_instructor_email_content_html = sanitize_textarea_field($_POST['gsp_lms_emails_new_order_instructor_email_content_html']);
		insert_meta_data('gsp_lms_emails_new_order_instructor_email_content_html',$gsp_lms_emails_new_order_instructor_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_order_student']) && count($_POST['gsp_lms_email_order_student'])>0) {

		$input_data = array();
		foreach($_POST['gsp_lms_email_order_student'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_order_student',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_emails_new_order_student_email_content_html'])) {
		$gsp_lms_emails_new_order_student_email_content_html = sanitize_textarea_field($_POST['gsp_lms_emails_new_order_student_email_content_html']);
		insert_meta_data('gsp_lms_emails_new_order_student_email_content_html',$gsp_lms_emails_new_order_student_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor']) && count($_POST['gsp_lms_email_become_an_instructor'])>0) {

		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_instructor'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}

		insert_meta_data('gsp_lms_email_become_an_instructor',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor_email_content_html'])) {
		$gsp_lms_email_become_an_instructor_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_instructor_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_instructor_email_content_html',$gsp_lms_email_become_an_instructor_email_content_html);
	}


	if (isset($_POST['gsp_lms_email_become_an_instructor_accepted']) && count($_POST['gsp_lms_email_become_an_instructor_accepted'])>0) {

		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_instructor_accepted'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}

		insert_meta_data('gsp_lms_email_become_an_instructor_accepted',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor_accepted_email_content_html'])) {
		$gsp_lms_email_become_an_instructor_accepted_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_instructor_accepted_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_instructor_accepted_email_content_html',$gsp_lms_email_become_an_instructor_accepted_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor_denied']) && count($_POST['gsp_lms_email_become_an_instructor_denied'])>0) {

		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_instructor_denied'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}

		insert_meta_data('gsp_lms_email_become_an_instructor_denied',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor_denied_email_content_html'])) {
		$gsp_lms_email_become_an_instructor_denied_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_instructor_denied_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_instructor_denied_email_content_html',$gsp_lms_email_become_an_instructor_denied_email_content_html);
	}


	if (isset($_POST['gsp_lms_email_become_an_instructor_send_mail']) && count($_POST['gsp_lms_email_become_an_instructor_send_mail'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_instructor_send_mail'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_become_an_instructor_send_mail',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_instructor_send_mail_email_content_html'])) {
		$gsp_lms_email_become_an_instructor_send_mail_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_instructor_send_mail_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_instructor_send_mail_email_content_html',$gsp_lms_email_become_an_instructor_send_mail_email_content_html);
	}


	if (isset($_POST['gsp_lms_email_become_an_student_send_mail']) && count($_POST['gsp_lms_email_become_an_student_send_mail'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_student_send_mail'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_become_an_student_send_mail',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_student_send_mail_email_content_html'])) {
		$gsp_lms_email_become_an_student_send_mail_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_student_send_mail_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_student_send_mail_email_content_html',$gsp_lms_email_become_an_student_send_mail_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_become_an_student']) && count($_POST['gsp_lms_email_become_an_student'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_student'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_become_an_student',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_student_email_content_html'])) {
		$gsp_lms_email_become_an_student_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_student_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_student_email_content_html',$gsp_lms_email_become_an_student_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_become_an_student_accepted']) && count($_POST['gsp_lms_email_become_an_student_accepted'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_student_accepted'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_become_an_student_accepted',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_student_accepted_email_content_html'])) {
		$gsp_lms_email_become_an_student_accepted_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_student_accepted_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_student_accepted_email_content_html',$gsp_lms_email_become_an_student_accepted_email_content_html);
	}

	if (isset($_POST['gsp_lms_email_become_an_student_denied']) && count($_POST['gsp_lms_email_become_an_student_denied'])>0) {
		$input_data = array();
		foreach($_POST['gsp_lms_email_become_an_student_denied'] as $row => $val){
			$input_data[$row] = sanitize_text_field($val); 
		}
		insert_meta_data('gsp_lms_email_become_an_student_denied',json_encode($input_data));
	}

	if (isset($_POST['gsp_lms_email_become_an_student_denied_email_content_html'])) {
		$gsp_lms_email_become_an_student_denied_email_content_html = sanitize_textarea_field($_POST['gsp_lms_email_become_an_student_denied_email_content_html']);
		insert_meta_data('gsp_lms_email_become_an_student_denied_email_content_html',$gsp_lms_email_become_an_student_denied_email_content_html);
	}

	if(isset($_POST['gsp_primary_color'])){
		$gsp_primary_color = sanitize_text_field($_POST['gsp_primary_color']);
		insert_meta_data('gsp_primary_color',$gsp_primary_color);
	}

	if(isset($_POST['gsp_secondary_color'])){
		$gsp_secondary_color = sanitize_text_field($_POST['gsp_secondary_color']);
		insert_meta_data('gsp_secondary_color',$gsp_secondary_color);
	}

	if(isset($_POST['gsp_button_text_color'])){
		$gsp_button_text_color = sanitize_text_field($_POST['gsp_button_text_color']);
		insert_meta_data('gsp_button_text_color',$gsp_button_text_color);
	}

	if(isset($_POST['gsp_button_background_color'])){
		$gsp_button_background_color = sanitize_text_field($_POST['gsp_button_background_color']);
		insert_meta_data('gsp_button_background_color',$gsp_button_background_color);
	}

	if(isset($_POST['gsp_button_hover_text_color'])){
		$gsp_button_hover_text_color = sanitize_text_field($_POST['gsp_button_hover_text_color']);
		insert_meta_data('gsp_button_hover_text_color',$gsp_button_hover_text_color);
	}

	if(isset($_POST['gsp_button_hover_background_color'])){
		$gsp_button_hover_background_color = sanitize_text_field($_POST['gsp_button_hover_background_color']);
		insert_meta_data('gsp_button_hover_background_color',$gsp_button_hover_background_color);
	}

	if(isset($_POST['gsp_favourite_icon_color'])){
		$gsp_favourite_icon_color = sanitize_text_field($_POST['gsp_favourite_icon_color']);
		insert_meta_data('gsp_favourite_icon_color',$gsp_favourite_icon_color);
	}

	if(isset($_POST['gsp_favourite_active_icon_color'])){
		$gsp_favourite_active_icon_color = sanitize_text_field($_POST['gsp_favourite_active_icon_color']);
		insert_meta_data('gsp_favourite_active_icon_color',$gsp_favourite_active_icon_color);
	}
	?>
	<div class="demo margin-top-30">

  <div role="tabpanel">



  <!-- Nav tabs -->

  <ul class="nav nav-tabs nav-justified nav-tabs-dropdown gsp_lms_setting_nav_menu" role="tablist">
  	 <li role="presentation" class="active"><a href="#generalsettings" aria-controls="generalsettings" role="tab" data-toggle="tab">General</a></li>

    <li role="presentation"><a href="#shortcode" aria-controls="shortcode" role="tab" data-toggle="tab">Shortcodes</a></li>

    <li role="presentation"><a href="#paymentsettings" aria-controls="paymentsettings" role="tab" data-toggle="tab">Payments</a></li>

    <li role="presentation"><a href="#emailsettings" aria-controls="emailsettings" role="tab" data-toggle="tab">Emails</a></li>

    <li role="presentation"><a href="#certificate_tab" aria-controls="certificate_tab" role="tab" data-toggle="tab">Certificate</a></li>
    <li role="presentation"><a href="#advanced_tab" aria-controls="advanced_tab" role="tab" data-toggle="tab">Advanced</a></li>
  </ul>



  <!-- Tab panes -->

  <div class="tab-content">
  	
  	<div role="tabpanel" class="tab-pane active" id="generalsettings">
    	<form method="post">
    	<div class="paypal_box">

    		<label class="col-sm-2">Currency</label>

    		<div class="col-sm-10">
    			<?php
    			$gsp_lms_currency = tbit_data_retrivedata('gsp_lms_currency');
    			?>

    			<select class="form-control" name="gsp_lms_cu rrency">
    				<option value="USD" <?php if($gsp_lms_currency=='USD'){ echo 'selected'; } ?> >USD</option>
    			</select>

    		</div>

    	<div class="clear"></div>

    	</div>


    	<div class="paypal_box">

    		<label class="col-sm-2">Commission(%)</label>

    		<div class="col-sm-10">
    		<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
    			$return_field = Tbit_quick_learn_return_pro_verison_input_field('commission_field');
    			echo html_entity_decode(esc_html($return_field));
    		?>
    		
    		<?php } else {
    			$required_text = Tbit_lms_require_pro_version_text();
    			echo html_entity_decode(esc_html($required_text));
    		}?>


    		</div>
    	</div>

    	<div class="col-sm-2 margin-top-20">

    		<input type="submit" name="submit" value="Save settings" class="btn btn-primary">

    	</div>

    	</form>



    </div>

    <div role="tabpanel" class="tab-pane" id="shortcode">

    	

		<h2>All Short Codes</h2>

		<table border="1" class="shortcodetable">

			<thead>

				<tr>

					<th>

						No.

					</th>

					<th>

						Title

					</th>

					<th>

						Short Code

					</th>

				</tr>

			</thead>

			<tbody>

				<tr>

					<td>1</td>

					<td>All Courses</td>

					<td><code>[all-courses]</code></td>

				</tr>

				<tr>

					<td>2</td>

					<td>Category Courses</td>

					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_catetory_couse');
							echo html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo html_entity_decode(esc_html($required_text));
						}
						?>
					</td>

				</tr>

				<tr>

					<td>3</td>

					<td>Featured Courses</td>
					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_Tbit_feature');
							echo html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo  html_entity_decode(esc_html($required_text));
						}
						?>
					</td>
				</tr>
				<tr>

					<td>4</td>

					<td>Register Form For Instructor</td>
					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_Tbit_as_instructor');
							echo  html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo  html_entity_decode(esc_html($required_text));
						}
						?>
					</td>

				</tr>

				<tr>

					<td>4</td>

					<td>Register Form For Student</td>

					<td><code>[register-user-as-student]</code></td>

				</tr>

				<tr>

					<td>5</td>

					<td>My Account</td>

					<td><code>[my-account]</code></td>

				</tr>

				<tr>

					<td>6</td>

					<td>Wishlist</td>

					<td><code>[wishlist]</code></td>

				</tr>
				<tr>

					<td>7</td>

					<td>All Instructors</td>
					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_Tbit_instructor');
							echo  html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo  html_entity_decode(esc_html($required_text));
						}
						?>
					</td>

				</tr>
				<tr>

					<td>8</td>

					<td>Featured Instructors</td>
					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_Tbit_instructor_is_featured');
							echo  html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo  html_entity_decode(esc_html($required_text));
						}
						?>
					</td>

				</tr>

				<tr>

					<td>9</td>

					<td>Specific Instructors</td>
					<td>
						<?php 
						if( function_exists('Tbit_quick_learn_return_pro_verison_text_return')) {
							$return_reponse = Tbit_quick_learn_return_pro_verison_text_return('shortcode_Tbit_instructor_is_id');
							echo  html_entity_decode(esc_html($return_reponse));
						} else {
							$required_text = Tbit_lms_require_pro_version_text();
							echo  html_entity_decode(esc_html($required_text));
						}
						?>
					</td>

				</tr>

			</tbody>

		</table>

	

    </div>

    <div role="tabpanel" class="tab-pane" id="emailsettings">
  		<div method="post" class="email_setting_box">

  			<div class="emailsettingsbox">
  				<div class="clear"></div>
  				<div class="email_s_leftbox">
  					<div class="e_s_l_abox active" id="order_general">
  						<a>General</a>
  					</div>
  					<div class="e_s_l_abox" id="order_admin">
  						<a>Order (Admin)</a>
  					</div>
  					<div class="e_s_l_abox" id="order_instructor">
  						<a>Order (Instructor)</a>
  					</div>
  					<div class="e_s_l_abox" id="order_student">
  						<a>Order (Student)</a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_instructor_send_mail">
  						<a>Become An Instructor </a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_instructor_request">
  						<a>Become An Instructor (Request)</a>
  					</div>
  					<div class="e_s_l_abox" id="become_an_instructor_accepted">
  						<a>Become An Instructor (Accepted)</a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_instructor_denied">
  						<a>Become An Instructor (Denied)</a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_student_send_mail">
  						<a>Become An Student </a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_student_request">
  						<a>Become An Student (Request)</a>
  					</div>
  					<div class="e_s_l_abox" id="become_an_student_accepted">
  						<a>Become An Student (Accepted)</a>
  					</div>

  					<div class="e_s_l_abox" id="become_an_student_denied">
  						<a>Become An Student (Denied)</a>
  					</div>

  				</div>
  				<div class="email_s_rightbox">
  					<div class="email_contentbox order_general active_email_content" >
  						<form method="post">
  						<table class="e_s_r_table">
  						<tbody>
  							
  							<tr>
  								<th>From Name</th>
  								<td>
  									<?php 
  									$gsp_from_name = tbit_data_retrivedata('gsp_from_name');
  									?>
  									<input type="text" name="gsp_from_name" id="gsp_from_name" value="<?php echo esc_attr($gsp_from_name);?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th>From Email</th>
  								<td>
  									<?php 
  									$gsp_from_email = tbit_data_retrivedata('gsp_from_email');
  									?>
  									<input type="text" name="gsp_from_email" id="gsp_from_email" value="<?php echo esc_attr($gsp_from_email);?>" class="email_text">
  								</td>
  							</tr>
  						</tbody>
  						</table>
						<p class="gsp-admin-settings-buttons">
							<button  class="button button-primary">Save settings</button>
						</p>
						</form>
  					</div>
  					<div class="email_contentbox order_admin" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php
  									$order_admin_enable = '';
  									$order_admin_subject = 'New order placed on {{order_date}}';
  									$gsp_lms_email_order_admin = tbit_data_retrivedata('gsp_lms_email_order_admin');
  									if($gsp_lms_email_order_admin !=''){
  										$json_decode = json_decode($gsp_lms_email_order_admin,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$order_admin_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$order_admin_subject = $json_decode['subject'];
  										}
  									}
  									
  									?>
  									<input type="checkbox" name="gsp_lms_email_order_admin[enable]" id="gsp_lms_email_order_admin[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($order_admin_enable);?>>
									<label for="gsp_lms_emails_order_admin[enable]">
									Notify admin when a new order is placed.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_order_admin[subject]" id="gsp_lms_email_order_admin[subject]" value="<?php echo esc_attr($order_admin_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_emails_new_order_admin_email_content_html";
									$name = 'gsp_lms_emails_new_order_admin_email_content_html';
									$email_content_admin_html = '<p>New order placed by <strong>{{order_user_name}}</strong></p>';
									$email_content_admin_html .= '<p>{{order_items_table}}</p>'; 
									$gsp_lms_emails_new_order_admin_email_content_html = tbit_data_retrivedata('gsp_lms_emails_new_order_admin_email_content_html');
									$content = $gsp_lms_emails_new_order_admin_email_content_html ? $gsp_lms_emails_new_order_admin_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_emails_new_order_admin_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									<li data-variable="{{order_id}}">
									<code>{{order_id}}</code></li>
									<li data-variable="{{order_user_id}}">
									<code>{{order_user_id}}</code></li>
									<li data-variable="{{order_user_name}}">
									<code>{{order_user_name}}</code></li>
									<li data-variable="{{order_items_table}}">
									<code>{{order_items_table}}</code></li>
									<li data-variable="{{order_date}}">
									<code>{{order_date}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
							<button  class="button button-primary">Save settings</button>
						</p>
  					</form>
  					<div class="clear"></div>
  					</div>

  					<div class="email_contentbox order_instructor" >
						<?php 
						if(function_exists('Tbit_order_instructor')){
						echo html_entity_decode(esc_html(Tbit_order_instructor()));
						} else {
						echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Order (Instructor)')));
						}
						?>
  					</div>

  					<div class="email_contentbox order_student" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php 
  									$order_student_enable = '';
  									$order_student_subject = 'Your order placed on {{order_date}}';
  									$gsp_lms_email_order_student = tbit_data_retrivedata('gsp_lms_email_order_student');
  									if($gsp_lms_email_order_student !=''){
  										$json_decode = json_decode($gsp_lms_email_order_student,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$order_student_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$order_student_subject = $json_decode['subject'];
  										}
  									}
  									?>
  									<input type="checkbox" name="gsp_lms_email_order_student[enable]" id="gsp_lms_email_order_student[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($order_student_enable); ?>>
									<label for="gsp_lms_email_order_student[enable]">
									Notify Students when they successfully enroll a course.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_order_student[subject]" id="gsp_lms_email_order_student[subject]" value="<?php echo esc_attr($order_student_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_emails_new_order_student_email_content_html";
									$name = 'gsp_lms_emails_new_order_student_email_content_html';
									$email_content_admin_html = '<p>Hi <strong>{{order_user_name}}</strong></p>';
									$email_content_admin_html .= '<p>We have received your order at <strong>{{site_title}}</strong> and send you the details.</p>'; 

									$email_content_admin_html .= '<p>You can also login to your account to see more details.</p>'; 
									$email_content_admin_html .= '<p>{{order_items_table}}</p>'; 
									$gsp_lms_emails_new_order_student_email_content_html = tbit_data_retrivedata('gsp_lms_emails_new_order_student_email_content_html');
									$content = $gsp_lms_emails_new_order_student_email_content_html ? $gsp_lms_emails_new_order_student_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_emails_new_order_student_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									<li data-variable="{{order_id}}">
									<code>{{order_id}}</code></li>
									<li data-variable="{{order_user_id}}">
									<code>{{order_user_id}}</code></li>
									<li data-variable="{{order_user_name}}">
									<code>{{order_user_name}}</code></li>
									<li data-variable="{{order_items_table}}">
									<code>{{order_items_table}}</code></li>
									<li data-variable="{{order_date}}">
									<code>{{order_date}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
							<button  class="button button-primary">Save settings</button>
					</p>
  					</form>
  					<div class="clear"></div>
  					</div>

  				   <div class="email_contentbox become_an_instructor_send_mail" >
  				   <?php 
  				   if(function_exists('Tbit_become_an_instructor')){
  				   	echo html_entity_decode(esc_html(Tbit_become_an_instructor()));
  				   } else {
  				   	echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Become An Instructor')));
  				   }
  				   ?>
  					</div>


  					<div class="email_contentbox become_an_instructor_request" >
	  				   <?php 
		  				   if(function_exists('Tbit_become_an_instructor_request')){
		  				   	echo html_entity_decode(esc_html(Tbit_become_an_instructor_request()));
		  				   } else {
		  				   	echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Become An Instructor (Request)')));
		  				   }
	  				   ?>
  					</div>

  					<div class="email_contentbox become_an_instructor_accepted" >
  						<?php 
		  				   if(function_exists('Tbit_become_an_instructor_accepted')){
		  				   	echo html_entity_decode(esc_html(Tbit_become_an_instructor_accepted()));
		  				   } else {
		  				   	echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Become An Instructor (Accepted)')));
		  				   }
	  				   ?>
  					</div>


  					<div class="email_contentbox become_an_instructor_denied" >
  						<?php 
		  				   if(function_exists('Tbit_become_an_instructor_denied')){
		  				   	echo html_entity_decode(esc_html(Tbit_become_an_instructor_denied()));
		  				   } else {
		  				   	echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Become An Instructor (Denied)')));
		  				   }
	  				   ?>
  					</div>
  					 <!-- Instructor Email Settings End  -->


  					<!-- Student Email Settings Start  -->


  					<div class="email_contentbox become_an_student_send_mail" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php 
  									$become_an_student_send_mail_enable = '';
  									$become_an_student_send_mail_subject = '[{{site_title}}] You Have Successfully Register ';
  									$gsp_lms_email_become_an_student_send_mail = tbit_data_retrivedata('gsp_lms_email_become_an_student_send_mail');
  									if($gsp_lms_email_become_an_student_send_mail !=''){
  										$json_decode = json_decode($gsp_lms_email_become_an_student_send_mail,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$become_an_student_send_mail_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$become_an_student_send_mail_subject = $json_decode['subject'];
  										}
  									}
  									?>
  									<input type="checkbox" name="gsp_lms_email_become_an_student_send_mail[enable]" id="gsp_lms_email_become_an_student_send_mail[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($become_an_student_send_mail_enable); ?>>
									<label for="gsp_lms_email_become_an_student_send_mail[enable]">
									Become an student Send email.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_become_an_student_send_mail[subject]" id="gsp_lms_email_become_an_student_send_mail[subject]" value="<?php echo esc_attr($become_an_student_send_mail_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_email_become_an_student_send_mail_email_content_html";
									$name = 'gsp_lms_email_become_an_student_send_mail_email_content_html';
									$email_content_admin_html = '<p>You have successfully with {{site_title}}.</p>';
									$email_content_admin_html .= '<p>Please wait for admin approve.</p>'; 
									$gsp_lms_email_become_an_student_send_mail_email_content_html = tbit_data_retrivedata('gsp_lms_email_become_an_student_send_mail_email_content_html');
									$content = $gsp_lms_email_become_an_student_send_mail_email_content_html ? $gsp_lms_email_become_an_student_send_mail_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_email_become_an_student_send_mail_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
						<button  class="button button-primary">Save settings</button>
					</p>
  					</form>
  					<div class="clear"></div>
  					</div>



  					<div class="email_contentbox become_an_student_request" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php 
  									$become_an_student_enable = '';
  									$become_an_student_subject = '[{{site_title}}] Request to become an student';
  									$gsp_lms_email_become_an_student = tbit_data_retrivedata('gsp_lms_email_become_an_student');
  									if($gsp_lms_email_become_an_student !=''){
  										$json_decode = json_decode($gsp_lms_email_become_an_student,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$become_an_student_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$become_an_student_subject = $json_decode['subject'];
  										}
  									}
  									?>
  									<input type="checkbox" name="gsp_lms_email_become_an_student[enable]" id="gsp_lms_email_become_an_student[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($become_an_student_enable); ?>>
									<label for="gsp_lms_email_become_an_student[enable]">
									Become an student email.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_become_an_student[subject]" id="gsp_lms_email_become_an_student[subject]" value="<?php echo esc_attr($become_an_student_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_email_become_an_student_email_content_html";
									$name = 'gsp_lms_email_become_an_student_email_content_html';
									$email_content_admin_html = '<p>User {{request_email}} has requested to become an Student at {{site_title}}</p>';
									$email_content_admin_html .= '<p>Please login to {{site_title}} and access user to manage the requesting.</p>'; 
									$gsp_lms_email_become_an_student_email_content_html = tbit_data_retrivedata('gsp_lms_email_become_an_student_email_content_html');
									$content = $gsp_lms_email_become_an_student_email_content_html ? $gsp_lms_email_become_an_student_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_email_become_an_student_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
						<button  class="button button-primary">Save settings</button>
					</p>
  					</form>
  					<div class="clear"></div>
  					</div>

  					<div class="email_contentbox become_an_student_accepted" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php 
  									$become_an_student_accepted_enable = '';
  									$become_an_student_accepted_subject = '[{{site_title}}] Your request to become an student accepted';
  									$gsp_lms_email_become_an_student_accepted = tbit_data_retrivedata('gsp_lms_email_become_an_student_accepted');
  									if($gsp_lms_email_become_an_student_accepted !=''){
  										$json_decode = json_decode($gsp_lms_email_become_an_student_accepted,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$become_an_student_accepted_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$become_an_student_accepted_subject = $json_decode['subject'];
  										}
  									}
  									?>
  									<input type="checkbox" name="gsp_lms_email_become_an_student_accepted[enable]" id="gsp_lms_email_become_an_student_accepted[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($become_an_student_accepted_enable); ?>>
									<label for="gsp_lms_email_become_an_student_accepted[enable]">
									Become an student email accepted.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_become_an_student_accepted[subject]" id="gsp_lms_email_become_an_student_accepted[subject]" value="<?php echo esc_attr($become_an_student_accepted_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_email_become_an_student_accepted_email_content_html";
									$name = 'gsp_lms_email_become_an_student_accepted_email_content_html';
									$email_content_admin_html = '<p>Congrats! You become an Student at <strong>{{site_title}}</strong></p>';
									$email_content_admin_html .= '<p>Please <a href="{{login_url}}">login</a> to <strong>{{site_title}}</strong> and start learning</p>'; 
									$gsp_lms_email_become_an_student_accepted_email_content_html = tbit_data_retrivedata('gsp_lms_email_become_an_student_accepted_email_content_html');
									$content = $gsp_lms_email_become_an_student_accepted_email_content_html ? $gsp_lms_email_become_an_student_accepted_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_email_become_an_student_accepted_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
						<button  class="button button-primary">Save settings</button>
					</p>
  					</form>
  					<div class="clear"></div>
  					</div>


  					<div class="email_contentbox become_an_student_denied" >
  					<form method="post">
  					<table class="e_s_r_table">
  						<tbody>
  							<tr>
  								<th>Enable/Disable</th>
  								<td>
  									<?php 
  									$become_an_student_denied_enable = '';
  									$become_an_student_denied_subject = '[{{site_title}}] Your request to become an student denied';
  									$gsp_lms_email_become_an_student_denied = tbit_data_retrivedata('gsp_lms_email_become_an_student_denied');
  									if($gsp_lms_email_become_an_student_denied !=''){
  										$json_decode = json_decode($gsp_lms_email_become_an_student_denied,true);
  										if(isset($json_decode['enable']) && $json_decode['enable'] ==1){
  											$become_an_student_denied_enable = 'checked';
  										}
  										if(isset($json_decode['subject']) && $json_decode['subject'] !=''){
  											$become_an_student_denied_subject = $json_decode['subject'];
  										}
  									}
  									?>
  									<input type="checkbox" name="gsp_lms_email_become_an_student_denied[enable]" id="gsp_lms_email_become_an_student_denied[enable]" value="1" class="admin_checkbox" <?php echo esc_attr($become_an_student_denied_enable); ?>>
									<label for="gsp_lms_email_become_an_student_denied[enable]">
									Become an student email denied.</label>
  								</td>
  							</tr>
  							<tr>
  								<th>Subject</th>
  								<td>
  									<input type="text" name="gsp_lms_email_become_an_student_denied[subject]" id="gsp_lms_email_become_an_student_denied[subject]" value="<?php echo esc_attr($become_an_student_denied_subject); ?>" class="email_text">
  								</td>
  							</tr>
  							<tr>
  								<th></th>
  								<td>
									<?php 
									$id = "gsp_lms_email_become_an_student_denied_email_content_html";
									$name = 'gsp_lms_email_become_an_student_denied_email_content_html';
									$email_content_admin_html = '<p>Your Become an student request at <strong>{{site_title}}</strong> has been denied</p>';
									$gsp_lms_email_become_an_student_denied_email_content_html = tbit_data_retrivedata('gsp_lms_email_become_an_student_denied_email_content_html');
									$content = $gsp_lms_email_become_an_student_denied_email_content_html ? $gsp_lms_email_become_an_student_denied_email_content_html : $email_content_admin_html;
									$settings = array('tinymce' => true, 'textarea_name' => "gsp_lms_email_become_an_student_denied_email_content_html",'editor_height' => 250);
									wp_editor(stripslashes($content), $id, $settings);
									?>
									<div class="gsp_lms-email-templates">

									<div class="gsp_lms-email-template html multipart">

									<ol class="gsp_lms-email-variables has-editor" data-target="gsp_lms_emails_new-order-adminemail_content-html">
									<li data-variable="{{site_url}}">
									<code>{{site_url}}</code></li>
									<li data-variable="{{site_title}}">
									<code>{{site_title}}</code></li>
									<li data-variable="{{login_url}}">
									<code>{{login_url}}</code></li>
									<li data-variable="{{site_admin_email}}">
									<code>{{site_admin_email}}</code></li>
									<li data-variable="{{site_admin_name}}">
									<code>{{site_admin_name}}</code></li>
									<li data-variable="{{username}}">
									<code>{{username}}</code></li>
									</ol>
									</div>
									</div>
  								</td>
  							</tr>
  						</tbody>
  					</table>
  					<p class="gsp-admin-settings-buttons">
						<button  class="button button-primary">Save settings</button>
					</p>
  					</form>
  					<div class="clear"></div>
  					</div>


  					<!-- Student Email Settings End -->

  					<div class="clear"></div>
  				</div>
  			</div>
  			<div class="clear"></div>
  		</div>
  	</div>

    <div role="tabpanel" class="tab-pane" id="certificate_tab">

    	<h3>Certificate Settings</h3>
    	<form action="" method="POST">
    	<div class="paypal_box">

    		<label class="col-sm-2">Certificate Website Name</label>

    		<div class="col-sm-10">

    		<input type="text" class="form-control" name="gsp_certificate_website_name" id="gsp_certificate_website_name" placeholder="Certificate website Name" value="<?php echo esc_attr(tbit_data_retrivedata('gsp_certificate_website_name'));?>">


    		</div>

    	<div class="clear"></div>

    	</div>

    	<div class="paypal_box">

    		<label class="col-sm-2">Certificate Content</label>

    		<div class="col-sm-10">

    		<textarea class="form-control" rows="15" name="gsp_certificate_conetnt"  id="gsp_certificate_conetnt"  placeholder="Certificate Content" > <?php echo esc_attr(tbit_data_retrivedata('gsp_certificate_conetnt'));?></textarea>
    		<p>Please Enter shortcode for Couse Name, Assesment. like {{cousename}}, {{assesmentname}}</p>

    		</div>

    	<div class="clear"></div>

    	</div>

    	<div class="paypal_box">

    		<label class="col-sm-2">Certificate Logo</label>

    		<div class="col-sm-10">

    		<?php
    		$gsp_certificate_logo = tbit_data_retrivedata('gsp_certificate_logo');
    		?>

    		<button id="" type="button" class="btn btn-primary misha-upl"><?php if($gsp_certificate_logo == ''){ ?>Logo Upload <?php } else {?> <div class="logo_img"><span class="misha-upl_close"><i class="fa fa-times"></i></span><img src="<?php echo esc_url($gsp_certificate_logo); ?>"></div> <?php }?></button>
    		<input type="hidden" name="gsp_certificate_logo" id="gsp_certificate_logo" value="<?php echo esc_url($gsp_certificate_logo); ?>">


    		</div>

    	<div class="clear"></div>

    	</div>


    	<div class="col-sm-2 margin-top-20">
    		<input type="hidden" name="certificate_tab">
    		<input type="submit" name="submit" value="Save settings" class="btn btn-primary">

    	</div>
    	</form>
    </div>

    <div role="tabpanel" class="tab-pane" id="paymentsettings">

    	<h3>Paypal Standrad</h3>

    	

    	<form action="" method="POST">

    	<div class="paypal_box">

    		<label class="col-sm-2">Paypal enable</label>

    		<div class="col-sm-10">

    			<input type="checkbox" name="gsp_paypal_enable" id="gsp_paypal_enable" value="enable" <?php if(tbit_data_retrivedata('gsp_paypal_enable')=='enable'){ echo 'checked'; }?>>

    			Enable Paypal Payment 

    		</div>

    	<div class="clear"></div>

    	</div>

    	<div class="paypal_box">

    		<label class="col-sm-2">Paypal Test mode enable</label>

    		<div class="col-sm-10">

    		<input type="checkbox" name="gsp_paypal_enable_test_mode" id="gsp_paypal_enable_test_mode" value="enable" <?php if(tbit_data_retrivedata('gsp_paypal_enable_test_mode')=='enable'){ echo 'checked'; }?>>

    			Enable Paypal Test mode 

    		</div>

    	<div class="clear"></div>
    	</div>

    	<div class="paypal_box">

    		<label class="col-sm-2">Paypal Receiver Email</label>

    		<div class="col-sm-10">

    			<input type="text" name="gsp_paypal_receiver_email" id="gsp_paypal_receiver_email" placeholder="Paypal Receiver" value="<?php echo esc_attr(tbit_data_retrivedata('gsp_paypal_receiver_email'));?>">

    		</div>

    	<div class="clear"></div>

    	</div>

    	<h3>Stripe configartion</h3>

    	<div class="stripe_box">

    		<label class="col-sm-2">Stripe enable</label>

    		<div class="col-sm-10">
			<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
    			$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_enable_field');
    			echo html_entity_decode(esc_html($return_field));
    		 } else {
    			$required_text = Tbit_lms_require_pro_version_text();
    			echo html_entity_decode(esc_html($required_text));
    		}?>

    		</div>

    	<div class="clear"></div>
    	</div>

    	<div class="stripe_box">

    		<label class="col-sm-2">Stripe Test mode enable</label>

    		<div class="col-sm-10">

    		<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
    			$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_test_mode_enable_field');
    			echo html_entity_decode(esc_html($return_field));
    		 } else {
    			$required_text = Tbit_lms_require_pro_version_text();
    			echo html_entity_decode(esc_html($required_text));
    		}?>

    		</div>

    	<div class="clear"></div>
    	</div>

    	<div class="stripe_box">

    		<label class="col-sm-2">Stripe Test Secret Key</label>

    		<div class="col-sm-10">

    		<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
    			$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_test_secret_key_field');
    			echo html_entity_decode(esc_html($return_field));
    		 } else {
    			$required_text = Tbit_lms_require_pro_version_text();
    			echo html_entity_decode(esc_html($required_text));
    		}?>

    		</div>

    	<div class="clear"></div>
    	</div>

    	<div class="stripe_box">

    		<label class="col-sm-2">Stripe Test Publishable Key</label>

    		<div class="col-sm-10">

    		<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
    			$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_test_publishable_key_field');
    			echo html_entity_decode(esc_html($return_field));
    		 } else {
    			$required_text = Tbit_lms_require_pro_version_text();
    			echo html_entity_decode(esc_html($required_text));
    		}?>

    		</div>

    	<div class="clear"></div>
    	</div>

    	<h4>Stripe Live Mode</h4>

    	<div class="stripe_box">
    		<label class="col-sm-2">Stripe Secret Live Key</label>
    		<div class="col-sm-10">
    			
				<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
				$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_live_secret_key_field');
				echo html_entity_decode(esc_html($return_field));
				} else {
				$required_text = Tbit_lms_require_pro_version_text();
				echo html_entity_decode(esc_html($required_text));
				}?>
    		</div>
    	<div class="clear"></div>
    	</div>
    	<div class="stripe_box">
    		<label class="col-sm-2">Stripe Publishable Live Key</label>
    		<div class="col-sm-10">
    		<?php if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
				$return_field = Tbit_quick_learn_return_pro_verison_input_field('stripe_live_publishable_key_field');
				echo html_entity_decode(esc_html($return_field));
			} else {
				$required_text = Tbit_lms_require_pro_version_text();
				echo html_entity_decode(esc_html($required_text));
			}?>
    		</div>
    	<div class="clear"></div>
    	</div>
    	<div class="col-sm-2 margin-top-20">
    		<input type="submit" name="submit" value="Save settings" class="btn btn-primary">
    	</div>
    	</form>
    </div>
  
  <div role="tabpanel" class="tab-pane" id="advanced_tab">
  	<h3>Style</h3>
  	<form method="post">

		<div class="admin_setting_box">
			<label class="col-sm-2"> Primary color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$primary_color = '#337ab7';
			$gsp_primary_color = tbit_data_retrivedata('gsp_primary_color');
			if($gsp_primary_color){
				$primary_color = $gsp_primary_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_primary_color" value="<?php echo esc_attr($primary_color); ?>">
			<input type="text" name="gsp_primary_color" value="<?php echo esc_attr($primary_color); ?>" class="width75px gsp_primary_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Secondary color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$secondary_color = '#333333';
			$gsp_secondary_color = tbit_data_retrivedata('gsp_secondary_color');
			if($gsp_secondary_color){
				$secondary_color = $gsp_secondary_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_secondary_color" value="<?php echo esc_attr($secondary_color); ?>">
			<input type="text" name="gsp_secondary_color"  value="<?php echo esc_attr($secondary_color); ?>" class="width75px gsp_secondary_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Button text color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$button_text_color = '#ffffff';
			$gsp_button_text_color = tbit_data_retrivedata('gsp_button_text_color');
			if($gsp_button_text_color){
				$button_text_color = $gsp_button_text_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_button_text_color" value="<?php echo esc_attr($button_text_color); ?>">
			<input type="text" name="gsp_button_text_color"value="<?php echo esc_attr($button_text_color); ?>" class="width75px gsp_button_text_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Button background color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$button_bc_color = '#007bff';
			$gsp_button_background_color = tbit_data_retrivedata('gsp_button_background_color');
			if($gsp_button_background_color){
				$button_bc_color = $gsp_button_background_color;
			}
			?>
			
			<input type="color"  class="s_color_box" id="gsp_button_background_color" value="<?php echo esc_attr($button_bc_color); ?>">
			<input type="text" name="gsp_button_background_color" value="<?php echo esc_attr($button_bc_color); ?>" class="width75px gsp_button_background_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Button hover text color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$button_hover_text_color = '#ffffff';
			$gsp_button_hover_text_color = tbit_data_retrivedata('gsp_button_hover_text_color');
			if($gsp_button_hover_text_color){
				$button_hover_text_color = $gsp_button_hover_text_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_button_hover_text_color" value="<?php echo esc_attr($button_hover_text_color); ?>">
			<input type="text" name="gsp_button_hover_text_color"  value="<?php echo esc_attr($button_hover_text_color); ?>" class="width75px gsp_button_hover_text_color">
			</div>
			<div class="clear"></div>
		</div>


		<div class="admin_setting_box">
			<label class="col-sm-2"> Button hover background color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$button_hover_bc_color = '#414141';
			$gsp_button_hover_background_color = tbit_data_retrivedata('gsp_button_hover_background_color');
			if($gsp_button_hover_background_color){
				$button_hover_bc_color = $gsp_button_hover_background_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_button_hover_background_color" value="<?php echo esc_attr($button_hover_bc_color); ?>">
			<input type="text" name="gsp_button_hover_background_color" value="<?php echo esc_attr($button_hover_bc_color); ?>" class="width75px gsp_button_hover_background_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Favourite icon color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$favourite_icon_color = '#007bff';
			$gsp_favourite_icon_color = tbit_data_retrivedata('gsp_favourite_icon_color');
			if($gsp_favourite_icon_color){
				$favourite_icon_color = $gsp_favourite_icon_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_favourite_icon_color" value="<?php echo esc_attr($favourite_icon_color); ?>">
			<input type="text" name="gsp_favourite_icon_color"  value="<?php echo esc_attr($favourite_icon_color); ?>" class="width75px gsp_favourite_icon_color">
			</div>
			<div class="clear"></div>
		</div>

		<div class="admin_setting_box">
			<label class="col-sm-2"> Favourite active icon color </label>
			<div class="col-sm-10 d-flex">
			<?php 
			$favourite_active_icon_color = '#ef4c4c';
			$gsp_favourite_active_icon_color = tbit_data_retrivedata('gsp_favourite_active_icon_color');
			if($gsp_favourite_active_icon_color){
				$favourite_active_icon_color = $gsp_favourite_active_icon_color;
			}
			?>
			<input type="color"  class="s_color_box" id="gsp_favourite_active_icon_color" value="<?php echo esc_attr($favourite_active_icon_color); ?>">
			<input type="text" name="gsp_favourite_active_icon_color" value="<?php echo esc_attr($favourite_active_icon_color); ?>" class="width75px gsp_favourite_active_icon_color">
			</div>
			<div class="clear"></div>
		</div>

		<p class="gsp-admin-settings-buttons margin-top-10">
			<button  class="button button-primary">Save settings</button>
		</p>

  	</form>
  </div>
  </div>
 </div>
</div>
<?php } }


if( !function_exists('Tbit_lms_user_assement_block')){
function Tbit_lms_user_assement_block(){
wp_register_style('Tbit_lms_admin_user_table',  plugins_url( 'assets/css/admin_user_table.css', __FILE__ ));
wp_enqueue_style('Tbit_lms_admin_user_table');


	?>

	<div class="table_userbox">

	<?php

	global $wpdb;

	if(isset($_GET['user_id']) && $_GET['user_id'] !='' ){
	$user_id = sanitize_text_field($_GET['user_id']);
	?>



	<div class="my-box-bg">

	<h2 class="heading-cont">Assessments</h2>

	<!-- Tab panes -->

	<div class="tab-content">

	<div id="home" class="container tab-pane active">

	<table class="gsp_lms_tb-list-table profile-list-quizzes profile-list-table">

	<thead>

	<tr>

	<th class="column-course">Course</th>

	<th class="column-quiz">Quiz</th>

	<th class="column-date">Date</th>

	<th class="column-status">Progress</th>

	<th class="column-time-interval">Interval</th>

	<th class="column-time-interval">Result</th>

	</tr>

	</thead>

	<tbody>

		<tbody>



						<?php
						$prepare_sql = $wpdb->prepare("SELECT gui.*,guim.* FROM ".$wpdb->prefix."gsp_user_items gui LEFT JOIN ".$wpdb->prefix."gsplms_section_items gsi ON gui.item_id = gsi.item_id LEFT JOIN ".$wpdb->prefix."gsp_user_itemmeta guim ON gui.user_item_id = guim.gsp_user_item_id WHERE gsi.section_id=%s AND gui.user_id=%s AND guim.meta_key =%s GROUP BY gui.user_item_id",2,$user_id,'results');

						$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

						if(count($get_results)>0){

							foreach ($get_results as $key => $value) {
							$course_id = $value['ref_id'];
							$end_date = $value['end_time'];
							$date=date_create($end_date);
							$date_formate = date_format($date,"M d, Y");
							$meta_value = unserialize($value['meta_value']);
						?>
						<tr>
						<td class="column-course"><a href="<?php echo esc_url(get_permalink($course_id));?>"><?php echo esc_html(get_the_title($course_id));?></a></td>
						<td class="column-quiz column-quiz-1194"><a href=""><?php echo esc_html(get_the_title($value['item_id']));?></a></td>
						<td class="column-date"><?php echo esc_html($date_formate);?></td>
						<td class="column-status"><span class="result-percent"><?php echo esc_html(round($meta_value['result'],2));?>%</span><span class="gsp_lms_tb-label label-completed"><?php echo esc_html($value['status']); ?></span></td>

						<td class="column-time-interval"><?php echo esc_html($meta_value['time_spend']); ?></td>

						<td class="column-time-interval"><?php echo esc_html($meta_value['grade_text']); ?></td>

						</tr>



						<?php } } else {?> 

							<tr>

								<td colspan="6" class="text-center"> No Assements </td>

							</tr>

						<?php } ?>

						</tbody>

	</tbody>



	</table>



	</div>

	</div>

</div>

<?php }  else {?>

<div class="user_table">

	<table border="1" class="width-100-zeroborder">

		<thead>

			<tr>

				<th>No.</th>

				<th>User Name</th>

			</tr>

		</thead>

		<tbody>

			<?php

			$get_results = $wpdb->get_results('SELECT user_id FROM '.$wpdb->prefix.'gsp_user_items GROUP BY user_id',ARRAY_A);

			

			if(count($get_results)>0){

				$kk= 1;

			foreach ($get_results as $key => $value) {
			$user_data = get_userdata($value['user_id']);
			?>

			<tr>

				<td><?php echo esc_html($kk);?></td>

				<td><a href="?page=user_assement&user_id=<?php echo esc_attr($value['user_id']);?>"><?php echo esc_html($user_data->data->display_name);?></a></td>

			</tr>

		<?php $kk++; } }?>

		</tbody>

	</table>

</div>

<?php }?>

</div>

<?php }
}





add_action( 'init', 'Tbit_lms_create_new_role' );




if( !function_exists('Tbit_lms_update_section_data_function')){
function Tbit_lms_update_section_data_function(){

	if(isset($_POST['section_name']) && $_POST['section_name'] !=''){

		$section_name = sanitize_title($_POST['section_name']);
		$section_description = '';
		$section_id = '';
		if(isset($_POST['section_description']) && !empty($_POST['section_description'])){
			$section_description = sanitize_textarea_field($_POST['section_description']);
		}

		if(isset($_POST['section_id']) && !empty($_POST['section_id'])){
			$section_id = sanitize_text_field($_POST['section_id']);
		}



		global $wpdb;

		$tablename=$wpdb->prefix.'gsplms_sections';

		$wpdb->update($tablename,array(

			'section_name' => $section_name,

			'section_description' => $section_description,

		),

		array(

			'section_id' => $section_id

		)

	);

	}

	die;

	

}
}


add_action('wp_ajax_order_status_change','tbit_lms_order_status_change');
if(!function_exists('tbit_lms_order_status_change')){
	function tbit_lms_order_status_change(){
		global $wpdb;
		$response = 0;
		if(isset($_POST['order_id']) && !empty($_POST['order_id'])>0){
			$order_id = sanitize_text_field($_POST['order_id']);
			$user_id=get_current_user_id();
			if(isset($_POST['status']) && !empty($_POST['status'])){
				$status = sanitize_text_field($_POST['status']);
				$args = array(
					'payment_status' => $status
				);
				$where = array(
					'order_id' => $order_id,
				);
				$result = $wpdb->update($wpdb->prefix.'user_payments',$args,$where);
				if($result){
					$response = 1;
				}
			}

		}
		echo esc_html($response);
		wp_die();
	}
}


add_action('wp_ajax_insertlesstinandtest', 'Tbit_lms_insert_section_item_function');


if( !function_exists('Tbit_lms_insert_section_item_function')){
function Tbit_lms_insert_section_item_function(){

	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['lessionandtesttitle']) && $_POST['lessionandtesttitle'] !=''){

		global $wpdb;



		$post_type= sanitize_text_field($_POST['type']);

		$user_id=get_current_user_id();

		$title= sanitize_title($_POST['lessionandtesttitle']);

		$args = array(

            'post_type'    => $post_type,

            'post_author'  => $user_id,

            'post_status'  => 'publish',

            'content'      => '',

            'post_title'   => $title

            );



		$post_id=wp_insert_post($args);



		if($post_type=='lms-lessons'){

			$section_id=1;

		} else {

			$section_id=2;

		}
		$course_id = 0;
		if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
			$course_id= sanitize_text_field($_POST['course_id']);
		}

		

		$wpdb->insert($wpdb->prefix.'gsplms_section_items',array(

                'section_id' => $section_id,

                'item_id' => $post_id,

                'item_order' => 0,

                'item_type' => $post_type,

                'course_id' =>$course_id,

            ));

	}
	$lastid = $post_id;

	$item_orderid=0;

	if($post_type == 'lms-lessons'){

		$post_type='gsp_lms_tb_lesson';

	} else {

		$post_type='lms-assesments';

		

	}

	$href=get_edit_post_link($lastid);

	$data=require_once('inc/admin/template-part/course_section_item.php');

	die;

}
}

add_action('wp_ajax_addandremovewishlist', 'Tbit_lms_addandremovewishlist');
if( !function_exists('Tbit_lms_addandremovewishlist')){
function Tbit_lms_addandremovewishlist()
{

	
	if(isset($_POST['course_id']) && $_POST['course_id'] !=''){
		global $wpdb;
		$user_id=get_current_user_id();
		$course_id = sanitize_text_field($_POST['course_id']);
		$prepare_sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE course_id=%s AND user_id=%s',$course_id,$user_id);
		$results = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($results)>0){
			$table = $wpdb->prefix.'gsp_lms_wishlist';
			$wpdb->delete( $table, array( 'course_id' => $course_id, 'user_id' => $user_id  ) );
			echo 2;
		} else {
			$array = array( 
				'course_id' => $course_id,
				 'user_id' => $user_id 
				 );
			$table = $wpdb->prefix.'gsp_lms_wishlist';
			$wpdb->insert($table,$array);
			echo 1;
		}
		wp_die();

	}


}
}



add_action('wp_ajax_login', 'Tbit_lms_login');
add_action( 'wp_ajax_nopriv_login', 'Tbit_lms_login' ); 
if( !function_exists('Tbit_lms_login')){
function Tbit_lms_login()
{
	if(isset($_POST['login']) && $_POST['login'] == 'Login'){
		$creds = array();
		$user_nicename = sanitize_title($_POST['user_nicename']);
		$user_pass = sanitize_text_field($_POST['user_pass']);
		$creds['user_login'] = isset( $_POST['user_nicename'] ) ? $user_nicename : '';
		$creds['user_password'] = isset( $_POST['user_pass'] ) ? $user_pass : '';
		$creds['remember'] = isset( $_POST['rememberme'] ) ? true : false;
		$user = wp_signon( $creds, true );
		$data['error'] = array();
		if ( is_wp_error( $user ) ) {
		error_log( $user->get_error_message() );

		if(isset($user->errors['invalid_username'])){
			$data['error'][] = $user->errors['invalid_username'][0];
		}
		if(isset($user->errors['incorrect_password'])){
			$data['error'][] = '<strong>Error:</strong> The password you entered for the username '.$user_nicename.' is incorrect.';
		}
		if(isset($user->errors['empty_username'])){
			$data['error'][] = $user->errors['empty_username'][0];
		}
		if(isset($user->errors['empty_password'])){
			$data['error'][] = $user->errors['empty_password'][0];
		}

		if(isset($user->errors['authentication_failed'])){
			$data['error'][] = $user->errors['authentication_failed'][0];
		}

			echo json_encode($data);
		} else {

			if(in_array('instructor', $user->roles)){
				$getusermeta = get_user_meta($user->ID,'tbit_user_status',true);
				if($getusermeta == 1){
				echo 1;
				} else if($getusermeta == 2) {
				wp_logout();
				$data['error'][] = 'Disapproved your account by Admin!';
				echo json_encode($data);
				} else {
				wp_logout();
				$data['error'][] = 'Admin not yet approved your account!';
				echo json_encode($data);
				}
			} else {
				echo 1;
			}
			
			
		}
		wp_die();

	}
}
}




add_action('wp_ajax_deletesectionitem', 'Tbit_lms_delete_section_item_function');
if( !function_exists('Tbit_lms_delete_section_item_function')){
function Tbit_lms_delete_section_item_function(){

	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['section_id']) && $_POST['section_id'] !=''){

		global $wpdb;

		$post_type= sanitize_text_field($_POST['type']);

		$section_id= sanitize_text_field($_POST['section_id']);

		$deletetype = '';

		if(isset($_POST['deletetype']) && !empty($_POST['deletetype'])){
		$deletetype= sanitize_text_field($_POST['deletetype']);
	}
	$item_id = '';

	if(isset($_POST['item_id']) && !empty($_POST['item_id'])){
		$item_id= sanitize_text_field($_POST['item_id']);
	}
	$course_id = '';
	if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
		$course_id= sanitize_text_field($_POST['course_id']);
	}

		if($deletetype=='permanently'){

			$wpdb->delete($wpdb->prefix.'posts',array('ID'=>$item_id));

			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('item_id'=>$item_id,'course_id'=>$course_id));

		} else {

			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('item_id'=>$item_id,'course_id'=>$course_id));

		}
	}

	echo 'yes';

	die;
}
}

add_action('wp_ajax_deletesection', 'Tbit_lms_delete_section_function');
if( !function_exists('Tbit_lms_delete_section_function')){
function Tbit_lms_delete_section_function(){

	if(isset($section_item_id) && $section_item_id !=''){
		$section_item_id = $section_item_id;
	} else {
		$section_item_id = 0;
	}

	if(isset($section_id) && $section_id !=''){
		$section_id = $section_id;
	} else {
		$section_id = 0;
	}

			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('section_item_id'=>$section_item_id));

			$wpdb->delete($wpdb->prefix.'gsplms_sections',array('section_id'=>$section_id));

		}
	}

add_action('wp_ajax_getselectionbox', 'Tbit_lms_getselectionbox_function');
if( !function_exists('Tbit_lms_getselectionbox_function')){
function Tbit_lms_getselectionbox_function(){



	if(isset($_POST['type']) && $_POST['type'] !=''){

		global $wpdb,$current_user;
		$current_user_roles = $current_user->roles;
		$user_id=get_current_user_id();



		$type= sanitize_text_field($_POST['type']);
		$course_id = 0;
		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
			$course_id= sanitize_text_field($_POST['course_id']);
		}

		if($type=='lession'){
			$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE course_id=%s AND section_id=%s",$course_id,1);
			$excludedata=$wpdb->get_results($prepare_sql,ARRAY_A);



			$excludelessiondata=array();

			if(count($excludedata)>0){

				foreach ($excludedata as $key => $value) {

					$excludelessiondata[]=$value['item_id'];

				}

			}

			if(count($excludelessiondata)>0){

				$excludelessiondata=implode(',', $excludelessiondata);
				

				if(in_array('administrator', $current_user_roles)){
					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND ID NOT IN (".$excludelessiondata.")",'lms-lessons','publish');
					$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);
				} else {
					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND post_author=%s AND ID NOT IN (".$excludelessiondata.")",'lms-lessons','publish',$user_id);
					$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);
				}
				$alldata=$lessiondata;

			} else {
				if(in_array('administrator', $current_user_roles)){

					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s",'lms-lessons','publish');
					$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);

				} else {

					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND post_author=%s",'lms-lessons','publish',$user_id);
					$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);
				}

				$alldata=$lessiondata;

			}

		}

		if($type=='assesment'){


			$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE course_id=%s AND section_id=%s",$course_id,2);
			$excludedata=$wpdb->get_results($prepare_sql,ARRAY_A);

			$excludeassesmentdata=array();

			if(count($excludedata)>0){

				foreach ($excludedata as $key => $value) {

					$excludeassesmentdata[]=$value['item_id'];

				}

			}

			if(count($excludeassesmentdata)>0){

				$excludeassesmentdata=implode(',', $excludeassesmentdata);
				if(in_array('administrator', $current_user_roles)){

				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND ID NOT IN (".$excludeassesmentdata.")",'lms-assesments','publish');

				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
				} else {
					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s  AND post_author=%s AND post_status=%s AND ID NOT IN (".$excludeassesmentdata.")",'lms-assesments',$user_id,'publish');
					$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
				}

				$alldata=$assesmentdata;

			} else {
				if(in_array('administrator', $current_user_roles)){

				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s",'lms-assesments','publish');
				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
				} else {
					$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_author=%s AND post_status=%s",'lms-assesments',$user_id,'publish');
					$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
				}

				$alldata=$assesmentdata;

			}

			

		}

		$type=$type;

		$data=require_once('inc/admin/template-part/selectlessionandassesments.php');

	}

	die;
}
}

add_action('wp_ajax_insertdatainlessionassesments', 'Tbit_lms_insertdatainlessionassesments_function');


if( !function_exists('Tbit_lms_insertdatainlessionassesments_function')){
function Tbit_lms_insertdatainlessionassesments_function(){

	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['section_id']) && $_POST['section_id'] !=''){

		global $wpdb;

		$post_type= sanitize_text_field($_POST['type']);

		$section_id= sanitize_text_field($_POST['section_id']);
		$course_id = 0;

		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
				$course_id=$_POST['course_id'];
		}

		if(isset($_POST['targetids']) && count($_POST['targetids'])>0){

			$datahtml='';

			foreach ($_POST['targetids'] as $key => $value) {

				$title=get_the_title($value);

				$wpdb->insert($wpdb->prefix.'gsplms_section_items',array(

				'section_id' => $section_id,

				'item_id' => $value,

				'item_order' => 0,

				'item_type' => $post_type,

				'course_id' =>$course_id,

				));

				$lastid = $wpdb->insert_id;

				$item_orderid=0;
				if($post_type == 'lms-lessons'){
					$post_type1='gsp_lms_tb_lesson';
				} else {
					$post_type1='lms-assesments';
				}
				$href=get_edit_post_link($lastid);

				$datahtml .='<li data-item-id="'.esc_attr($lastid).'" data-item-order="'.esc_attr($item_orderid).'" class="section-item '.esc_attr($post_type1).'">
				<div class="drag gsp_lms_tb-sortable-handle">

				<svg viewBox="0 0 32 32" class="svg-icon">

				<path d="M 14 5.5 a 3 3 0 1 1 -3 -3 A 3 3 0 0 1 14 5.5 Z m 7 3 a 3 3 0 1 0 -3 -3 A 3 3 0 0 0 21 8.5 Z m -10 4 a 3 3 0 1 0 3 3 A 3 3 0 0 0 11 12.5 Z m 10 0 a 3 3 0 1 0 3 3 A 3 3 0 0 0 21 12.5 Z m -10 10 a 3 3 0 1 0 3 3 A 3 3 0 0 0 11 22.5 Z m 10 0 a 3 3 0 1 0 3 3 A 3 3 0 0 0 21 22.5 Z"></path>

				</svg>

				</div>

				<div class="icon"></div>

				<div class="title">

				<input type="text" value="'.esc_attr($title).'">

				</div>

				<div class="item-actions">

				<div class="actions">



				<div data-content-tip="Edit item" class="action edit-item gsp_lms_tb-title-attr-tip ready">

				<a href="'.esc_url($href).'" target="_blank" class="gsp_lms_tb-btn-icon dashicons dashicons-edit"></a>

				</div>

				<div class="action delete-item">

				<a class="gsp_lms_tb-btn-icon dashicons dashicons-trash"></a>

				<ul class="ui-sortable" style="">
				<li><a>Remove from course</a></li>
				<li><a class="delete-permanently">Move to trash</a></li>
				</ul>
				</div>
				</div>
				</div>
				</li>';
			}
		}
	}
	echo html_entity_decode(esc_html($datahtml));
	wp_die();
}
}

add_action('wp_ajax_searchquery', 'Tbit_lms_searchquery_function');
if( !function_exists('Tbit_lms_searchquery_function')){
function Tbit_lms_searchquery_function(){

	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['section_id']) && $_POST['section_id'] !=''){

		global $wpdb;

		$post_type= sanitize_text_field($_POST['type']);

		$section_id= sanitize_text_field($_POST['section_id']);
		$course_id = 0;
		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){

		$course_id=sanitize_text_field($_POST['course_id']);
	}
	$search = '';
	if(isset($_POST['search']) && !empty($_POST['search'])){
		$search=sanitize_text_field($_POST['search']);
	}


		$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s",$section_id,$course_id);
		$excludedata=$wpdb->get_results($prepare_sql,ARRAY_A);

		$excludedatanew=array();

		if(count($excludedata)>0){

		foreach ($excludedata as $key => $value) {

			$excludedatanew[]=$value['item_id'];

		}

		}

		$sql="SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type='".$post_type."' AND post_status='publish'";

		if($search !=''){

		$sql .=" AND post_title LIKE '%".$search."%'";

		}
		if(count($excludedatanew)>0){

		$excludedatanew=implode(',',$excludedatanew);

		$sql.=" AND ID NOT IN (".$excludedatanew.")";

		}

		$alldata=$wpdb->get_results($sql,ARRAY_A);

		$data=require_once('inc/admin/template-part/searchitem.php');

	}

	wp_die();
}
}

add_action('wp_ajax_insertqustionanswerstart', 'Tbit_lms_insertqustionanswerstart_function');
if( !function_exists('Tbit_lms_insertqustionanswerstart_function')){
function Tbit_lms_insertqustionanswerstart_function(){

	if(isset($_POST['question_id']) && $_POST['question_id']!=''){

		global $wpdb;
		$question_id=sanitize_text_field($_POST['question_id']);
		$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$question_id);
		$results=$wpdb->get_results($prepare_sql,ARRAY_A);

		if(count($results)>0){

		} else {

			update_post_meta($question_id,'gsplmsq_type','true_or_false');

			$true=array(

				'text' => 'True',

				'value' => 'true',

				'is_true' => 'yes',

			);

			$false=array(

				'text' => 'False',

				'value' => 'false',

				'is_true' =>''

			);

			$wpdb->insert($wpdb->prefix.'gsplms_question_answers',array(

				'question_id' => $question_id,

				'answer_data' => serialize($true),

			));

			$wpdb->insert($wpdb->prefix.'gsplms_question_answers',array(

				'question_id' => $question_id,

				'answer_data' => serialize($false),

			));

		}

	}

	wp_die();

}
}

add_action('wp_ajax_insertanswer_type', 'Tbit_lms_insertanswer_type_function');
if( !function_exists('Tbit_lms_insertanswer_type_function')){
function Tbit_lms_insertanswer_type_function(){

	if(isset($_POST['selectanswer_type']) && $_POST['selectanswer_type']!=''){

		global $wpdb;

		$selectanswer_type=sanitize_text_field($_POST['selectanswer_type']);

		
		$question_id = 0;
		if(isset($_POST['question_id']) && !empty($_POST['question_id'])){
				$question_id=sanitize_text_field($_POST['question_id']);
		}

		update_post_meta($question_id,'gsplmsq_type',$selectanswer_type);

		$getanswer_type=$selectanswer_type;

		$post_id=$question_id;

		if($getanswer_type=='true_or_false'){
			$ids = array();
		if(isset($_POST['getarray'])){

		$ids=$_POST['getarray'];
	}

		$ids = implode( ',', array_map( 'absint', $ids ) );

		$wpdb->query( "DELETE FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id='".$post_id."'  AND question_answer_id NOT IN($ids)" );

		}

		$data=require_once('inc/admin/template-part/questionrows.php');

	}

	wp_die();

}
}

add_action('wp_ajax_insertanswer_typenew', 'Tbit_lms_insertanswer_typenew_function');
if( !function_exists('Tbit_lms_insertanswer_typenew_function')){
function Tbit_lms_insertanswer_typenew_function(){

	if(isset($_POST['selectanswer_type']) && $_POST['selectanswer_type']!=''){

		global $wpdb;

		$selectanswer_type=sanitize_text_field($_POST['selectanswer_type']);
		$question_id = 0;
		if(isset($_POST['question_id']) && !empty($_POST['question_id'])){

		$question_id=sanitize_text_field($_POST['question_id']);

	}
		$getanswer_type=$selectanswer_type;

		$post_id=$question_id;

		

		$addnew=array(

		'text' => 'New Option',

		'value' => 'newoption',

		'is_true' =>''

		);

		$wpdb->insert($wpdb->prefix.'gsplms_question_answers',array(

		'question_id' => $question_id,

		'answer_data' => serialize($addnew),

		));
		$data=require_once('inc/admin/template-part/questionrows.php');
	}
	wp_die();
}
}

add_action('wp_ajax_questiontextchange', 'Tbit_lms_questiontextchange_function');

if( !function_exists('Tbit_lms_questiontextchange_function')){

function Tbit_lms_questiontextchange_function(){

	if(isset($_POST['text']) && $_POST['text']!=''){

		global $wpdb;

		$text=sanitize_text_field($_POST['text']);
		$answer_id=sanitize_text_field($_POST['answer_id']);
		$updatedata=array(

		'text' => $text,

		'value' => strtolower(str_replace(' ','',$text)),

		'is_true' =>''

		);

		$wpdb->update($wpdb->prefix.'gsplms_question_answers',array(

		'answer_data' => serialize($updatedata),

		),array(

			'question_answer_id' => $answer_id,

		));

	}
	wp_die();
}
}

add_action('wp_ajax_deletequestionoption', 'Tbit_lms_deletequestionoption_function');


if( !function_exists('Tbit_lms_deletequestionoption_function')){
function Tbit_lms_deletequestionoption_function(){

	if(isset($_POST['answer_id']) && $_POST['answer_id']!=''){

		global $wpdb;

		$answer_id=sanitize_text_field($_POST['answer_id']);

		$wpdb->delete($wpdb->prefix.'gsplms_question_answers',array(

			'question_answer_id' => $answer_id,

		));

$selectanswer_type = '';
if(isset($_POST['selectanswer_type']) && !empty($_POST['selectanswer_type'])){


		$selectanswer_type=sanitize_text_field($_POST['selectanswer_type']);

	}
$question_id = 0;
	if(isset($_POST['question_id']) && !empty($_POST['question_id'])){


		$question_id=sanitize_text_field($_POST['question_id']);

	}

		$getanswer_type=$selectanswer_type;

		$post_id=$question_id;
		$data=require_once('inc/admin/template-part/questionrows.php');

	}

	wp_die();

}
}



add_action('wp_ajax_updateanswerdata', 'Tbit_lms_updateanswerdata_function');


if( !function_exists('Tbit_lms_updateanswerdata_function')){
function Tbit_lms_updateanswerdata_function(){
	if(isset($_POST['answer_id']) && $_POST['answer_id']!=''){

		global $wpdb;

		$answer_id=sanitize_text_field($_POST['answer_id']);
		$selectanswer_type = '';

		if(isset($_POST['selectanswer_type']) && !empty($_POST['selectanswer_type'])){

		$selectanswer_type=sanitize_text_field($_POST['selectanswer_type']);

	}
$question_id = 0;
	if(isset($_POST['question_id']) && !empty($_POST['question_id'])){

		$question_id=sanitize_text_field($_POST['question_id']);

	}

	$is_true = false;
	if(isset($_POST['is_true']) && !empty($_POST['is_true'])){

		$is_true=sanitize_text_field($_POST['is_true']);

	}

		if($selectanswer_type=='single_choice' || $selectanswer_type=='true_or_false'){

		$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$question_id);
		$results=$wpdb->get_results($prepare_sql,ARRAY_A);

		if(count($results)>0){

			foreach ($results as $key => $value) {

				if($value['answer_data'] !=''){

					$updatedata=unserialize($value['answer_data']);

					if($value['question_answer_id']==$answer_id){

						$updatedata['is_true'] =$is_true;

					} else {

						$updatedata['is_true'] ='';

					}

					$wpdb->update($wpdb->prefix.'gsplms_question_answers',array(

					'answer_data' => serialize($updatedata),

					),array(

					'question_answer_id' => $value['question_answer_id'],

					));

				}

			}

		}



		} else {
			$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_answer_id=%s",$answer_id);
			$results=$wpdb->get_results($prepare_sql,ARRAY_A);

			if(count($results)>0){

				$unserialize=unserialize($results[0]['answer_data']);

				$unserialize['is_true'] = $is_true;

				$wpdb->update($wpdb->prefix.'gsplms_question_answers',array(

					'answer_data' => serialize($unserialize),

					),array(

					'question_answer_id' => $results[0]['question_answer_id'],

					));

			}

		}

		

	}

	wp_die();

}
}



add_action('wp_ajax_getassetmentselectionbox', 'Tbit_lms_getassetmentselectionbox_function');


if( !function_exists('Tbit_lms_getassetmentselectionbox_function')){
function Tbit_lms_getassetmentselectionbox_function(){



	if(isset($_POST['assesment_id']) && $_POST['assesment_id'] !=''){

		global $wpdb;



		$assesment_id=sanitize_text_field($_POST['assesment_id']);




		$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$assesment_id);
		$excludedata=$wpdb->get_results($prepare_sql,ARRAY_A);

			$excludeassesmentdata=array();

			if(count($excludedata)>0){

				foreach ($excludedata as $key => $value) {

					$excludeassesmentdata[]=$value['question_id'];

				}

			}

			if(count($excludeassesmentdata)>0){

				$excludeassesmentdata=implode(',', $excludeassesmentdata);
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND ID NOT IN (".$excludeassesmentdata.")",'lms-question','publish');
				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);

				$alldata=$assesmentdata;

			} else {
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s",'lms-question','publish');
				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);

				$alldata=$assesmentdata;

			}

			

		

		$type=$type;

		$data=require_once('inc/admin/template-part/selectquestion.php');

	}

	die;

}
}



add_action('wp_ajax_searchassesmentquery', 'Tbit_lms_searchassesmentquery_function');


if( !function_exists('Tbit_lms_searchassesmentquery_function')){
function Tbit_lms_searchassesmentquery_function(){

	if(isset($_POST['assesment_id']) && $_POST['assesment_id'] !=''){

		global $wpdb;



		$assesment_id=sanitize_text_field($_POST['assesment_id']);
		$search = '';
		if(isset($_POST['search']) && !empty($_POST['search'])){
			$search=sanitize_text_field($_POST['search']);
		}


		$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$assesment_id);
		$excludedata=$wpdb->get_results($prepare_sql,ARRAY_A);

			$excludeassesmentdata=array();

			if(count($excludedata)>0){

				foreach ($excludedata as $key => $value) {

					$excludeassesmentdata[]=$value['question_id'];

				}

			}

			if(count($excludeassesmentdata)>0){

				$excludeassesmentdata=implode(',', $excludeassesmentdata);

				$sql="SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type='lms-question' AND post_status='publish' AND ID NOT IN (".$excludeassesmentdata.")";

				



					if($search !=''){

					$sql .=" AND post_title LIKE '%".$search."%'";

					}

					$assesmentdata=$wpdb->get_results($sql,ARRAY_A);



				$alldata=$assesmentdata;

			} else {



				$sql="SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type='lms-question' AND post_status='publish'";

				



					if($search !=''){

					$sql .=" AND post_title LIKE '%".$search."%'";

					}

				$assesmentdata=$wpdb->get_results($sql,ARRAY_A);

				$alldata=$assesmentdata;

			}

		$data=require_once('inc/admin/template-part/searchquestion.php');

	}

	die;
}
}







add_action('wp_ajax_insertdatainassementquestion', 'Tbit_lms_insertdatainassementquestion_function');


if( !function_exists('Tbit_lms_insertdatainassementquestion_function')){
function Tbit_lms_insertdatainassementquestion_function(){

	if(isset($_POST['assesment_id']) && $_POST['assesment_id'] !=''){

		global $wpdb;

		$assesment_id=sanitize_text_field($_POST['assesment_id']);





		

		if(isset($_POST['targetids']) && count($_POST['targetids'])>0){

			$datahtml='';

			foreach ($_POST['targetids'] as $key => $value) {

				$title=get_the_title($value);

				$wpdb->insert($wpdb->prefix.'gsplms_quiz_questions',array(

				'quiz_id' => $assesment_id,

				'question_id' => $value,

				));

			}

			$post_id=$assesment_id;

			$prepare_sql = $wpdb->prepare("SELECT gqq.question_id,p.post_title FROM ".$wpdb->prefix."gsplms_quiz_questions gqq LEFT JOIN ".$wpdb->prefix."posts p ON gqq.question_id=p.ID WHERE quiz_id=%s",$post_id);
			$results=$wpdb->get_results($prepare_sql,ARRAY_A);

			if(count($results)>0){
				require_once('inc/admin/template-part/assestment_questionlist.php');

			}
		}
	}

	wp_die();
}
}





add_action('wp_ajax_deleteassementitem', 'Tbit_lms_deleteassementitem_function');


if( !function_exists('Tbit_lms_deleteassementitem_function')){
function Tbit_lms_deleteassementitem_function(){

	if(isset($_POST['deletetype']) && $_POST['deletetype'] !='' && isset($_POST['question_id']) && $_POST['question_id'] !=''){

		global $wpdb;

		$deletetype=sanitize_text_field($_POST['deletetype']);

		$question_id=sanitize_text_field($_POST['question_id']);
		$post_id = 0;
		if(isset($_POST['post_id']) && !empty($_POST['post_id'])){
			$post_id = sanitize_text_field($_POST['post_id']);
		}



		if($deletetype=='permanently'){

			

			$wpdb->delete($wpdb->prefix.'posts',array('ID'=>$question_id));

			$wpdb->delete($wpdb->prefix.'gsplms_quiz_questions',array('question_id'=>$question_id,'quiz_id'=>$post_id));

		} else {

			$wpdb->delete($wpdb->prefix.'gsplms_quiz_questions',array('question_id'=>$question_id,'quiz_id'=>$post_id));

		}

		

	}

	echo 'yes';

	die;

	

}
}



add_action('wp_ajax_useranswersubmit', 'Tbit_lms_useranswersubmit_function');


if( !function_exists('Tbit_lms_useranswersubmit_function')){
function Tbit_lms_useranswersubmit_function(){

	if(isset($_POST['deletetype']) && $_POST['deletetype'] !='' && isset($_POST['question_id']) && $_POST['question_id'] !=''){

		global $wpdb;

		$deletetype=sanitize_text_field($_POST['deletetype']);

		$question_id=sanitize_text_field($_POST['question_id']);



		if($deletetype=='permanently'){

			

			$wpdb->delete($wpdb->prefix.'posts',array('ID'=>$question_id));

			$wpdb->delete($wpdb->prefix.'gsplms_quiz_questions',array('question_id'=>$question_id));

		} else {

			$wpdb->delete($wpdb->prefix.'gsplms_quiz_questions',array('question_id'=>$question_id));

		}

		

	}

	echo 'yes';

	die;

	

}
}

add_action( 'wp_enqueue_scripts', 'Tbit_lms_enqueue_my_styles' );
if( !function_exists('Tbit_lms_enqueue_my_styles')){
	function Tbit_lms_enqueue_my_styles(){
	
	wp_register_style('Tbit_lms_bootstrap', plugins_url( 'assets/css/bootstrap/bootstrap.min.css', __FILE__ ));
	wp_enqueue_style('Tbit_lms_bootstrap');

	wp_register_style('Tbit_lms_fontawesome', plugin_dir_url( __FILE__ ) . "/assets/css/font-awesome.min.css?id=".rand());
	wp_enqueue_style('Tbit_lms_fontawesome');

	wp_enqueue_style( 'tbit-quick-learn-css',plugin_dir_url( __FILE__ ) . "/style.css?id=".rand());
	Tbit_lms_root_css();

	wp_enqueue_script('frontend-gsp-common-js', plugin_dir_url( __FILE__ ).'/assets/js/gsp-front-lms-common.js?id='.rand(),array(),false,true);

	wp_add_inline_script( 'frontend-gsp-common-js', 'const ADMIN_AJAX_URL = ' . json_encode( array(
    'admin_url' => admin_url('admin-ajax.php'),
) ), 'before' );

}
}
if( !function_exists('Tbit_lms_admin_gspstyle')){
function Tbit_lms_admin_gspstyle() {

  wp_enqueue_style('admin-gsp-styles', plugin_dir_url( __FILE__ ).'/assets/css/gsp-admin.css?id='.rand());

  wp_enqueue_script('admin-gsp-common-js', plugin_dir_url( __FILE__ ).'/assets/js/tbit-quick-learn-common.js?id='.rand());

}
}

add_action('admin_enqueue_scripts', 'Tbit_lms_admin_gspstyle');




if( !function_exists('Tbit_lms_insert_lession_data')){
function Tbit_lms_insert_lession_data(){

	global $wpdb;

    if(isset($_POST['videoid']) && $_POST['videoid'] !='' && isset($_POST['course_id']) && $_POST['course_id'] !='' ){
    	$videoid = sanitize_text_field($_POST['videoid']);
    	$course_id = sanitize_text_field($_POST['course_id']);
    	$user_id=get_current_user_id();

    	$wpdb->insert($wpdb->prefix.'completed_lesson',array('userid'=>$user_id,'videoid'=>$videoid,'course_id'=> $course_id));
    	echo 1;
    	exit();
    }
}
}

add_action( 'wp_ajax_insert_lession_data', 'Tbit_lms_insert_lession_data' );    // If called from admin panel

add_action( 'wp_ajax_nopriv_insert_lession_data', 'Tbit_lms_insert_lession_data' ); 
if( !function_exists('Tbit_lms_updatequizdata')){
function Tbit_lms_updatequizdata(){
	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['item_id']) && $_POST['item_id'] !=''){

		global $wpdb,$post;

		$url     = wp_get_referer();
		$post_id = url_to_postid( $url ); 

		$type= sanitize_text_field($_POST['type']);

		$item_id= sanitize_text_field($_POST['item_id']);
		$main_item_id = 0;
	if(isset($_POST['main_item_id']) && !empty($_POST['main_item_id'])){	
		$main_item_id= sanitize_text_field($_POST['main_item_id']);
	}

		$value = '';

		if(isset($_POST['value'])){

			$value = sanitize_text_field($_POST['value']);

		}

		if($type=='skip'){

			$value = '';

		}

		if($type=='prev'){

			$value = '';

		}

		$correct = 0;


		$prepare_sql = $wpdb->prepare("SELECT user_item_id FROM ".$wpdb->prefix."gsp_user_items WHERE item_id=%s AND ref_id=%s ORDER BY user_item_id DESC",$main_item_id,$post_id);
		$results=$wpdb->get_results($prepare_sql,ARRAY_A);


		if(count($results)>0){
			
			$user_item_id = $results[0]['user_item_id'];
			$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_itemmeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'results');
			$results=$wpdb->get_results($prepare_sql,ARRAY_A);

			if(count($results)>0){

				$meta_value = unserialize($results[0]['meta_value']);

				if(isset($meta_value['questions']) && count($meta_value['questions'])>0){

					
					$prepare_sql = $wpdb->prepare("SELECT answer_data FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$item_id);

					$results333=$wpdb->get_results($prepare_sql,ARRAY_A);

					

					if(count($results333)>0){

						foreach ($results333 as $k => $v) {

							$unserialize_value = unserialize($v['answer_data']);

							if($unserialize_value['value'] == $value){

								if($unserialize_value['is_true']=='yes'){

									$correct = 1;

								}

							}

						}

					}

				}

				

				$user_mark = 0;

				$question_wrong = 0;

				$question_correct = 0;

				$next_question_id = 0;

				$answered = 0;

				$total_count = 0;

				$question_skip = 0;





				$keys = array_flip(array_keys($meta_value['questions']));

				$values = array_keys($meta_value['questions']);

				$pre_id = $values[$keys[$item_id]-1];

				foreach ($meta_value['questions'] as $key => $value) {

					$total_count = $total_count + 1;

					if($item_id==$key) {

						$is_correct='yes';

						if($correct==1){

							$lms_question_mark = get_post_meta($key,'lms_question_mark',true);

							$meta_value['questions'][$key]['correct'] = 1;

							$meta_value['questions'][$key]['mark'] = $lms_question_mark;

							$user_mark = $lms_question_mark+$user_mark;

							$question_correct = $question_correct + 1;

						} else {
							$mark = 0;
							if($type=='skip'){

								$skip_minus_point =  get_post_meta($main_item_id,'lms_assement_minus_skip_point',true);
								
								if($skip_minus_point !=''){
									$mark = $mark - $skip_minus_point;
									$user_mark = $user_mark - $skip_minus_point;

								} else {
									$mark = 0;
									$user_mark = $user_mark + 0;

								}

								$meta_value['questions'][$key]['correct'] = 'skip';

							} else {



								$w_minus_point =  get_post_meta($main_item_id,'lms_assement_minus_point',true);
								
								if($w_minus_point !=''){
									$mark = $mark - $w_minus_point;
									$user_mark = $user_mark - $w_minus_point;

								} else {
									$mark = 0;
									$user_mark = $user_mark + 0;

								}



								$question_wrong = $question_wrong + 1;

								$meta_value['questions'][$key]['correct'] = 0;

							}

							$meta_value['questions'][$key]['mark'] = $mark;

						}

						$meta_value['questions'][$key]['answered'] = 1;

						$answered = $answered + 1;

					} else {



						$user_mark = $user_mark + $meta_value['questions'][$key]['mark'];



						if($meta_value['questions'][$key]['correct'] == '0'){

							$question_wrong =  $question_wrong + 1;

						}

						if($meta_value['questions'][$key]['correct'] == 'skip'){

							$question_skip =  $question_skip + 1;

						}

						if($meta_value['questions'][$key]['correct'] == 1){

							$question_correct =  $question_correct + 1;

						}



						if(isset($is_correct) && $is_correct=='yes'){

							$next_question_id = $key;

						}

						$is_correct='no';

						if($meta_value['questions'][$key]['answered']==1){

							$answered = $answered + 1;

						}

					}





				}

				$meta_value['user_mark'] = $user_mark;

				$meta_value['question_count'] = $total_count;

				$meta_value['question_empty'] = $total_count-(int)$answered;

				$meta_value['question_answered'] = (int)$answered;

				$meta_value['question_wrong'] = $question_wrong;

				$meta_value['question_correct'] =  $question_correct;

				$datahtml = '';

				

				if($type=='complete'){

				$lms_assement_passing_grade=get_post_meta($main_item_id,'lms_assement_passing_grade',true);
				$lms_assement_retake=get_post_meta($main_item_id,'lms_assement_retake',true);

				if($meta_value['user_mark']>0){

				$percentage = ( $meta_value['user_mark'] / $meta_value['mark'] ) * 100;

				$percentage = round($percentage,2);
				} else {
					$percentage = 0;
				}

				if($percentage>=$lms_assement_passing_grade){

					$grade = 'passed';

				} else {

					$grade = 'failed';

				}



				$questioncount = $meta_value['question_count'];



				$meta_value['time_spend'] = sanitize_text_field($_POST['timespent']);

				$meta_value['status'] =  'completed';

				$meta_value['grade'] =  $grade;

				$meta_value['result'] =  $percentage;

				$meta_value['grade_text'] =  $grade;



				$serializedata = serialize($meta_value);
				$wpdb->update($wpdb->prefix.'gsp_user_items',array('end_time'=>date('Y-m-d H:i:s'),'status' => 'completed'),array('user_item_id'=>$user_item_id));
				$wpdb->update($wpdb->prefix.'gsp_user_itemmeta',array('meta_value'=>$serializedata),array('gsp_user_item_id'=>$user_item_id,'meta_key'=>'results'));
				

				$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_retakemeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'retaken_count');

				$r_result = $wpdb->get_results($prepare_sql,ARRAY_A);
				if(count($r_result)>0 && isset($r_result[0]['meta_value']) && $r_result[0]['meta_value'] !=''){
				$retake_count = $r_result[0]['meta_value'];
					$ac_r_count = (int)$lms_assement_retake - (int)$retake_count;
				} else {
					$ac_r_count = $lms_assement_retake;
				}
					$prepare_sql = $wpdb->prepare("SELECT start_time,end_time FROM ".$wpdb->prefix."gsp_user_items WHERE user_item_id=%s",$user_item_id);

					$remain_results=$wpdb->get_results($prepare_sql,ARRAY_A);

					$user_start_time = 0;
					$user_end_time = 0;

					if(count($remain_results)>0){
						$user_start_time = $remain_results[0]['start_time'];
						$user_end_time = $remain_results[0]['end_time'];
					}

					
					$dateTimeObject1 = date_create($user_end_time); 
					$dateTimeObject2 = date_create($user_start_time); 
					$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
					$hours = $difference->days * 24;
					$hours += $difference->h;
					$minutes = $difference->i;
					$seconds = $difference->s;
					$user_used_time = sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);



					$timespent = sanitize_text_field($_POST['timespent']);

					$question_correct = $meta_value['question_correct'];

					$question_wrong = $meta_value['question_wrong'];



					$datahtml .= '<div id="content-item-quiz" class="content-item-summary">';

					$datahtml .= '<h3 class="course-item-title quiz-title">'.esc_html(get_the_title($main_item_id)).'</h3>';

					$datahtml .= '<div class="quiz-result passed">';

					$datahtml .= '<h3>Your Result</h3>';

					$datahtml .= '<div class="result-grade"><span class="result-achieved" style="font-size: 30px;color: #007bff;">'.$percentage.'%</span><p class="result-message">Your grade is <strong>'.esc_html($grade).'</strong> </p></div>';

					$datahtml .= ' <ul class="result-statistic">';

					$datahtml .= '<li class="result-statistic-field yyy"><strong>Time spend</strong><p>'.esc_html($user_used_time).'</p></li>';

        			$datahtml .= '<li class="result-statistic-field"><strong>Questions</strong><p>'.esc_html($questioncount).'</p></li>';

        			$datahtml .= '<li class="result-statistic-field"><strong>Correct</strong><p>'.esc_html($question_correct).'</p></li>';

        			$datahtml .= '<li class="result-statistic-field"><strong>Wrong</strong><p>'.esc_html($question_wrong).'</p></li>';

       				$datahtml .= '</ul>';

       				if($ac_r_count != '' && $ac_r_count != 0){
       				$datahtml .= '<div class="retake_button"><button class="btn btn_retake" data-id="'.esc_attr($main_item_id).'" data-course_id="'.esc_attr($post_id).'" > Retake('.esc_html($ac_r_count).')</button></div>';
       				}

       				$datahtml .= '<div class="navigationbox_quiz">';
       				$get_course_next_prev = tbit_lms_checknext_prev($post_id,$main_item_id);
       				if($get_course_next_prev['prev'] == 'yes'){
       					$datahtml .= '<div class="prev_quiz" data-id="'.esc_attr($main_item_id).'">Prev</div>';
       				}
       				if($get_course_next_prev['next'] == 'yes'){
       					$datahtml .= '<div class="nxt_quiz" data-id="'.esc_attr($main_item_id).'">Next</div>';
       				}
       				$datahtml .= '</div>';



					$datahtml .= '</div>';

					$datahtml .= '</div>';





				} else if($type=='skip' || $type=='next'){

				$serializedata = serialize($meta_value);

				$wpdb->update($wpdb->prefix.'gsp_user_itemmeta',array('meta_value'=>$serializedata),array('gsp_user_item_id'=>$user_item_id,'meta_key'=>'results'));

					$datahtml = '';
				if($next_question_id){

					$wpdb->update($wpdb->prefix.'gsp_user_itemmeta',array('meta_value' => $next_question_id ),array('gsp_user_item_id'=>$user_item_id,'meta_key'=>'_current_question'));


					$datahtml .='<h4 class="question-title">'.esc_html(get_the_title($next_question_id)).'</h4>';

					$datahtml .='<div class="an_checkbox_mainbox" data-item-id="'.esc_attr($next_question_id).'" data-main-item-id="'.esc_attr($main_item_id).'"> ';

					$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$next_question_id);

					$qget_results11=$wpdb->get_results($prepare_sql,ARRAY_A);

					foreach ($qget_results11 as $key => $value) {

							$answer_dataqq = unserialize($value['answer_data']);

							if(count($answer_dataqq)>0){

								$value = $answer_dataqq['value'];

								$text = $answer_dataqq['text'];

								$datahtml .='<div class="an_checkbox">';

									$datahtml .='<input style="display: block;" type="radio" name="answer" class="radio_btn" value="'.esc_attr($value).'"><span style="margin-left: 10px;" class="radio_btntext">'.esc_html($text).'</span></div>';

							 }

						}

					$datahtml .='</div>';

					$datahtml .='<div class="gsp_lms_tb-quiz-buttons">';



					$next_question_idnew = 'no';

					foreach ($meta_value['questions'] as $key => $value) {

					if($next_question_id==$key){

						$is_correctnew='yes';

					} else if(isset($is_correctnew) && $is_correctnew=='yes') {

						$next_question_idnew='yes';

					} else {

						$next_question_idnew='no';

					}

				}

				if(isset($next_question_idnew) && $next_question_idnew=='yes' ){

					$datahtml .= '<form name="next-question" class="prev-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="prev-question" value="prev" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Prev</button></form><form name="next-question" class="next-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="next-question" value="next" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Next</button></form><form name="skip-question" class="skip-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="skip-question" value="skip" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Skip</button></form>';

				} else {

					$datahtml .= '<form name="next-question" class="prev-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="prev-question" value="prev" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Prev</button></form><form name="complete-quiz" data-confirm="Do you want to complete quiz &quot;Awesome test&quot;?" data-action="complete-quiz" class="complete-quiz form-button gsp_lms_tb-form" method="post" enctype="multipart/form-data"><button type="button" name="completeQuiz" id="complete-question" value="complete" style="border-radius: 25px;padding: 0 30px; font-size: 16px;line-height: 50px;border: none;">Complete</button></form>';

				}



					$datahtml .='</div>';

				}

				$datahtml .='<div class=""></div>';



				} else if($type=='prev'){



				$datahtml = '';

					$wpdb->update($wpdb->prefix.'gsp_user_itemmeta',array('meta_value' => $pre_id ),array('gsp_user_item_id'=>$user_item_id,'meta_key'=>'_current_question'));

					$datahtml .='<h4 class="question-title">'.esc_html(get_the_title($pre_id)).'</h4>';

					$datahtml .='<div class="an_checkbox_mainbox" data-item-id="'.esc_attr($pre_id).'" data-main-item-id="'.esc_attr($main_item_id).'"> ';

					
					$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$pre_id);

					$qget_results11=$wpdb->get_results($prepare_sql,ARRAY_A);

					foreach ($qget_results11 as $key => $value) {

							$answer_dataqq = unserialize($value['answer_data']);

							if(count($answer_dataqq)>0){

								$value = $answer_dataqq['value'];

								$text = $answer_dataqq['text'];

								$datahtml .='<div class="an_checkbox">';

									$datahtml .='<input style="display: block;" type="radio" name="answer" class="radio_btn" value="'.esc_attr($value).'"><span style="margin-left: 10px;" class="radio_btntext">'.esc_html($text).'</span></div>';

							 }

						}

					$datahtml .='</div>';

					$datahtml .='<div class="gsp_lms_tb-quiz-buttons">';



					$next_question_idnew = 'no';

					$firstarray = 0;

					$i=0;

					foreach ($meta_value['questions'] as $key => $value) {

						if($i==0){

							$firstarray = $key;

							$i++;

						}

					if($next_question_id==$key){

						$is_correctnew='yes';

					} else if(isset($is_correctnew) && $is_correctnew=='yes') {

						$next_question_idnew='yes';

					} else {

						$next_question_idnew='no';

					}

				}



				$keys = array_flip(array_keys($meta_value['questions']));

				$values = array_keys($meta_value['questions']);

				$next_id = $values[$keys[$item_id]-1];



				if(isset($next_id) && $next_id !='' ){



					if($pre_id !='' && $pre_id != $firstarray ){

						$datahtml .= '<form name="prev-question" class="prev-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="prev-question" value="prev" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Prev</button></form>';

					}

					$datahtml .= '<form name="next-question" class="next-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="next-question" value="next" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Next</button></form><form name="skip-question" class="skip-question form-button gsp_lms_tb-form" method="post" action=""><button type="button" id="skip-question" value="skip" style="border-radius: 25px;padding: 0 30px;font-size: 16px;line-height: 50px;border: none;">Skip</button></form>';

				} else {

					$datahtml .= '<form name="complete-quiz" data-confirm="Do you want to complete quiz &quot;Awesome test&quot;?" data-action="complete-quiz" class="complete-quiz form-button gsp_lms_tb-form" method="post" enctype="multipart/form-data"><button type="button" name="completeQuiz" id="complete-question" value="complete" style="border-radius: 25px;padding: 0 30px; font-size: 16px;line-height: 50px;border: none;">Complete</button></form>';

				}



					$datahtml .='</div>';

				

				$datahtml .='<div class=""></div>';



				



				}

				

			}



		}

		echo html_entity_decode(esc_html($datahtml));

	}

	wp_die();

	

}
}



add_action( 'wp_ajax_updatequizdata', 'Tbit_lms_updatequizdata' );    // If called from admin panel

add_action( 'wp_ajax_nopriv_updatequizdata', 'Tbit_lms_updatequizdata' ); 







add_action('wp_ajax_generalinformationupdate', 'Tbit_lms_generalinformationupdate');


if( !function_exists('Tbit_lms_generalinformationupdate')){
function Tbit_lms_generalinformationupdate(){

	if(isset($_POST['name']) && $_POST['name'] !=''){

		global $wpdb;
		$user_id=get_current_user_id();

		$name=sanitize_text_field($_POST['name']);
		$contact_phone = 0;
		$instructor_experience = '';
		$instructor_twitter = '';
		$instructor_facebook = '';
		$instructor_instagram = '';
		$instructor_whatsapp = '';
		$instructor_bio = '';
		if(isset($_POST['contact_phone']) && !empty($_POST['contact_phone'])){

		$contact_phone=sanitize_text_field($_POST['contact_phone']);
		}

		if(isset($_POST['instructor_experience']) && !empty($_POST['instructor_experience'])){
			$instructor_experience=sanitize_text_field($_POST['instructor_experience']);
		}
		if(isset($_POST['instructor_twitter']) && !empty($_POST['instructor_twitter'])){
			$instructor_twitter=sanitize_text_field($_POST['instructor_twitter']);
		}

		if(isset($_POST['instructor_facebook']) && !empty($_POST['instructor_facebook'])){
			$instructor_facebook=sanitize_text_field($_POST['instructor_facebook']);
		}

		if(isset($_POST['instructor_instagram']) && !empty($_POST['instructor_instagram'])){
			$instructor_instagram=sanitize_text_field($_POST['instructor_instagram']);
		}
		if(isset($_POST['instructor_whatsapp']) && !empty($_POST['instructor_whatsapp'])){
			$instructor_whatsapp=sanitize_textarea_field($_POST['instructor_whatsapp']);
		}
		if(isset($_POST['instructor_bio']) && !empty($_POST['instructor_bio'])){
			$instructor_bio=sanitize_textarea_field($_POST['instructor_bio']);
		}

		$wpdb->update($wpdb->prefix.'users',array(

			'display_name' => $name,

		),

		array(

			'ID' => $user_id

		)

		);

		update_user_meta($user_id,'contact_phone',$contact_phone);
		update_user_meta($user_id,'instructor_experience',$instructor_experience);

		update_user_meta($user_id,'instructor_twitter',$instructor_twitter);
		update_user_meta($user_id,'instructor_facebook',$instructor_facebook);
		update_user_meta($user_id,'instructor_instagram',$instructor_instagram);
		update_user_meta($user_id,'instructor_whatsapp',$instructor_whatsapp);
		update_user_meta($user_id,'instructor_bio',$instructor_bio);
		update_user_meta($user_id,'description',$instructor_bio);
		echo 1;	

	}

	die;

}
}

add_action('wp_ajax_changepassword', 'Tbit_lms_changepassword');


if( !function_exists('Tbit_lms_changepassword')){
function Tbit_lms_changepassword(){

	if(isset($_POST['current_password']) && $_POST['current_password'] !='' && isset($_POST['new_password']) && $_POST['new_password'] !=''){

		global $wpdb;

		$current_password=sanitize_text_field($_POST['current_password']);

		$new_password=sanitize_text_field($_POST['new_password']);



		$user_id=get_current_user_id();

		$user = wp_get_current_user();



		$checkpassword = wp_check_password($current_password,$user->data->user_pass,$user_id);

		if($checkpassword){

			wp_set_password( $new_password, $user_id );

			echo 1;

		} else {

			echo 0;

		}

	}

	

	die;

	

}
}



add_action('wp_ajax_profileimageupload', 'Tbit_lms_profileimageupload');


if( !function_exists('Tbit_lms_profileimageupload')){
function Tbit_lms_profileimageupload(){

	if(isset($_FILES['filename2']['name']) && $_FILES['filename2']['name'] !=''){
		$upload = wp_upload_bits( $_FILES['filename2']['name'], null, file_get_contents( $_FILES['filename2']['tmp_name'] ) );

		$wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );

		$wp_upload_dir = wp_upload_dir();

		$attachment = array(

		'guid' => $wp_upload_dir['baseurl'] . _wp_relative_upload_path( $upload['file'] ),

		'post_mime_type' => $wp_filetype['type'],

		'post_title' => preg_replace('/\.[^.]+$/', '', basename( $upload['file'] )),

		'post_content'   => '',

		'post_status'    => 'inherit'

		);

		$attach_id = wp_insert_attachment( $attachment, $upload['file']);

		require_once(ABSPATH . 'wp-admin/includes/image.php');

		$attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );

		wp_update_attachment_metadata( $attach_id, $attach_data );

		update_user_meta(wp_get_current_user()->id, "wp_user_avatar", $attach_id);

		echo 1;

	} else {

		echo 0;

	}

	

	die;

	

}
}



add_action('wp_ajax_startquiz', 'Tbit_lms_startquiz');


if( !function_exists('Tbit_lms_startquiz')){
function Tbit_lms_startquiz(){
	global $post,$wpdb;
	$user_id=get_current_user_id();
	if(isset($_POST['ref_type']) && $_POST['ref_type'] !=''){
	$ref_type = sanitize_text_field($_POST['ref_type']);
	$ref_id = 0;
	if(isset($_POST['ref_id']) && !empty($_POST['ref_id'])){
	$ref_id = sanitize_text_field($_POST['ref_id']);
	}
	$item_id = 0;
	if(isset($_POST['item_id']) && !empty($_POST['item_id'])){
	$item_id = sanitize_text_field($_POST['item_id']);
 	}
	$status = '';
	if(isset($_POST['status']) && !empty($_POST['status'])){
	$status = sanitize_text_field($_POST['status']);
 }

	$array=array(
	'user_id' => $user_id,
	'item_id' => $item_id,
	'start_time' => date('Y-m-d H:i:s'),
	'status' => $status,
	'ref_id' => $ref_id,
	'ref_type' => $ref_type,
	);

	$wpdb->insert($wpdb->prefix.'gsp_user_items',$array);

	$lastsaid = $wpdb->insert_id;

	$item_id = $item_id;

	$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$item_id);
	$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);
	$question_ids=array();
	$question_retake_count = get_post_meta($item_id,'lms_assement_retake',true);
	if(count($get_results)>0){
	foreach ($get_results as $key => $value111) {
	$question_ids[]=$value111['question_id'];
	}
	}
	$question_ids=implode(',', $question_ids);
	$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_status=%s AND ID IN($question_ids)",'publish');
	$qget_results=$wpdb->get_results($prepare_sql,ARRAY_A);
	$data_quiz['questions'] = array();

	$lms_question_mark_count = 0;

	$user_mark = 0;

	$question_count = 0;

	$_current_question = '';

	

	foreach ($qget_results as $key => $value) {

	if($_current_question == ''){

		$_current_question = $value['ID'];

	}

	$data_quiz['questions'][$value['ID']] = array();

	

	$question_gsplmsq_type = get_post_meta($value['ID'],'gsplmsq_type',true);

	$lms_question_mark = get_post_meta($value['ID'],'lms_question_mark',true);

	$lms_question_hint = get_post_meta($value['ID'],'lms_question_hint');

	$lms_question_mark_count = (int)$lms_question_mark_count + (int)$lms_question_mark;

	$user_mark = 0;

	$question_count = $question_count+1;

	$data_quiz['questions'][$value['ID']]['correct'] = ''; 

	$data_quiz['questions'][$value['ID']]['mark'] = 0;

	$data_quiz['questions'][$value['ID']]['type'] = $question_gsplmsq_type;

	$data_quiz['questions'][$value['ID']]['answered'] = '';

	}





	$quiestion_data = array(

	'questions'=>$data_quiz['questions'],

	'mark' =>  $lms_question_mark_count,

	'user_mark' => 0,

	'question_count' => $question_count,

	'question_empty' => $question_count,

	'question_answered' =>  0,

	'question_wrong' => 0,

	'question_correct' => '',

	'status' => 'started',

	'grade' => '',

	'result' => '',

	'time_spend'=>'',

	'retake_count' =>  $question_retake_count,

	'grade_text'=>''

	);

	$array_insert = array(

	'gsp_user_item_id' => $lastsaid,

	'meta_key' => 'results',

	'meta_value' => serialize($quiestion_data),

	);

	$wpdb->insert($wpdb->prefix.'gsp_user_itemmeta',$array_insert);

	$array_insert = array(

	'gsp_user_item_id' => $lastsaid,

	'meta_key' => '_current_question',

	'meta_value' => $_current_question,

	);

	$wpdb->insert($wpdb->prefix.'gsp_user_itemmeta',$array_insert);

	$data=require_once('inc/get_quiz_question.php');

	}



	wp_die();

}
}




/* Retake Start Quiz Start */


add_action('wp_ajax_retakestartquiz', 'Tbit_lms_retakestartquiz');


if( !function_exists('Tbit_lms_retakestartquiz')){
function Tbit_lms_retakestartquiz(){

	global $post,$wpdb;

	$user_id=get_current_user_id();

	if(isset($_POST['ref_type']) && $_POST['ref_type'] !=''){

	$ref_type = sanitize_text_field($_POST['ref_type']);

	$ref_id = 0;
	if(isset($_POST['ref_id']) && !empty($_POST['ref_id'])){

	$ref_id = sanitize_text_field($_POST['ref_id']);

}

	$item_id = 0;
	if(isset($_POST['item_id']) && !empty($_POST['item_id'])){
	$item_id = sanitize_text_field($_POST['item_id']);
 }

	$status = '';
	if(isset($_POST['status']) && !empty($_POST['status'])){
	$status = sanitize_text_field($_POST['status']);
	}

	$array=array(

	'user_id' => $user_id,

	'item_id' => $item_id,

	'start_time' => date('Y-m-d H:i:s'),

	'status' => $status,

	'ref_id' => $ref_id,

	'ref_type' => $ref_type,

	);


	$prepare_sql = $wpdb->prepare("SELECT user_item_id FROM ".$wpdb->prefix."gsp_user_items WHERE user_id=%s AND item_id=%s AND ref_id=%s AND ref_type=%s",$user_id,$item_id,$ref_id,$ref_type);

	$rgi_result = $wpdb->get_results($prepare_sql,ARRAY_A); 

	if(count($rgi_result)>0 && isset($rgi_result[0]['user_item_id']) && $rgi_result[0]['user_item_id'] !=''){
		$user_item_id = $rgi_result[0]['user_item_id'];

	$wpdb->update($wpdb->prefix.'gsp_user_items',$array,array('user_item_id' => $user_item_id));

	$lastsaid = $user_item_id;

	$item_id = $item_id;

	
	$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$item_id);

	$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

	$question_ids=array();


	$question_retake_count = get_post_meta($item_id,'lms_assement_retake',true);




	if(count($get_results)>0){

	foreach ($get_results as $key => $value111) {

	$question_ids[]=$value111['question_id'];

	}

	}



	$question_ids=implode(',', $question_ids);
	$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_status=%s AND ID IN($question_ids)",'publish');
	$qget_results=$wpdb->get_results($prepare_sql,ARRAY_A);

	
	$data_quiz['questions'] = array();

	$lms_question_mark_count = 0;

	$user_mark = 0;

	$question_count = 0;

	$_current_question = '';

	

	foreach ($qget_results as $key => $value) {

	if($_current_question == ''){

		$_current_question = $value['ID'];

	}

	$data_quiz['questions'][$value['ID']] = array();

	

	$question_gsplmsq_type = get_post_meta($value['ID'],'gsplmsq_type',true);

	$lms_question_mark = get_post_meta($value['ID'],'lms_question_mark',true);

	$lms_question_hint = get_post_meta($value['ID'],'lms_question_hint');

	$lms_question_mark_count = (int)$lms_question_mark_count + (int)$lms_question_mark;

	$user_mark = 0;

	$question_count = $question_count+1;

	$data_quiz['questions'][$value['ID']]['correct'] = ''; 

	$data_quiz['questions'][$value['ID']]['mark'] = 0;

	$data_quiz['questions'][$value['ID']]['type'] = $question_gsplmsq_type;

	$data_quiz['questions'][$value['ID']]['answered'] = '';

	}





	$quiestion_data = array(

	'questions'=>$data_quiz['questions'],

	'mark' =>  $lms_question_mark_count,

	'user_mark' => 0,

	'question_count' => $question_count,

	'question_empty' => $question_count,

	'question_answered' =>  0,

	'question_wrong' => 0,

	'question_correct' => '',

	'status' => 'started',

	'grade' => '',

	'result' => '',

	'time_spend'=>'',

	'retake_count' =>  $question_retake_count,

	'grade_text'=>''

	);

	$array_insert = array(

	'gsp_user_item_id' => $lastsaid,

	'meta_key' => 'results',

	'meta_value' => serialize($quiestion_data),

	);

	$wpdb->insert($wpdb->prefix.'gsp_user_itemmeta',$array_insert);

	$array_insert = array(

	'gsp_user_item_id' => $lastsaid,

	'meta_key' => '_current_question',

	'meta_value' => $_current_question,

	);

	$wpdb->insert($wpdb->prefix.'gsp_user_itemmeta',$array_insert);

	$data=require_once('inc/get_quiz_question.php');

	}
	}



	wp_die();

}
}


/* Retake Start Quiz End */







add_action('wp_ajax_get_quiz_data', 'Tbit_lms_get_quiz_data');


if( !function_exists('Tbit_lms_get_quiz_data')){
function Tbit_lms_get_quiz_data(){

	global $post,$wpdb;


	if(isset($_POST['item_id']) && $_POST['item_id'] !=''){

		$user_id=get_current_user_id();

		$item_id = sanitize_text_field($_POST['item_id']);
		$course_id = 0;
		if(isset($_POST['course_id']) && $_POST['course_id'] !=''){
			$course_id = sanitize_text_field($_POST['course_id']);
		}


		$data=require_once('inc/startdata.php');

	}

	wp_die();

}
}



// function that runs when shortcode is called
if( !function_exists('Tbit_lms_my_listing_shortcode')){
function Tbit_lms_my_listing_shortcode() { 

// Things that you want to do. 

//if(is_user_logged_in()){

	$message = Tbit_lms_get_my_list(array(),'all',array(),'All Listings','all-courses'); 

//} else {

	//$message = 'No Listing'; 

//}



 

// Output needs to be return

return $message;

}
} 



// register shortcode

add_shortcode('all-courses', 'Tbit_lms_my_listing_shortcode'); 
if( !function_exists('Tbit_lms_calculateOrderAmountMain')){
		function Tbit_lms_calculateOrderAmountMain($course_id): int {
		$course_org_price = get_post_meta($course_id,'lms-course-price',true);
		$course_sale_price = get_post_meta($course_id,'gsp_sale_price',true);
		if($course_sale_price !='' && $course_sale_price !=0){
		$itemAmount = $course_sale_price;
		} else {
		$itemAmount = $course_org_price;
		}
		return $itemAmount;

		}
}
if(!function_exists('Tbit_lms_addpayment')){
	function Tbit_lms_addpayment(){
		global $wpdb,$current_user;
		$user_id=get_current_user_id();
		$admin_commission = 100;
		if(function_exists('Tbit_quick_pro_admin_commission')){
			$admin_commission = Tbit_quick_pro_admin_commission();
		}
		if(isset($_REQUEST['payment_intent']) && $_REQUEST['payment_intent'] !=''){
		$payment_intent = sanitize_text_field($_REQUEST['payment_intent']);
		$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."user_payments WHERE transaction_id=%s",$payment_intent);
		$result = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($result)>0){
		
		} else {
		$course_id = 0;
		$payment_intent = sanitize_text_field($_REQUEST['payment_intent']);
		if(isset($_REQUEST['course_id']) && $_REQUEST['course_id'] !=''){
			$course_id = sanitize_text_field($_REQUEST['course_id']);  
		} 
		$price =Tbit_lms_calculateOrderAmountMain($course_id);

		if($_REQUEST['redirect_status'] == 'succeeded'){
			$status = 'Completed';
		} else {
			$status = sanitize_text_field($_REQUEST['redirect_status']);
		}


		$gsp_stripe_test_mode_enable = Tbit_lms_retrivedata('gsp_stripe_test_mode_enable');
		if($gsp_stripe_test_mode_enable=='enable'){
		$secret_key = Tbit_lms_retrivedata('gsp_stripe_secret_key');
		} else {
		$secret_key = Tbit_lms_retrivedata('gsp_stripe_live_secret_key');
		}
		$url = 'https://api.stripe.com/v1/';
		$api = 'payment_intents/'.$payment_intent;
		$headers = array('Authorization'=> 'Bearer '.$secret_key);
		$args = array(
		'body'        => '',
		'timeout'     => '5',
		'redirection' => '5',
		'httpversion' => '1.0',
		'blocking'    => true,
		'headers'     => $headers,
		'cookies'     => array(),
		);

		$response = wp_remote_post( $url . $api, $args );
		$apiBody     = json_decode( wp_remote_retrieve_body( $response ) );

		if(isset($apiBody->status) && $apiBody->status == 'succeeded'){
		$status = 'Completed';
		} else {
		$status = $apiBody->status;
		}
		$array = array(
		'transaction_id' => $payment_intent,
		'amount'=> $price ,
		'transaction_type' => 'stripe',
		'subscribed_date' => date('Y-m-d H:i:s'),
		'user_id' => $user_id,
		'course_id' => $course_id,
		'payment_status'=>$status,
		'admin_commission' => $admin_commission
		);

		$sql = $wpdb->prepare("SELECT transaction_id FROM ".$wpdb->prefix."user_payments WHERE transaction_id=%s",array($payment_intent));
		$r_sql = $wpdb->get_results($sql);
		if(count($r_sql)<=0){
		$wpdb->insert($wpdb->prefix.'user_payments',$array);
		$lastid = $wpdb->insert_id;
		/* new order mail  */
		Tbit_lms_order_mail($lastid,$course_id,$user_id);
		}
		}
		} else if(isset($_POST['txn_id'])){
		    $enableSandbox = tbit_data_retrivedata('gsp_paypal_enable_test_mode');
		    $paypalUrl = $enableSandbox ? 'https://www.sandbox.paypal.com/cgi-bin/webscr' : 'https://www.paypal.com/cgi-bin/webscr';
		    // Assign posted variables to local data array.
		    $data = [
		        'item_name' => sanitize_text_field($_POST['item_name']),
		        'item_number' => sanitize_text_field($_POST['item_number']),
		        'payment_status' => sanitize_text_field($_POST['payment_status']),
		        'payment_amount' => sanitize_text_field($_POST['mc_gross']),
		        'payment_currency' => sanitize_text_field($_POST['mc_currency']),
		        'txn_id' => sanitize_text_field($_POST['txn_id']),
		        'receiver_email' => sanitize_text_field($_POST['receiver_email']),
		        'payer_email' => sanitize_text_field($_POST['payer_email']),
		        'custom' => sanitize_text_field($_POST['custom']),
		    ];
		    $array = array(
		    'transaction_id' => sanitize_text_field($_POST['txn_id']),
		    'amount'=>sanitize_text_field($_POST['mc_gross']),
		    'transaction_type' => 'paypal',
		    'subscribed_date' => date('Y-m-d H:i:s'),
		    'user_id' => sanitize_text_field($_POST['custom']),
		    'course_id' => sanitize_text_field($_POST['item_number']),
		    'payment_status'=>sanitize_text_field($_POST['payment_status']),
		    'admin_commission' => $admin_commission,
		    );
		    $wpdb->insert($wpdb->prefix.'user_payments',$array);
		    $lastid = $wpdb->insert_id;
		    $user_id = sanitize_text_field($_POST['custom']);
		    $course_id = sanitize_text_field($_POST['item_number']);
		    /* new order mail  */
		    Tbit_lms_order_mail($lastid,$course_id,$user_id);      
		}




	}
}

// function that runs when shortcode is called
if( !function_exists('Tbit_lms_all_listing_shortcode')){
function Tbit_lms_all_listing_shortcode() { 

// Things that you want to do. 

if(is_user_logged_in()){

	$message = Tbit_lms_get_my_list(array(),'my',array(),'My Listings','all_listing'); 

} else {

	$message = 'No Listing'; 

}



 

// Output needs to be return

return $message;

}
} 



// register shortcode

add_shortcode('all_listing', 'Tbit_lms_all_listing_shortcode'); 
 




if( !function_exists('Tbit_lms_get_my_list')){
function Tbit_lms_get_my_list($data=array(),$type='all',$category=array(),$heading='My Listing',$short_code = ''){
global $wpdb;
if(is_admin()){
	return '['.$short_code.']';
} else {


wp_register_style('Tbit_lms_list_custom_css',  plugins_url( 'assets/css/list_custom_css.css?id='.rand(), __FILE__ ));
wp_enqueue_style('Tbit_lms_list_custom_css');
wp_register_script('Tbit_lms_list_js', plugins_url( 'assets/js/lms_list.js?id='.rand(), __FILE__ ),'','',true);
wp_enqueue_script('Tbit_lms_list_js');
wp_localize_script( 'Tbit_lms_list_js', 'admin_url', array('ajax_url' => admin_url( 'admin-ajax.php' ) ) );
ob_start();

?>
<section class="comn-sec1 section-3 all_m_listingbox">
   <div class="">
      <div class="row lat-cours">
         <?php
            $args = array(
            'post_type' => 'lms-Courses',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            );
            if(isset($_GET['sort']) && $_GET['sort'] !='' ){
            if($_GET['sort']=='latest'){
	            $args['orderby'] = 'date';
	            $args['order'] = 'DESC';
            }
            if($_GET['sort']=='oldest'){
	            $args['orderby'] = 'date';
	            $args['order'] = 'ASC';
            }
            if($_GET['sort']=='nameasc'){
	            $args['orderby'] = 'title';
	            $args['order'] = 'ASC';
            }
            if($_GET['sort']=='namedesc'){
	            $args['orderby'] = 'title';
	            $args['order'] = 'DESC';
            }
            }
            
            if($type=='my'){
            $args['post_author'] = get_current_user_id();
            } else if($type=='feature'){
            $meta_query = array();
            $meta_query[] = array(
            'key' => 'lms_featured',
            'value' => 1,
            'compare' => '='
            );
            $args['meta_query'] = $meta_query;
            }
            if(count($category)>0){
            $args['tax_query'] = array(
            array(
            'taxonomy' => 'course-categories',
            'field'    => 'ID',
            'terms'    => $category,
            ),
            );
            }
            $courses = new WP_Query($args);
            
            $user_id=get_current_user_id();
            $prepare_sql = $wpdb->prepare('SELECT course_id FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
            $wishlistdata = $wpdb->get_results($prepare_sql,ARRAY_A);
            $wishlist_array = array();
            if(count($wishlistdata)>0){
            foreach ($wishlistdata as $key => $value) {
            $wishlist_array[] = $value['course_id'];
            }
            }
            if(isset($courses->posts) && count($courses->posts)>0){ 
            	foreach ($courses->posts as $key => $value) {
	            $featured_img_url = get_the_post_thumbnail_url($value->ID, 'get_the_post_thumbnail_url'); 
	            $colsec3smval = "4";
	            $cols3value = "4";
	            $colsec3xlval = "4";
	            ?>
	            <?php 
				$course_id_f = $value->ID;
				$heart_active = '';
				if(in_array($course_id_f, $wishlist_array)){
				$heart_active = 'heart_active';
				} ?>

				<div class=" product product-grid postproduct col-sm-<?php echo esc_attr($colsec3smval); ?>  col-lg-<?php echo esc_attr($cols3value); ?> col-xl-<?php echo esc_attr($colsec3xlval); ?>">
				<a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>" alt="<?php echo esc_attr(get_the_title($value->ID)); ?>" class="s_p_l_a_t_item">
				<span class="gsp-lms top_fav_icon"><i class="fa fa-heart heart_icon <?php echo esc_attr($heart_active); ?> " aria-hidden="true" data-id="<?php echo esc_attr($value->ID);?>" data-user_id="<?php echo esc_attr($user_id);?>"></i></span>
				<?php
				if ( has_post_thumbnail($value->ID) ){

				?>
				<img src="<?php echo esc_url(get_the_post_thumbnail_url($value->ID,'thumbnail')); ?>"  class="contextual" alt="" />
				<?php } else {
				$default_image = plugins_url( 'image/default.png', __FILE__ );
				?>
				<img src="<?php echo esc_url($default_image); ?>"  class="contextual" alt="" />
				<?php } ?>

				</a>
				
				<div class="icon-content">
				<div class="d-flex justify-between mt-10">
					<?php 
					$author = get_the_author();
					$prepare_sql_main = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s",1,$value->ID);
					$get_results=$wpdb->get_results($prepare_sql_main,ARRAY_A);
					$lessioncount = count($get_results);
					?>
					<span><i class="fa fa-user"></i> <?php echo esc_html($author); ?></span>
					<span class="c_publish_date">
						<i class="fa fa-book"></i> <?php echo esc_html($lessioncount); ?>
					</span>
				</div>
				<a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>" alt="<?php echo esc_attr(get_the_title($value->ID)); ?>">
				<h3 class="mt-0"><?php echo esc_html(get_the_title($value->ID)); ?></h3>
				</a>
				<div class="all_coursesbox">
				<?php
				if(!is_user_logged_in()){?>
				<a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>" alt="<?php echo esc_attr(get_the_title($value->ID)); ?>" class="creat-btn">Buy Now</a>
				<?php } else {?>
				<a href="<?php echo esc_url(get_the_permalink($value->ID)); ?>" alt="<?php echo esc_attr(get_the_title($value->ID)); ?>" class="creat-btn">Start Now</a>
				<?php }?>
				<?php
				$result = Tbit_get_courseratings_count_with_average($value->ID);
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
				</div>
	         
	         	<?php } ?>
         	<?php } else { ?>
         		<div class="text-center">No Listings</div>
         	<?php } ?>
      </div>
   </div>
</section>
<?php
$content = ob_get_clean();
  return $content;
 } 
}

}

add_filter( 'single_template', 'Tbit_lms_override_single_template' );
if( !function_exists('Tbit_lms_override_single_template')){
function Tbit_lms_override_single_template( $single_template ){
    global $post,$current_user;
    if($post->post_type == 'lms-courses'){
	if(!isset($current_user->data->ID)){
		wp_redirect(home_url().'/quick-learn-my-account/');
		exit();
	}
    $file = dirname(__FILE__) .'/templates/single-'. $post->post_type .'.php';
    if( file_exists( $file ) ) $single_template = $file;
    return $single_template;
	}

}
}


if( !function_exists('Tbit_lms_register_user_as_student')){
function Tbit_lms_register_user_as_student(){?>





<?php

if (isset($_POST['save'])){

global $wpdb;

$txt='';

$txt1='';
$username = '';
if(isset($_POST['user_nicename']) && !empty($_POST['user_nicename'])){
	$username=sanitize_text_field($_POST['user_nicename']);
}

$email = '';
if(isset($_POST['user_email']) && !empty($_POST['user_email'])){
	$email=sanitize_email($_POST['user_email']);
}

$password = '';
if(isset($_POST['user_pass']) && !empty($_POST['user_pass'])){
	$password=sanitize_text_field($_POST['user_pass']);
}

$confirm = '';
if(isset($_POST['confirm_password']) && !empty($_POST['confirm_password'])){
	$confirm=sanitize_text_field($_POST['confirm_password']);
}


$exists = email_exists($email);

$date = date('Y-m-d H:i:s'); 

$table_name = $wpdb->prefix . "users";

$data=array();

if( empty($username)|| empty($email)|| empty($password)|| empty($confirm)) 

{

$errMsg= "Please don't leave the required fields.";

}

elseif((strlen($username) < 3) || (!preg_match('/^\w+$/',$username))){

  $errorusr=" User Name length should be  greater than 3 ";

}elseif(strlen($password) < 5){//password

    $errorpass="Password length must be greater than 5 ";

}elseif($password != $confirm){//Repeat password

    $errorcpass="Password Doesnt matched!!!";

}elseif(!preg_match('/^[\w\.]+@\w+\.\w+$/i',$email)){//mailbox

    $erroremailfrmt="Email should be in format www@gmail.com";

}

elseif($exists){

 	$erroremail= " Email Already exists!!!";

}

else{

$data=array(

'user_login' =>$username,

'user_nicename' =>$username, 

'user_email' => $email,

'user_registered' => $date,

'display_name' => $username,

'user_pass' => $password,

'role' => 'student'

);

wp_insert_user($data);

$lastid = $wpdb->insert_id;


$txt="Registered Successfully. Please verify your email.";

$login_url = home_url().'/quick-learn-my-account/';

echo "<script>setTimeout(\"window.location.href='".esc_url($login_url)."'\",1500);</script>";

}  

}
ob_start();
?>

<section class="comn-sec grey-bg">

<div class="container1 news-sec">

<div class="row ">

	<form name="myForm" method="POST" id="form" class="signup-form" enctype="multipart/form-data">

	<h2 class="form-title"><?php home_url(); ?>Registeration Form</h2>
	<?php 
	if($errorusr){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($errorusr); ?></h5>
	<?php }?>
	<?php 
	if($errMsg){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($errMsg); ?></h5>
	<?php }?>
	<?php 
	if($errorpass){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($errorpass); ?></h5>
	<?php }?>
	<?php 
	if($errorcpass){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($errorcpass); ?></h5>
	<?php }?>
	<?php 
	if($erroremail){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($erroremail); ?></h5>
	<?php }?>
	<?php 
	if($erroremailfrmt){
	?>
	<h5 style="color: red;text-align: center;width: 100%;"><?Php echo esc_html($erroremailfrmt); ?></h5>
	<?php }?>
	<?php 
	if($txt){
	?>
	<h5 style="color:green;text-align: center;width: 100%;"><?Php echo esc_html($txt); ?></h5>
	<?php }?>


	<div class="form-group">

	<input type="text" class="form-input" name="user_nicename" id="uname" placeholder="Enter User Name" value="<?php echo isset($_POST['user_nicename']) ? sanitize_text_field($_POST['user_nicename']) : '' ?>"/><div id="div1"></div>

	</div>

	<div class="form-group">

	<input type="email" name="user_email" id="email" placeholder="Enter  Email" value="<?php echo isset($_POST['user_email']) ? sanitize_email($_POST['user_email']) : '' ?>" />

	</div>

	<div class="form-group p-relative">

	<input name="user_pass" id="password" type="password" placeholder="Enter  Password" value="<?php echo isset($_POST['user_pass']) ? sanitize_text_field($_POST['user_pass']) : '' ?>"/><i class="fa fa-eye eyefaicon" aria-hidden="true" onclick="eyeicon()"></i>

	</div>

	<div class="form-group p-relative">

	<input type="password" name="confirm_password" id="confirm_password" placeholder="Enter  Confirm Password" value="<?php echo isset($_POST['confirm_password']) ? sanitize_text_field($_POST['confirm_password']) : '' ?>"/> 
	<i class="fa fa-eye eyefaicon" aria-hidden="true" onclick="eye_icon()"></i>
	</div>


	<div class="form-group d-flex">

	<input type="submit" name="save" id="update" class="btn btn-primary" value="Sign up" />

	<a href="<?php echo esc_url(home_url()) ?>/quick-learn-my-account" class="instrloginbtn">Login</a>

	</div>

	</form>

</div>

</div>

</section>



<?php
$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
 }
}



add_shortcode('register-user-as-student', 'Tbit_lms_register_user_as_student'); 


if( !function_exists('Tbit_lms_my_account')){
function Tbit_lms_my_account(){
	wp_register_style('Tbit_lms_list_custom_css',  plugins_url( 'assets/css/list_custom_css.css?id='.rand(), __FILE__ ));
	wp_enqueue_style('Tbit_lms_list_custom_css');
ob_start();

if(!is_user_logged_in()){
	?>
<div class="profile-board">

	<div class="container">

		<div class="row">
		<form name="myForm" method="POST" id="form" class="signup-form" enctype="multipart/form-data">
		
		<h2 class="form-title">Login!</h2>
		<?php if($_SESSION['account_activated']){?>
		<div class="textaccount_activated">
			<?php echo html_entity_decode(esc_html($_SESSION['account_activated']));?>
		</div>
		<?php
		unset($_SESSION['account_activated']);
		 } ?>
		<div class="form-group">
		<input type="text" class="form-input" name="user_nicename" id="uname" placeholder="Enter User Name" value=""><div id="div1"></div>
		</div>

		<div class="form-group p-relative">
		<input name="user_pass" id="password" type="password" placeholder="Enter  Password" value=""><i class="fa fa-eye eyefaicon" aria-hidden="true" onclick="eyeicon()"></i>
		</div>


		<div class="form-group d-flex">
		<input type="button" name="login" id="update" class="btn btn-primary login_submit" value="Login">
		<a class="btn btn-primary register_type in_register_btn">Register</a>
		</div>
		</form>
		</div>
	</div>

<div class="custommodel">
	<div class="c_header_box text-right">
		<button type="button" class="c_popup_closebtn"><i class="fa fa-times"></i></button>
	</div>
	<div class="c_popupbodybox">
		<a href="<?php echo esc_url(home_url())?>/student-register" class="btn btn_c_typeselect">As Student</a>
		<?php 
		if(function_exists('Tbit_quick_learn_return_pro_verison_input_field')){
			$return_field = Tbit_quick_learn_return_pro_verison_input_field('as_instructor');
			echo html_entity_decode(esc_html($return_field));
		}
		?>
	</div>
</div>
</div>
<?php
} else {
global $wpdb;
$user = wp_get_current_user();
wp_register_style('Tbit_lms_list_custom_css',  plugins_url( 'assets/css/list_custom_css.css', __FILE__ ));
wp_enqueue_style('Tbit_lms_list_custom_css');
?>
<div class="profile-board">
	<div class="container">
		<div class="row">
			<div class="col-sm-3">
				<div id="gsp_lms-profile-nav">
					<ul class="gsp_lms-tabs tabs">
							<?php
							$active_tab = '';
							if(isset($_POST['a_course_name'])){
							$active_tab = 'active';
							}
							?>
						<li class="dashboard <?php if($active_tab==''){?> active <?php }?> listbox"><a class="sidebartab" data-tab="profilebox_tab">Dashboard</a></li>
						<li class="quizzes listbox <?php echo esc_html($active_tab);?>"><a class="sidebartab" data-tab="assessments_tab">Assessments</a></li>
						<?php
						if(in_array('instructor',$user->roles) || in_array('administrator',$user->roles)){
						?>
						<li class="listingbox listbox"><a class="sidebartab" data-tab="mylisting_tab">My Listing</a></li>
						<?php } ?>
						<li class="wishlist listbox"><a class="sidebartab"  data-tab="wishlist_tab">Wishlist</a></li>
						<li class="order listbox"><a class="sidebartab"  data-tab="order_tab">Order</a></li>
						<li class="settings has-child listingbox">
							<a href="#" data-tab="settings" class="dropdownbox">Settings</a>
							<ul class="profile-tab-sections" style="display: none;padding-left:20px">
								<li class="basic-information listbox">
									<a class="sidebartab" data-tab="general_tab">General</a>
								</li>
								<li class="avatar listbox">
									<a class="sidebartab" data-tab="avatar_tab" >Avatar</a>
								</li>
								<li class="change-password listbox">
									<a class="sidebartab" data-tab="password_tab">Password</a>
								</li>
							</ul>
						</li>
						<?php
						if(in_array('instructor',$user->roles) || in_array('administrator',$user->roles)){
						?>
						<li><a href="<?php echo esc_url(home_url());?>/wp-admin/post-new.php?post_type=lms-courses" target="_blank" >Add New</a></li>
						<?php } ?>
					</ul>
				</div>
			</div>
			<div class="col-sm-9">
				<?php
				$active_tab = '';
				if(isset($_POST['a_course_name'])){
					$active_tab = 'active';
				}
				?>
				<div class="profilebox sectionbox profilebox_tab" <?php if($active_tab=='active'){ ?> style="display: none;"  <?php } ?> >
				<div class="user-prof">
					<div class="row">
					<div class="col-md-4 img text-center">
					<?php
					$get_avatar_url = esc_url( plugin_dir_url( __FILE__ )."image/default_avater.png");
					$get_attachment_id = get_user_meta($user->ID,'wp_user_avatar',true);
					if($get_attachment_id !=''){
						$get_avatar_url = wp_get_attachment_url($get_attachment_id);
					}
					?>
					<img src="<?php echo esc_url($get_avatar_url); ?>" class="img-rounded" style="width:auto;" />
					</div>
					<div class="col-md-8 details">
					<blockquote>
					<h3><?php echo esc_html($user->display_name); ?></h3>
					<small><?php echo esc_html($user->user_email); ?></small>
					</blockquote>
					<blockquote>
					<h3>Contact info</h3>
					<small>Email:<a href="mailto:<?php echo esc_attr($user->user_email); ?>"><?php echo esc_html($user->user_email); ?></a></small>
					</blockquote>
					<blockquote>
					<h5>Hello <?php echo esc_html($user->display_name); ?></h5>
					<small>( not <?php echo esc_html($user->display_name); ?>? <a href="<?php echo esc_url(wp_logout_url());?>">Sign Out</a> )</small>
					</blockquote>
					</div>
					</div>
				</div>
				</div>
				
				<div class="notificationbox sectionbox assessments_tab" <?php if($active_tab==''){?> style="display: none" <?php }?>>
					<style type="text/css"></style>
					<?php
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
				wp_register_style('Tbit_lms_bootstrap', plugins_url( 'assets/css/bootstrap/bootstrap.min.css', __FILE__ ));
				wp_enqueue_style('Tbit_lms_bootstrap');
				wp_register_script('Tbit_lms_bootstrap', plugins_url( 'assets/js/bootstrap.min.js', __FILE__ ),'','',false);
				wp_enqueue_script('Tbit_lms_bootstrap');

					?>


						<!-- Modal -->
						<div id="certificate_myModal" class="modal fade" role="dialog">
						<div class="modal-dialog">

						<!-- Modal content-->
						<div class="modal-content">
						<div class="modal-header">
						<a href="<?php echo esc_url(home_url());?>/quick-learn-my-account?ceriticate_download=yes" class="download_cerificate">Download</a>
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						<div class="modal-body">

						<div class="pm-certificate-container">
						<div class="outer-border"></div>
						<div class="inner-border"></div>

						<div class="pm-certificate-border col-xs-12">
						<div class="row pm-certificate-header">
						<div class="pm-certificate-title cursive col-xs-12 text-center">
						<?php
						$certificate_logo = tbit_data_retrivedata('gsp_certificate_logo');
						if($certificate_logo !=''){
						?>
						<div class="certificate_logo">
							<img src="<?php echo esc_url($certificate_logo);?>" width="150">
						</div>
						<?php } ?>
						<h2 class="nomargin"><?php echo esc_html(tbit_data_retrivedata('gsp_certificate_website_name'));  ?></h2>
						</div>
						</div>

						<div class="row pm-certificate-body">
						<?php
						$userdata = wp_get_current_user();
						?>
						<div class="pm-certificate-block">
						<div class="col-xs-12">
						<div class="row">
						<div class="col-xs-2"><!-- LEAVE EMPTY --></div>
						<div class="pm-certificate-name underline margin-0 col-xs-8 text-center">
						<span class="pm-name-text bold student_name"><?php echo esc_html($userdata->first_name.' '.$userdata->last_name); ?></span>
						</div>
						<div class="col-xs-2"><!-- LEAVE EMPTY --></div>
						</div>
						</div>
						<?php
						$get_cerificate_conetnt = tbit_data_retrivedata('gsp_certificate_conetnt');
						?>
						<div class="col-xs-12 text-center certificate_conetntbox" data-htmlcontent="<?php echo esc_html($get_cerificate_conetnt);?>">          
						<?php echo esc_html($get_cerificate_conetnt);?>
						</div>
						
						</div>       

						<div class="col-xs-12">
						<div class="row">
						<div class="pm-certificate-footer">
						<div class="col-xs-4 pm-certified col-xs-4 text-center">
						<span class="pm-credits-text block sans"><?php echo esc_html(tbit_data_retrivedata('gsp_certificate_website_name')); ?> <span class="c_c_score"></span> </span>
						<span class="pm-empty-space block underline"></span>
						
						</div>
						<div class="col-xs-4">
						<!-- LEAVE EMPTY -->
						</div>
						<div class="col-xs-4 pm-certified col-xs-4 text-center">
						<span class="pm-credits-text block sans">Date <br /> <span class="c_c_date"></span></span>
						<span class="pm-empty-space block underline"></span>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						</div>
						<div class="my-box-bg">
						<h2 class="heading-cont">Assessments
						<form method="post">
						<div class="search_filter_box">
						<div class="inputbox display_flex">
						<?php
						$a_course_name = '';
						if(isset($_POST['a_course_name'])){
						$a_course_name = sanitize_text_field($_POST['a_course_name']);
						}
						?>
						<input type="text" name="a_course_name" value="<?php echo esc_html($a_course_name);?>" placeholder="search Course" class="form-control width-200">
						<button type="submit" class="btn btn-primary margin-left-10">Search</button>
						</div>
						</div>
						</form>
						</h2>
						<!-- Tab panes -->
						<div class="tab-content">

						<div id="home" class="tab-pane active">

						<table class="gsp_lms_tb-list-table profile-list-quizzes profile-list-table">

						<thead>

						<tr>

						<th class="column-course">Course / Assessments</th>

						<th class="column-quiz">Download Certificate</th>

						<th class="column-date">Date</th>

						<th class="column-status">Progress</th>

						<th class="column-time-interval">Interval</th>

						<th class="column-time-interval">Result</th>

						</tr>

						</thead>

						<tbody>



						<?php
						$search_c_name = '';
						if(isset($_POST['a_course_name'])){
							$ccn = sanitize_text_field($_POST['a_course_name']);
							$search_c_name = 'AND po.post_title LIKE "%'.$ccn.'%"';
						}

						$user_id = $user->ID;

						$prepare_sql = $wpdb->prepare("SELECT gui.*,guim.* FROM ".$wpdb->prefix."gsp_user_items gui LEFT JOIN ".$wpdb->prefix."gsplms_section_items gsi ON gui.item_id = gsi.item_id LEFT JOIN ".$wpdb->prefix."gsp_user_itemmeta guim ON gui.user_item_id = guim.gsp_user_item_id LEFT JOIN ".$wpdb->prefix."posts po ON gui.ref_id = po.ID WHERE gsi.section_id=%s AND gui.user_id=%s ".$search_c_name." AND guim.meta_key =%s GROUP BY gui.user_item_id",2,$user_id,'results');

						$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);



						if(count($get_results)>0){

							foreach ($get_results as $key => $value) {

							$course_id = $value['ref_id'];

							$end_date = $value['end_time'];

							$date=date_create($end_date);

							$date_formate = date_format($date,"M d, Y");

							$meta_value = unserialize($value['meta_value']);

						?>

						<tr>

						<td class="column-course" data-id="<?php echo esc_attr($value['ref_id']); ?>"><a href="<?php echo esc_url(get_permalink($course_id));?>"><?php echo esc_html(get_the_title($course_id));?></a> / <a><?php echo esc_html(get_the_title($value['item_id']));?> </a>  </td>

						<td class="column-quiz column-quiz-1194" ><a href="" class="certificate_link" data-user_item_id="<?php echo esc_attr($value['user_item_id']);?>" data-item_id="<?php echo esc_attr($value['item_id']);?>" data-assement_name="<?php echo esc_attr(get_the_title($value['item_id']));?>"  data-course_name="<?php echo esc_attr(get_the_title($course_id));?>" data-date="<?php echo esc_attr($date_formate); ?>" data-score="<?php echo esc_attr(round($meta_value['result'],2));?>%" >Download</a></td>

						<td class="column-date"><?php echo esc_html($date_formate);?></td>

						<td class="column-status"><span class="result-percent"><?php echo esc_html(round($meta_value['result'],2));?>%</span><span class="gsp_lms_tb-label label-completed"><?php echo esc_html($value['status']); ?></span></td>

						<td class="column-time-interval"><?php echo esc_html($meta_value['time_spend']); ?></td>

						<td class="column-time-interval"><?php echo esc_html($meta_value['grade_text']); ?></td>

						</tr>



						<?php } } else {?> 

							<tr>

								<td colspan="6" class="text-center"> No Assements </td>

							</tr>

						<?php } ?>

						</tbody>

						

						</table>



						</div>

						</div>

						</div>



					</div>


					<div class="notificationbox sectionbox mylisting_tab"  style="display: none">
						<div class="my-box-bgp">
						<h2 class="heading-cont">My Listings</h2>
						<?php 

						$args = array(

						'post_type' => 'lms-Courses',

						'posts_per_page' => -1,

						'post_status' => 'publish',
						'author' => get_current_user_id()

						);

					$args['post_author'] = get_current_user_id();

					$courses = new WP_Query($args);

					if($courses->have_posts()) {

					while($courses->have_posts()) : 

					$courses->the_post() ;

					$featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'get_the_post_thumbnail_url'); 



					$colsec3smval = "3";

					$cols3value = "3";

					$colsec3xlval = "3";

					?>

					<div class=" product product-grid postproduct col-sm-<?php echo esc_attr($colsec3smval); ?>  col-lg-<?php echo esc_attr($cols3value); ?> col-xl-<?php echo esc_attr($colsec3xlval); ?>">





					<a href="<?php esc_url(the_permalink()); ?>" alt="<?php esc_attr(the_title()); ?>"><?php



					if ( has_post_thumbnail() ){

					?>

					<img src="<?php esc_url(the_post_thumbnail_url('thumbnail')); ?>"  class="contextual my_listing_img" alt="" />

					<?php } else {

					?>

					<img src="<?php echo esc_url(home_url()).'/wp-content/plugins/tbit-quick-learn/image/default.png';?>"  class="contextual my_listing_img" alt="" />

					<?php }

					?></a>

					<?php 
					$course_id_f = get_the_ID();
					$heart_active = '';
					 ?>

					<div class="icon-content">
					<a href="<?php esc_url(the_permalink()); ?>" alt="<?php esc_attr(the_title()); ?>"><h3 class="font20"><?php echo esc_html(get_the_title()); ?></h3> </a>
					
					<a href="<?php echo esc_url(home_url()); ?>/wp-admin/post.php?post=<?php echo esc_attr($course_id_f); ?>&action=edit" alt="<?php esc_attr(the_title()); ?>" class="creat-btn">Edit</a>
					<a href="<?php esc_url(the_permalink()); ?>" alt="<?php esc_attr(the_title()); ?>" class="creat-btn">View</a>

					</div>



					</div>

					<?php endwhile ?>

					<?php } else { ?>

					<div>No Data</div>

					<?php } ?>
					</div>
				</div>

					<div class="profilebox sectionbox wishlist_tab" style="display: none;">

						<div class="my-box-bgff">

							<h2 class="heading-cont">Wishlist</h2>
							<?php
							$prepare_sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
							$rr = $wpdb->get_results($prepare_sql,ARRAY_A);
							if(count($rr)>0){ ?>
							<div >

							<?php

							$user_id=get_current_user_id();
							$prepare_sql = $wpdb->prepare('SELECT course_id FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
							$wishlistdata = $wpdb->get_results($prepare_sql,ARRAY_A);
							$wishlist_array = array();
							if(count($wishlistdata)>0){

							foreach ($wishlistdata as $key => $value) {
								$wishlist_array[] = $value['course_id'];
							}
							}
							if(count($rr)>0){
								foreach ($rr as $key => $value) {
								$courseid = $value['course_id'];
								$course_id_f = $courseid;
								$heart_active = '';
								if(in_array($course_id_f, $wishlist_array)){
								$heart_active = 'heart_active';
								}
								?>
								<div class=" product product-grid postproduct col-sm-4  col-lg-4 col-xl-4">
								<span class="gsp-lms gsp-lms-big"><i class="fa fa-heart heart_icon <?php  echo esc_attr($heart_active); ?> " aria-hidden="true" data-id="<?php  echo esc_attr($courseid);?>" data-user_id="<?php  echo esc_attr($user_id);?>" ></i></span>	
								<a href="<?php echo esc_url(get_the_permalink($courseid)); ?>" alt="<?php echo esc_attr(get_the_title($courseid)); ?>">
								<?php
								if ( has_post_thumbnail($courseid) ){
								?>
								<img src="<?php echo esc_url(get_the_post_thumbnail_url($courseid,'thumbnail')); ?>"  class="contextual my_listing_img" alt="" />
								<?php } else {
								?>
								<img src="<?php echo esc_url(home_url()).'/wp-content/plugins/tbit-quick-learn/image/default.png';?>"  class="contextual my_listing_img" alt="" />
								<?php } ?>

								</a>
								<div class="icon-content">
								<a href="<?php echo esc_url(get_the_permalink($courseid)); ?>" alt="<?php echo esc_html(get_the_title($courseid)); ?>"><h3 class="font20"><?php echo esc_html(get_the_title($courseid)); ?></h3> </a>
								</div>
								
								</div>
									
								<?php }
							}
							?>
							</div>
							<?php } else { ?>
							<div class="gsp_lms-message success"><i class="fa"></i>No Wishlist yet</div>
						<?php } ?>
						</div>
					</div>

					<div class="profilebox sectionbox order_tab" style="display: none;">

						<div class="my-box-bg">

							<h2 class="heading-cont">My Orders</h2>

							<?php
							$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."user_payments WHERE user_id=%s",$user_id);
							$get_results = $wpdb->get_results($prepare_sql,ARRAY_A);

							if(count($get_results)<=0){

							?>

							<div class="gsp_lms-message success"><i class="fa"></i>No Orders yet</div>

							<?php } else {?>



							<div >

							<style type="text/css"></style>

							<table border="1" class="gsp_lms_tb-list-table ordertable profile-list-quizzes profile-list-table width-100-zeroborder">

							<thead>

							<tr>

							<th class="column-course">Order</th>

							<th class="column-quiz">Date</th>

							<th class="column-quiz">Status</th>

							<th class="column-quiz">Total</th>

							</tr>

							</thead>

							<tbody>

							<tbody>
							<?php


							function timeago($date) {
							$timestamp = strtotime($date);	

							$strTime = array("second", "minute", "hour", "day", "month", "year");
							$length = array("60","60","24","30","12","10");

							$currentTime = time();
							if($currentTime >= $timestamp) {
							$diff     = time()- $timestamp;
							for($i = 0; $diff >= $length[$i] && $i < count($length)-1; $i++) {
							$diff = $diff / $length[$i];
							}

							$diff = round($diff);
							return $diff . " " . $strTime[$i] . "(s) ago ";
							}
							}
							
							if(count($get_results)>0){

							$ik = 1;

							foreach ($get_results as $key => $value) {
							?>

							<tr>

							<td class="column-quiz"><a href="<?php echo esc_url(get_permalink($value['course_id']));?>"><?php echo esc_html(get_the_title($value['course_id']));?></a></td>

							<td class="column-date"><?php echo esc_html(timeago($value['subscribed_date'])); ?></td>

							<td class="column-status"><?php echo esc_html($value['payment_status']); ?></td>

							<td class="column-total"><?php echo esc_html($value['amount'].' '.tbit_data_retrivedata('gsp_lms_currency')); ?></td>
							</tr>
							<?php $ik++; } } else {?> 
							<tr>
							<td colspan="6" class="text-center"><i class="fa"></i>No Orders yet </td>
							</tr>
							<?php } ?>

							</tbody>

							</tbody>



							</table>



							</div>

	

							<?php } ?>

						</div>						

					</div>

					

					<div class="profilebox sectionbox general_tab" style="display: none;">

						<div class="my-box-bg">

							<h2 class="heading-cont">General Setting</h2>

							<form class="form general_setting_form">

								<div class="row">

									<div class="col-sm-6">

										<div class="form-group">

											<label for="email">Username:</label>

											<input type="text" class="form-control" id="username" value="<?php echo esc_attr($user->user_login); ?>" readonly="">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label for="email">Email:</label>

											<input type="email" class="form-control" id="email" value="<?php echo esc_attr($user->user_email); ?>" readonly="">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label for="email">Name:</label>

											<input type="text" class="form-control" id="Name" name="name" value="<?php echo esc_attr($user->display_name); ?>">

										</div>

									</div>

									<div class="col-sm-6">

										<div class="form-group">

											<label for="email">Phone:</label>

											<?php

											$phone =  get_user_meta($user->ID,'contact_phone',true);

											?>

											<input type="tel" class="form-control" id="tel" name="contact_phone" value="<?php echo esc_attr($phone);?>">

										</div>

									</div>

									
									<?php
									
									$current_user_roles = $user->roles;
									if(in_array('instructor',$current_user_roles) || in_array('administrator',$current_user_roles)){
										$experience =  get_user_meta($user->ID,'instructor_experience',true);
									?>
									<div class="col-sm-6">

										<div class="form-group">

											<label for="Experience">Experience:</label>

											<input type="text" class="form-control" name="instructor_experience" id="Experience" value="<?php echo esc_attr($experience); ?>" >

										</div>

									</div>
									<?php
									$instructor_twitter =  get_user_meta($user->ID,'instructor_twitter',true);
									?>
									<div class="col-sm-6">

										<div class="form-group">

											<label for="Experience">Twitter:</label>

											<input type="text" class="form-control" name="instructor_twitter" id="instructor_twitter" value="<?php echo esc_attr($instructor_twitter); ?>" >

										</div>

									</div>

									<?php
									$instructor_facebook =  get_user_meta($user->ID,'instructor_facebook',true);
									?>
									<div class="col-sm-6">

										<div class="form-group">

											<label for="Experience">Facebook:</label>

											<input type="text" class="form-control" name="instructor_facebook" id="instructor_facebook" value="<?php echo esc_attr($instructor_facebook); ?>" >

										</div>

									</div>

									<?php
									$instructor_instagram =  get_user_meta($user->ID,'instructor_instagram',true);
									?>
									<div class="col-sm-6">

										<div class="form-group">

											<label for="Experience">Instagram:</label>

											<input type="text" class="form-control" name="instructor_instagram" id="instructor_instagram" value="<?php echo esc_attr($instructor_instagram); ?>" >

										</div>

									</div>

									<?php
									$instructor_whatsapp =  get_user_meta($user->ID,'instructor_whatsapp',true);
									?>
									<div class="col-sm-6">

										<div class="form-group">

											<label for="WhatsApp">WhatsApp:</label>

											<input type="text" class="form-control" name="instructor_whatsapp" id="instructor_whatsapp" placeholder="Enter WhatsApp No. " value="<?php echo esc_attr($instructor_whatsapp); ?>" >

										</div>

									</div>

									<?php
									$instructor_bio =  get_user_meta($user->ID,'instructor_bio',true);
									?>
									<div class="col-sm-12">

										<div class="form-group">

											<label for="Experience">Bio:</label>
											<textarea class="form-control" placeholder="Bio" name="instructor_bio" id="instructor_bio" rows="6"><?php echo esc_html($instructor_bio); ?></textarea>

										</div>

									</div>
									<?php }?>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="button" id="general_inforupdtae" class="btn btn-primary mb-2">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
					<div class="profilebox sectionbox avatar_tab" style="display: none;">
						<div class="my-box-bg">
							<h2 class="heading-cont">Avatar Setting</h2>
							<form id="profile_image_uploadform" class="profile_image_uploadbox">
							<div class="edit-pic">
								<img class="edit_pic_border" src="<?php echo esc_url($get_avatar_url);?>" id="userimg" />
								<div class="edit-upload-icon">
									<i class="fa fa-camera"></i>
									<input type="file" id="myFile" name="filename2" accept="image/*" onchange="Account_loadFile(event)">
								</div><br /><br />
								<div class="form-group">
									<button type="button" id="profile_image_upload" class="btn btn-primary mb-2">Submit</button>
								</div>
							</div>
						</form>
						</div>
					</div>
					<div class="profilebox sectionbox password_tab" style="display: none;">
						<div class="my-box-bg">
							<h2 class="heading-cont">Password Setting</h2>
							<form class="form change_password_update">
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label for="Current Password">Current Password:</label>
											<input type="password" class="form-control" id="current_password" name="current_password">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="New Password">New Password:</label>
											<input type="password" class="form-control" id="new_password" name="new_password">
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label for="Confirm Password">Confirm Password:</label>
											<input type="password" class="form-control" id="confirm_password" name="confirm_password">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<button type="button" id="change_password_update" class="btn btn-primary mb-2">Submit</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
			</div>
		</div>
	</div>
</div>
<?php } 
$output_string = ob_get_contents();
	ob_end_clean();
	return $output_string;
}
}
add_shortcode('my-account', 'Tbit_lms_my_account'); 
add_shortcode('wishlist', 'Tbit_lms_wishlist_shortcode'); 
if( !function_exists('Tbit_lms_wishlist_shortcode')){
	function Tbit_lms_wishlist_shortcode(){
		global $wpdb;
		$user_id=get_current_user_id();
		wp_register_style('Tbit_lms_list_custom_css',  plugins_url( 'assets/css/list_custom_css.css', __FILE__ ));
		wp_enqueue_style('Tbit_lms_list_custom_css');
		ob_start()
		?>
		<div class="my-box-bgff container wishlist_shortcodedata">
		<h2 class="heading-cont">Wishlist</h2>
		<?php
		$prepare_sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
		$rr = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($rr)>0){ ?>
		<div >
		<?php
		$prepare_sql = $wpdb->prepare('SELECT course_id FROM '.$wpdb->prefix.'gsp_lms_wishlist WHERE user_id=%s',$user_id);
		$wishlistdata = $wpdb->get_results($prepare_sql,ARRAY_A);
		$wishlist_array = array();
		if(count($wishlistdata)>0){
		foreach ($wishlistdata as $key => $value) {
		$wishlist_array[] = $value['course_id'];
		}
		}
		if(count($rr)>0){
		foreach ($rr as $key => $value) {
		$courseid = $value['course_id'];
		$course_id_f = $courseid;
		$heart_active = '';
		if(in_array($course_id_f, $wishlist_array)){
		$heart_active = 'heart_active';
		}
		?>
		<div class=" product product-grid postproduct col-sm-4  col-lg-4 col-xl-4">
		<span class="gsp-lms gsp-lms-big"><i class="fa fa-heart heart_icon <?php  echo esc_attr($heart_active); ?> " aria-hidden="true" data-id="<?php  echo esc_attr($courseid);?>" data-user_id="<?php  echo esc_attr($user_id);?>"></i></span>	
		<a href="<?php echo esc_url(get_the_permalink($courseid)); ?>" alt="<?php echo esc_attr(get_the_title($courseid)); ?>">
		<?php
		if ( has_post_thumbnail($courseid) ){
		?>
		<img src="<?php echo esc_url(get_the_post_thumbnail_url($courseid,'thumbnail')); ?>"  class="contextual my_listing_img" alt="" />
		<?php } else {
		?>
		<img src="<?php echo esc_url( plugins_url( 'image/default.png', __FILE__ ) );?>"  class="contextual my_listing_img" alt="" />
		<?php } ?>

		</a>
		<div class="icon-content">
		<a href="<?php echo esc_url(get_the_permalink($courseid)); ?>" alt="<?php echo esc_attr(get_the_title($courseid)); ?>"><h3 class="font20"><?php echo esc_html(get_the_title($courseid)); ?></h3> </a>
		</div>
		</div>
		<?php }
		}
		?>
		</div>
		<?php } else { ?>
		<div class="gsp_lms-message success"><i class="fa"></i>No Wishlist yet</div>
		<?php } ?>
		</div>				
		<?php 
		$output_string = ob_get_contents();
		ob_end_clean();
		return $output_string;
}
}
add_filter('user_row_actions', 'Tbit_lms_user_approve_disapporve', 10, 2);
if(!function_exists('Tbit_lms_user_approve_disapporve')){
function Tbit_lms_user_approve_disapporve($actions, $user_object) {
	if(in_array('instructor', $user_object->roles)){
	$getusermeta = get_user_meta($user_object->data->ID,'tbit_user_status',true);
	if( $getusermeta == 1 ){
    $actions['user_approve'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_approve_link'>" . __( 'Approved' ) . "</a>";
    $actions['user_disapprove'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_disapprove_link'>" . __( 'Disapprove' ) . "</a>";
	} else if( $getusermeta == 2) {
		$actions['user_approve'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_approve_link'>" . __( 'Approve' ) . "</a>";
    $actions['user_disapprove'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_disapprove_link'>" . __( 'Disapproved' ) . "</a>";
	} else {
		$actions['user_approve'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_approve_link'>" . __( 'Approve' ) . "</a>";
    $actions['user_disapprove'] = "<a href='#' data-user_id='".$user_object->data->ID."' class='user_disapprove_link'>" . __( 'Disapprove' ) . "</a>";
	}
	}
    return $actions;
}
}
add_action('wp_ajax_approve_user', 'Tbit_lms_approve_user');
if(!function_exists('Tbit_lms_approve_user')){
	function Tbit_lms_approve_user(){
		if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
			$user_id = sanitize_text_field($_POST['user_id']);
			update_user_meta($user_id,'tbit_user_status',1);
			$rrr = Tbit_lms_instructor_approve_disapprove($user_id,'approved');
			echo 1;
		} else {
			echo 0;
		}
		wp_die();
	}
}
add_action('wp_ajax_disapprove_user', 'Tbit_lms_disapprove_user');
if(!function_exists('Tbit_lms_disapprove_user')){
	function Tbit_lms_disapprove_user(){
		if(isset($_POST['user_id']) && !empty($_POST['user_id'])){
			$user_id = sanitize_text_field($_POST['user_id']);
			update_user_meta($user_id,'tbit_user_status',2);
			Tbit_lms_instructor_approve_disapprove($user_id,'disapproved');
			echo 1;
		} else {
			echo 0;
		}
		wp_die();
	}
}
if(!function_exists('Tbit_lms_remove_dashboard_menus')){
function Tbit_lms_remove_dashboard_menus(){
    remove_menu_page( 'view-transaction' ); 
}
}
add_action( 'admin_menu', 'Tbit_lms_remove_dashboard_menus' );
if(!function_exists('Tbit_lms_check_login')){
function Tbit_lms_check_login($user) {


    if ($user instanceof WP_User) {
    	if(in_array('student',$user->roles)){
    		$is_activated = get_user_meta($user->ID,'is_activated',true);
    		if($is_activated == 1){
    			return $user;
    		} else if($is_activated == 0){
    			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Please Verify Your Mail!' ) );
    		}
    	} else if(in_array('instructor', $user->roles)){
        $is_activated = get_user_meta($user->ID,'is_activated',true);
        if($is_activated == 1){
			$getusermeta = get_user_meta($user->ID,'tbit_user_status',true);
			if($getusermeta == 1){
				return $user;
			} else if($getusermeta == 2) {
			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Disapproved your account by Admin!' ) );
			} else {
			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Admin not yet approved your account!' ) );
			}
		} else if($is_activated == 0){
			$user = new WP_Error( 'authentication_failed', __( '<strong>ERROR</strong>: Please Verify Your Mail!' ) );
		}
	}
    }
    return $user;
}
}
add_filter('wp_authenticate_user', 'Tbit_lms_check_login', 9, 1);
add_action('wp_ajax_assetment_retake', 'Tbit_lms_assetment_retake');
if(!function_exists('Tbit_lms_assetment_retake')){
	function Tbit_lms_assetment_retake(){
		if(isset($_POST['assesment_id']) && isset($_POST['course_id']) && !empty($_POST['assesment_id']) && !empty($_POST['course_id'])){
				global $wpdb;
				$user_id=get_current_user_id();
				$assesment_id = sanitize_text_field($_POST['assesment_id']);
				$course_id = sanitize_text_field($_POST['course_id']);
				$prepare_sql = $wpdb->prepare("SELECT user_item_id FROM ".$wpdb->prefix."gsp_user_items WHERE user_id=%s AND item_id=%s AND ref_id =%s ",$user_id,$assesment_id,$course_id);
				$result = $wpdb->get_results($prepare_sql,ARRAY_A);
				if(count($result)>0 && isset($result[0]['user_item_id'])){
					$user_item_id = sanitize_text_field($result[0]['user_item_id']);
					
					$prepare_sql = $wpdb->prepare("SELECT meta_id,meta_value FROM ".$wpdb->prefix."gsp_user_retakemeta WHERE gsp_user_item_id=%s",$user_item_id);

					$r_result = $wpdb->get_results($prepare_sql,ARRAY_A);
					$retake_count = 0;
					if(count($r_result)>0 && isset($r_result[0]['meta_value']) && $r_result[0]['meta_value'] !=''){
						$retake_count = (int)$r_result[0]['meta_value']+1;

						$u_array = array(
							'meta_value' => $retake_count
						);

						$meta_id = $r_result[0]['meta_id'];

						$wpdb->update($wpdb->prefix."gsp_user_retakemeta", $u_array, array('meta_id' => $meta_id ));
					} else {
						$retake_count = 1;

						$i_array = array(
							'gsp_user_item_id' => $user_item_id,
							'meta_key' => 'retaken_count',
							'meta_value' => $retake_count,
						);
						$wpdb->insert($wpdb->prefix."gsp_user_retakemeta", $i_array);
					}
					$wpdb->delete($wpdb->prefix.'gsp_user_itemmeta',array('gsp_user_item_id' => $user_item_id));
					echo 1;
				} else {
					echo 0;
				}

		} else {
			echo 0;
		}
		wp_die();
	}
}

function load_media_files() {
    wp_enqueue_media();
}
add_action( 'admin_enqueue_scripts', 'load_media_files' ); 

add_filter('manage_lms-courses_posts_columns', 'Tbit_lms_course_author_columns_head');
if(!function_exists('Tbit_lms_course_author_columns_head')){
function Tbit_lms_course_author_columns_head($columns) {
    $columns['author'] = 'Author';
    $columns['ratings'] = 'Ratings';
    
	$n_columns = array();
	$move = 'author'; // what to move
	$before = 'taxonomy-course-categories'; // move before this
	foreach($columns as $key => $value) {
	if ($key==$before){
	$n_columns[$move] = $move;
	}
	$n_columns[$key] = $value;
	}
	return $n_columns;


}
}
if(!function_exists('Tbit_lms_courses_course_columns_content')){
function Tbit_lms_courses_course_columns_content($column_name, $post_ID) {
    if($column_name == 'ratings'){

    	$result = Tbit_get_courseratings_count_with_average($post_ID);
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




    	$star_filled_content = 'dashicons-star-filled';
    	$star_empty_content = 'dashicons-star-empty';

    	$datahtml ='<div class="ac_list_rminbox">';
    	$datahtml .='<div class="">'. $raverage .' out of 5 </div>';
    	$datahtml .='<div class="ac_list_raingbox">';
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

    		$datahtml .='<div class="admin_main_starbox">';
    		$datahtml .='<div class="'.$star_empty_content.' admin_under_star"></div>';
    		$datahtml .='<div class="'.$star_filled_content.' admin_over_star" style="width:'.$width.'%"></div>';
    		$datahtml .='</div>';
    	}
    	
    	//if($total>0){
    		$datahtml .=' <div class="">('.esc_html($total).')</div>';
    	//}
    	$datahtml .='</div>';
    	$datahtml .='</div>';
    	echo html_entity_decode(esc_html($datahtml));
    }
}
}

add_action( 'manage_lms-courses_posts_custom_column', 'Tbit_lms_courses_course_columns_content', 5, 2 );

add_filter('manage_lms-lessons_posts_columns', 'Tbit_lms_lessons_course_columns_head');
if(!function_exists('Tbit_lms_lessons_course_columns_head')){
function Tbit_lms_lessons_course_columns_head($columns) {

    $columns['course'] = 'Course';
	$n_columns = array();
	$move = 'course';
	$before = 'date';
	foreach($columns as $key => $value) {
	if ($key==$before){
	$n_columns[$move] = $move;
	}
	$n_columns[$key] = $value;
	}
	return $n_columns;

}

}
if(!function_exists('Tbit_lms_lessons_course_columns_content')){
function Tbit_lms_lessons_course_columns_content($column_name, $post_ID) {
	global $wpdb;
    if ($column_name == 'course') {
    	$prepare_sql = $wpdb->prepare("SELECT course_id FROM ".$wpdb->prefix."gsplms_section_items WHERE item_id=%s AND section_id=%s AND item_type=%s",$post_ID,1,'lms-lessons');

    	$result = $wpdb->get_results($prepare_sql,ARRAY_A);

    	if(count($result)>0 && isset($result[0]['course_id']) && !empty($result[0]['course_id'])){
    		$courses = '';
    		foreach ($result as $key => $value) {
    			$course_id = $value['course_id'];
    			$courses .=  '<a href="'.admin_url('edit.php?post_type=lms-lessons').'&course_id='.$course_id.'">'.get_the_title($value['course_id']).'</a>, ';
    		}
    		
    		echo html_entity_decode(esc_html($courses));
    	} else {
    		echo '<span aria-hidden="true">—</span>';
    	}
    }
}
}
add_action( 'manage_lms-lessons_posts_custom_column', 'Tbit_lms_lessons_course_columns_content', 5, 2 );



add_filter('manage_lms-assesments_posts_columns', 'Tbit_lms_assesments_course_columns_head');
if(!function_exists('Tbit_lms_assesments_course_columns_head')){
function Tbit_lms_assesments_course_columns_head($columns) {

    $columns['course'] = 'Course';
	$n_columns = array();
	$move = 'course';
	$before = 'date';
	foreach($columns as $key => $value) {
	if ($key==$before){
	$n_columns[$move] = $move;
	}
	$n_columns[$key] = $value;
	}
	return $n_columns;

}

}
if(!function_exists('Tbit_lms_assesments_course_columns_content')){
function Tbit_lms_assesments_course_columns_content($column_name, $post_ID) {
	global $wpdb;
    if ($column_name == 'course') {
    	$prepare_sql = $wpdb->prepare("SELECT course_id FROM ".$wpdb->prefix."gsplms_section_items WHERE item_id=%s AND section_id=%s AND item_type=%s",$post_ID,2,'lms-assesments');

    	$result = $wpdb->get_results($prepare_sql,ARRAY_A);

    	if(count($result)>0 && isset($result[0]['course_id']) && !empty($result[0]['course_id'])){
    		$courses = '';
    		foreach ($result as $key => $value) {
    			$course_id = $value['course_id'];
    			$courses .=  '<a href="'.admin_url('edit.php?post_type=lms-assesments').'&course_id='.$course_id.'">'.esc_html(get_the_title($value['course_id'])).'</a>,  ';
    		}
    		echo html_entity_decode(esc_html($courses));
    	} else {
    		echo '<span aria-hidden="true">—</span>';
    	}
    }
}
}
add_action( 'manage_lms-assesments_posts_custom_column', 'Tbit_lms_assesments_course_columns_content', 5, 2 );

add_filter('manage_lms-question_posts_columns', 'Tbit_lms_question_assesments_columns_head');
if(!function_exists('Tbit_lms_question_assesments_columns_head')){
function Tbit_lms_question_assesments_columns_head($columns) {

    $columns['assemensts'] = 'Assessmensts';
	$n_columns = array();
	$move = 'assemensts';
	$before = 'date';
	foreach($columns as $key => $value) {
	if ($key==$before){
	$n_columns[$move] = $move;
	}
	$n_columns[$key] = $value;
	}
	return $n_columns;

}

}
if(!function_exists('Tbit_lms_question_assesments_columns_content')){
function Tbit_lms_question_assesments_columns_content($column_name, $post_ID) {
	global $wpdb;
    if ($column_name == 'assemensts') {
    	$prepare_sql = $wpdb->prepare("SELECT quiz_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE question_id=%s",$post_ID);

    	$result = $wpdb->get_results($prepare_sql,ARRAY_A);

    	if(count($result)>0 && isset($result[0]['quiz_id']) && !empty($result[0]['quiz_id'])){
    		$assesmentdata = '';
    		foreach ($result as $key => $value) {
    			$quiz_id = $value['quiz_id'];
    			$assesmentdata .=  '<a href="'.admin_url('edit.php?post_type=lms-question').'&assesment_id='.$quiz_id.'">'.get_the_title($value['quiz_id']).'</a>, ';
    		}
    		
    		echo html_entity_decode(esc_html($assesmentdata));
    	} else {
    		echo '<span aria-hidden="true">—</span>';
    	}
    }
}
}
add_action( 'manage_lms-question_posts_custom_column', 'Tbit_lms_question_assesments_columns_content', 5, 2 );
add_action( 'pre_get_posts', function ( $wp_query ) {
	if (
        ! empty( $_REQUEST['course_id'] ) &&
        is_admin() &&
        $wp_query->is_main_query() &&
        ( $wp_query->get( 'post_type' ) === 'lms-assesments' || $wp_query->get( 'post_type' ) === 'lms-lessons' )
    ) {
		global $wpdb;
		$course_id = sanitize_text_field($_REQUEST['course_id']);
		$type = 'lms-lessons';
		$section_id = 1;
		if($wp_query->get( 'post_type' ) === 'lms-assesments' ){
			$type = 'lms-assesments';
			$section_id = 2;
		} else if($wp_query->get( 'post_type' ) === 'lms-lessons'){
			$type = 'lms-lessons';
			$section_id = 1;
		}

		$prepare_sql = $wpdb->prepare("SELECT item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE course_id=%s AND section_id=%s AND item_type=%s GROUP BY item_id",$course_id,$section_id,$type);

		$courses = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($courses)>0){
			$lesson_id = [];
			foreach ($courses as $key => $value) {
				$lesson_id[] = $value['item_id'];
			}
			$wp_query->set( 'post__in', $lesson_id );
		}


         

	} else if (
        ! empty( $_REQUEST['assesment_id'] ) &&
        is_admin() &&
        $wp_query->is_main_query() &&
        ( $wp_query->get( 'post_type' ) === 'lms-question')
    ) {

    	global $wpdb;
		$assesment_id = sanitize_text_field($_REQUEST['assesment_id']);
		$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s GROUP BY question_id",$assesment_id);

		$questions = $wpdb->get_results($prepare_sql,ARRAY_A);
		if(count($questions)>0){
			$questions_id = [];
			foreach ($questions as $key => $value) {
				$questions_id[] = $value['question_id'];
			}
			$wp_query->set( 'post__in', $questions_id );
		}

	}
});

add_action( 'restrict_manage_posts', function(){
	$course_id = '';
	if(isset($_GET['course_id']) && $_GET['course_id'] !=''){
		$course_id = sanitize_text_field($_GET['course_id']);
	}
	$assesment_id = '';
	if(isset($_GET['assesment_id']) && $_GET['assesment_id'] !=''){
		$assesment_id = sanitize_text_field($_GET['assesment_id']);
	}
?>
<input type="hidden" name="assesment_id" value="<?php echo esc_attr($assesment_id); ?>" />
<?php } );

add_action('parent_file', function(){
	global $current_screen;
    $taxonomy = $current_screen->taxonomy;
    if ($taxonomy == 'course-categories')
        return $parent_file = 'lms-settings1';
    if ($taxonomy == 'course_tag')
        return $parent_file = 'lms-settings1';
});


add_action( 'user_register', function( $user_id ) {

   $gsp_from_name = Tbit_lms_retrivedata('gsp_from_name');
   $gsp_from_email = Tbit_lms_retrivedata('gsp_from_email');
   $admin_email = get_bloginfo( 'admin_email' );

   $userdata = get_userdata($user_id);
   $roles = $userdata->roles;
    
	if(in_array('student',$roles)){
		tbit_lms_verification_mail_send($user_id);
		$gsp_lms_email_become_an_student = Tbit_lms_retrivedata('gsp_lms_email_become_an_student');
		if($gsp_lms_email_become_an_student !=''){
			$json_decode_become_student = json_decode($gsp_lms_email_become_an_student,true);
			if(isset($json_decode_become_student['enable']) && $json_decode_become_student['enable'] == 1){
			$gsp_lms_email_become_an_student_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_email_content_html');
			if($gsp_lms_email_become_an_student_email_content_html !=''){
			$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_student_email_content_html),$user_id);

			$message = Tbit_mail_with_html($return_message);

			$subject = Tbit_become_an_instructor_mail_html($json_decode_become_student['subject'],$user_id);

			$mailsend = Tbit_mail_send($gsp_from_email,$admin_email,$subject,$message,$gsp_from_name);
			}
			}
		} /* gsp_lms_email_become_an_student end code  */



		$gsp_lms_email_become_an_student_send_mail = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_send_mail');
		if($gsp_lms_email_become_an_student_send_mail !=''){
			$become_an_student_send_mail = json_decode($gsp_lms_email_become_an_student_send_mail,true);
			if(isset($become_an_student_send_mail['enable']) && $become_an_student_send_mail['enable'] == 1){
			$gsp_lms_email_become_an_student_send_mail_email_content_html = Tbit_lms_retrivedata('gsp_lms_email_become_an_student_send_mail_email_content_html');
			if($gsp_lms_email_become_an_student_send_mail_email_content_html !=''){
			$return_message = Tbit_become_an_instructor_mail_html(stripslashes($gsp_lms_email_become_an_student_send_mail_email_content_html),$user_id);
			$message = Tbit_mail_with_html($return_message);
			$subject = Tbit_become_an_instructor_mail_html($become_an_student_send_mail['subject'],$user_id);
			$mailsend = Tbit_mail_send($gsp_from_email,$userdata->user_email,$subject,$message,$gsp_from_name);
			}
			}
		} /* gsp_lms_email_become_an_student end code  */

	}

} );
add_action('init','tbit_lms_new_rewrite_rule');
if(!function_exists('tbit_lms_new_rewrite_rule')){
function tbit_lms_new_rewrite_rule(){
	add_rewrite_endpoint('thankyou',EP_ALL);
	flush_rewrite_rules();
}
}
add_filter( 'template_include', 'tbit_lms_template_include');
if(!function_exists('tbit_lms_template_include')){
function tbit_lms_template_include($template){
if ( get_query_var( 'thankyou', false ) !== false ) {
	Tbit_lms_addpayment();
	$new_template = TBIT_LMS_DIR .'/templates/thankyou.php';
	if(file_exists($new_template)){
		$template = $new_template;
	} 
}
return $template;
}
}
add_action( 'init', 'tbit_lms_verify_user_code' );
if(!function_exists('tbit_lms_verify_user_code')){
function tbit_lms_verify_user_code(){
    if(isset($_GET['act'])){
    	$act = sanitize_text_field($_GET['act']);
        $data = unserialize(base64_decode($act));
        $code = get_user_meta($data['id'], 'activation_code', true);
        // verify whether the code given is the same as ours
        if($code == $data['code']){
            // update the user meta
            update_user_meta($data['id'], 'is_activated', 1);
            $_SESSION['account_activated'] = ( __( '<strong>Success:</strong> Your account has been verified!', 'text-domain' )  );
        }
    }
}
}