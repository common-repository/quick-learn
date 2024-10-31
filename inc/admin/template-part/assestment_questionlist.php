<?php

$results=$results;

if(count($results)>0){

   $i=1;

   foreach ($results as $key => $value) {

   $getpostmeta=get_post_meta($value['question_id'],'gsplmsq_type',true);

?>



<div data-item-id="<?php echo esc_attr($value['question_id']) ?>" data-question-order="0" class="question-item <?php echo esc_attr($getpostmeta); ?>">

   <div class="question-actions table-row">

      <div class="order"><?php echo esc_html($i);?></div>

      <div class="name"><input type="text" value="<?php echo esc_attr($value['post_title']);?>" class="question-title"></div>

      <div class="type"><?php

      if($getpostmeta=='multi_choice2'){

         echo 'Multi Choice';

      } else if($getpostmeta=='single_choice'){

         echo 'Single Choice';

      } else if($getpostmeta=='true_or_false'){

         echo 'True or False';

      }

      ?></div>

      <div class="actions">

         <div class="gsp_lms_tb-box-data-actions gsp_lms_tb-toolbar-buttons">

            <div data-content-tip="Edit item" class="gsp_lms_tb-toolbar-btn gsp_lms_tb-title-attr-tip ready" data-id="5f9fda0c0afbb"><a href="post.php?post=<?php echo esc_attr($value['question_id']);?>&amp;action=edit" target="_blank" class="gsp_lms_tb-btn-icon dashicons dashicons-edit"></a></div>

            <div class="gsp_lms_tb-toolbar-btn gsp_lms_tb-btn-remove gsp_lms_tb-toolbar-btn-dropdown">

               <a class="gsp_lms_tb-btn-icon dashicons dashicons-trash"></a> 

               <ul>

                  <li><a class="remove">Remove from quiz</a></li>

                  <li><a class="delete">Move to trash</a></li>

               </ul>

            </div>

            <span class="gsp_lms_tb-toolbar-btn gsp_lms_tb-btn-toggle close"></span>

         </div>

      </div>

   </div>

</div>



<?php $i++; } }?>