<?php
global $wpdb;

$prepare_sql = $wpdb->prepare("SELECT * FROM ".$wpdb->prefix."gsp_user_items WHERE user_id=%s AND item_id=%s AND ref_type=%s AND ref_id=%s",$user_id,$item_id,'lms-assesments',$course_id);

$user_data=$wpdb->get_results($prepare_sql,ARRAY_A);

$lms_assement_duration=get_post_meta($item_id,'lms_assement_duration',true);
$lms_assement_duration_type=get_post_meta($item_id,'lms_assement_duration_type',true);
$lms_assement_retake=get_post_meta($item_id,'lms_assement_retake',true);
$lms_assement_passing_grade=get_post_meta($item_id,'lms_assement_passing_grade',true);


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

if(count($user_data)<=0){?>
<ul class="quiz-intro">
<li>
<span class="mpqi_vlable">Attempts allowed &nbsp;&nbsp;</span>
<span class="mpqi_alable">
<?php
if($lms_assement_retake==0){
echo 'No';
} else {
echo esc_html($lms_assement_retake);
}
?>
</span>
</li>
<li>
<span class="mpqi_vlable">Duration</span>
<span class="mpqi_alable"><?php echo esc_html(getDuration($lms_assement_duration,$lms_assement_duration_type));?></span>
</li>
<li>
<span class="mpqi_vlable">Passing grade</span>
<span class="mpqi_alable"><?php echo esc_html($lms_assement_passing_grade);?>%</span>
</li>
<li>
<span class="mpqi_vlable">Questions</span>
<span class="mpqi_alable"><?php echo esc_html(count($qget_results));?></span>
</li>
</ul>
<form method="post" action="">
<input type="hidden" name="start_assesment" value="yes">
<input type="hidden" name="item_id" value="<?php echo esc_attr($item_id);?>">
<input type="hidden" name="ref_id" value="<?php echo esc_attr($course_id);?>">
<input type="hidden" name="ref_type" value="lms-assesments">
<input type="hidden" name="status" value="started">
<div class="mp_startbtn">
<button 
type="button" 
class="button btn btn-success quiz_start_btn"
data-ref_type="lms-assesments"
data-ref_id="<?php echo esc_attr($course_id);?>"
data-item_id="<?php echo esc_attr($item_id);?>"
data-status="started"
>
Start
</button>
</div>
<?php } else if(isset($user_data[0]['status']) && $user_data[0]['status'] == 'completed' ){

$user_item_id = $user_data[0]['user_item_id'];

$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_itemmeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'results');

$user_data_result=$wpdb->get_results($prepare_sql,ARRAY_A);
$unserialize = unserialize($user_data_result[0]['meta_value']);
$title=get_the_title($item_id);

$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_user_retakemeta WHERE gsp_user_item_id=%s AND meta_key=%s",$user_item_id,'retaken_count');

$r_result = $wpdb->get_results($prepare_sql,ARRAY_A);

if(count($r_result)>0 && isset($r_result[0]['meta_value']) && $r_result[0]['meta_value'] !=''){
 $retake_count = $r_result[0]['meta_value'];
 $ac_r_count = (int)$lms_assement_retake - (int)$retake_count;
} else {
	$ac_r_count = $lms_assement_retake;
}


?>

<div id="content-item-quiz" class="content-item-summary">

<h3 class="course-item-title quiz-title"><?php echo esc_html($title); ?></h3>

<div class="quiz-result passed">

<h3>Your Result</h3>

<div class="result-grade"><span class="result-achieved" style="font-size: 30px;color: #007bff;"><?php echo esc_html($unserialize['result']);?>%</span><p class="result-message">Your grade is <strong><?php echo esc_html($unserialize['grade_text']);?></strong> </p></div>

<ul class="result-statistic">

<?php 
$user_start_time = $user_data[0]['start_time'];
$user_end_time = $user_data[0]['end_time'];

$dateTimeObject1 = date_create($user_end_time); 
$dateTimeObject2 = date_create($user_start_time); 
$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
$hours = $difference->days * 24;
$hours += $difference->h;
$minutes = $difference->i;
$seconds = $difference->s;
$user_used_time = sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);


?>

