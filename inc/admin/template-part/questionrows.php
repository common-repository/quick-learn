<?php

global $post,$wpdb;

?>

<div class="assesment_contentbox" data-getanswer_type="<?php echo esc_attr($getanswer_type);?>" >

<div class="questionrowsbox">

<table class="acb_tablebox">

<thead class="acbt_theadbox">

<tr>

<th class="order">#</th> 

<th class="answer-text">Answer Text</th> 

<th class="answer-correct">Correct?</th> 

<th class="actions"></th>

</tr>

</thead>

	<tbody>

	<?php
	$prepare_sql = $wpdb->prepare('SELECT * FROM '.$wpdb->prefix.'gsplms_question_answers WHERE question_id=%s ORDER BY question_answer_id ASC',$post_id);
	$results=$wpdb->get_results($prepare_sql,ARRAY_A); 

	?>

	<?php

	if(count($results)>0){

	if(count($results)>1){

		$enabledeletebtn='yes';

	} else {

		$enabledeletebtn='no';

	}

	$i=1;
	$checked = '';
	$echecked = '';
	foreach ($results as $key => $value) {

	$answer=unserialize($value['answer_data']);
	if($answer['is_true'] == 'yes'){
		$checked = 'yes';
	}
	if($i == count($results) && $checked == ''){
		$echecked = 'yes';
	}
	?>

	<tr data-answer-id="<?php echo esc_attr($value['question_answer_id']);?>" class="answer-option">

	<td class="order"><?php echo esc_html($i);?>.</td> 

	<td class="answer-text">

	<input type="text" value="<?php echo esc_attr($answer['text']);?>">

	</td>

	<td class="answer-correct gsp_lms_tb-answer-check">



	<?php if($getanswer_type=='true_or_false' || $getanswer_type=='single_choice'){?>

	<input type="radio" name="answer_question[<?php echo esc_attr($post_id);?>]" <?php if($answer['is_true']=='yes'){

	echo 'checked';

	}?> <?php if($echecked=='yes'){

	echo 'checked';

	}?> value="<?php echo esc_attr($answer['is_true']);?>">

	<?php } else if($getanswer_type=='multi_choice1') {?>

	<input type="checkbox" name="answer_question[<?php echo esc_attr($post_id);?>]" <?php if($answer['is_true']=='yes'){

	echo 'checked';

	}?> value="<?php echo esc_attr($answer['is_true'])?>">

	<?php }?>

	</td> 

	<td class="actions1 gsp_lms_tb-toolbar-buttons1">

		<?php

		if($enabledeletebtn =='yes'){

		?>

		<div class="gsp_lms_tb-toolbar-btn1 gsp_lms_tb-btn-remove1 remove-answer1">

			<a class="gsp_lms_tb-btn-icon1 dashicons dashicons-trash"></a>

		</div>

	    <?php }?>

	</td>

	</tr>

	<?php $i++; }

	} else {?>

	<tr data-answer-id="-1" class="answer-option">

	<td class="order">1.</td> 

	<td class="answer-text">

	<input type="text" value="true">

	</td>

	<td class="answer-correct gsp_lms_tb-answer-check">

	<input type="radio" name="answer_question[<?php echo esc_attr($post_id);?>]" value="true" checked></td> 

	<td class="actions gsp_lms_tb-toolbar-buttons"></td>

	</tr>

	<tr data-answer-id="-2" class="answer-option">

	<td class="order">2.</td> 

	<td class="answer-text">

	<input type="text" value="false">

	</td>

	<td class="answer-correct gsp_lms_tb-answer-check">

	<input type="radio" name="answer_question[<?php echo esc_attr($post_id);?>]" value="true"></td> 

	<td class="actions gsp_lms_tb-toolbar-buttons"></td>

	</tr>

	<?php }?>



</tbody>

</table>

<?php

if($getanswer_type=='multi_choice'  || $getanswer_type=='single_choice'){?>

	<div class="addoptionbtn" data-post_id=<?php echo esc_attr($post_id);?>>

		<button  data-type="<?php echo esc_attr($getanswer_type);?>" type="button" name="addoption" class="button">Add Option</button>

	</div>

<?php }

?>

</div>

</div>