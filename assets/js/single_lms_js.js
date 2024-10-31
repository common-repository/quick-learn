$(document).ready(function(){
	var ajaxurl = ADMIN_AJAX_URL_Single_LMS.admin_url;
	var item_id =ADMIN_AJAX_URL_Single_LMS.item_id;
	$.ajax({
	url:ajaxurl,
	type:'post',
	dataType:'html',
	data:{'action':'get_quiz_data','item_id':item_id},
	beforeSend:function(){
	$('.quiestion_rightbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
	},
	success:function(data){
	$('.quiestion_rightbox').html(data);
	}
	});
});