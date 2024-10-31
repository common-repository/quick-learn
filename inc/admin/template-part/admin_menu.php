<?php
    if( !function_exists('Tbit_lms_add_new_menu_items')){
    function Tbit_lms_add_new_menu_items()
    {
        add_menu_page(
            "Theme Options",
            "Theme Options",
            "manage_options",
            "theme-options",
            "Tbit_lms_theme_options_page",
            "",
            99
        );

    }
    } 
    if( !function_exists('Tbit_lms_theme_options_page')){  
    function Tbit_lms_theme_options_page()
    {
        ?>
            <div class="wrap">
            <div id="icon-options-general" class="icon32"></div>
            <h1>Theme Options</h1>
           

            <?php
                $active_tab = "header-options";
                if(isset($_GET["tab"]))
                {
                    if($_GET["tab"] == "header-options")
                    {
                        $active_tab = "header-options";
                    }
                    elseif($_GET["tab"] == "footer-options")
                    {
                        $active_tab = "footer-options";
                    }
                    elseif($_GET["tab"] == "settings-options")
                    {
                        $active_tab = "settings-options";
                    }
                    elseif($_GET["tab"] == "section-detail")
                    {
                        $active_tab = "section-detail";
                    }
                }
            ?>
          
           
            <h2 class="nav-tab-wrapper">
                <a href="?page=theme-options&tab=header-options" class="nav-tab <?php if($active_tab == 'header-options'){echo 'nav-tab-active';} ?> "><?php _e('Header Options', 'sandbox'); ?></a>
                <a href="?page=theme-options&tab=footer-options" class="nav-tab <?php if($active_tab == 'footer-options'){echo 'nav-tab-active';} ?>"><?php _e('Footer Options', 'sandbox'); ?></a>
                <a href="?page=theme-options&tab=section-detail" class="nav-tab <?php if($active_tab == 'section-detail'){echo 'nav-tab-active';} ?>"><?php _e('Home', 'sandbox'); ?></a>
            </h2>
              <form method="post" enctype="multipart/form-data" action="<?php echo esc_url( add_query_arg( // wrapped for clarity
  'tab', $active_tab, admin_url( 'options.php' )
) ); ?>">

                <?php
               
                    settings_fields("header_section");
                   
                    do_settings_sections("theme-options");

                    submit_button();
                   
                ?>          
            </form>
        </div>
        <?php
    }
}

    add_action("admin_menu", "Tbit_lms_add_new_menu_items");
    if( !function_exists('Tbit_lms_display_header_options_content')){  
    function Tbit_lms_display_header_options_content(){echo "The header of the theme";}
    }
    if( !function_exists('Tbit_lms_display_tele_form_element')){  
    function Tbit_lms_display_tele_form_element()
    {
        ?>
            
            <input type="text" name="toplefttelephone" id="toplefttelephone" value="<?php echo esc_attr(get_option('toplefttelephone')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_email_form_element')){
    function Tbit_lms_display_email_form_element()
    {
       
        ?>
            <input type="text" name="topleftemail1" id="topleftemail1" value="<?php echo esc_attr(get_option('
            topleftemail1')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_register_form_element')){
    function Tbit_lms_display_register_form_element()
    {
        ?>
            <?php $value =get_option('toprightregister'); ?>
            <input type="checkbox" name="toprightregister" <?php checked( $value, 'on' ); ?>>
            <?php esc_html_e( 'Register Enable', 'text-domain' ); ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_toprightlogin_form_element')){
    function Tbit_lms_display_toprightlogin_form_element()
    {
        ?>
            <?php $value =get_option('toprightlogin'); ?>
            <input type="checkbox" name="toprightlogin" <?php checked( $value, 'on'); ?>>
        <?php esc_html_e( 'login Enable', 'text-domain' ); ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_contactno_form_element')){
    function Tbit_lms_display_contactno_form_element()
    {
        ?>
            <input type="text" name="footercontactno" id="footercontactno" value="<?php echo esc_attr(get_option('footercontactno')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_contactmail_form_element')){
    function Tbit_lms_display_contactmail_form_element()
    {
        ?>
            <input type="text" name="footercontactmail" id="footercontactmail" class="bbc" value="<?php echo esc_attr(get_option('footercontactmail')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_contactglobe_form_element')){
    function Tbit_lms_display_contactglobe_form_element()
    {
        ?>
            <input type="text" name="footercontactglobe" id="footercontactglobe" value="<?php echo esc_attr(get_option('footercontactglobe')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footersocialtwitter_form_element')){
    function Tbit_lms_display_footersocialtwitter_form_element()
    {
        ?>
            <input type="text" name="footersocialtwitter" id="footersocialtwitter" value="<?php echo esc_attr(get_option('footersocialtwitter')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footersocialfacebook_form_element')){
    function Tbit_lms_display_footersocialfacebook_form_element()
    {
        ?>
            <input type="text" name="footersocialfacebook" id="footersocialfacebook" value="<?php echo esc_attr(get_option('footersocialfacebook')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footersocialgoogle_form_element')){
    function Tbit_lms_display_footersocialgoogle_form_element()
    {
        ?>
            <input type="text" name="footersocialgoogle" id="footersocialgoogle" value="<?php echo esc_attr(get_option('footersocialgoogle')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footersociallinkdin_form_element')){
    function Tbit_lms_display_footersociallinkdin_form_element()
    {
        ?>
            <input type="text" name="footersociallinkdin" id="footersociallinkdin" value="<?php echo esc_attr(get_option('footersociallinkdin')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footeryoutube_form_element')){
    function Tbit_lms_display_footeryoutube_form_element()
    {
        ?>
            <input type="text" name="footeryoutube" id="footeryoutube" value="<?php echo esc_attr(get_option('footeryoutube')); ?>" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_footer_images_form_element')){
    function Tbit_lms_display_footer_images_form_element()
    {
        ?>
            <?php $footer_images = get_option( 'footer_images' );
            if($footer_images!=''){
            $footer_image=$footer_image;
            echo '<img src="'.esc_url($footer_images).'" class="fimg"  />';
            }
            ?>
            <input type="button" name="upload-btn" id="upload-btn" class="button-secondary upload_footer_image" value="Upload Image">
            <input type="hidden" name="footer_images" id="footer_image" value="<?php echo esc_attr( get_option( 'footer_images' ) ); ?>" >
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_slider_form_element')){
    function Tbit_lms_display_slider_form_element()
    {
        ?>
            <?php $sliderconfirm = get_option( 'sliderconfirm' ); ?>
            Yes <input type="radio" onclick="javascript:yesnoCheck();" name="sliderconfirm" id="yesCheck"  <?php if($sliderconfirm=='yes'){?>checked="checked" <?php }?> value="yes" />
             No <input type="radio" onclick="javascript:yesnoCheck();" name="sliderconfirm" id="noCheck" <?php if($sliderconfirm=='no'){?>checked="checked" <?php }?> value="no" />
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_slider_pic_element')){
    function Tbit_lms_display_slider_pic_element()
    {
         ?>
                <?php $sliderconfirm = get_option( 'sliderconfirm' ); ?>   
                <?php
                $trade_pic = get_option('trade_pic');
                $trade_pic = explode(',', $trade_pic[0]);
                if(isset($trade_pic[0]) && $trade_pic[0]  == ''){
                unset($trade_pic[0]);
                }
                ?>  
                <?php if($sliderconfirm== 'yes'){?>
                <div id="ifYes" style="visibility:visible">
                 <img class="slider_image dd" src="<?php if(isset($trade_pic[0]) && $trade_pic[0]  != ''){ echo esc_url($trade_pic[0]); } ?>" height="100" width="100"/>
                <input class="slider_image_url" type="hidden" name="trade_pic[]" size="60" value="<?php echo esc_attr(implode(',',$trade_pic));?>">
                <input type="button" class="slider_image_upload" value="Upload Profile Picture" data-group="1">
                </div>       
                <?php } ?>
                <?php if($sliderconfirm=='no'){?>
                <div id="ifYes" style="visibility:hidden">
                 <img class="slider_image ff" src="<?php if(isset($trade_pic[0]) && $trade_pic[0]  != ''){ echo esc_url($trade_pic[0]); } ?>" height="100" width="100"/>
                <input class="slider_image_url" type="hidden" name="trade_pic[]" size="60" value="<?php echo esc_attr(implode(',',$trade_pic));?>">
                <input type="button" class="slider_image_upload" value="Upload Profile Picture" data-group="1">
                </div>
                <?php } ?>    
    <?php        
    }
    }

    if( !function_exists('Tbit_lms_display_section_form_element')){
    function Tbit_lms_display_section_form_element()
    {
        ?> 
        <?php $checkedradio = esc_attr(get_option( 'section1' )); ?>
    Yes<input type="radio"  name="section1" onclick="javascript:sectionyesnoCheck();" value="yes" id="yestitleCheck"  <?php if($checkedradio== 'yes'){?> checked="checked" <?php }?>>
    No<input type="radio"   name="section1" onclick="javascript:sectionyesnoCheck();"  value="no" id="notitleCheck" <?php if($checkedradio!= 'yes'){?> checked="checked" <?php }?>>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectiontitle_form_element')){
    function Tbit_lms_display_sectiontitle_form_element()
    {
        ?>
        <?php $checkedradio = esc_attr(get_option( 'section1' )); ?>
        <?php if($checkedradio== 'yes'){?>
        <div class="label" id="sectiontitle" style="display:block">
        <span class="boldStmt"> Title</span>
        <input type="text" name="sectiontitle" value="<?php echo esc_attr(get_option('sectiontitle')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedradio== 'no'){?>
        <div class="label" id="sectiontitle" style="display:none" >
        <span class="boldStmt"> Title</span>
        <input type="text" name="sectiontitle" value="<?php echo esc_attr(get_option('sectiontitle')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectiondesc_form_element')){
    function Tbit_lms_display_sectiondesc_form_element()
    {
         ?>
        <?php $checkedradio = esc_attr(get_option( 'section1' ));?>
            <?php if($checkedradio=='yes'){?>
            <div class="label" id="sectiondesc" style="display:block" ><span class="boldStmt">Description</span>
            <input  type="text" name="sectiondesc" value="<?php echo esc_attr(get_option('sectiondesc')); ?>" />
            </div>
            <?php }?>
            <?php if($checkedradio=='no'){?>
            <div class="label" id="sectiondesc" style="display:none"><span class="boldStmt">Description</span>
            <input   type="text" name="sectiondesc" value="<?php echo esc_attr(get_option('sectiondesc')); ?>" />
            </div>
            <?php }?>
        <?php
       
    }
    }
    if( !function_exists('Tbit_lms_display_sectionposttype_form_element')){
      function Tbit_lms_display_sectionposttype_form_element()
    {
     ?>
     <?php 
             $sectionposttype = esc_attr(get_option( 'sectionposttype' ));
            $checkedradio = esc_attr(get_option( 'section1' ));
             ?>
     <?php
     $args = array(
       'public'   => true,
       '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
    ?>
    <?php if($checkedradio=='yes'){?>
    <div class="label" id="seletd_postype" style="display:block"><span class="boldStmt">Post Type</span>   
    <select name="sectionposttype"> <?php
    foreach ( $post_types  as $post_type ) {
       $selected='';
        if($post_type==$sectionposttype){
            $selected = "selected";
        }
       echo '<option value="'.esc_attr($post_type).'" '.esc_attr($selected).'>'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php if($checkedradio=='no'){?>
     <div class="label" id="seletd_postype" style="display:none"><span class="boldStmt">Post Type</span>   
    <select name="sectionposttype"> <?php
    foreach ( $post_types  as $post_type ) {
       echo '<option value="'.esc_attr($post_type).'">'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php
       
    }
    }
    if( !function_exists('Tbit_lms_display_sectionnofposts_form_element')){
    function Tbit_lms_display_sectionnofposts_form_element()
    {
        ?> <?php 
            $sectionnofposts = esc_attr(get_option( 'sectionnofposts' ));
            $checkedradio = esc_attr(get_option( 'section1' ));
             ?>
             <?php if($checkedradio=='yes') { ?>
            <div class="label" id="selectdsection1_postnum" style="display:block"><span class="boldStmt">No Of Posts</span>
            <select name="sectionnofposts">
            <option value="2" <?php if($sectionnopots=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($sectionnofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($sectionnofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($sectionnofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            <?php } ?>
            <?php if($checkedradio=='no'){ ?>
             <div class="label" id="selectdsection1_postnum" style="display:none"><span class="boldStmt">No Of Posts</span>
            <select name="sectionnofposts">
            <option value="2" <?php if($sectionnopots=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($sectionnofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($sectionnofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($sectionnofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
        <?php   
    }
    }
    if( !function_exists('Tbit_lms_display_section1numcolumn_form_element')){
       function Tbit_lms_display_section1numcolumn_form_element()
    {
        ?>
            <?php 
            $section1numcolumn = esc_attr(get_option( 'section1numcolumn' ));
            $checkedradio = esc_attr(get_option( 'section1' ));
             ?>
            <?php if($checkedradio=='yes') { ?>
            <div class="label" id="selectedsection1_numcol" style="display:block" ><span class="boldStmt"> No Of Columns</span>
           <select name="section1numcolumn">
            <option <?php if($section1numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section1numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section1numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section1numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section1numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedradio=='no') { ?>
            <div class="label" id="selectedsection1_numcol" style="display:none" ><span class="boldStmt"> No Of Columns</span>
           <select name="section1numcolumn">
            <option <?php if($section1numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section1numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section1numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section1numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section1numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectionnorderby_form_element')){
       function Tbit_lms_display_sectionnorderby_form_element()
    {
        ?>
            <?php 
            $sectionnorderby = esc_attr(get_option( 'section1norderby' ));
            $checkedradio = esc_attr(get_option( 'section1' ));?>
             <?php if($checkedradio=='yes') { ?>
            <div class="label" id="selectedsection1_norderby" style="display:block"><span class="boldStmt"> Order</span>
            <select name="section1norderby">
            <option <?php if($sectionnorderby=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($sectionnorderby=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedradio=='no') { ?>
            <div class="label" id="selectedsection1_norderby" style="display:none"><span class="boldStmt"> Order</span>
            <select name="section1norderby">
            <option <?php if($sectionnorderby=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($sectionnorderby=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectionnordertype_form_element')){
      function Tbit_lms_display_sectionnordertype_form_element()
    {
        ?>
            <?php 
            $sectionnordertype = esc_attr(get_option( 'sectionnordertype' ));
            $checkedradio = esc_attr(get_option( 'section1' ));?>
            <?php if($checkedradio=='yes') { ?>
            <div class="label" id="selectedsection1_ordertype" style="display:block;"><span class="boldStmt">Order By</span>
           <select name="section1nordertype" >
            <option <?php if($sectionnordertype=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($sectionnordertype=='date'){?> selected="selected" <?php }?>>date</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedradio=='no') { ?>
            <div class="label" id="selectedsection1_ordertype" style="display:none;"><span class="boldStmt">Order By</span>
           <select name="sectionnordertype" >
            <option <?php if($sectionnordertype=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($sectionnordertype=='date'){?> selected="selected" <?php }?>>date</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    //Section-2 theme settings Functions call to display input fields
    if( !function_exists('Tbit_lms_display_section2_form_element')){
    function Tbit_lms_display_section2_form_element()
    {
        ?>    
        <?php $checkedsection2radio = esc_attr(get_option( 'section2' ));
        ?>
    Yes<input type="radio"  name="section2" onclick="javascript:section2yesnoCheck();" value="yes" id="yestitle2Check"  <?php if($checkedsection2radio== 'yes'){?> checked="checked" <?php }?>>
    No<input type="radio"   name="section2" onclick="javascript:section2yesnoCheck();"  value="no" id="notitleCheck" <?php if($checkedsection2radio!= 'yes'){?> checked="checked" <?php }?>>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectiontitle2_form_element')){
    function Tbit_lms_display_sectiontitle2_form_element()
    {
        ?>    
        <?php $checkedsection2radio = esc_attr(get_option( 'section2' )); ?>
        <?php if($checkedsection2radio== 'yes'){?>
        <div class="label" id="section2_title" style="display:block"><span class="boldStmt"> Title</span>
        <input type="text" name="section2title" value="<?php echo esc_attr(get_option('section2title')); ?>" />
         </div>
        <?php } ?>
        <div class="label" id="section2_title" style="display:none"  ><span class="boldStmt"> Title</span>
        <?php if($checkedsection2radio== 'no'){?>
        <input type="text" name="section2title" id="section2_title" value="<?php echo esc_attr(get_option('section2title')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2desc_form_element')){
    function Tbit_lms_display_section2desc_form_element()
    {
        ?>    
        <?php $checkedsection2radio = esc_attr(get_option( 'section2' )); ?>
        <?php if($checkedsection2radio== 'yes'){?>
        <div class="label" id="section2_desc" style="display:block" ><span class="boldStmt"> Description</span>
        <input type="text" name="sectio2descr" value="<?php echo esc_attr(get_option('sectio2descr')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection2radio== 'no'){?>
        <div class="label" id="section2_desc" style="display:none" ><span class="boldStmt"> Description</span>
        <input type="text" name="sectio2descr" value="<?php echo esc_attr(get_option('sectio2descr')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2posttype_form_element')){
    function Tbit_lms_display_section2posttype_form_element()
    {
        ?> 
            <?php 
            $section2posttype = esc_attr(get_option( 'section2posttype' ));
             $checkedsection2radio = esc_attr(get_option( 'section2' ));
             ?>
     <?php
     $args = array(
       'public'   => true,
       '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
    ?>
    <?php if($checkedsection2radio=='yes'){?>
    <div class="label" id="seletdsection2_postype" style="display:block"><span class="boldStmt">Post Type</span>   
    <select name="section2posttype"> <?php
    foreach ( $post_types  as $post_type ) {
        $selected='';
        if($post_type==$section2posttype){
            $selected = "selected";
        }
       echo '<option value="'.esc_attr($post_type).'" '.esc_attr($selected).'>'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php if($checkedsection2radio=='no'){?>
     <div class="label" id="seletdsection2_postype" style="display:none"><span class="boldStmt">Post Type</span>   
    <select name="section2posttype"> <?php
    foreach ( $post_types  as $post_type ) {
       echo '<option value="'.esc_attr($post_type).'">'.esc_html($post_type) . '</option>';
    }  
     ?>
    </select>
    </div>   
    <?php } ?>
           
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2nofposts_form_element')){
    function Tbit_lms_display_section2nofposts_form_element()
    {
            ?> 
            <?php 
            $section2nofposts = esc_attr(get_option( 'section2nofposts' ));
            $checkedsection2radio = esc_attr(get_option( 'section2' ));
             ?>
             <?php if($checkedsection2radio=='yes') { ?>
            <div class="label" id="selectdsection2_postnum" style="display:block" ><span class="boldStmt"> No Of Posts</span>
            <select name="section2nofposts" >
            <option value="2" <?php if($section2nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section2nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section2nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section2nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection2radio=='no'){ ?>
            <div class="label" id="selectdsection2_postnum" style="display:none" ><span class="boldStmt"> No Of Posts</span>
            <select name="section2nofposts" >
            <option value="2" <?php if($section2nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section2nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section2nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section2nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2numcolumn_form_element')){
    function Tbit_lms_display_section2numcolumn_form_element()
    {
        ?>
            <?php 
            $section2numcolumn = esc_attr(get_option( 'section2numcolumn' ));
            $checkedsection2radio = esc_attr(get_option( 'section2' ));
             ?>
            <?php if($checkedsection2radio=='yes') { ?>
            <div class="label" id="selectedsection2_numcol" style="display:block"><span class="boldStmt"> No Of Columns</span>
           <select name="section2numcolumn"  >
            <option <?php if($section2numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section2numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section2numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section2numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section2numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedsection2radio=='no') { ?>
            <div class="label" id="selectedsection2_numcol" style="display:none"><span class="boldStmt"> No Of Columns</span>
           <select name="section2numcolumn">
            <option <?php if($section2numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section2numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section2numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section2numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section2numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2norderby_form_element')){
    function Tbit_lms_display_section2norderby_form_element()
    {
        ?>
            <?php 
            $section2norderby = esc_attr(get_option( 'section2norderby' ));
            $checkedsection2radio = esc_attr(get_option( 'section2' ));?>
             <?php if($checkedsection2radio=='yes') { ?>
            <div class="label" id="selectedsection2_norderby" style="display:block"><span class="boldStmt"> Order</span>
            <select name="section2norderby" >
            <option <?php if($section2norderby=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section2norderby=='DESC'){?> selected="selected" <?php }?>>DESC</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection2radio=='no') { ?>
            <div class="label" id="selectedsection2_norderby" style="display:none"><span class="boldStmt"> Order</span>
            <select name="section2norderby">
            <option <?php if($section2norderby=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section2norderby=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section2nordertype_form_element')){
    function Tbit_lms_display_section2nordertype_form_element()
    {
        ?>
            <?php 
            $section2nordertype = esc_attr(get_option( 'section2nordertype' ));
            $checkedsection2radio = esc_attr(get_option( 'section2' ));?>
            <?php if($checkedsection2radio=='yes') { ?>
            <div class="label" id="selectedsection2_ordertype" style="display:block;"><span class="boldStmt">Order By</span>
            <select name="section2nordertype" >
            <option <?php if($section2nordertype=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section2nordertype=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection2radio=='no') { ?>
            <div class="label" id="selectedsection2_ordertype" style="display:none;"><span class="boldStmt">Order By</span>
            <select name="section2nordertype" >
            <option <?php if($section2nordertype=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section2nordertype=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    //Section-3 theme settings Functions call to display input fields
    if( !function_exists('Tbit_lms_display_section3_form_element')){
    function Tbit_lms_display_section3_form_element()
    {
        ?>    
        <?php $checkedsection3radio = esc_attr(get_option( 'section3' ));
        ?>
    Yes<input type="radio"  name="section3" onclick="javascript:section3yesnoCheck();" value="yes" id="yestitle3Check"  <?php if($checkedsection3radio== 'yes'){?> checked="checked" <?php }?>>
    No<input type="radio"   name="section3" onclick="javascript:section3yesnoCheck();"  value="no" id="notitleCheck" <?php if($checkedsection3radio!= 'yes'){?> checked="checked" <?php }?>>
        <?php
    }
}
    if( !function_exists('Tbit_lms_display_section3title_form_element')){
    function Tbit_lms_display_section3title_form_element()
    {
        ?>
        <?php $checkedsection3radio = esc_attr(get_option( 'section3' )); ?>
        <?php if($checkedsection3radio== 'yes'){?>
        <div class="label" id="section3_title" style="display:block">
        <span class="boldStmt"> Title</span>
        <input type="text" name="section3title" value="<?php echo esc_attr(get_option('section3title')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection3radio== 'no'){?>
        <div class="label" id="section3_title" style="display:none" >
        <span class="boldStmt"> Title</span>
        <input type="text" name="section3title" value="<?php echo esc_attr(get_option('section3title')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3desc_form_element')){
    function Tbit_lms_display_section3desc_form_element()
    {
        ?>    
        <?php $checkedsection3radio = esc_attr(get_option( 'section3' )); ?>
        <?php if($checkedsection3radio== 'yes'){?>
        <div class="label" id="section3_desc" style="display:block" ><span class="boldStmt"> Description</span>
        <input type="text" name="section3desc" value="<?php echo esc_attr(get_option('section3desc')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection3radio== 'no'){?>
        <div class="label" id="section3_desc" style="display:none" ><span class="boldStmt"> Description</span>
        <input type="text" name="section3desc" value="<?php echo esc_attr(get_option('section3desc')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3posttype_form_element')){
    function Tbit_lms_display_section3posttype_form_element()
    {
        ?> 
            <?php 
            $section3posttype = esc_attr(get_option( 'section3posttype' ));
             $checkedsection3radio = esc_attr(get_option( 'section3' ));
             ?>
     <?php
     $args = array(
       'public'   => true,
       '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
    ?>
    <?php if($checkedsection3radio=='yes'){?>
    <div class="label" id="section3_posttype" style="display:block"><span class="boldStmt">Post Type</span>   
    <select name="section3posttype"> <?php
    foreach ( $post_types  as $post_type ) {
        $selected='';
        if($post_type==$section3posttype){
            $selected = "selected";
        }
       echo '<option value="'.esc_attr($post_type).'" '.esc_attr($selected).'>'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php if($checkedsection3radio=='no'){?>
     <div class="label" id="section3_posttype" style="display:none"><span class="boldStmt">Post Type</span>   
    <select name="section3posttype"> <?php
    foreach ( $post_types  as $post_type ) {
       echo '<option value="'.esc_attr($post_type).'">'.esc_html($post_type) . '</option>';
    }  
     ?>
    </select>
    </div>   
    <?php } ?>
           
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3nofposts_form_element')){
    function Tbit_lms_display_section3nofposts_form_element()
    {
            ?> 
            <?php 
            $section3nofposts = esc_attr(get_option( 'section3nofposts' ));
            $checkedsection3radio = esc_attr(get_option( 'section3' ));
             ?>
             <?php if($checkedsection3radio=='yes') { ?>
            <div class="label" id="section3_nofposts" style="display:block" ><span class="boldStmt"> No Of Posts</span>
            <select name="section3nofposts" >
            <option value="2" <?php if($section3nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section3nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section3nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section3nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection3radio=='no'){ ?>
            <div class="label" id="section3_nofposts" style="display:none" ><span class="boldStmt"> No Of Posts</span>
            <select name="section3nofposts" >
            <option value="2" <?php if($section3nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section3nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section3nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section3nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3numcolumn_form_element')){
    function Tbit_lms_display_section3numcolumn_form_element()
    {
        ?>
            <?php 
            $section3numcolumn = esc_attr(get_option( 'section3numcolumn' ));
            $checkedsection3radio = esc_attr(get_option( 'section3' ));
             ?>
            <?php if($checkedsection3radio=='yes') { ?>
            <div class="label" id="section3_numcolumn" style="display:block"><span class="boldStmt"> No Of Columns</span>
           <select name="section3numcolumn"  >
            <option <?php if($section3numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section3numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section3numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section3numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section3numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedsection3radio=='no') { ?>
            <div class="label" id="section3_numcolumn" style="display:none"><span class="boldStmt"> No Of Columns</span>
           <select name="section3numcolumn">
            <option <?php if($section3numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section3numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section3numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section3numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section3numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3norder_form_element')){
    function Tbit_lms_display_section3norder_form_element()
    {
        ?>
            <?php 
            $section3norder = esc_attr(get_option( 'section3norder' ));
            $checkedsection3radio = esc_attr(get_option( 'section3' ));?>
             <?php if($checkedsection3radio=='yes') { ?>
            <div class="label" id="section3_norder" style="display:block"><span class="boldStmt"> Order</span>
            <select name="section3norder" >
            <option <?php if($section3norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section3norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection3radio=='no') { ?>
            <div class="label" id="section3_norder" style="display:none"><span class="boldStmt"> Order</span>
            <select name="section3norder">
            <option <?php if($section3norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section3norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section3norderby_form_element')){
    function Tbit_lms_display_section3norderby_form_element()
    {
        ?>
            <?php 
            $section3norderby = esc_attr(get_option( 'section3norderby' ));
            $checkedsection3radio = esc_attr(get_option( 'section3' ));?>
            <?php if($checkedsection3radio=='yes') { ?>
            <div class="label" id="section3_norderby" style="display:block;"><span class="boldStmt">Order By</span>
            <select name="section3norderby" >
            <option <?php if($section3norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section3norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection3radio=='no') { ?>
            <div class="label" id="section3_norderby" style="display:none;"><span class="boldStmt">Order By</span>
            <select name="section3norderby" >
            <option <?php if($section3norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section3norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    //Section-4 theme settings Functions call to display input fields
    if( !function_exists('Tbit_lms_display_section4_form_element')){
    function Tbit_lms_display_section4_form_element()
    {
        ?>    
        <?php $checkedsection4radio = esc_attr(get_option( 'section4' ));
        ?>
    Yes<input type="radio"  name="section4" onclick="javascript:section4yesnoCheck();" value="yes" id="yestitle4Check"  <?php if($checkedsection4radio== 'yes'){?> checked="checked" <?php }?>>
    No<input type="radio"   name="section4" onclick="javascript:section4yesnoCheck();"  value="no" id="notitleCheck" <?php if($checkedsection4radio!= 'yes'){?> checked="checked" <?php }?>>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectiontitle4_form_element')){
    function Tbit_lms_display_sectiontitle4_form_element()
    {
        ?>
        <?php $checkedsection4radio = esc_attr(get_option( 'section4' )); ?>
        <?php if($checkedsection4radio== 'yes'){?>
        <div class="label" id="section4_title" style="display:block">
        <span class="boldStmt"> Title</span>
        <input type="text" name="section4title" value="<?php echo esc_attr(get_option('section4title')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection4radio== 'no'){?>
        <div class="label" id="section4_title" style="display:none" >
        <span class="boldStmt"> Title</span>
        <input type="text" name="section4title" value="<?php echo esc_attr(get_option('section4title')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4desc_form_element')){
    function Tbit_lms_display_section4desc_form_element()
    {
        ?>    
        <?php $checkedsection4radio = esc_attr(get_option( 'section4' )); ?>
        <?php if($checkedsection4radio== 'yes'){?>
        <div class="label" id="section4_desc" style="display:block" ><span class="boldStmt"> Description</span>
        <input type="text" name="section4desc" value="<?php echo esc_attr(get_option('section4desc')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection4radio== 'no'){?>
        <div class="label" id="section4_desc" style="display:none" ><span class="boldStmt"> Description</span>
        <input type="text" name="section4desc" value="<?php echo esc_attr(get_option('section4desc')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4posttype_form_element')){
    function Tbit_lms_display_section4posttype_form_element()
    {
        ?>    
        <?php 
            $section4posttype = esc_attr(get_option( 'section4posttype' ));
             $checkedsection4radio = esc_attr(get_option( 'section4' ));
             ?>
     <?php
     $args = array(
       'public'   => true,
       '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
    ?>
    <?php if($checkedsection4radio=='yes'){?>
    <div class="label" id="section4_posttype" style="display:block"><span class="boldStmt">Post Type</span>   
    <select name="section4posttype"> <?php
    foreach ( $post_types  as $post_type ) {
        $selected='';
        if($post_type==$section4posttype){
            $selected = "selected";
        }
       echo '<option value="'.esc_attr($post_type).'" '.esc_attr($selected).'>'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php if($checkedsection4radio=='no'){?>
     <div class="label" id="section4_posttype" style="display:none"><span class="boldStmt">Post Type</span>   
    <select name="section4posttype"> <?php
    foreach ( $post_types  as $post_type ) {
       echo '<option value="'.esc_attr($post_type).'">'.esc_html($post_type) . '</option>';
    }  
     ?>
    </select>
    </div>   
    <?php } ?>
           
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4nofposts_form_element')){
    function Tbit_lms_display_section4nofposts_form_element()
    {
            ?> 
            <?php 
            $section4nofposts = esc_attr(get_option( 'section4nofposts' ));
            $checkedsection4radio = esc_attr(get_option( 'section4' ));
             ?>
             <?php if($checkedsection4radio=='yes') { ?>
            <div class="label" id="section4_nofposts" style="display:block" ><span class="boldStmt"> No Of Posts</span>
            <select name="section4nofposts" >
            <option value="2" <?php if($section4nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section4nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section4nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section4nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection4radio=='no'){ ?>
            <div class="label" id="section4_nofposts" style="display:none" ><span class="boldStmt"> No Of Posts</span>
            <select name="section4nofposts" >
            <option value="2" <?php if($section4nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section4nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section4nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section4nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4numcolumn_form_element')){
    function Tbit_lms_display_section4numcolumn_form_element()
    {
        ?>
            <?php 
            $section4numcolumn = esc_attr(get_option( 'section4numcolumn' ));
            $checkedsection4radio = esc_attr(get_option( 'section4' ));
             ?>
            <?php if($checkedsection4radio=='yes') { ?>
            <div class="label" id="section4_numcolumn" style="display:block"><span class="boldStmt"> No Of Columns</span>
           <select name="section4numcolumn"  >
            <option <?php if($section4numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section4numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section4numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section4numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section4numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedsection4radio=='no') { ?>
            <div class="label" id="section4_numcolumn" style="display:none"><span class="boldStmt"> No Of Columns</span>
           <select name="section4numcolumn">
            <option <?php if($section4numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section4numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section4numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section4numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section4numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4norder_form_element')){
    function Tbit_lms_display_section4norder_form_element()
    {
        ?>
            <?php 
            $section4norder = esc_attr(get_option( 'section4norder' ));
            $checkedsection4radio = esc_attr(get_option( 'section4' ));?>
             <?php if($checkedsection4radio=='yes') { ?>
            <div class="label" id="section4_norder" style="display:block"><span class="boldStmt"> Order</span>
            <select name="section4norder" >
            <option <?php if($section4norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section4norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection4radio=='no') { ?>
            <div class="label" id="section4_norder" style="display:none"><span class="boldStmt"> Order</span>
            <select name="section4norder">
            <option <?php if($section4norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section4norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section4norderby_form_element')){
    function Tbit_lms_display_section4norderby_form_element()
    {
        ?>
            <?php 
            $section4norderby = esc_attr(get_option( 'section4norderby' ));
            $checkedsection4radio = esc_attr(get_option( 'section4' ));?>
            <?php if($checkedsection4radio=='yes') { ?>
            <div class="label" id="section4_norderby" style="display:block;"><span class="boldStmt">Order By</span>
            <select name="section4norderby" >
            <option <?php if($section4norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section4norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection4radio=='no') { ?>
            <div class="label" id="section4_norderby" style="display:none;"><span class="boldStmt">Order By</span>
            <select name="section4norderby" >
            <option <?php if($section4norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section4norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5_form_element')){
    function Tbit_lms_display_section5_form_element()
    {
        ?>    
        <?php $checkedsection5radio = esc_attr(get_option( 'section5' ));
        ?>
    Yes<input type="radio"  name="section5" onclick="javascript:section5yesnoCheck();" value="yes" id="yestitle5Check"  <?php if($checkedsection5radio== 'yes'){?> checked="checked" <?php }?>>
    No<input type="radio"   name="section5" onclick="javascript:section5yesnoCheck();"  value="no" id="notitleCheck" <?php if($checkedsection5radio!= 'yes'){?> checked="checked" <?php }?>>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5title_form_element')){
    function Tbit_lms_display_section5title_form_element()
    {
        ?>
        <?php $checkedsection5radio = esc_attr(get_option( 'section5' )); ?>
        <?php if($checkedsection5radio== 'yes'){?>
        <div class="label" id="section5_title" style="display:block">
        <span class="boldStmt"> Title</span>
        <input type="text" name="section5title" value="<?php echo esc_attr(get_option('section5title')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection5radio== 'no'){?>
        <div class="label" id="section5_title" style="display:none" >
        <span class="boldStmt"> Title</span>
        <input type="text" name="section5title" value="<?php echo esc_attr(get_option('section5title')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5desc_form_element')){
    function Tbit_lms_display_section5desc_form_element()
    {
        ?>    
        <?php $checkedsection5radio = esc_attr(get_option( 'section5' )); ?>
        <?php if($checkedsection5radio== 'yes'){?>
        <div class="label" id="section5_desc" style="display:block" ><span class="boldStmt"> Description</span>
        <input type="text" name="section5desc" value="<?php echo esc_attr(get_option('section5desc')); ?>" />
        </div>
        <?php } ?>
        <?php if($checkedsection5radio== 'no'){?>
        <div class="label" id="section5_desc" style="display:none" ><span class="boldStmt"> Description</span>
        <input type="text" name="section5desc" value="<?php echo esc_attr(get_option('section5desc')); ?>" />
        </div>
        <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5posttype_form_element')){
    function Tbit_lms_display_section5posttype_form_element()
    {
        ?>    
        <?php 
            $section5posttype = esc_attr(get_option( 'section5posttype' ));
             $checkedsection5radio = esc_attr(get_option( 'section5' ));
             ?>
     <?php
     $args = array(
       'public'   => true,
       '_builtin' => false,
    );

    $output = 'names'; // names or objects, note names is the default
    $operator = 'and'; // 'and' or 'or'

    $post_types = get_post_types( $args, $output, $operator ); 
    ?>
    <?php if($checkedsection5radio=='yes'){?>
    <div class="label" id="section5_posttype" style="display:block"><span class="boldStmt">Post Type</span>   
    <select name="section5posttype"> <?php
    foreach ( $post_types  as $post_type ) {
        $selected='';
        if($post_type==$section5posttype){
            $selected = "selected";
        }
       echo '<option value="'.esc_attr($post_type).'" '.esc_attr($selected).'>'.esc_html($post_type) .'</option>';
    }  
     ?>
    </select>
    </div>
    <?php } ?>
    <?php if($checkedsection5radio=='no'){?>
     <div class="label" id="section5_posttype" style="display:none"><span class="boldStmt">Post Type</span>   
    <select name="section5posttype"> <?php
    foreach ( $post_types  as $post_type ) {
       echo '<option value="'.esc_attr($post_type).'">'.esc_html($post_type) . '</option>';
    }  
     ?>
    </select>
    </div>   
    <?php } ?>
           
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_sectionn5ofposts_form_element')){
    function Tbit_lms_display_sectionn5ofposts_form_element()
    {
            ?> 
            <?php 
            $section5nofposts = esc_attr(get_option( 'section5nofposts' ));
            $checkedsection5radio = esc_attr(get_option( 'section5' ));
             ?>
             <?php if($checkedsection5radio=='yes') { ?>
            <div class="label" id="section5_nofposts" style="display:block" ><span class="boldStmt"> No Of Posts</span>
            <select name="section5nofposts" >
            <option value="2" <?php if($section5nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section5nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section5nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section5nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection5radio=='no'){ ?>
            <div class="label" id="section5_nofposts" style="display:none" ><span class="boldStmt"> No Of Posts</span>
            <select name="section5nofposts" >
            <option value="2" <?php if($section5nofposts=='2'){?>selected="selected" <?php }?>>2</option>
            <option value="4"  <?php if($section5nofposts=='4'){?>selected="selected" <?php }?>>4</option>
            <option value="6"  <?php if($section5nofposts=='6'){?>selected="selected" <?php }?>>6</option>
            <option value="8" <?php if($section5nofposts=='8'){?> selected="selected" <?php }?>>8</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5numcolumn_form_element')){
    function Tbit_lms_display_section5numcolumn_form_element()
    {
        ?>
            <?php 
            $section5numcolumn = esc_attr(get_option( 'section5numcolumn' ));
            $checkedsection5radio = esc_attr(get_option( 'section5' ));
             ?>
            <?php if($checkedsection5radio=='yes') { ?>
            <div class="label" id="section5_numcolumn" style="display:block"><span class="boldStmt"> No Of Columns</span>
           <select name="section5numcolumn"  >
            <option <?php if($section5numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section5numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section5numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section5numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section5numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
            <?php if($checkedsection5radio=='no') { ?>
            <div class="label" id="section5_numcolumn" style="display:none"><span class="boldStmt"> No Of Columns</span>
           <select name="section5numcolumn">
            <option <?php if($section5numcolumn=='1'){?> selected="selected" <?php }?>>1</option>
            <option <?php if($section5numcolumn=='2'){?> selected="selected" <?php }?>>2</option>
            <option <?php if($section5numcolumn=='3'){?>selected="selected" <?php } ?>>3</option>
            <option <?php if($section5numcolumn=='4'){?> selected="slected" <?php }?>>4</option>
            <option <?php if($section5numcolumn=='6'){?> selected="selected" <?php }?>>6</option>
           </select>
            </div>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5norder_form_element')){
    function Tbit_lms_display_section5norder_form_element()
    {
        ?>
            <?php 
            $section5norder = esc_attr(get_option( 'section5norder' ));
            $checkedsection5radio = esc_attr(get_option( 'section5' ));?>
             <?php if($checkedsection5radio=='yes') { ?>
            <div class="label" id="section5_norder" style="display:block"><span class="boldStmt"> Order</span>
            <select name="section5norder" >
            <option <?php if($section5norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section5norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection5radio=='no') { ?>
            <div class="label" id="section5_norder" style="display:none"><span class="boldStmt"> Order</span>
            <select name="section5norder">
            <option <?php if($section5norder=='ASC'){?> selected="selected" <?php }?>>ASC</option>
            <option <?php if($section5norder=='DESC'){?> selected="selected" <?php }?>>DESC</option>
           </select>
            <?php } ?>
        <?php
    }
    }
    if( !function_exists('Tbit_lms_display_section5norderby_form_element')){
    function Tbit_lms_display_section5norderby_form_element()
    {
        ?>
            <?php 
            $section5norderby = esc_attr(get_option( 'section5norderby' ));
            $checkedsection5radio = esc_attr(get_option( 'section5' ));?>
            <?php if($checkedsection5radio=='yes') { ?>
            <div class="label" id="section5_norderby" style="display:block;"><span class="boldStmt">Order By</span>
            <select name="section5norderby" >
            <option <?php if($section5norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section5norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
            <?php if($checkedsection5radio=='no') { ?>
            <div class="label" id="section5_norderby" style="display:none;"><span class="boldStmt">Order By</span>
            <select name="section5norderby" >
            <option <?php if($section5norderby=='title'){?> selected="selected" <?php }?>>title</option>
            <option <?php if($section5norderby=='date'){?> selected="selected" <?php }?>>date</option>
            </select>
            </div>
            <?php } ?>
        <?php
    }
    }
 
    if( !function_exists('Tbit_lms_display_options')){
    function Tbit_lms_display_options()
    {
        add_settings_section("header_section", "", "", "theme-options");

        //here we display the sections and options in the settings page based on the active tab
        if(isset($_GET["tab"]))
        {
            if($_GET["tab"] == "header-options")
            {
                add_settings_field("toplefttelephone", "Telephone", "Tbit_lms_display_tele_form_element", "theme-options", "header_section");
                register_setting("header_section", "toplefttelephone");

                add_settings_field("topleftemail1", "Email", "Tbit_lms_display_email_form_element", "theme-options", "header_section");
                register_setting("header_section", "topleftemail1");

                add_settings_field("toprightregister", "Register", "Tbit_lms_display_register_form_element", "theme-options", "header_section");
                register_setting("header_section", "toprightregister");

                add_settings_field("toprightlogin", "Login", "Tbit_lms_display_toprightlogin_form_element", "theme-options", "header_section");
                register_setting("header_section", "toprightlogin");

               
                
            }
            elseif($_GET["tab"] == "footer-options")
            {
                add_settings_field("footercontactno", "Footer Phone", "Tbit_lms_display_contactno_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footercontactno");

                add_settings_field("footercontactmail", "Footer mail", "Tbit_lms_display_contactmail_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footercontactmail");

                add_settings_field("footercontactglobe", "Footer globe", "Tbit_lms_display_contactglobe_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footercontactglobe");

                add_settings_field("footersocialfacebook", "Footer Facebook", "Tbit_lms_display_footersocialfacebook_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footersocialfacebook");

                add_settings_field("footersocialtwitter", "Footer twitter", "Tbit_lms_display_footersocialtwitter_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footersocialtwitter");

                add_settings_field("footersocialgoogle", "Footer Gmail", "Tbit_lms_display_footersocialgoogle_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footersocialgoogle");

                add_settings_field("footersociallinkdin", "Footer Linkdin", "Tbit_lms_display_footersociallinkdin_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footersociallinkdin");

                add_settings_field("footeryoutube", "Footer Youtube", "Tbit_lms_display_footeryoutube_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footeryoutube");

                add_settings_field("footer_images", "Footer Images", "Tbit_lms_display_footer_images_form_element", "theme-options", "header_section");      
               
                register_setting("header_section", "footer_images");

            }
            
            elseif($_GET["tab"] == "section-detail")
            {
                // Add Fields For Section-1
                add_settings_field("sliderconfirm", "slider", "Tbit_lms_display_slider_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sliderconfirm");

                add_settings_field("trade_pic", "", "Tbit_lms_display_slider_pic_element", "theme-options", "header_section");
                register_setting("header_section", "trade_pic"); 

                add_settings_field("section1", "Section-1", "Tbit_lms_display_section_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section1");

                add_settings_field("sectiontitle","", "Tbit_lms_display_sectiontitle_form_element", "theme-options", "header_section"); 

                register_setting("header_section", "sectiontitle");

                add_settings_field("sectiondesc", "", "Tbit_lms_display_sectiondesc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectiondesc");

                add_settings_field("sectionposttype", "", "Tbit_lms_display_sectionposttype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectionposttype");

                add_settings_field("sectionnofposts", "", "Tbit_lms_display_sectionnofposts_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectionnofposts");
                add_settings_field("section1numcolumn", "", "Tbit_lms_display_section1numcolumn_form_element", "theme-options", "header_section");
                register_setting("header_section", "section1numcolumn");
                add_settings_field("section1norderby", "", "Tbit_lms_display_sectionnorderby_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section1norderby");
           
                add_settings_field("sectionnordertype", "", "Tbit_lms_display_sectionnordertype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectionnordertype");

                // Add Fields For Section-2
                add_settings_field("section2", "Section-2", "Tbit_lms_display_section2_form_element", "theme-options", "header_section");
                register_setting("header_section", "section2");
                add_settings_field("section2title","", "Tbit_lms_display_sectiontitle2_form_element", "theme-options", "header_section"); 
                register_setting("header_section", "section2title");
                add_settings_field("section2descr", "", "Tbit_lms_display_section2desc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectio2descr");
                add_settings_field("section2descr", "", "Tbit_lms_display_section2desc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "sectio2descr");
               
                add_settings_field("section2posttype", "", "Tbit_lms_display_section2posttype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section2posttype");
                add_settings_field("sectio2nnofposts", "", "Tbit_lms_display_section2nofposts_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section2nofposts");
                add_settings_field("section2numcolumn", "", "Tbit_lms_display_section2numcolumn_form_element", "theme-options", "header_section");
                register_setting("header_section", "section2numcolumn");
                add_settings_field("section2norderby", "", "Tbit_lms_display_section2norderby_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section2norderby");
                add_settings_field("section2nordertype", "", "Tbit_lms_display_section2nordertype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section2nordertype");
                // Add Fields For Section-3
                add_settings_field("section3", "Section-3", "Tbit_lms_display_section3_form_element", "theme-options", "header_section");
                register_setting("header_section", "section3");
                add_settings_field("section3title","", "Tbit_lms_display_section3title_form_element", "theme-options", "header_section"); 

                register_setting("header_section", "section3title");

                add_settings_field("section3desc", "", "Tbit_lms_display_section3desc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section3desc");

                add_settings_field("section3posttype", "", "Tbit_lms_display_section3posttype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section3posttype");
                add_settings_field("sectio3nnofposts", "", "Tbit_lms_display_section3nofposts_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section3nofposts");
                add_settings_field("section3numcolumn", "", "Tbit_lms_display_section3numcolumn_form_element", "theme-options", "header_section");
                register_setting("header_section", "section3numcolumn");
                add_settings_field("section3norder", "", "Tbit_lms_display_section3norder_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section3norder");

                add_settings_field("section3norderby", "", "Tbit_lms_display_section3norderby_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section3norderby");

                // Add Fields For Section-4
                add_settings_field("section4", "Section-4", "Tbit_lms_display_section4_form_element", "theme-options", "header_section");
                register_setting("header_section", "section4");
                add_settings_field("section4title","", "Tbit_lms_display_sectiontitle4_form_element", "theme-options", "header_section"); 
                register_setting("header_section", "section4title");
                add_settings_field("section4desc", "", "Tbit_lms_display_section4desc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4desc");
                add_settings_field("section4posttype", "", "Tbit_lms_display_section4posttype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4posttype");
                add_settings_field("sectio4nnofposts", "", "Tbit_lms_display_section4nofposts_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4nofposts");
                add_settings_field("section4numcolumn", "", "Tbit_lms_display_section4numcolumn_form_element", "theme-options", "header_section");
                register_setting("header_section", "section4numcolumn");
                add_settings_field("section4norder", "", "Tbit_lms_display_section4norder_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4norder");
                add_settings_field("section4norder", "", "Tbit_lms_display_section4norder_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4norder");
                add_settings_field("section4norderby", "", "Tbit_lms_display_section4norderby_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section4norderby");

                // Add Fields For Section-4
                add_settings_field("section5", "Section-5", "Tbit_lms_display_section5_form_element", "theme-options", "header_section");
                register_setting("header_section", "section5");
                add_settings_field("section5title","", "Tbit_lms_display_section5title_form_element", "theme-options", "header_section"); 

                register_setting("header_section", "section5title");
                add_settings_field("section5desc", "", "Tbit_lms_display_section5desc_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section5desc");
                add_settings_field("section5posttype", "", "Tbit_lms_display_section5posttype_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section5posttype");
                add_settings_field("section5nofposts", "", "Tbit_lms_display_sectionn5ofposts_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section5nofposts");
                add_settings_field("section5numcolumn", "", "Tbit_lms_display_section5numcolumn_form_element", "theme-options", "header_section");
                register_setting("header_section", "section5numcolumn");
                add_settings_field("section5norder", "", "Tbit_lms_display_section5norder_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section5norder");
                add_settings_field("section5norderby", "", "Tbit_lms_display_section5norderby_form_element", "theme-options", "header_section");      
                register_setting("header_section", "section5norderby");

           
            }
        }
        else
        {
            add_settings_field("toplefttelephone", "Telephone", "Tbit_lms_display_tele_form_element", "theme-options", "header_section");
            register_setting("header_section", "toplefttelephone");
        }
       
    }
    }
add_action("admin_init", "Tbit_lms_display_options");
if( !function_exists('Tbit_lms_course_curriculum_callback')){
function Tbit_lms_course_curriculum_callback(){
    global $wpdb,$post;
    ?>
    <div class="course_curriculum_main_content">
    <div class="curriculum-sections ui-sortable">

    <div data-section-order="" data-section-id="1" data-course-id="<?php echo esc_attr($post->ID);?>" class="section custom_section">
    <div class="section-collapse" style="display: block;">
        <div class="section-content">
            <div class="section-list-items no-item">
                <ul class="ui-sortable">
                <?php
                $item_ids=array();
                $prepare_sql = $wpdb->prepare("SELECT section_item_id,item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s",1,$post->ID); 
                $results=$wpdb->get_results($prepare_sql,ARRAY_A);
                if(count($results)>0){
                foreach ($results as $key => $value) {
                $item_id=$value['item_id'];
                $section_item_id=$value['section_item_id'];
                $prepare_sql = $wpdb->prepare("SELECT post_title,ID FROM ".$wpdb->prefix."posts WHERE ID =%s AND post_status=%s",$item_id,'publish');
                    $results=$wpdb->get_results($prepare_sql,ARRAY_A);
                    if(count($results)>0){
                        foreach ($results as $key => $value) {
                            $lastid=$item_id;
                            $item_orderid=1;
                            $post_type='gsp_lms_tb_lesson';
                            $title=$value['post_title'];
                            $href=get_edit_post_link($lastid);
                            include('course_section_item.php');
                         }
                    }
                }
                }
                
                ?>
                </ul>
            </div>
        </div>
        <div class="section-actions">
            <button type="button" class="button button-secondary selectitembtn" data-type="lession">Select Lession</button>
        </div>
    </div>

</div>
    </div>

    </div>
 <?php }
}




if( !function_exists('Tbit_lms_course_assesment_callback')){
 function Tbit_lms_course_assesment_callback(){
    global $wpdb,$post;
    ?>
    <div class="course_curriculum_main_content">
    <div class="curriculum-sections ui-sortable">
    <div data-section-id="2" data-course-id="<?php echo esc_attr($post->ID);?>" class="section custom_section">
    <div class="section-collapse" style="display: block;">
        <div class="section-content">
            <div class="section-list-items no-item">
                <ul class="ui-sortable">
                <?php
                $item_ids=array();
                
                $prepare_sql = $wpdb->prepare("SELECT section_item_id,item_id FROM ".$wpdb->prefix."gsplms_section_items WHERE section_id=%s AND course_id=%s",2,$post->ID);
                $results=$wpdb->get_results($prepare_sql,ARRAY_A);
                if(count($results)>0){
                foreach ($results as $key => $value) {
                $item_id=$value['item_id'];
                $section_item_id=$value['section_item_id'];

                $prepare_sql = $wpdb->prepare("SELECT post_title,ID FROM ".$wpdb->prefix."posts WHERE ID =%s AND post_status=%s",$item_id,'publish');
                    $results=$wpdb->get_results($prepare_sql,ARRAY_A);
                    if(count($results)>0){
                        foreach ($results as $key => $value) {
                            $lastid=$item_id;
                            $item_orderid=1;
                            $post_type='lms-assesments';
                            $title=$value['post_title'];
                            $href=get_edit_post_link($lastid);
                            include('course_section_item.php');
                         }
                    }
                }
                }
                
                ?>
                </ul>

            </div>
        </div>
        <div class="section-actions">
            <button type="button" class="button button-secondary selectitembtn" data-type="assesment">Select Assesment</button>
        </div>
    </div>

</div>
    
    </div>
    </div>

 <?php }
}

if( !function_exists('Tbit_lms_lesson_assements_callback')){
function Tbit_lms_lesson_assements_callback(){
    global $post;   
    $content = get_post_meta($post->ID, 'youtube_url',true);
    ?>
    <label style="width: 100%;margin-bottom: 3px;display: block;font-weight: 500;">Youtube Url</label>
    <input type="text" name="youtube_url" value="<?php echo esc_attr($content);?>" placeholder="Please Enter youtube url" style="width: 100%;border-radius: 2px" />
<?php }
}


add_action('save_post', function ($post_id) {
global $wpdb;

 if (isset($_POST['_lms_course_author'])){
    $lms_course_author = sanitize_text_field($_POST['_lms_course_author']);
    $wpdb->update($wpdb->prefix.'posts',array('post_author' => $lms_course_author ),array('ID' => $post_id ));
  }



if(isset($_POST['course_assement_des']) && !empty($_POST['course_assement_des'])){
    $course_assement_des = sanitize_textarea_field($_POST['course_assement_des']);
    update_post_meta($post_id,'course_assement_des',$course_assement_des);
    }
  if(isset($_POST['youtube_url'])){
    $youtube_url = sanitize_text_field($_POST['youtube_url']);
    update_post_meta($post_id,'youtube_url',$youtube_url);
    }

  if (isset($_POST['lms_course_banner_image'])){
    $lms_course_banner_image = sanitize_text_field($_POST['lms_course_banner_image']);
    update_post_meta($post_id, 'lms_course_banner_image', $lms_course_banner_image);
  }
  if (isset($_POST['duration'])){
    $duration = sanitize_text_field($_POST['duration']);
    update_post_meta($post_id, 'duration', $duration);
  }
  if (isset($_POST['qsde_type'])){
    $qsde_type = sanitize_text_field($_POST['qsde_type']);
    update_post_meta($post_id, 'qsde_type', $qsde_type);
  }
  if (isset($_POST['qasx'])){
    $qasx = sanitize_text_field($_POST['qasx']);
    update_post_meta($post_id, 'qasx', $qasx);
  }
  if (isset($_POST['lms_retake_count'])){
    $lms_retake_count = sanitize_text_field($_POST['lms_retake_count']);
    update_post_meta($post_id, 'lms_retake_count', $lms_retake_count);
  }
  if (isset($_POST['_gsp_lms_tb_featured'])){
    $gsp_lms_tb_featured = sanitize_text_field($_POST['_gsp_lms_tb_featured']);
    update_post_meta($post_id, '_gsp_lms_tb_featured', $gsp_lms_tb_featured);
  }
  if (isset($_POST['lms_external_link_buy_course'])){
    $lms_external_link_buy_course = sanitize_text_field($_POST['lms_external_link_buy_course']);
    update_post_meta($post_id, 'lms_external_link_buy_course', $lms_external_link_buy_course);
  }
  if (isset($_POST['course_passinggrade'])){
    $course_passinggrade = sanitize_text_field($_POST['course_passinggrade']);
    update_post_meta($post_id, 'course_passinggrade', $course_passinggrade);
  }
  if (isset($_POST['lms-course-price'])){
    $lms_course_price = sanitize_text_field($_POST['lms-course-price']);
    update_post_meta($post_id, 'lms-course-price', $lms_course_price);
  }

  if (isset($_POST['lms_featured']) && $_POST['lms_featured']=='on'){
    update_post_meta($post_id, 'lms_featured', 1);
  } else {
    update_post_meta($post_id, 'lms_featured', 0);
  }


  if (isset($_POST['gsp_sale_price'])){
    $gsp_lms_tb_sale_price = sanitize_text_field($_POST['gsp_sale_price']);
    update_post_meta($post_id, 'gsp_sale_price', $gsp_lms_tb_sale_price);
  }

  

  if (isset($_POST['_lms_course_author'])){
    $lms_course_author = sanitize_text_field($_POST['_lms_course_author']);
    update_post_meta($post_id, '_lms_course_author', $lms_course_author);
  }

  if (isset($_POST['_lms_course_author'])){
    $lms_course_author = sanitize_text_field($_POST['_lms_course_author']);
    update_post_meta($post_id, '_lms_course_author', $lms_course_author);
  }
  
  if (isset($_POST['gsp_required_enroll']) && $_POST['gsp_required_enroll']=='on'){
    update_post_meta($post_id, 'gsp_required_enroll', 1);
  } else {
    update_post_meta($post_id, 'gsp_required_enroll', 0);
  }

  
  if (isset($_POST['lms_assement_duration'])){
    $lms_assement_duration = sanitize_text_field($_POST['lms_assement_duration']);
    update_post_meta($post_id, 'lms_assement_duration', $lms_assement_duration);
  }

  if (isset($_POST['lms_show_correct_answer']) && $_POST['lms_show_correct_answer']=='on'){
    update_post_meta($post_id, 'lms_show_correct_answer', 1);
  }
  if (isset($_POST['lms_review_question']) && $_POST['lms_review_question']=='on'){
    update_post_meta($post_id, 'lms_review_question', 1);
  }
  if (isset($_POST['lms_pagination_question']) && $_POST['lms_pagination_question']=='on'){
    update_post_meta($post_id, 'lms_pagination_question', 1);
  }
  if (isset($_POST['lms_assement_duration_type'])){
     $lms_assement_duration_type = sanitize_text_field($_POST['lms_assement_duration_type']);
    update_post_meta($post_id, 'lms_assement_duration_type', $lms_assement_duration_type);
  }

  if (isset($_POST['lms_assement_minus_point'])){
    $lms_assement_minus_point = sanitize_text_field($_POST['lms_assement_minus_point']);
    update_post_meta($post_id, 'lms_assement_minus_point', $lms_assement_minus_point);
  }
  if (isset($_POST['lms_assement_minus_skip_point'])){
    $lms_assement_minus_skip_point = sanitize_text_field($_POST['lms_assement_minus_skip_point']);
    update_post_meta($post_id, 'lms_assement_minus_skip_point', $lms_assement_minus_skip_point);
  }
  if (isset($_POST['lms_assement_passing_grade'])){
    $lms_assement_passing_grade = sanitize_text_field($_POST['lms_assement_passing_grade']);
    update_post_meta($post_id, 'lms_assement_passing_grade', $lms_assement_passing_grade);
  }
  if (isset($_POST['lms_assement_retake'])){
    $lms_assement_retake = sanitize_text_field($_POST['lms_assement_retake']);
    update_post_meta($post_id, 'lms_assement_retake', $lms_assement_retake);
  }
  if (isset($_POST['lms_question_mark'])){
    $lms_question_mark = sanitize_text_field($_POST['lms_question_mark']);
    update_post_meta($post_id, 'lms_question_mark', $lms_question_mark);
  }


});
if( !function_exists('Tbit_lms_course_banner_image')){
function Tbit_lms_course_banner_image(){
    global $post;   
    $content = get_post_meta($post->ID, 'lms_course_banner_image',true);
    ?>
    <p>
    <label for="lms_course_banner_image">Image Upload</label><br>
    <input type="text" name="lms_course_banner_image" id="lms_course_banner_image" class="meta-image regular-text" value="<?php echo esc_attr($content); ?>">
    <input type="button" class="button image-upload" value="Browse">
</p>
<div class="image-preview"><img src="<?php echo esc_url($content); ?>" style="max-width: 250px;"></div>



<script>
  jQuery(document).ready(function ($) {
    // Instantiates the variable that holds the media library frame.
    var meta_image_frame
    // Runs when the image button is clicked.
    $('.image-upload').click(function (e) {
      // Get preview pane
      var meta_image_preview = $(this)
        .parent()
        .parent()
        .children('.image-preview')
      // Prevents the default action from occuring.
      e.preventDefault()
      var meta_image = $(this).parent().children('.meta-image')
      // If the frame already exists, re-open it.
      if (meta_image_frame) {
        meta_image_frame.open()
        return
      }
      // Sets up the media library frame
      meta_image_frame = wp.media.frames.meta_image_frame = wp.media({
        title: meta_image.title,
        button: {
          text: meta_image.button,
        },
      })
      // Runs when an image is selected.
      meta_image_frame.on('select', function () {
        // Grabs the attachment selection and creates a JSON representation of the model.
        var media_attachment = meta_image_frame
          .state()
          .get('selection')
          .first()
          .toJSON()
        // Sends the attachment URL to our custom image input field.
        meta_image.val(media_attachment.url)
        meta_image_preview.children('img').attr('src', media_attachment.url)
      })
      // Opens the media library frame.
      meta_image_frame.open()
    })
  })
</script>

<?php }
}

if( !function_exists('Tbit_lms_course_setting_callback')){
function Tbit_lms_course_setting_callback(){
    global $post,$wpdb;
    ?>
<div class="qwe rwmb-duration-wrapper" id="field-_gsp_lms_tb_duration">
   <div class="rty">
      <label for="qsde">Duration</label>
   </div>
   <div class="uio">
      <?php
      $duration=get_post_meta($post->ID,'duration',true);
      if($duration ==''){
        $duration=10;
      }
      ?>
      <input type="number" class="rgn" name="duration" id="qsde" value="<?php echo esc_attr($duration);?>" step="1" min="1" placeholder="">
      <?php
      $qsde_type=get_post_meta($post->ID,'qsde_type',true);
      if($qsde_type == ''){
        $qsde_type='minute';
      }
      ?>
      <select name="qsde_type" id="qsde_type">
         <option value="minute" <?php if($qsde_type=='minute'){?> selected="selected" <?php }?>>Minute(s)</option>
         <option value="hour" <?php if($qsde_type=='hour'){?> selected="selected" <?php }?>>Hour(s)</option>
         <option value="day" <?php if($qsde_type=='day'){?> selected="selected" <?php }?>>Day(s)</option>
         <option value="week" <?php if($qsde_type=='week'){?> selected="selected" <?php }?>>Week(s)</option>
      </select>
      <p id="qsde-description" class="description">The duration of the course.</p>
   </div>
   
</div>
<?php
$qasx=get_post_meta($post->ID,'qasx',true);
if($qasx == ''){
    $qasx= 1000;
}
?>
<div class="qwe rgn-wrapper" id="field-qasx">
   <div class="rty">
      <label for="qasx">Maximum Students</label>
   </div>
   <div class="uio">
      <input step="1" min="0" value="<?php echo esc_attr($qasx);?>" type="number" size="30" id="qasx" class="rgn" name="qasx">
      <p id="qasx-description" class="description">Maximum number of students who can enroll in this course.</p>
   </div>
   
</div>
<?php
$prepare_sql = $wpdb->prepare("SELECT COUNT(*) as totalcount FROM ".$wpdb->prefix."user_payments WHERE course_id=%s AND payment_status = %s",$post->ID,'Completed');
$student_enroll_result = $wpdb->get_results($prepare_sql,ARRAY_A);
$totalcount = 0;
if(count($student_enroll_result)>0 && isset($student_enroll_result[0]['totalcount'])){
    $totalcount = $student_enroll_result[0]['totalcount'];
}

?>
<div class="qwe rgn-wrapper" id="field-_lms_students">
   <div class="rty">
      <label for="lms_students">Students Enrolled</label>
   </div>
   <div class="uio">
      <input step="1" min="0" value="<?php echo esc_attr($totalcount);?>" type="number" size="30" id="lms_students" class="rgn" readonly>
      <p id="lms_students-description" class="description">How many students have taken this course.</p>
   </div>
   
</div>

<?php
$lms_featured=get_post_meta($post->ID,'lms_featured',true);
if($lms_featured == ''){
    $lms_featured = 0;
}
?>
<div class="qwe rwmb-ygfd" id="field-lms_featured">
   <div class="rty">
      <label for="lms_featured">Featured</label>
   </div>
   <div class="uio">
      <input type="checkbox" class="poi" name="lms_featured" id="lms_featured" <?php if($lms_featured==1){ echo "checked"; }?>>
      <p id="vbn" class="description">Set course as featured.</p>
   </div>
   
</div>

<?php
$lms_external_link_buy_course=get_post_meta($post->ID,'lms_external_link_buy_course',true);
if($lms_external_link_buy_course == ''){
    $lms_external_link_buy_course = '';
}
?>    
<?php }
}
if( !function_exists('Tbit_lms_assesment_setting_callback')){
function Tbit_lms_assesment_setting_callback(){
    global $post;
    ?>
    <?php
$course_passinggrade=get_post_meta($post->ID,'course_passinggrade',true);
if($course_passinggrade == ''){
    $course_passinggrade = 80;
}
?>
<div class="qwe rgn-wrapper" id="field-_gsp_lms_tb_passing_condition">
    <div class="rty">
        <label for="_gsp_lms_tb_passing_condition">Passing condition value</label>
    </div>
    <div class="uio">
        <input value="<?php echo esc_attr($course_passinggrade);?>" name="course_passinggrade" type="number" size="30" id="_gsp_lms_tb_passing_condition" class="rgn">
        <p id="_gsp_lms_tb_passing_condition-description" class="description">The percentage of quiz result or completed lessons to finish the course.</p>
    </div>
</div>

    
<?php }
}


if( !function_exists('Tbit_lms_pricing_setting_callback')){
function Tbit_lms_pricing_setting_callback(){
    global $post,$wpdb;
$lms_course_price=get_post_meta($post->ID,'lms-course-price',true);
if($lms_course_price == ''){
    $lms_course_price = 80;
}
    $gsp_lms_currency = 'USD';
    
    $prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",'gsp_lms_currency');
    $result = $wpdb->get_results($prepare_sql,ARRAY_A);
    if(count($result)>0 && isset($result[0]['meta_value']) && !empty($result[0]['meta_value'])){
    $gsp_lms_currency = $result[0]['meta_value'];
    }

    ?>
<div class="qwe rgn-wrapper" id="field-_gsp_lms_tb_price">
    <div class="rty">
        <label for="_gsp_lms_tb_price">Price</label>
    </div>
    <div class="uio">
        <input type="number" size="30" name="lms-course-price"  id="_gsp_lms_tb_price" class="rgn" value="<?php echo esc_attr($lms_course_price);?>">
        <p id="_gsp_lms_tb_price-description" class="description">Course price in <strong><?php echo esc_html($gsp_lms_currency);?></strong> currency.</p>
    </div>      
</div>
 <?php
$gsp_lms_tb_sale_price=get_post_meta($post->ID,'gsp_sale_price',true);
if($gsp_lms_tb_sale_price == ''){
    $gsp_lms_tb_sale_price = '';
}
 ?>   
<div class="qwe rgn-wrapper" id="field-gsp_sale_price">
    <div class="rty">
        <label for="gsp_sale_price">Sale Price</label>
    </div>
    <div class="uio">
        <input type="number" name="gsp_sale_price" size="30" id="gsp_sale_price" class="rgn" value="<?php echo esc_attr($gsp_lms_tb_sale_price);?>">
        <p id="gsp_sale_price-description" class="description">Course sale price in <strong><?php echo esc_html($gsp_lms_currency); ?></strong> currency. Leave blank to remove sale price. <a href="#" id="gsp_sale_price_schedule">Schedule</a></p>
    </div>
</div>
 <?php
$gsp_lms_tb_required_enroll=get_post_meta($post->ID,'gsp_required_enroll',true);
if($gsp_lms_tb_required_enroll == ''){
    $gsp_lms_tb_required_enroll = 0;
}
 ?> 
<div class="qwe rwmb-ygfd" id="field-gsp_required_enroll">
    
    <div class="uio">
        
        <input type="checkbox" class="poi" name="gsp_required_enroll"  id="gsp_required_enroll" <?php if($gsp_lms_tb_required_enroll==1){ echo 'checked'; } ?>><p id="gsp_required_enroll-description" class="description">Enrollment Required</p>
    </div>          
</div>
    
    
<?php }
}
if( !function_exists('Tbit_lms_author_callback')){
function Tbit_lms_author_callback(){
global $post;
    ?>
<div class="qwe rwmb-select-wrapper" id="field-_gsp_lms_tb_course_author">
    <div class="rty">
        <label for="_gsp_lms_tb_course_author">Author</label>
    </div>
    <div class="uio">
        <select id="_gsp_lms_tb_course_author" name="_lms_course_author" class="rwmb-select">
            <?php 
            $alluser=get_users( array('role__in' => array('administrator', 'instructor' )));
            $author_id = get_post_field ('post_author', $post_id);
            $lms_course_author=get_post_meta($post->ID,'_lms_course_author',true);
            if($lms_course_author == ''){
                $lms_course_author = $author_id;
            }

            

            foreach ($alluser as $key => $value) {?>
            <option <?php if($lms_course_author==$value->data->ID){?> selected="selected" <?php }?> value="<?php echo esc_attr($value->data->ID); ?>"><?php echo esc_html($value->data->display_name);?></option>

            <?php }
            ?>
            
        </select>
    </div>
</div>

<?php }
}
if( !function_exists('Tbit_lms_question_assements_callback')){
function Tbit_lms_question_assements_callback(){
global $post,$wpdb;
?>
<div class="assesment_headingbox">
    <h3 class="amb_leftbox">
    Question Answers
    <div class="amb_rightbox">
        <?php 
        $getanswer_type=get_post_meta($post->ID,'gsplmsq_type',true);
        ?>
      <select id="selectanswer_type">
        <option value="true_or_false" <?php if($getanswer_type=='true_or_false'){ echo 'selected'; }?>>True or False</option>
        <option value="single_choice" <?php if($getanswer_type=='single_choice'){ echo 'selected'; }?>>Single Choice</option>
      </select>
    </div>
    </h3>
    <div class="clear"></div>
</div>
<div class="assesmentdata">
    <?php 
    $post_id=$post->ID;
    include ('questionrows.php');?>
</div>
<?php }
}
if( !function_exists('Tbit_lms_question_setting_callback')){
function Tbit_lms_question_setting_callback(){
    global $post;
    ?>
    <div id="question-setting" class="comn-sec">
    <div class="container">
        <form class="gerernal-form">
            <div class="row">
                <?php 
                $lms_question_mark=get_post_meta($post->ID,'lms_question_mark',true);
                if($lms_question_mark ==''){
                    $lms_question_mark=1;
                }
                ?>
                <div class="col-sm-12">
                    <h6>Mark For This Question</h6>
                    <input type="number" min="0" class="form-control" value="<?php echo esc_attr($lms_question_mark);?>" name="lms_question_mark" />
                    <label>Mark for choosing the right answer.</label>
                </div>
            </div>
        </form>
    </div>
</div>
<?php }
}
if( !function_exists('Tbit_lms_assements_Questions')){
function Tbit_lms_assements_Questions(){
    global $post,$wpdb;
    ?>
    <div class="questions_quizbox">
        <div class="a_qestionbox">
            <?php
            $post_id=$post->ID;
            $prepare_sql = $wpdb->prepare("SELECT gqq.question_id,p.post_title FROM ".$wpdb->prefix."gsplms_quiz_questions gqq LEFT JOIN ".$wpdb->prefix."posts p ON gqq.question_id=p.ID WHERE quiz_id=%s",$post_id);
            $results=$wpdb->get_results($prepare_sql,ARRAY_A);
            if(count($results)>0){
                include('assestment_questionlist.php');
            }
            ?>
        </div>
        <div class="addnewbuttonbox">
            
            <b>Select Question</b>
            <button type="button" class="addnewquestionbtn button">Select</button>
        </div>
    </div>
    <style type="text/css">
        .addnewbuttonbox{
            display: flex;
            align-items: center;
            padding: 20px 0px 0px 0px;
        }
        .addnewbuttonbox b{margin-right: 20px;}
    </style>
<?php }
}
if( !function_exists('Tbit_lms_assesementquestionsetting_callback')){
function Tbit_lms_assesementquestionsetting_callback(){
    global $post;
    ?>
            <div id="gerernal-setting" class="comn-sec">
    <div class="container">
        <form class="gerernal-form">
            <div class="row">
                <?php
                $lms_pagination_question=get_post_meta($post->ID,'lms_pagination_question',true);
                if($lms_pagination_question==''){
                    $lms_pagination_question=0;
                }
                ?>
                <?php
                $lms_review_question=get_post_meta($post->ID,'lms_review_question',true);
                if($lms_review_question==''){
                    $lms_review_question=0;
                }
                ?>
                <?php
                $lms_show_correct_answer=get_post_meta($post->ID,'lms_show_correct_answer',true);
                if($lms_show_correct_answer==''){
                    $lms_show_correct_answer=0;
                }
                ?>
                <?php
                $lms_assement_duration=get_post_meta($post->ID,'lms_assement_duration',true);
                if($lms_assement_duration==''){
                    $lms_assement_duration=10;
                }
                ?>
                <div class="col-sm-6">
                    <h6>Duration</h6>
                    <div class="input-with-select row">
                        <div class="col-sm-5">
                            <input type="number" min="1" class="form-control" name="lms_assement_duration" value="<?php echo esc_attr($lms_assement_duration);?>" />
                        </div>
                        <?php
                        $lms_assement_duration_type=get_post_meta($post->ID,'lms_assement_duration_type',true);
                        if($lms_assement_duration_type==''){
                        $lms_assement_duration_type='minute';
                        }
                        ?>
                        <div class="col-sm-7">
                            <select name="lms_assement_duration_type" class="form-control">
                            <option value="minute" <?php if($lms_assement_duration_type=='minute'){?> selected="selected" <?php }?>>Minute(s)</option>
                            <option value="hour" <?php if($lms_assement_duration_type=='hour'){?> selected="selected" <?php }?>>Hour(s)</option>
                            <option value="day" <?php if($lms_assement_duration_type=='day'){?> selected="selected" <?php }?>>Day(s)</option>
                            <option value="week" <?php if($lms_assement_duration_type=='week'){?> selected="selected" <?php }?>>Week(s)</option>
                            </select>

                        </div>
                        <div class="col-sm-12">
                            <label>Duration of the quiz. Set 0 to disable.</label>
                        </div>                      
                    </div>
                </div>
                <?php
                $lms_assement_minus_point=get_post_meta($post->ID,'lms_assement_minus_point',true);
                if($lms_assement_minus_point==''){
                $lms_assement_minus_point='0';
                }
                ?>
                <div class="col-sm-6">
                    <h6>Minus Points</h6>
                    <input type="text" name="lms_assement_minus_point" class="form-control" value="<?php echo esc_attr($lms_assement_minus_point);?>" />
                    <label>How many points minus for each wrong question in quiz.</label>
                </div>
                <?php
                $lms_assement_minus_skip_point=get_post_meta($post->ID,'lms_assement_minus_skip_point',true);
                if($lms_assement_minus_skip_point==''){
                $lms_assement_minus_skip_point='0';
                }
                ?>
                <div class="col-sm-6">
                    <h6>Minus For Skip</h6>
                    <input type="text" class="form-control" value="<?php echo esc_attr($lms_assement_minus_skip_point);?>" name="lms_assement_minus_skip_point" />
                    <label>minus points for skip question.</label>
                </div>
                <?php
                $lms_assement_passing_grade=get_post_meta($post->ID,'lms_assement_passing_grade',true);
                if($lms_assement_passing_grade==''){
                $lms_assement_passing_grade='80';
                }
                ?>
                <div class="col-sm-6">
                    <h6>Passing Grade (%)</h6>
                    <input type="text" class="form-control" value="<?php echo esc_attr($lms_assement_passing_grade);?>" name="lms_assement_passing_grade" />
                    <label>Requires user reached this point to pass the quiz.</label>
                </div>
                <?php
                $lms_assement_retake=get_post_meta($post->ID,'lms_assement_retake',true);
                if($lms_assement_retake==''){
                $lms_assement_retake='0';
                }
                ?>
                <div class="col-sm-6">
                    <h6>Re-take</h6>
                    <input name="lms_assement_retake" type="text" class="form-control" value="<?php echo esc_attr($lms_assement_retake);?>" />
                    <label>How many times the user can re-take quiz. Set to 0 to disable re-taking.</label>
                </div>
            </div>
        </form>
    </div>
</div>
<?php }
}
?>