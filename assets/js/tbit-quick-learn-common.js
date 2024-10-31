(function($){
$(document).ready(function(){

$('body').delegate('.sales_reportbox ul li','click',function(){
	var self = $(this);
	var id = self.data('id');
	if(!self.hasClass('active')){
		$('.sales_reportbox ul li,.sales_reportitembox').removeClass('active');
		self.addClass('active');
		$('#'+id+'.sales_reportitembox').addClass('active');
	}
});

$('#upload-btn').click(function(e) {
	e.preventDefault();
	var image = wp.media({ 
	title: 'Upload Image',
	multiple: false
	}).open()
	.on('select', function(e){
	var uploaded_image = image.state().get('selection').first();
	var image_url = uploaded_image.toJSON().url;
	$('.fimg').remove();
	$('.upload_footer_image').before('<img src="'+image_url+'" class="fimg" />');
	$('#footer_image').val(image_url);
	});
});
$('body').delegate('.section-head .actions .collapse','click',function(){
	if($(this).hasClass('open')){
		$(this).removeClass('open').addClass('close');
		$(this).parents('.section').find('.section-collapse').hide('300');
	} else {
		$(this).removeClass('close').addClass('open');
		$(this).parents('.section').find('.section-collapse').show('300');
	}
});
$('body').delegate('select[name=sales_payment_status]','click',function(e){
	$('.s_inbox').remove();
	var self = $(this);
	var order_id = self.data('order_id');
	var status = self.val();
	$.ajax({
		url:ajaxurl,
		data:{'action':'order_status_change','order_id':order_id,'status':status},
		dataType:'json',
		type:'POST',
		beforeSend:function(){
			self.after('<div class="s_inbox sloader"></div>');
		},
		success:function(data){
			if(data==1){
				$('.s_inbox').remove();
				self.after('<div class="s_inbox sinuptext"><i class="fa fa-check-circle"></i> Updated Successfully. </div>');
				setTimeout(function(){
					$('.s_inbox').remove();
				},1000);
			} else {
				$('.s_inbox').remove();
			}
		}
	});

});
$('body').delegate('.user_approve_link','click',function(e){
	e.preventDefault();
	var self = jQuery(this);
	var user_id = $(this).data('user_id');
	$.ajax({
		url:ajaxurl,
		data:{'action':'approve_user','user_id':user_id},
		dataType:'json',
		type:'POST',
		beforeSend:function(){
			//$('.user_approve_link,.user_disapprove_link').attr('disabled','disabled');
		},
		success:function(data){
			
			if(data == 1){
				self.parents('.row-actions').find('.user_approve_link').html('Approved');
				self.parents('.row-actions').find('.user_disapprove_link').html('Disapprove');
			} else {
				//$('.user_approve_link,.user_disapprove_link').removeAttr('disabled');
			}
		}
	});
});
$('body').delegate('.user_disapprove_link','click',function(e){
	e.preventDefault();
	var self = jQuery(this);
	var user_id = $(this).data('user_id');
	$.ajax({
		url:ajaxurl,
		data:{'action':'disapprove_user','user_id':user_id},
		dataType:'json',
		type:'POST',
		beforeSend:function(){
			//$('.user_approve_link,.user_disapprove_link').attr('disabled','disabled');
		},
		success:function(data){
			
			if(data == 1){
				self.parents('.row-actions').find('.user_disapprove_link').html('Disapproved');
				self.parents('.row-actions').find('.user_approve_link').html('Approve');
			}
		}
	});
});
$('body').delegate('.new-section-item.section-item .title input','keypress',function(e){
	if(e.which == 13){
		e.preventDefault();
		var lessionandtesttitle=$(this).val();
		var type=$(this).parents('.new-section-item.section-item').find('.types label.type.current input').val();
		var section_id=1;
		var course_id=$(this).parents('.section.custom_section').data('course-id');
		if(type=='lms-lessons'){
			var section_id=1;
		} else {
			var section_id=2;
		}

		if(lessionandtesttitle !=''){
		$.ajax({
		url:ajaxurl,
		data:{'action':'insertlesstinandtest','type':type,'lessionandtesttitle':lessionandtesttitle,'section_id':section_id,'course_id':course_id},
		dataType:'html',
		type:"POST",
		success:function(data){
			$('.new-section-item.section-item .title input').val('');
			$('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable').append(data.html);
			setTimeout(function(){
			console.log($('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable li:last-child').find('.action.edit-item a.gsp_lms_tb-btn-icon'));
			var url = $('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable li:last-child').find('.action.edit-item a.gsp_lms_tb-btn-icon').attr('href');
			console.log(url);
			var frefff = url+'&courseid='+course_id;
			window.open(frefff, '_blank').focus();
			},2000);
		}
		});
		}
	}
});

$('body').delegate('.createnew','click',function(e){
	var lessionandtesttitle=jQuery(this).parents('.new-section-item').find('.title input').val();
	if(lessionandtesttitle != ''){
		e.preventDefault();
		var type=$(this).parents('.new-section-item.section-item').find('.types label.type.current input').val();
		var section_id=1;
		var course_id=$(this).parents('.section.custom_section').data('course-id');
		if(type=='lms-lessons'){
			var section_id=1;
		} else {
			var section_id=2;
		}

		if(lessionandtesttitle !=''){
		$.ajax({
		url:ajaxurl,
		data:{'action':'insertlesstinandtest','type':type,'lessionandtesttitle':lessionandtesttitle,'section_id':section_id,'course_id':course_id},
		dataType:'html',
		type:"POST",
		success:function(data){
			$('.new-section-item.section-item .title input').val('');
			$('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable').append(data);
			setTimeout(function(){
			console.log($('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable li:last-child').find('.action.edit-item a.gsp_lms_tb-btn-icon'));
			var url = $('.section.custom_section[data-section-id='+section_id+'] .section-list-items>ul.ui-sortable li:last-child').find('.action.edit-item a.gsp_lms_tb-btn-icon').attr('href');
			console.log(url);
			var frefff = url+'&courseid='+course_id;
			window.open(frefff, '_blank').focus();
			},2000);

		}
		});
		}
	}
});

$('body').delegate('.section-item .action.delete-item ul li','click',function(e){
	var item_id=$(this).parents('li.section-item').data('item-id');
	var section_id=$(this).parents('div.section.custom_section').data('section-id');
	var type=$(this).parents('li.section-item');
	var course_id = $(this).parents('.section.custom_section').data('course-id');
	if(type.hasClass('gsp_lms_tb_lesson')){
		type='lms-lessons';
	} else {
		type='lms-assesments';
	}

	if($(this).find('a').hasClass('delete-permanently')){
		var deletetype='permanently';
	} else {
		var deletetype='fromcourse';
	}
 	
 	$(this).parents('.item-actions').addClass('disabled');

	$.ajax({
		url:ajaxurl,
		data:{'action':'deletesectionitem','deletetype':deletetype,'type':type,'item_id':item_id,'section_id':section_id,'course_id':course_id},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			$('li.section-item[data-item-id='+item_id+']').addClass('empty-item');
		},
		success:function(data){
			$('li.section-item[data-item-id='+item_id+']').remove();
		}
		});
});

$('body').delegate('.confirm_deletesection','click',function(e){
	var section_id=$(this).data('section-id');
	var section_item_id=$(this).data('item-id');
	
	$.ajax({
		url:ajaxurl,
		data:{'action':'deletesection','deletetype':deletetype,'type':type,'section_item_id':section_item_id,'section_id':section_id},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			$('li.section-item[data-item-id='+section_item_id+']').addClass('empty-item');
		},
		success:function(data){
			$('li.section-item[data-item-id='+section_item_id+']').remove();
		}
		});
});

$('body').delegate('.selectitembtn','click',function(){
	var type=$(this).data('type');
	var self= $(this);
	var course_id=$(this).parents('.section.custom_section').data('course-id');
	$.ajax({
		url:ajaxurl,
		data:{'action':'getselectionbox','type':type,'course_id':course_id},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			self.addClass('loadingspin disabled');
			//self.html('');
		},
		success:function(data){
			self.removeClass('loadingspin');
			self.removeClass('disabled');
			$('#poststuff').prepend(data);
			//$('li.section-item[data-item-id='+section_item_id+']').remove();
		}
		});
});
$('body').delegate('.gsp_lms_tb-choose-items .header a.close','click',function(){
	$('#gsp_lms_tb-modal-choose-items').remove();
});

$('body').delegate('.lessionandtestselected input','click',function(){
	var enable=0;
	$('.lessionandtestselected input').each(function(){
		if($(this).prop("checked") == true){
			enable=1;
		}
	});
	if(enable==1){
	$('.footer .cart button.checkout').removeAttr('disabled');
	} else {
		$('.footer .cart button.checkout').attr('disabled','disabled');	
	}
});
$('body').delegate('.assementquestionlist input','click',function(){
	var enable=0;
	$('.assementquestionlist input').each(function(){
		if($(this).prop("checked") == true){
			enable=1;
		}
	});
	if(enable==1){
	$('.footer .cart button.checkout2').removeAttr('disabled');
	} else {
		$('.footer .cart button.checkout2').attr('disabled','disabled');	
	}
});


$('body').delegate('.footer .cart button.checkout2','click',function(){
	var self = $(this);
	var targetids=[];
	$('.assementquestionlist input:checked').each(function(){
		targetids.push($(this).data('id'));
	});
	if(targetids.length>0){
		
		var assesment_id=$(this).parents('#gsp_lms_tb-modal-choose-items').data('assesment_id');
		$.ajax({
		url:ajaxurl,
		data:{'action':'insertdatainassementquestion','assesment_id':assesment_id,'targetids':targetids},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			self.addClass('loadingspin disabled');
		},
		success:function(data){
			$('.a_qestionbox').html(data);
			self.removeClass('loadingspin');
			self.removeClass('disabled');
			$('#gsp_lms_tb-modal-choose-items').remove();
		}
		});
	}
});


