<?php

require('inc/gsp-functions.php');
require('inc/gsp_theme_config.php');
add_action('wp_ajax_addnewsection', 'Tbit_lms_add_new_sction_function');
if( !function_exists('Tbit_lms_add_new_sction_function')){
function Tbit_lms_add_new_sction_function(){
	if(isset($_POST['section_name']) && $_POST['section_name'] !=''){

		global $wpdb;
		$section_name = sanitize_text_field($_POST['section_name']);

		$section_course_id = 0;
		if(isset($_POST['section_course_id']) && !empty($_POST['section_course_id'])){
		$section_course_id= sanitize_text_field($_POST['section_course_id']);
		}

		$section_order = '';
		if(isset($_POST['section_order']) && !empty($_POST['section_order'])){
		$section_order= sanitize_text_field($_POST['section_order']);
		}


		$tablename=$wpdb->prefix.'gsplms_sections';
		$wpdb->insert($tablename,array(
			'section_name' => $section_name,
			'section_course_id' => $section_course_id,
			'section_order' =>  $section_order,
			'section_description' => '',
		));
	}
	$section_name=$section_name;
	$lastid = $wpdb->insert_id;
	$data=require_once('inc/admin/template-part/course_newsection.php');
	die;
	
}
}

add_action('wp_ajax_updatesectiondata', 'Tbit_lms_update_section_data_function');
if( !function_exists('Tbit_lms_update_section_data_function')){
function Tbit_lms_update_section_data_function(){
	if(isset($_POST['section_name']) && $_POST['section_name'] !=''){

		global $wpdb;

		$section_name = sanitize_text_field($_POST['section_name']);
		$section_description = '';
		if(isset($_POST['section_description']) && !empty($_POST['section_description'])){
			$section_description = sanitize_textarea_field($_POST['section_description']);
		}

		$section_id = 0;
		if(isset($_POST['section_id']) && !empty($_POST['section_id'])){
		$section_id= sanitize_text_field($_POST['section_id']);
		}

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


add_action('wp_ajax_insertlesstinandtest', 'Tbit_lms_insert_section_item_function');
if( !function_exists('Tbit_lms_insert_section_item_function')){
function Tbit_lms_insert_section_item_function(){
	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['lessionandtesttitle']) && $_POST['lessionandtesttitle'] !=''){
		global $wpdb;

		$post_type=sanitize_text_field($_POST['type']);
		$user_id=get_current_user_id();
		$title=sanitize_text_field($_POST['lessionandtesttitle']);
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
		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
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
	$lastid = $wpdb->insert_id;
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




add_action('wp_ajax_deletesectionitem', 'Tbit_lms_delete_section_item_function');
if( !function_exists('Tbit_lms_delete_section_item_function')){
function Tbit_lms_delete_section_item_function(){
	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['section_id']) && $_POST['section_id'] !=''){
		global $wpdb;
		$post_type=sanitize_text_field($_POST['type']);
		$section_id=sanitize_text_field($_POST['section_id']);

		$deletetype = '';
		if(isset($_POST['deletetype']) && !empty($_POST['deletetype'])){
		$deletetype= sanitize_text_field($_POST['deletetype']);
		}

		$section_item_id = 0;
		if(isset($_POST['section_item_id']) && !empty($_POST['section_item_id'])){
		$section_item_id= sanitize_text_field($_POST['section_item_id']);
		}


		
		if($deletetype=='permanently'){
			$prepare_sql = $wpdb->prepare('SELECT item_id FROM '.$wpdb->prefix.'gsplms_section_items WHERE section_item_id=%s',$section_item_id);
			$get_id=$wpdb->get_results($prepare_sql,ARRAY_A);
			$post_id=$get_id[0]['item_id'];
			$wpdb->delete($wpdb->prefix.'posts',array('ID'=>$post_id));
			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('section_item_id'=>$section_item_id));
		} else {
			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('section_item_id'=>$section_item_id));
		}
		
	}
	echo 'yes';
	die;
	
}
}

add_action('wp_ajax_deletesection', 'Tbit_lms_delete_section_function');
if( !function_exists('Tbit_lms_delete_section_function')){
function Tbit_lms_delete_section_function(){


			$wpdb->delete($wpdb->prefix.'gsplms_section_items',array('section_item_id'=>$section_item_id));
			$wpdb->delete($wpdb->prefix.'gsplms_sections',array('section_id'=>$section_id));
		}
	}

add_action('wp_ajax_getselectionbox', 'Tbit_lms_getselectionbox_function');
if( !function_exists('Tbit_lms_getselectionbox_function')){
function Tbit_lms_getselectionbox_function(){

	if(isset($_POST['type']) && $_POST['type'] !=''){
		global $wpdb;

		$type=sanitize_text_field($_POST['type']);

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
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND ID NOT IN (".$excludelessiondata.")",'lms-lessons','publish');
				$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);
				$alldata=$lessiondata;
			} else {
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s",'lms-lessons','publish');
				$lessiondata=$wpdb->get_results($prepare_sql,ARRAY_A);
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
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s AND ID NOT IN (".$excludeassesmentdata.")",'lms-assesments','publish');
				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
				$alldata=$assesmentdata;
			} else {
				$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_type=%s AND post_status=%s",'lms-assesments','publish');
				$assesmentdata=$wpdb->get_results($prepare_sql,ARRAY_A);
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
		$post_type=sanitize_text_field($_POST['type']);
		$section_id=sanitize_text_field($_POST['section_id']);
		
		$course_id = 0;
		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
		$course_id= sanitize_text_field($_POST['course_id']);
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
	echo esc_html($datahtml);
	wp_die();
	
}
}


add_action('wp_ajax_searchquery', 'Tbit_lms_searchquery_function');
if( !function_exists('Tbit_lms_searchquery_function')){
function Tbit_lms_searchquery_function(){
	if(isset($_POST['type']) && $_POST['type'] !='' && isset($_POST['section_id']) && $_POST['section_id'] !=''){
		global $wpdb;
		$post_type=sanitize_text_field($_POST['type']);
		$section_id=sanitize_text_field($_POST['section_id']);

		$course_id = 0;
		if(isset($_POST['course_id']) && !empty($_POST['course_id'])){
		$course_id= sanitize_text_field($_POST['course_id']);
		}

		$search = '';
		if(isset($_POST['search']) && !empty($_POST['search'])){
		$search= sanitize_text_field($_POST['search']);
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