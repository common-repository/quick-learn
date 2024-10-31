<?php
add_action('admin_init','Tbit_lms_rpt_add_role_caps',999);
if( !function_exists('Tbit_lms_rpt_add_role_caps')){
function Tbit_lms_rpt_add_role_caps() {

	$roles = array(
		'administrator',
		'instructor',
		'student'

	);

	foreach ($roles as $key => $value) {
		if($value == 'instructor'){
		$role = get_role($value);               

	    $role->add_cap( 'read');
	    $role->add_cap('upload_files');
	    $role->add_cap( 'read_lms-courses');
	    $role->add_cap( 'read_private_lms-courses' );
	    $role->add_cap( 'edit_lms-courses' );
	    $role->add_cap( 'edit_published_lms-courses' );
	    $role->add_cap( 'delete_private_lms-courses' );
	    $role->add_cap( 'delete_published_lms-courses' );
	    $role->remove_cap('delete_lms-courses');
	    $role->remove_cap('delete_others_lms-courses');
	    $role->remove_cap('edit_others_lms-courses');
	    $role->remove_cap('publish_lms-courses');
	    $role->add_cap( 'delete_private_lms-lessons' );
	    $role->add_cap( 'delete_published_lms-lessons' );
	    $role->add_cap( 'edit_lms-lessons' );
	    $role->add_cap( 'edit_private_lms-lessons');
	    $role->add_cap( 'edit_published_lms-lessons' );
	    $role->add_cap( 'read_private_lms-lessons' );
	    $role->remove_cap('delete_lms-lessons');
	    $role->remove_cap('delete_others_lms-lessons');
	    $role->remove_cap('edit_others_lms-lessons');
	    $role->remove_cap('publish_lms-lessons');
	    $role->add_cap( 'delete_private_lms-assesments' );
	    $role->add_cap( 'delete_published_lms-assesments' );
	    $role->add_cap( 'edit_lms-assesments' );
	    $role->add_cap( 'edit_private_lms-assesments');
	    $role->add_cap( 'edit_published_lms-assesments' );
	    $role->add_cap( 'read_private_lms-assesments' );
	    $role->remove_cap('delete_lms-assesments');
	    $role->remove_cap('delete_others_lms-assesments');
	    $role->remove_cap('edit_others_lms-assesments');
	    $role->remove_cap('publish_lms-assesments');
	    $role->add_cap( 'delete_private_lms-question' );
	    $role->add_cap( 'delete_published_lms-question' );
	    $role->add_cap( 'edit_lms-question' );
	    $role->add_cap( 'edit_private_lms-question');
	    $role->add_cap( 'edit_published_lms-question' );
	    $role->add_cap( 'delete_posts' );
	    $role->add_cap( 'delete_published_posts' );
	    $role->remove_cap('delete_others_posts');
	    $role->remove_cap('delete_private_posts');
	    $role->remove_cap('edit_others_posts');
	    $role->remove_cap('edit_posts');
	    $role->remove_cap('edit_private_posts');
	    $role->remove_cap('edit_published_posts');
	    $role->remove_cap('manage_categories');
	    $role->remove_cap('moderate_comments');
	    $role->remove_cap('publish_posts');
	    $role->remove_cap('read_private_posts');
	    $role->remove_cap('delete_lms-question');
	    $role->remove_cap('delete_others_lms-question');
	    $role->remove_cap('edit_others_lms-question');
	    $role->remove_cap('publish_lms-question');
	} else if($value == 'administrator'){
		$role = get_role($value);               

	    $role->add_cap( 'read');
	    $role->add_cap('upload_files');
	    $role->add_cap( 'read_lms-courses');
	    $role->add_cap( 'read_private_lms-courses' );
	    $role->add_cap( 'edit_lms-courses' );
	    $role->add_cap( 'edit_published_lms-courses' );
	    $role->add_cap( 'delete_private_lms-courses' );
	    $role->add_cap( 'delete_published_lms-courses' );
	    $role->add_cap('delete_lms-courses');
	    $role->add_cap('delete_others_lms-courses');
	    $role->add_cap('edit_others_lms-courses');
	    $role->add_cap('publish_lms-courses');
	    $role->add_cap( 'delete_private_lms-lessons' );
	    $role->add_cap( 'delete_published_lms-lessons' );
	    $role->add_cap( 'edit_lms-lessons' );
	    $role->add_cap( 'edit_private_lms-lessons');
	    $role->add_cap( 'edit_published_lms-lessons' );
	    $role->add_cap( 'read_private_lms-lessons' );
	    $role->add_cap('delete_lms-lessons');
	    $role->add_cap('delete_others_lms-lessons');
	    $role->add_cap('edit_others_lms-lessons');
	    $role->add_cap('publish_lms-lessons');
	    $role->add_cap( 'delete_private_lms-assesments' );
	    $role->add_cap( 'delete_published_lms-assesments' );
	    $role->add_cap( 'edit_lms-assesments' );
	    $role->add_cap( 'edit_private_lms-assesments');
	    $role->add_cap( 'edit_published_lms-assesments' );
	    $role->add_cap( 'read_private_lms-assesments' );
	    $role->add_cap('delete_lms-assesments');
	    $role->add_cap('delete_others_lms-assesments');
	    $role->add_cap('edit_others_lms-assesments');
	    $role->add_cap('publish_lms-assesments');
	    $role->add_cap( 'delete_private_lms-question' );
	    $role->add_cap( 'delete_published_lms-question' );
	    $role->add_cap( 'edit_lms-question' );
	    $role->add_cap( 'edit_private_lms-question');
	    $role->add_cap( 'edit_published_lms-question' );
	    $role->add_cap( 'delete_posts' );
	    $role->add_cap( 'delete_published_posts' );
	    $role->add_cap('delete_others_posts');
	    $role->add_cap('delete_private_posts');
	    $role->add_cap('edit_others_posts');
	    $role->add_cap('edit_posts');
	    $role->add_cap('edit_private_posts');
	    $role->add_cap('edit_published_posts');
	    $role->add_cap('manage_categories');
	    $role->add_cap('moderate_comments');
	    $role->add_cap('publish_posts');
	    $role->add_cap('read_private_posts');
	    $role->add_cap('delete_lms-question');
	    $role->add_cap('delete_others_lms-question');
	    $role->add_cap('edit_others_lms-question');
	    $role->add_cap('publish_lms-question');
	} else if($value == 'student'){
		$role = get_role($value);
	    $role->remove_cap('delete_others_posts');
	    $role->remove_cap('delete_private_posts');
	    $role->remove_cap('edit_others_posts');
	    $role->remove_cap('edit_posts');
	    $role->remove_cap('read');
	    $role->remove_cap('edit_private_posts');
	    $role->remove_cap('edit_published_posts');
	    $role->remove_cap('manage_categories');
	    $role->remove_cap('moderate_comments');
	    $role->remove_cap('publish_posts');
	    $role->remove_cap('read_private_posts');
	    $role->remove_cap('delete_lms-question');
	    $role->remove_cap('delete_others_lms-question');
	    $role->remove_cap('edit_others_lms-question');
	    $role->remove_cap('publish_lms-question');
	}
}
}

}


?>