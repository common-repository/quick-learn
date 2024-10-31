<?php

register_activation_hook( __FILE__, 'Tbit_lms_activation_function');
	if( !function_exists('Tbit_lms_activation_function')){
	function Tbit_lms_activation_function() {
	global $wpdb;
	$wpdb->hide_errors();
	$collate = '';
	 if ( $wpdb->has_cap( 'collation' ) ) {
		$collate = $wpdb->get_charset_collate();
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		$queries = array();
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
		array_push($queries, "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}gsp_user_items (
		`user_item_id` bigint(20) NOT NULL AUTO_INCREMENT,
		`user_id` bigint(20) NULL,
		`item_id` bigint(20) NULL,
		`start_time` datetime NULL,
		`end_time` datetime NULL,
		`status` varbinary(45) NULL,
		`ref_id` bigint(20) NULL,
		`ref_type` varchar(45) NULL,
		`parent_id` bigint(20) NULL,PRIMARY KEY  (`user_item_id`)
		) {$collate}");

		foreach ($queries as $key => $sql) {
		dbDelta( $sql );
		}
	 }
}
}
?>