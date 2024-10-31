<?php
add_theme_support('custom-logo');
require('admin/wp-admin-function.php');
if( !function_exists('Tbit_lms_get_theme_options')){
function Tbit_lms_get_theme_options() {
 return get_option( 'theme_options' );
}
}
if( !function_exists('Tbit_lms_get_theme_option')){
function Tbit_lms_get_theme_option( $id ) {
  $options = Tbit_lms_get_theme_options();
  if ( isset( $options[$id] ) ) {
  return $options[$id];
  }
}
}
if( !function_exists('gpslms_sidebar_registration')){
function gpslms_sidebar_registration() {
$shared_args = array(
'before_title'  => '<h2 class="widget-title subheading heading-size-3">',
'after_title'   => '</h2>',
'before_widget' => '<div class="widget %2$s"><div class="widget-content">',
'after_widget'  => '</div></div>',
);

// Footer #1.

register_sidebar(

array_merge(

$shared_args,

array(

'name'        => __( 'Footer #1', 'gps-lms' ),

'id'          => 'sidebar-1',

'description' => __( 'Widgets in this area will be displayed in the first column in the footer.', 'gps-lms' ),

)

)

);

// Footer #2.

register_sidebar(

array_merge(

$shared_args,

array(
'name'        => __( 'Footer #2', 'gps-lms' ),
'id'          => 'sidebar-2',
'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'gps-lms' ),

)

)

);

}
}

add_action( 'widgets_init', 'gpslms_sidebar_registration' );



/* gsp-function.php */
if( !function_exists('Tbit_lms_register_widget_areas')){
function Tbit_lms_register_widget_areas() {

$shared_args = array(

'before_title'  => '<h2 class="widget-title subheading heading-size-3">',

'after_title'   => '</h2>',

'before_widget' => '<div class="widget %2$s"><div class="widget-content">',

'after_widget'  => '</div></div>',

);

// Footer #2.

register_sidebar(

array_merge(

$shared_args,

array(

'name'        => __( 'Footer 3', 'gps-lms' ),

'id'          => 'footer_area_two',

'description' => __( 'Widgets in this area will be displayed in the second column in the footer.', 'gps-lms' ),

)

)

);

}
}

add_action( 'widgets_init', 'Tbit_lms_register_widget_areas' );