$('body').delegate('.footer .cart button.checkout','click',function(){
	var targetids=[];
	$('.lessionandtestselected input:checked').each(function(){
		targetids.push($(this).data('id'));
	});
	if(targetids.length>0){
		var type=$(this).parents('#gsp_lms_tb-modal-choose-items').find('.typedata').data('type');
		var course_id=$(this).parents('#gsp_lms_tb-modal-choose-items').data('course_id');
		var section_id = $(this).parents('#gsp_lms_tb-modal-choose-items').find('.typedata').data('section-id');
		var self = $(this);
		$.ajax({
		url:ajaxurl,
		data:{'action':'insertdatainlessionassesments','type':type,'course_id':course_id,'section_id':section_id,'targetids':targetids},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			self.addClass('loadingspin disabled');
			//$('li.section-item[data-item-id='+section_item_id+']').addClass('empty-item');
		},
		success:function(data){
			$('.section.custom_section[data-section-id='+section_id+'] .section-list-items ul').append(data);
			self.removeClass('loadingspin');
			self.removeClass('disabled');
			$('#gsp_lms_tb-modal-choose-items').remove();

		}
		});
	}
});

$('body').delegate('.modal-search-input','keyup',function(){
	var search=$(this).val();
		var type=$(this).parents('#gsp_lms_tb-modal-choose-items').find('.typedata').data('type');
		var course_id=$(this).parents('#gsp_lms_tb-modal-choose-items').data('course_id');
		var section_id = $(this).parents('#gsp_lms_tb-modal-choose-items').find('.typedata').data('section-id');
		search=search.trim();
		$.ajax({
		url:ajaxurl,
		data:{'action':'searchquery','type':type,'course_id':course_id,'section_id':section_id,'search':search},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
		},
		success:function(data){
			$('.modal-search-box').html(data);
		}
		});
});

