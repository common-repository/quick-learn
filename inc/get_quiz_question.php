<?php
	
	$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$item_id);
	$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);
	$question_ids=array();

	if(count($get_results)>0){
	foreach ($get_results as $key => $value111) {
	$question_ids[]=$value111['question_id'];
	}
	}

	$question_ids=implode(',', $question_ids);	

	$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_status=%s AND ID IN($question_ids)",'publish');
	$qget_results=$wpdb->get_results($prepare_sql,ARRAY_A);

	$lms_assement_duration=get_post_meta($item_id,'lms_assement_duration',true);
	$lms_assement_duration_type=get_post_meta($item_id,'lms_assement_duration_type',true);
	$lms_assement_retake=get_post_meta($item_id,'lms_assement_retake',true);
	$lms_assement_passing_grade=get_post_meta($item_id,'lms_assement_passing_grade',true);

	$data_quiz['questions'] = array();
	$lms_question_mark_count = 0;
	$user_mark = 0;
	$question_count = 0;
	$_current_question = '';
	if(count($qget_results)>0){
	$jjjjj = 0;
	foreach ($qget_results as $key => $value) {
	if($jjjjj == 0){
	$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsplms_question_answers WHERE question_id=%s",$value['ID']);
	$qget_results11=$wpdb->get_results($prepare_sql,ARRAY_A);?>

	<div class="quiz-progress">
	<div class="progress-items">
	<div class="progress-item quiz-current-question">
	<span class="progress-number">
	<span class="progress_number_count">1</span>/<?php echo esc_html(count($qget_results));?>            </span>
	<span class="progress-label">
	Question            </span>
	</div>
	<div class="progress-item quiz-countdown">
	<span class="progress-number" id="time"><?php
	$timeremain = tbit_lms_getDuration($lms_assement_duration,$lms_assement_duration_type);
	echo esc_html($timeremain);
	?></span>
	<span class="progress-label timeremain" data-time= "<?php echo esc_attr($timeremain);?>" data-timespend= "0">
	Time remaining            </span>
	</div>
	</div>
	</div>
	<div class="mainquestionbox">
	<h4 class="question-title"><?php echo esc_html($value["post_title"]); ?></h4>
	<?php
	if(count($qget_results11)>0){?>
	<div class="an_checkbox_mainbox" data-item-id="<?php echo esc_attr($value['ID']); ?>" data-main-item-id="<?php echo esc_attr($item_id); ?>"> 
	<?php 
	foreach ($qget_results11 as $key => $value) {
	$answer_dataqq = unserialize($value['answer_data']);
	if(count($answer_dataqq)>0){?>
	<div class="an_checkbox">
	<input style="display: block;" type="radio" name="answer" class="radio_btn" value="<?php echo esc_attr($answer_dataqq['value']);?>">
	<span style="margin-left: 10px;" class="radio_btntext"><?php echo esc_html($answer_dataqq['text']);?></span>
	</div>
	<?php }
	}?>
	</div>
	<div class="gsp_lms_tb-quiz-buttons">

	<?php
	if (count($qget_results)>1){?>
	<form name="next-question" class="next-question form-button gsp_lms_tb-form" method="post" action="">
	<button type="button" id="next-question" value="next" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Next</button>
	</form>
	<form name="skip-question" class="skip-question form-button gsp_lms_tb-form" method="post" action="">
	<button type="button" id="skip-question" value="skip" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Skip</button>
	</form>
	<?php }?>


	<?php
	if (count($qget_results)==1){?>
	<form name="complete-quiz" data-confirm="Do you want to complete quiz &quot;Awesome test&quot;?" data-action="complete-quiz" class="complete-quiz form-button gsp_lms_tb-form" method="post" enctype="multipart/form-data">
	<button type="button" name="completeQuiz" id="complete-question" value="complete" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Complete</button>

	</form>
	<?php }?>
	</div>
	<?php } }
	$jjjjj++ ;}
	}
if(!function_exists('tbit_lms_getDuration')){
function tbit_lms_getDuration($lms_assement_duration,$lms_assement_duration_type){
if($lms_assement_duration_type=='minute'){
$minutes=$lms_assement_duration;
$hours = floor($minutes / 60); // Get the number of whole hours
$minutes = $minutes % 60; // Get the remainder of the hours
$seconds = 00;
return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
} else if($lms_assement_duration_type=='hour'){
$minutes = 00;
$seconds = 00;
return sprintf ("%02d:%02d:%02d", $lms_assement_duration, $minutes,$seconds);
} else if($lms_assement_duration_type=='day'){
$minutes = 00;
$seconds = 00;
$hours=$lms_assement_duration*24;
return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
} else if($lms_assement_duration_type=='week'){
$minutes = 00;
$seconds = 00;
$hours=($lms_assement_duration*7)*24;
return sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
}
}
}
	?>
	<div class=""></div>
	</div>

<script type="text/javascript">

	var upgradeTime = $('#time').html();
var upgradeTimed1 = $('.progress-label.timeremain').data('time');
if(typeof upgradeTimed1 != 'undefined'){
var upgradeTimed = upgradeTimed1.split(':');
} else {
var upgradeTimed = [];
}



var timer1 = 0;
if(upgradeTimed.length==3){

if(upgradeTimed[0] != 00){
timer1 = timer1+(upgradeTimed[0]*3600);
}
if(upgradeTimed[1] != 00){
timer1 = timer1+(upgradeTimed[1]*60);
}
timer1 = timer1+Number(upgradeTimed[2]);
} else {
if(upgradeTimed[0] != 00){
timer1 = timer1+(upgradeTimed[0]*86400);
}
if(upgradeTimed[1] != 00){
timer1 = timer1+(upgradeTimed[1]*3600);
}
if(upgradeTimed[2] != 00){
timer1 = timer1+(upgradeTimed[2]*60);
}
timer1 = timer1+Number(upgradeTimed[3]);
}

var seconds = timer1;
	

function tbit_lms_timer() {


var days        = Math.floor(seconds/24/60/60);
var hoursLeft   = Math.floor((seconds) - (days*86400));
var hours       = Math.floor(hoursLeft/3600);
var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
var minutes     = Math.floor(minutesLeft/60);
var remainingSeconds = seconds % 60;
function tbit_lms_pad(n) {
return (n < 10 ? "0" + n : n);
}

if(days==00){
document.getElementById('time').innerHTML = tbit_lms_pad(hours) + ":" + tbit_lms_pad(minutes) + ":" + tbit_lms_pad(remainingSeconds);
} else {
document.getElementById('time').innerHTML = tbit_lms_pad(days) + ":" + tbit_lms_pad(hours) + ":" + tbit_lms_pad(minutes) + ":" + tbit_lms_pad(remainingSeconds);
}
var gettimespend =  $('.timeremain').attr('data-timespend');
var gettimespendnew = Number(gettimespend)+1;
$('.timeremain').attr('data-timespend',gettimespendnew);


if (seconds == 0) {
jQuery('#complete-question').trigger('click');
jQuery('#next-question').attr('value','complete');
jQuery('#next-question').trigger('click');
clearInterval(countdownTimer);

//document.getElementById('countdown').innerHTML = "Completed";
} else {
seconds--;
}
}
if(upgradeTimed.length>0){
var countdownTimer = setInterval('tbit_lms_timer()', 1000);
}
</script>