add_action( 'show_user_profile', 'Tbit_lms_user_profile_featured' );
add_action( 'edit_user_profile', 'Tbit_lms_user_profile_featured' );
if(!function_exists('Tbit_lms_user_profile_featured')){
function Tbit_lms_user_profile_featured( $user ) { 
  global $current_user;
  $user_roles = array();
  if(isset($user->roles) && count($user->roles)>0){
    $user_roles = $user->roles;
  }
  if(in_array('administrator',$current_user->roles) && ( in_array('instructor', $user_roles) || (in_array('administrator', $user_roles)))){
    if(in_array('instructor', $user_roles)){
      $is_featured = get_the_author_meta( 'is_featured', $user->ID );
    }
    $contact_phone = get_user_meta($user->ID,'contact_phone',true);
    $instructor_experience = get_user_meta($user->ID,'instructor_experience',true);
    $instructor_twitter = get_user_meta($user->ID,'instructor_twitter',true);
    $instructor_facebook = get_user_meta($user->ID,'instructor_facebook',true);
    $instructor_instagram = get_user_meta($user->ID,'instructor_instagram',true);
    $instructor_whatsapp = get_user_meta($user->ID,'instructor_whatsapp',true);
  ?>
    <h3><?php _e("Instructor additional Info", "blank"); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="address"><?php _e("Phone"); ?></label></th>
        <td>
            <input type="text" name="contact_phone" id="contact_phone"  class="regular-text" value="<?php echo esc_attr($contact_phone);?>" placeholder="<?php _e("Phone"); ?>" /><br />
        </td>
    </tr>

    <tr>
        <th><label for="address"><?php _e("Experience"); ?></label></th>
        <td>
            <input type="text" name="instructor_experience" id="instructor_experience"  class="regular-text" value="<?php echo esc_attr($instructor_experience);?>" placeholder="<?php _e("Experience"); ?>" /><br />
        </td>
    </tr>

    <tr>
        <th><label for="address"><?php _e("Twitter"); ?></label></th>
        <td>
            <input type="text" name="instructor_twitter" id="instructor_twitter"  class="regular-text" value="<?php echo esc_attr($instructor_twitter);?>" placeholder="<?php _e("Twitter"); ?>" /><br />
        </td>
    </tr>

    <tr>
        <th><label for="address"><?php _e("Facebook"); ?></label></th>
        <td>
            <input type="text" name="instructor_facebook" id="instructor_facebook"  class="regular-text" value="<?php echo esc_attr($instructor_facebook);?>" placeholder="<?php _e("Facebook"); ?>" /><br />
        </td>
    </tr>

    <tr>
        <th><label for="address"><?php _e("Instagram"); ?></label></th>
        <td>
            <input type="text" name="instructor_instagram" id="instructor_instagram"  class="regular-text" value="<?php echo esc_attr($instructor_instagram);?>" placeholder="<?php _e("Instagram"); ?>" /><br />
        </td>
    </tr>

    <tr>
        <th><label for="address"><?php _e("WhatsApp"); ?></label></th>
        <td>
            <input type="text" name="instructor_whatsapp" id="instructor_whatsapp"  class="regular-text" value="<?php echo esc_attr($instructor_whatsapp);?>" placeholder="<?php _e("WhatsApp"); ?>" /><br />
        </td>
    </tr>
    <?php 
    if(in_array('instructor', $user_roles)){
    ?>
    <tr>
        <th><label for="address"><?php _e("Featured"); ?></label></th>
        <td>
            <input type="checkbox" name="is_featured" id="is_featured"  class="regular-text" <?php if($is_featured == 1){ echo 'checked'; } ?> /><br />
        </td>
    </tr>
    <?php }?>
    </table>
<?php } } }

add_action( 'personal_options_update', 'Tbit_lms_save_user_profile_featured' );
add_action( 'edit_user_profile_update', 'Tbit_lms_save_user_profile_featured' );
if(!function_exists('Tbit_lms_save_user_profile_featured')){
function Tbit_lms_save_user_profile_featured( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }

    if(isset($_POST['is_featured']) && $_POST['is_featured'] == 'on'){
      update_user_meta( $user_id, 'is_featured', 1 );
    } else {
      update_user_meta( $user_id, 'is_featured', 0 );
    }

    if(isset($_POST['description'])){
      $description = sanitize_textarea_field($_POST['description']);
      update_user_meta($user_id,'instructor_bio',$description);
    }

    if(isset($_POST['contact_phone'])){
      $contact_phone = sanitize_textarea_field($_POST['contact_phone']);
      update_user_meta($user_id,'contact_phone',$contact_phone);
    }

    if(isset($_POST['instructor_experience'])){
      $instructor_experience = sanitize_textarea_field($_POST['instructor_experience']);
      update_user_meta($user_id,'instructor_experience',$instructor_experience);
    }

    if(isset($_POST['instructor_twitter'])){
      $instructor_twitter = sanitize_textarea_field($_POST['instructor_twitter']);
      update_user_meta($user_id,'instructor_twitter',$instructor_twitter);
    }

    if(isset($_POST['instructor_facebook'])){
      $instructor_facebook = sanitize_textarea_field($_POST['instructor_facebook']);
      update_user_meta($user_id,'instructor_facebook',$instructor_facebook);
    }

    if(isset($_POST['instructor_instagram'])){
      $instructor_instagram = sanitize_textarea_field($_POST['instructor_instagram']);
      update_user_meta($user_id,'instructor_instagram',$instructor_instagram);
    }

    if(isset($_POST['instructor_whatsapp'])){
      $instructor_whatsapp = sanitize_textarea_field($_POST['instructor_whatsapp']);
      update_user_meta($user_id,'instructor_whatsapp',$instructor_whatsapp);
    }


}
}


?>