$('body').delegate('.modal-assesmentbox .modal-search-input','keyup',function(){
	var search=$(this).val();
		var assesment_id=$(this).parents('#gsp_lms_tb-modal-choose-items').data('assesment_id');
		search=search.trim();
		$.ajax({
		url:ajaxurl,
		data:{'action':'searchassesmentquery','assesment_id':assesment_id,'search':search},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
		},
		success:function(data){
			$('.modal-assesmentbox .modal-search-box').html(data);
		}
		});
});

var tableacb_tablebox=$('table.acb_tablebox');
if(tableacb_tablebox.hasClass('acb_tablebox')){
var question_id = $('#post_ID').attr('value');
$.ajax({
url:ajaxurl,
data:{'action':'insertqustionanswerstart','question_id':question_id},
dataType:'html',
type:"POST",
beforeSend:function(){
},
success:function(data){

}
});
}


$('body').delegate('#selectanswer_type','change',function(){
	var selectanswer_type = $(this).val();
	var question_id=$('#post_ID').attr('value');
	var getarray=[];
	var i=0;
	$('.acb_tablebox tbody tr').each(function(){
	if(i<=1){
		getarray.push($(this).data('answer-id'));
	}
	i++;
	});
	$.ajax({
	url:ajaxurl,
	data:{'action':'insertanswer_type','selectanswer_type':selectanswer_type,'question_id':question_id,'getarray':getarray},
	dataType:'html',
	type:"POST",
	beforeSend:function(){
	},
	success:function(data){
	$('.questionrowsbox').html(data);
	}
	});
});

