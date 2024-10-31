<?php
require('template-part/admin_menu.php');
add_theme_support( 'post-thumbnails' );
if( !function_exists('Tbit_lms_create_gsplms_submenu')){
function Tbit_lms_create_gsplms_submenu(){
	global $current_user;
	$current_user_roles = $current_user->roles;


	$labels = array(
        'name'                       => _x( 'Courses', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Course', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Taxonomy', 'text_domain' ),
        'all_items'                  => __( 'All Course', 'text_domain' ),
        'parent_item'                => __( 'Parent Course', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Course:', 'text_domain' ),
        'new_item_name'              => __( 'New Course', 'text_domain' ),
        'add_new'            		 => _x( 'Add Course', 'text_domain' ),
        'add_new_item'               => __( 'Add Course', 'text_domain' ),
        'edit_item'                  => __( 'Edit Course', 'text_domain' ),
        'update_item'                => __( 'Update Course', 'text_domain' ),
        'view_item'                  => __( 'View Course', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Course', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Course', 'text_domain' ),
        'search_items'               => __( 'Search Course', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No Course', 'text_domain' ),
        'items_list'                 => __( 'Course list', 'text_domain' ),
        'items_list_navigation'      => __( 'Course list navigation', 'text_domain' ),
    );
 
	if(in_array('administrator', $current_user_roles)){
	
	register_post_type('lms-courses',
 		array(
 			'labels' => array(
 				'name' => esc_html('Courses','tbit-quick-learn'),
 				'singular_name' => esc_html('Course','tbit-quick-learn'),
 				'add_new' => esc_html('Add New Course','tbit-quick-learn'),
 				'add_new_item' => esc_html('Add New Course','tbit-quick-learn'),
 				'edit' => esc_html('Edit Course','tbit-quick-learn'),
 				'edit_item' => esc_html('Edit Course','tbit-quick-learn'),
 				'new_item' => esc_html('New Course','tbit-quick-learn'),
 				'view' => esc_html('View Course','tbit-quick-learn'),
 				'view_item' => esc_html('View Course','tbit-quick-learn'),
 				'search_items' => esc_html('Search Course','tbit-quick-learn'),
 				'not_found' => esc_html('No Course','tbit-quick-learn'),
 				'not_found_in_trash' => esc_html('No Course','tbit-quick-learn'),
 			),
 			'public'   => true,
 			'capability_type' => array('lms-course','lms-courses'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
            'show_in_rest' => true,
 			'supports' => array('editor','title','thumbnail','custom-fields','page-attributes','post-formats','editor'),
			'register_meta_box_cb' => 'Tbit_lms_course_meta_boxs',
			'show_in_menu' => 'lms-settings1',
 		)
 	);
} else {
	register_post_type('lms-courses',
 		array(
 			'labels' => array(
 				'name' => esc_html('Courses','tbit-quick-learn'),
 				'singular_name' => esc_html('Course','tbit-quick-learn'),
 				'add_new' => esc_html('Add New Course','tbit-quick-learn'),
 				'add_new_item' => esc_html('Add New Course','tbit-quick-learn'),
 				'edit' => esc_html('Edit Course','tbit-quick-learn'),
 				'edit_item' => esc_html('Edit Course','tbit-quick-learn'),
 				'new_item' => esc_html('New Course','tbit-quick-learn'),
 				'view' => esc_html('View Course','tbit-quick-learn'),
 				'view_item' => esc_html('View Course','tbit-quick-learn'),
 				'search_items' => esc_html('Search Course','tbit-quick-learn'),
 				'not_found' => esc_html('No Course','tbit-quick-learn'),
 				'not_found_in_trash' => esc_html('No Course','tbit-quick-learn'),
 			),
 			'public'   => true,
 			'capability_type' => array('lms-course','lms-courses'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
            'show_in_rest' => true,
 			'supports' => array('editor','title','thumbnail','custom-fields','page-attributes','post-formats','editor'),
			'register_meta_box_cb' => 'Tbit_lms_course_meta_boxs',
 		)
 	);
}

	$labels = array(
        'name'                       => _x( 'Course Categories', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Course Categories', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Course Categories', 'text_domain' ),
        'all_items'                  => __( 'Course Categories', 'text_domain' ),
        'parent_item'                => __( 'Parent Course Categories', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Course Categories:', 'text_domain' ),
        'new_item_name'              => __( 'New Course Categories', 'text_domain' ),
        'add_new'            		 => _x( 'Add Course Categories', 'text_domain' ),
        'add_new_item'               => __( 'Add Course Categories', 'text_domain' ),
        'edit_item'                  => __( 'Edit Course Categories', 'text_domain' ),
        'update_item'                => __( 'Update Course Categories', 'text_domain' ),
        'view_item'                  => __( 'View Course Categories', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Course Categories', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Course Categories', 'text_domain' ),
        'search_items'               => __( 'Search Course Categories', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No Course Categories', 'text_domain' ),
        'items_list'                 => __( 'Course Categories list', 'text_domain' ),
        'items_list_navigation'      => __( 'Course Categories list navigation', 'text_domain' ),
    );
    $args = array(
        'labels'                     => $labels,
        'hierarchical'               => true,
        'public'                     => true,
        'show_ui'                    => true,
        'show_admin_column'          => true,
        'show_in_nav_menus'          => true,
        'show_tagcloud'              => true,
        'show_in_rest' => true,
    );
    register_taxonomy( 'course-categories', array( 'lms-courses' ), $args );


    register_taxonomy( 
            'course_tag', 
            'lms-courses', 
            array(
                'label'         => __( 'Tags', 'text_domain' ), 
                'singular_name' => __( 'Tag', 'text_domain' ), 
                'hierarchical'               => true,
                'public'                     => true,
                'show_ui'                    => true,
                'show_admin_column'          => true,
                'show_in_nav_menus'          => true,
                'show_tagcloud'              => true,
                'show_in_rest' => true,
            )  
        );


    $labels = array(
        'name'                       => _x( 'Lessons', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Lessons', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Lessons', 'text_domain' ),
        'all_items'                  => __( 'Lessons', 'text_domain' ),
        'parent_item'                => __( 'Parent Lesson', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Lesson:', 'text_domain' ),
        'new_item_name'              => __( 'New Lesson', 'text_domain' ),
        'add_new'            		 => _x( 'Add Lesson', 'text_domain' ),
        'add_new_item'               => __( 'Add Lesson', 'text_domain' ),
        'edit_item'                  => __( 'Edit Lesson', 'text_domain' ),
        'update_item'                => __( 'Update Lesson', 'text_domain' ),
        'view_item'                  => __( 'View Lesson', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Lesson', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Lesson', 'text_domain' ),
        'search_items'               => __( 'Search Lesson', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No Lesson', 'text_domain' ),
        'items_list'                 => __( 'Lesson list', 'text_domain' ),
        'items_list_navigation'      => __( 'Lesson list navigation', 'text_domain' ),
    );
	if(in_array('administrator', $current_user_roles)){
	
	register_post_type('lms-lessons',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-lesson','lms-lessons'),
 			'map_meta_cap' => true,
 			'hierarchical' => false,
 			'has_archive' => false,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_lesson_meta_boxs',
			'show_in_menu' => 'lms-settings1',
 		)
 	);
} else {
	register_post_type('lms-lessons',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-lesson','lms-lessons'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_lesson_meta_boxs',
 		)
 	);
}

	$labels = array(
        'name'                       => _x( 'Assessments', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Assessments', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Assessments', 'text_domain' ),
        'all_items'                  => __( 'Assessments', 'text_domain' ),
        'parent_item'                => __( 'Parent Assessment', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Assessment:', 'text_domain' ),
        'new_item_name'              => __( 'New Assessment', 'text_domain' ),
        'add_new'            		 => _x( 'Add Assessment', 'text_domain' ),
        'add_new_item'               => __( 'Add Assessment', 'text_domain' ),
        'edit_item'                  => __( 'Edit Assessment', 'text_domain' ),
        'update_item'                => __( 'Update Assessment', 'text_domain' ),
        'view_item'                  => __( 'View Assessment', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Assessment', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Assessment', 'text_domain' ),
        'search_items'               => __( 'Search Assessment', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No Assessment', 'text_domain' ),
        'items_list'                 => __( 'Assessment list', 'text_domain' ),
        'items_list_navigation'      => __( 'Assessment list navigation', 'text_domain' ),
    );

	if(in_array('administrator', $current_user_roles)){
	
	register_post_type('lms-assesments',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-assesment','lms-assesments'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_assesment_meta_boxs',
			'show_in_menu' => 'lms-settings1',
 		)
 	);
} else {
	register_post_type('lms-assesments',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-assesment','lms-assesments'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_assesment_meta_boxs',
 		)
 	);
}

	$labels = array(
        'name'                       => _x( 'Questions', 'Taxonomy General Name', 'text_domain' ),
        'singular_name'              => _x( 'Question', 'Taxonomy Singular Name', 'text_domain' ),
        'menu_name'                  => __( 'Questions', 'text_domain' ),
        'all_items'                  => __( 'Questions', 'text_domain' ),
        'parent_item'                => __( 'Parent Question', 'text_domain' ),
        'parent_item_colon'          => __( 'Parent Question:', 'text_domain' ),
        'new_item_name'              => __( 'New Question', 'text_domain' ),
        'add_new'            		 => _x( 'Add Question', 'text_domain' ),
        'add_new_item'               => __( 'Add Question', 'text_domain' ),
        'edit_item'                  => __( 'Edit Question', 'text_domain' ),
        'update_item'                => __( 'Update Question', 'text_domain' ),
        'view_item'                  => __( 'View Question', 'text_domain' ),
        'separate_items_with_commas' => __( 'Separate items with commas', 'text_domain' ),
        'add_or_remove_items'        => __( 'Add or remove Question', 'text_domain' ),
        'choose_from_most_used'      => __( 'Choose from the most used', 'text_domain' ),
        'popular_items'              => __( 'Popular Question', 'text_domain' ),
        'search_items'               => __( 'Search Question', 'text_domain' ),
        'not_found'                  => __( 'Not Found', 'text_domain' ),
        'no_terms'                   => __( 'No Question', 'text_domain' ),
        'items_list'                 => __( 'Question list', 'text_domain' ),
        'items_list_navigation'      => __( 'Question list navigation', 'text_domain' ),
    );

	if(in_array('administrator', $current_user_roles)){
	
	register_post_type('lms-question',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-questi','lms-question'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_question_meta_boxs',
			'show_in_menu' => 'lms-settings1',
 		)
 	);
} else {
	register_post_type('lms-question',
 		array(
 			'labels' => $labels,
 			'public'   => true,
            'publicly_queryable' => false,
 			'capability_type' => array('lms-questi','lms-question'),
 			'map_meta_cap' => true,
 			'hierarchical' => true,
 			'has_archive' => true,
 			'supports' => array('editor','title','post-formats'),
			'register_meta_box_cb' => 'Tbit_lms_question_meta_boxs',
 		)
 	);
}
flush_rewrite_rules();

 }
}
 add_action('init','Tbit_lms_create_gsplms_submenu');
 if( !function_exists('Tbit_lms_gsp_lms_new_menu')){
 function Tbit_lms_gsp_lms_new_menu() {
	register_nav_menu('primary-menu',__( 'Primary Menu' ));
}
}
if( !function_exists('Tbit_lms_register_settings')){
function Tbit_lms_register_settings() {
	register_setting( 'theme_options', 'theme_options','sanitize' );
}
}
if ( is_admin() ) {
 add_action( 'admin_menu', 'Tbit_lms_add_admin_menu');
 add_action( 'admin_init', 'Tbit_lms_register_settings');
}
if( !function_exists('Tbit_lms_add_admin_menu')){
function Tbit_lms_add_admin_menu() {
  add_menu_page('LMS','Quick Learn','manage_options','lms-settings1','5','dashicons-welcome-learn-more',5);
  add_submenu_page( 'lms-settings1', 'Instructors', 'Instructors','manage_options', 'instructors','Tbit_lms_instructor_pro',0);

  add_submenu_page( 'lms-settings1', 'Students', 'Students','manage_options', 'students','Tbit_lms_student',1);

  add_submenu_page( 'lms-settings1', 'Categories', 'Categories','manage_options', 'edit-tags.php?taxonomy=course-categories','',2);
  add_submenu_page( 'lms-settings1', 'Tags', 'Tags','manage_options', 'edit-tags.php?taxonomy=course_tag','',3);

  add_submenu_page('lms-settings1','Pay Commission','Pay Commission','manage_options','instructor-payment','Tbit_lms_instructor_payment_pro',9);
  add_menu_page('View Transaction','View Transaction','manage_options','view-transaction','Tbit_lms_view_transaction_pro','dashicons-money-alt');
  add_submenu_page('lms-settings1','Reviews','Reviews','manage_options','reviews','Tbit_lms_course_review',8);
}
}

if(!function_exists('Tbit_lms_instructor_payment_pro')){
    function Tbit_lms_instructor_payment_pro(){
        if(function_exists('Tbit_lms_instructor_payment')){
            Tbit_lms_instructor_payment();
        } else {
            echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Pay')));
        }
    }
}
if(!function_exists('Tbit_lms_instructor_pro')){
    function Tbit_lms_instructor_pro(){
        if(function_exists('Tbit_lms_instructor')){
            Tbit_lms_instructor();
        } else {
           echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('Instructors')));
        }
    }
}
if(!function_exists('Tbit_lms_view_transaction_pro')){
    function Tbit_lms_view_transaction_pro(){
        if(function_exists('Tbit_lms_view_transaction')){
            Tbit_lms_view_transaction();
        } else {
            echo html_entity_decode(esc_html(Tbit_lms_require_pro_version_html('View Transaction')));
        }
    }
}

if(!function_exists('Tbit_lms_course_review')){
    function Tbit_lms_course_review(){
    global $wpdb;
    wp_register_style('Tbit_lms_fontawesome',  plugins_url( '/../assets/css/font-awesome.min.css?id='.rand(), dirname(__FILE__) ));
    wp_enqueue_style('Tbit_lms_fontawesome');
    wp_register_style('Tbit_lms_admin_user_table',  plugins_url( '/../assets/css/admin_user_table.css?id='.rand(), dirname(__FILE__) ));
    wp_enqueue_style('Tbit_lms_admin_user_table');
    ?>
    
        <div class="instructor_tablebox margintop50">
        <div class="my-box-bg">
            <h2 class="heading-cont">Course Rating & Reviews</h2>
            <div class="tab-content nopadding noborder">
                <div id="home" class="tab-pane active nopadding">
        <table class="wp-list-table widefat fixed striped table-view-list users">
        <thead>
        <tr>
        <th scope="col" id="course-name" class="manage-column column-course-name column-primary sortable desc">
        <span>Course Name</span>
        </th>
        <th scope="col" id="comments" class="manage-column column-comments">comments</th>
        <th scope="col" id="rating" class="manage-column column-rating sortable desc">
        <span>Ratings</span>
        </th>
        <th scope="col" id="Username" class="manage-column column-posts">User Name</th>
        <th scope="col" id="date" class="manage-column column-date">Date</th>
        <th scope="col" id="action" class="manage-column column-action text-center">Actions</th>

        </tr>

        </thead>
        <tbody id="the-list" data-wp-lists="list:user">
        <?php
        $result = Tbit_get_courseratings();
        if(count($result)>0){
            foreach ($result as $key => $value) {?>
            <tr id="rating-<?php echo esc_attr($value['rating_id']); ?>">
            <td class="username column-username has-row-actions column-primary" data-colname="Username">
            <strong>
            <a href="<?php echo  esc_url(admin_url());?>/post.php?post=<?php echo esc_attr($value['post_id'])?>&action=edit"><?php echo esc_html(get_the_title($value['post_id']));?></a>
            </strong>
            </td>
            <td class="column-primary"><?php echo esc_html($value['comment']);?></td>
            <td class="column-primary">

                <?php 
                $datahtml ='<div class="ac_list_rminbox">';
                $datahtml .='<div class="ac_list_raingbox">';
                $average = $value['rating'];
                $star_filled_content = 'dashicons-star-filled';
                $star_empty_content = 'dashicons-star-empty';
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
                $datahtml .='</div>';
                $datahtml .='</div>';
                echo html_entity_decode(esc_html($datahtml));
                ?>
            </td>
            <td class="column-primary">
                <?php 
                $rating_user = get_user_by('id',$value['user_id']); 
                echo esc_html($rating_user->display_name);
                ?>
                    
            </td>
            <td class="column-primary">
                <?php
                $date = date_create($value['created_on']);
                $date_format = date_format($date,'D dS F, Y');
                echo esc_html($date_format);
                ?>
            </td>
            <td class="column-primary text-center">
                <div class="row-actions1 ratingactionbox">
                    <?php
                    $approve_title = 'Approve';
                    $disapprove_title = 'Disapprove';
                    $aactive = '';
                    $dactive = '';
                    if($value['status'] == 1){
                        $approve_title = 'Approved';
                        $aactive = 'active';
                    } else {
                        $disapprove_title = 'Disapproved';
                        $dactive = 'active';
                    }
                    ?>
                    <i class="fa fa-eye rating_abtn rating_adbtn <?php echo esc_attr($aactive);?>" data-status="yes" data-id="<?php echo esc_attr($value['rating_id']); ?>" title="<?php echo esc_attr($approve_title);?>"></i>
                    <i class="fa fa-eye-slash rating_dbtn rating_adbtn <?php echo esc_attr($dactive);?>" data-status="no" data-id="<?php echo esc_attr($value['rating_id']); ?>" title="<?php echo esc_attr($disapprove_title);?>"></i>
                    <span class="delete delete_ratingbtn" data-id="<?php echo esc_attr($value['rating_id']); ?>"><i class="fa fa-trash"></i></span>
                </div>
            </td>
            </tr>
            <?php }
        } else {
        ?>
        <tr>
        <td class="text-center" colspan="6">No Data</td>
        </tr>
            <?php }?>


                </tbody>
        </table>


    </div>
        </div>
    </div>
</div>

    <?php }
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

if(!function_exists('Tbit_lms_student')){
    function Tbit_lms_student(){
    global $wpdb;

    wp_register_style('Tbit_lms_fontawesome',  plugins_url( '/../assets/css/font-awesome.min.css?id='.rand(), dirname(__FILE__) ));
    wp_enqueue_style('Tbit_lms_fontawesome');


    wp_register_style('Tbit_lms_admin_user_table',  plugins_url( '/../assets/css/admin_user_table.css?id='.rand(), dirname(__FILE__) ));
    wp_enqueue_style('Tbit_lms_admin_user_table');
        $args = array(
        'role'    => 'student',
        'orderby' => 'user_nicename',
        'order'   => 'ASC',
        'fields' => array( 'id','display_name','user_email','user_login' ),
        );

        $users = get_users( $args );
        ?>
        <div class="instructor_tablebox margintop50">
        <div class="my-box-bg">
            <h2 class="heading-cont">Students</h2>
            <div class="tab-content nopadding noborder">
            <div id="home" class="tab-pane active nopadding">
                <table class="wp-list-table widefat fixed striped table-view-list users">
                <thead>
                <tr>
                <th scope="col" id="username" class="manage-column column-username column-primary sortable desc">
                <span>Username</span>
                </th>
                <th scope="col" id="name" class="manage-column column-name">Name</th>
                <th scope="col" id="email" class="manage-column column-email sortable desc">
                <span>Email</span>
                </th>
                <th scope="col" id="role" class="manage-column column-role text-center">Actions</th>

                </tr>

                </thead>
                <tbody id="the-list" data-wp-lists="list:user">
                <?php
                if(count($users)>0){
                    $i= 1;
                    
                    foreach ($users as $key => $value) {  
                ?>
                <tr id="user-<?php echo esc_attr($i);?>">
                <td class="username column-username has-row-actions column-primary" data-colname="Username">
                <?php
                $get_avatar_url = esc_url( Tbit_PLUGIN_URL."/tbit-quick-learn/image/default_avater.png");
                $get_attachment_id = get_user_meta($value->ID,'wp_user_avatar',true);
                if($get_attachment_id !=''){
                $get_avatar_url = wp_get_attachment_url($get_attachment_id);
                }
                ?>
                <img src="<?php echo esc_url($get_avatar_url); ?>" class="img-rounded" width="32" height="32" />
                <strong>
                  <a href="<?php echo esc_url(home_url());?>/wp-admin/user-edit.php?user_id=<?php echo esc_attr($value->ID); ?>"><?php echo esc_html($value->user_login); ?></a>
                </strong>
                <br>
                <div class="row-actions">
                  <span class="edit">
                    <a href="<?php echo esc_url(home_url());?>/wp-admin/user-edit.php?user_id=<?php echo esc_attr($value->ID); ?>">Edit</a> | </span>
                  <span class="view">
                    <a href="<?php echo esc_url(home_url());?>/instructor/<?php echo esc_attr($value->user_login); ?>/" aria-label="View posts by <?php echo esc_attr($value->user_login); ?>">View</a>
                  | </span>
                <span class="delete">
                <?php 
                echo "<a class='submitdelete' href='" . wp_nonce_url( "users.php?action=delete&amp;user=$value->ID", 'bulk-users' ) . "'>" . __( 'Delete' ) . '</a>';
                ?>
                </span>
                </div>
              </td>
              <td class="name column-name" data-colname="Name">

                <?php 
                if($value->display_name){
                 echo esc_html($value->display_name);
                } else {
                ?>
                <span aria-hidden="true">—</span>
                <?php }?>
              </td>
              <td class="email column-email" data-colname="Email">
                <?php 
                if($value->user_email){
                 echo esc_html($value->user_email);
                } else {
                ?>
                <span aria-hidden="true">—</span>
                <?php }?>
              </td>
              <td class="action column-action text-center" data-colname="action">
                  
                <div class="t_i_actionbtnbox">
                    <a href="<?php echo esc_url(home_url());?>/wp-admin/user-edit.php?user_id=<?php echo esc_attr($value->ID); ?>" title="Edit" class="t_i_a_link"><i class="fa fa-edit i_t_a_btn"></i></a>
                </div>
                    
              </td>
                </tr>
                <?php $i++; } } else{ ?>
                    <tr>
                        <td colspan="4" class="text-center">No Data</td>
                    </tr>
                <?php }?>
                </tbody>
                </table>


            </div>
        </div>
    </div>
</div>



    <?php }
}




add_action( 'init', 'Tbit_lms_gsp_lms_new_menu' );
if( !function_exists('Tbit_lms_course_meta_boxs')){
function Tbit_lms_course_meta_boxs(){
    global $current_user;
    $current_user_roles = $current_user->roles;
 	 add_meta_box('course_curriculum','Lessons','Tbit_lms_course_curriculum_callback');
 	 add_meta_box('course_assements','Assesments','Tbit_lms_course_assesment_callback');	
 	 add_meta_box('General Setting','General Setting','Tbit_lms_course_setting_callback');	
 	 add_meta_box('Pricing Setting','Pricing Setting','Tbit_lms_pricing_setting_callback'); 
     if(in_array('administrator',$current_user_roles)){
 	  add_meta_box('Author','Author','Tbit_lms_author_callback'); 
     }
 	 add_meta_box('Banner','Banner','Tbit_lms_course_banner_image');
 }
}
if( !function_exists('Tbit_lms_assesment_meta_boxs')){
 function Tbit_lms_assesment_meta_boxs(){
 	 add_meta_box('assements_Questions','Questions','Tbit_lms_assements_Questions');
 	 add_meta_box('assements_Questions Setting','Questions Settings','Tbit_lms_assesementquestionsetting_callback');	
 	 	 
 }
}
if( !function_exists('Tbit_lms_question_meta_boxs')){
 function Tbit_lms_question_meta_boxs(){
 	 add_meta_box('question_assements','Questions','Tbit_lms_question_assements_callback');
 	 add_meta_box('Questions Setting','Questions Setting','Tbit_lms_question_setting_callback');	 
 }
}
 if( !function_exists('Tbit_lms_lesson_meta_boxs')){
 function Tbit_lms_lesson_meta_boxs(){
 	 add_meta_box('lesson_assements','General Settings','Tbit_lms_lesson_assements_callback'); 
 }
}
 


?>