<li class="result-statistic-field ddddd"><strong>Time spend</strong><p><?php echo esc_html($user_used_time);?></p></li>
<li class="result-statistic-field"><strong>Questions</strong><p><?php echo esc_html($unserialize['question_count']);?></p></li>
<li class="result-statistic-field"><strong>Correct</strong><p><?php echo esc_html($unserialize['question_correct']);?></p></li>
<li class="result-statistic-field"><strong>Wrong</strong><p><?php echo esc_html($unserialize['question_wrong']);?></p></li>
</ul>
<?php
	if($ac_r_count != '' && $ac_r_count != 0){

?>
<div class="retake_button">
	<button class="btn btn_retake" data-id="<?php echo esc_attr($item_id); ?>" data-course_id="<?php echo esc_attr($course_id); ?>"> Retake(<?php echo esc_html($ac_r_count);?>)</button>
</div>
<?php }?>
</div>
</div>
<div class="navigationbox_quiz">
	<div class="prev_quiz" data-id="<?php echo esc_attr($user_data[0]['item_id']);?>">Prev</div>
	<div class="nxt_quiz" data-id="<?php echo esc_attr($user_data[0]['item_id']);?>">Next</div>
</div>
<?php } else if(isset($user_data[0]['status']) && $user_data[0]['status'] == 'started' ){
	$assesment_start_time = 0; 
	$current_question_number = 1;
	$total_question_count = 0;
	$table_name = "{$wpdb->prefix}gsp_user_itemmeta";
	$user_item_id = 0;
	if(isset($user_data[0]['user_item_id']) && $user_data[0]['user_item_id'] !=''){
		$user_item_id = $user_data[0]['user_item_id'];
	}

	if(isset($user_data[0]['start_time']) && $user_data[0]['start_time'] !=''){
		$assesment_start_time = $user_data[0]['start_time'];
	}

	$item_sql = $wpdb->prepare( "SELECT meta_value FROM $table_name  WHERE  gsp_user_item_id=%s AND meta_key=%s",array($user_item_id,'_current_question') );
	$u_result= $wpdb->get_results($item_sql,ARRAY_A);
	
	$is_q_active = '';
	$current_question_id = 0;
	if(count($u_result)>0 && isset($u_result[0]['meta_value']) && !empty($u_result[0]['meta_value'])){
		$current_question_id = $u_result[0]['meta_value'];
		$get_post_status = get_post_status($u_result[0]['meta_value']);
		if($get_post_status == 'publish'){
			$is_q_active = 1;
		}
	}

	$prepare_sql = $wpdb->prepare("SELECT question_id FROM ".$wpdb->prefix."gsplms_quiz_questions WHERE quiz_id=%s",$item_id);
	$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);

	$question_ids=array();
	$rr = 1;
	if(count($get_results)>0){
	$total_question_count = count($get_results);
	foreach ($get_results as $key => $value111) {
	if($value111['question_id'] == $current_question_id){
		$current_question_number = $rr;
	}
	$question_ids[]=$value111['question_id'];
	$rr++;
	}
	}


	if($is_q_active === 1){
		$qget_results[0] = array(
			'ID' => $current_question_id,
		);
	} else {
		$question_ids=implode(',', $question_ids);	
		$prepare_sql = $wpdb->prepare("SELECT ID,post_title FROM ".$wpdb->prefix."posts WHERE post_status=%s AND ID IN($question_ids)",'publish');
		$qget_results=$wpdb->get_results($prepare_sql,ARRAY_A);
	}
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
	<span class="progress_number_count"><?php echo esc_html($current_question_number); ?></span>/<?php echo esc_html($total_question_count);?>            </span>
	<span class="progress-label">
	Question            </span>
	</div>
	<div class="progress-item quiz-countdown">
	<span class="progress-number" id="time"><?php
	

	$addtime = $lms_assement_duration.$lms_assement_duration_type;

	$total_assesment_time = strtotime($assesment_start_time.'+'.$addtime);
	$currenttime = strtotime(date('Y-m-d H:i:s'));
	$remaintime = $total_assesment_time - $currenttime;
	
	if($remaintime<=0){
		$timeremain = getDuration(0,$lms_assement_duration_type);
	} else {
		$endtime = $total_assesment_time;
		$endtime_convert = date('Y-m-d H:i:s', $endtime);
		$from_date = date('Y-m-d H:i:s');

		$dateTimeObject1 = date_create($endtime_convert); 
		$dateTimeObject2 = date_create($from_date); 
		$difference = date_diff($dateTimeObject1, $dateTimeObject2); 
		$hours = $difference->days * 24;
		$hours += $difference->h;
		$minutes = $difference->i;
		$seconds = $difference->s;
		$timeremain = sprintf ("%02d:%02d:%02d", $hours, $minutes,$seconds);
	}
	echo esc_html($timeremain);
	?></span>
	<span class="progress-label timeremain" data-time= "<?php echo esc_attr($timeremain);?>" data-timespend= "0">
	Time remaining            </span>
	</div>
	</div>
	</div>
	<div class="mainquestionbox">
	<h4 class="question-title"><?php echo esc_html(get_the_title($value["ID"])); ?></h4>
	<?php
	if(count($qget_results11)>0){?>
	<div class="an_checkbox_mainbox" data-item-id="<?php echo esc_attr($value['ID']); ?>" data-main-item-id="<?php echo esc_attr($item_id); ?>"> 
	<?php 
	foreach ($qget_results11 as $key => $value) {
	$answer_dataqq = unserialize($value['answer_data']);
	if(count($answer_dataqq)>0){?>
	<div class="an_checkbox">
	<input style="display: block;" type="radio" name="answer" class="radio_btn" value="<?php echo esc_attr($answer_dataqq['value'])?>">
	<span style="margin-left: 10px;" class="radio_btntext"><?php echo esc_html($answer_dataqq['text']);?></span>
	</div>
	<?php }
	}?>
	</div>
	<div class="gsp_lms_tb-quiz-buttons">
	<?php
	if($total_question_count>1 && $current_question_number == $total_question_count ){?>
	<form name="prev-question" class="prev-question form-button gsp_lms_tb-form" method="post" action="">
	<button type="button" id="prev-question" value="prev" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Prev</button>
	</form>
	<form name="complete-quiz" data-confirm="Do you want to complete quiz &quot;Awesome test&quot;?" data-action="complete-quiz" class="complete-quiz form-button gsp_lms_tb-form" method="post" enctype="multipart/form-data">
	<button type="button" name="completeQuiz" id="complete-question" value="complete" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Complete</button>
	</form>


	<?php }else if($total_question_count>1 && $current_question_number>1 ){?>

	<form name="prev-question" class="prev-question form-button gsp_lms_tb-form" method="post" action="">
	<button type="button" id="prev-question" value="prev" style="border-radius: 25px;
	padding: 0 30px;
	font-size: 16px;
	line-height: 50px;
	border: none;">Prev</button>
	</form>
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

	<?php } else if ( $total_question_count>1 && $current_question_number == 1) {?>
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
	<?php } elseif ($total_question_count==1){?>
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
	?>
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
	

function timer() {


var days        = Math.floor(seconds/24/60/60);
var hoursLeft   = Math.floor((seconds) - (days*86400));
var hours       = Math.floor(hoursLeft/3600);
var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
var minutes     = Math.floor(minutesLeft/60);
var remainingSeconds = seconds % 60;
function pad(n) {
return (n < 10 ? "0" + n : n);
}

if(days==00){
document.getElementById('time').innerHTML = pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
} else {
document.getElementById('time').innerHTML = pad(days) + ":" + pad(hours) + ":" + pad(minutes) + ":" + pad(remainingSeconds);
}
var gettimespend =  $('.timeremain').attr('data-timespend');
var gettimespendnew = Number(gettimespend)+1;
$('.timeremain').attr('data-timespend',gettimespendnew);


if (seconds == 0) {
jQuery('#complete-question').trigger('click');
jQuery('#next-question').attr('value','complete');
jQuery('#next-question').trigger('click');

clearInterval(countdownTimer);
} else {
seconds--;
}
}
if(upgradeTimed.length>0){
var countdownTimer = setInterval('timer()', 1000);
}
</script>
	<?php
}
?>