function updatequestionanswer(){

	var selectanswer_type=$('.assesment_contentbox input[type=radio]:checked').parents('.assesment_contentbox').data('getanswer_type');
	var answer_id=$('.assesment_contentbox input[type=radio]:checked').parents('.answer-option').data('answer-id');
	var question_id=$('#post_ID').attr('value');
	var is_true='yes';
	$.ajax({
	url:ajaxurl,
	data:{'action':'updateanswerdata','is_true':is_true,'answer_id':answer_id,'question_id':question_id,'selectanswer_type':selectanswer_type},
	dataType:'html',
	type:"POST",
	beforeSend:function(){
	},
	success:function(data){
	}
	});

}

$('body').delegate('.addoptionbtn button','click',function(){
	var selectanswer_type = $(this).data('type');
	var question_id=$('#post_ID').attr('value');
	$.ajax({
	url:ajaxurl,
	data:{'action':'insertanswer_typenew','selectanswer_type':selectanswer_type,'question_id':question_id},
	dataType:'html',
	type:"POST",
	beforeSend:function(){
	},
	success:function(data){
		$('.questionrowsbox').html(data);
		updatequestionanswer();
	}
	});
});

$('body').delegate('.assesmentdata input','keypress',function(e){
	if(e.which == 13){
		e.preventDefault();
		var gettype=$(this).attr('type');
		if(gettype=='text'){
			var answer_id=$(this).parents('.answer-option').data('answer-id');
			var selftext=$(this).val();
			$.ajax({
			url:ajaxurl,
			data:{'action':'questiontextchange','text':selftext,'answer_id':answer_id},
			dataType:'html',
			type:"POST",
			beforeSend:function(){
			},
			success:function(data){
			//$('.questionrowsbox').html(data);
			}
			});
		}
	}
});
$('body').delegate('.assesmentdata input[type=text]','blur',function(e){
		e.preventDefault();
		var gettype=$(this).attr('type');
		if(gettype=='text'){
			var answer_id=$(this).parents('.answer-option').data('answer-id');
			var selftext=$(this).val();
			$.ajax({
			url:ajaxurl,
			data:{'action':'questiontextchange','text':selftext,'answer_id':answer_id},
			dataType:'html',
			type:"POST",
			beforeSend:function(){
			},
			success:function(data){
			//$('.questionrowsbox').html(data);
			}
			});
		}
});
$('body').delegate('.actions1.gsp_lms_tb-toolbar-buttons1 .gsp_lms_tb-btn-remove1','click',function(e){
		e.preventDefault();
		    var selectanswer_type=$(this).parents('.assesment_contentbox').data('getanswer_type');
			var answer_id=$(this).parents('.answer-option').data('answer-id');
			var question_id=$('#post_ID').attr('value');
			var self = $(this);
			var change_radio_checked = 0;
			if(self.parents('.answer-option').find('input[type=radio]').is(':checked')){
				change_radio_checked = 1;
			}
			
			$.ajax({
			url:ajaxurl,
			data:{'action':'deletequestionoption','question_id':question_id,'selectanswer_type':selectanswer_type,'answer_id':answer_id},
			dataType:'html',
			type:"POST",
			beforeSend:function(){
			},
			success:function(data){
			$('.questionrowsbox').html(data);
			if(change_radio_checked == 1){
				$('tr.answer-option:first-child input[type=radio]').prop("checked", true);
				updatequestionanswer();
			}
			}
			});
});

$('body').delegate('.acb_tablebox .answer-correct input','click',function(e){
		//e.preventDefault();
			var selectanswer_type=$(this).parents('.assesment_contentbox').data('getanswer_type');
			var answer_id=$(this).parents('.answer-option').data('answer-id');
			var question_id=$('#post_ID').attr('value')
			if($(this).prop("checked") == true){
                var is_true='yes';
            } else {
            	var is_true='';
            }
			$.ajax({
			url:ajaxurl,
			data:{'action':'updateanswerdata','is_true':is_true,'answer_id':answer_id,'question_id':question_id,'selectanswer_type':selectanswer_type},
			dataType:'html',
			type:"POST",
			beforeSend:function(){
			},
			success:function(data){
			//$('.questionrowsbox').html(data);
			}
			});
});

$('body').delegate('.addnewquestionbtn','click',function(){
	var assesment_id=$('#post_ID').attr('value');
	var self = $(this);
	$.ajax({
		url:ajaxurl,
		data:{'action':'getassetmentselectionbox','assesment_id':assesment_id},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			self.addClass('loadingspin disabled');
		},
		success:function(data){
			self.removeClass('loadingspin');
			self.removeClass('disabled');
			$('#poststuff').prepend(data);
			//$('li.section-item[data-item-id='+section_item_id+']').remove();
		}
		});
});

$('body').delegate('.question-actions.table-row .actions .gsp_lms_tb-toolbar-btn.gsp_lms_tb-btn-remove ul li','click',function(e){
	var question_id=$(this).parents('.question-item').data('item-id');
	var post_id = $('#post_ID').val();

	$(this).parents('.gsp_lms_tb-btn-remove').addClass('disabled');

	if($(this).find('a').hasClass('delete')){
		var deletetype='permanently';
	} else {
		var deletetype='fromassement';
	}
	$.ajax({
		url:ajaxurl,
		data:{'action':'deleteassementitem','deletetype':deletetype,'question_id':question_id,'post_id':post_id},
		dataType:'html',
		type:"POST",
		beforeSend:function(){
			$('div[data-item-id='+question_id+'].question-item').addClass('empty-item');
		},
		success:function(data){
			$('div[data-item-id='+question_id+'].question-item').remove();
		}
		});
});
$('body').delegate('.delete_ratingbtn','click',function(){
	var selfid = $(this).data('id');
	var self = $(this);
	$.ajax({
		url:ajaxurl,
		dataType:'json',
		type:'POST',
		data:{'action':'removerating','rating_id':selfid},
		beforeSend:function(){
			self.addClass('disabled');
			self.addClass('empty-item');
		},
		success:function(returndata){
			if(returndata == 1){
				$('#rating-'+selfid).remove();
			}
		}
	});
});

$('body').delegate('.rating_adbtn','click',function(){
	var selfid = $(this).data('id');
	var self = $(this);
	var self_status = $(this).data('status');
	if(!self.hasClass('active')){
	$.ajax({
		url:ajaxurl,
		dataType:'json',
		type:'POST',
		data:{'action':'approvedisapproverating','rating_id':selfid,'status':self_status},
		beforeSend:function(){
			self.addClass('empty-item-fa-icon');
			self.addClass('disabled');
		},
		success:function(returndata){
			self.removeClass('empty-item-fa-icon');
			self.removeClass('disabled');
			self.parent().find('.rating_adbtn').removeClass('active');
			if(returndata == 1){
				self.addClass('active');
			}
		}
	});
	}
});

$('.e_s_l_abox').click(function(){
	var self = $(this);
	var id = self.attr('id');
	$('.e_s_l_abox').removeClass('active');
	self.addClass('active');
	$('.email_contentbox').removeClass('active_email_content');
	$('.email_contentbox.'+id).addClass('active_email_content');
});


var theInput = document.getElementById("gsp_primary_color");
theInput.addEventListener("input", function(){
  var theColor = theInput.value;
  $('.gsp_primary_color').val(theColor);
}, false);

var theInput1 = document.getElementById("gsp_secondary_color");
theInput1.addEventListener("input", function(){
  var theColor1 = theInput1.value;
  $('.gsp_secondary_color').val(theColor1);
}, false);
var theInput2 = document.getElementById("gsp_button_text_color");
theInput2.addEventListener("input", function(){
  var theColor2 = theInput2.value;
  $('.gsp_button_text_color').val(theColor2);
}, false);

var theInput3 = document.getElementById("gsp_button_background_color");
theInput3.addEventListener("input", function(){
  var theColor3 = theInput3.value;
  $('.gsp_button_background_color').val(theColor3);
}, false);

var theInput4 = document.getElementById("gsp_button_hover_text_color");
theInput4.addEventListener("input", function(){
  var theColor4 = theInput4.value;
  $('.gsp_button_hover_text_color').val(theColor4);
}, false);

var theInput5 = document.getElementById("gsp_button_hover_background_color");
theInput5.addEventListener("input", function(){
  var theColor5 = theInput5.value;
  $('.gsp_button_hover_background_color').val(theColor5);
}, false);

var theInput6 = document.getElementById("gsp_favourite_icon_color");
theInput6.addEventListener("input", function(){
  var theColor6 = theInput6.value;
  $('.gsp_favourite_icon_color').val(theColor6);
}, false);

var theInput7 = document.getElementById("gsp_favourite_active_icon_color");
theInput7.addEventListener("input", function(){
  var theColor7 = theInput7.value;
  $('.gsp_favourite_active_icon_color').val(theColor7);
}, false);


});

})(jQuery);