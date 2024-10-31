var $ = jQuery;

var Account_loadFile = function(event) {

    var output = document.getElementById('userimg');

    output.src = URL.createObjectURL(event.target.files[0]);

    output.onload = function() {

      URL.revokeObjectURL(output.src) // free memory

    }

  };

  function openCity(evt, cityName) {
	$('.s_y_box').each(function(){
	var thishtml = $(this).html();
	$(this).html(thishtml);
	});
	var i, tabcontent, tablinks;
	tabcontent = document.getElementsByClassName("tabcontent");
	for (i = 0; i < tabcontent.length; i++) {
	tabcontent[i].style.display = "none";
	}
	tablinks = document.getElementsByClassName("tablinks");
	for (i = 0; i < tablinks.length; i++) {
	tablinks[i].className = tablinks[i].className.replace(" active", "");
	}
	document.getElementById(cityName).style.display = "block";
	jQuery('.tablinks[data-id='+cityName+']').addClass('active');
  }
  Date.prototype.addHours= function(h){
	this.setHours(this.getHours()+h);
	return this;
  }

jQuery(document).ready(function(){
var ajaxurl = ADMIN_AJAX_URL.admin_url;
jQuery('body').delegate('.register_type','click',function(){
	jQuery('body').prepend('<div class="fadeMe"></div>');
	jQuery('.custommodel').addClass('open');
});
jQuery('body').delegate('.c_popup_closebtn','click',function(){
	jQuery('.fadeMe').remove();
	jQuery('.custommodel').removeClass('open');
});
jQuery('.login_submit').click(function(e){
		e.preventDefault();
		jQuery('#login_error').remove();
		var user_nicename = jQuery(this).parents('.signup-form').find('#uname').val();
		var user_pass = jQuery(this).parents('.signup-form').find('#password').val();
		
		jQuery.ajax({
			url:ajaxurl,
			type:'POST',
			dataType:'json',
			data:{'action':'login','user_nicename':user_nicename,'user_pass':user_pass,'login':'Login'},
			success:function(data){
				console.log(data);
				if(data==1){
					window.location.reload();
				} else {
					var datahtml = '';
					$.each(data.error,function(index,val){
						datahtml += val+'<br />';
					});
					jQuery('.signup-form').prepend('<div id="login_error">'+datahtml+'</div>');
					
				}
			}
		});

	});
	
	jQuery('.wishlist_tab .heart_icon,.wishlist_shortcodedata .heart_icon').click(function(e){
	e.preventDefault();
	var course_id = jQuery(this).data('id');
	jQuery(this).parents('.product.product-grid').remove();
	jQuery.ajax({
	url:ajaxurl,
	type:'POST',
	dataType:'json',
	data:{'action':'addandremovewishlist','course_id':course_id},
	success:function(data){
	}
	});
	});
	// jQuery('body').delegate('.download_cerificate','click',function(){
	// 	var user_item_id = jQuery(this).data('user_item_id');
	// 	var item_id = jQuery(this).data('item_id');
	// 	var current_url = window.location.href
	// });
	jQuery('.certificate_link').click(function(e){
		e.preventDefault();
		var ass_q = jQuery(this).data('assement_name');
		var ass_c = jQuery(this).data('course_name');
		var ass_date = jQuery(this).data('date');
		var user_item_id = jQuery(this).data('user_item_id');
		var item_id = jQuery(this).data('item_id');
		//jQuery('.certificate_conetntbox').html('<div class="spinnerbig"></div>');

		var certificate_conetntbox = jQuery('.certificate_conetntbox').data('htmlcontent');

		var newtext = certificate_conetntbox.replace('{{assesmentname}}', ass_q);

		var newtextnew = newtext.replace('{{cousename}}', ass_c);

		jQuery('.certificate_conetntbox').html('');
		jQuery('.certificate_conetntbox').html(newtextnew);

		var download_cerificate_link = jQuery('.download_cerificate').attr('href');
		var hh = download_cerificate_link+'&user_item_id='+user_item_id;
		jQuery('.download_cerificate').attr('href',hh);

		var ass_s = jQuery(this).data('score');
		jQuery('.assement_data_quiz').html(ass_q);
		jQuery('.c_c_n').html(ass_c);
		jQuery('.c_c_date').html(ass_date);
		jQuery('.c_c_score').html('<b>Score:</b> '+ass_s);
		jQuery('#certificate_myModal').addClass('show in');
		jQuery('.modal-backdrop').remove();
		jQuery('body').append('<div class="modal-backdrop fade in"></div>');
	});
	jQuery('body').delegate('button.close','click',function(){
		jQuery('#certificate_myModal').removeClass('show');
		jQuery('#certificate_myModal').removeClass('in');
		jQuery('.modal-backdrop').remove();
	});
	jQuery('body').delegate('.dropdownbox','click',function(e){
		e.preventDefault();
		if(jQuery(this).hasClass('activedropdown')){
		jQuery(this).removeClass('activedropdown');
		jQuery(this).parent().find('ul').hide(2000);
		} else {
		jQuery(this).addClass('activedropdown');
		jQuery(this).parent().find('ul').show(2000);
		}
	});
	jQuery('body').delegate('.sidebartab','click',function(e){
		e.preventDefault();
		var tab = jQuery(this).data('tab');
		jQuery('.listbox').removeClass('active');
		jQuery(this).parent().addClass('active');
		jQuery('.sectionbox').hide();
		jQuery('.sectionbox.'+tab).show();
	});
	jQuery('body').delegate('#general_inforupdtae','click',function(){
		var name = jQuery('#Name').val();
		var newname = jQuery('#Name').val();
		var contact_phone = jQuery('input[name=contact_phone]').val();
		var instructor_experience = jQuery('input[name=instructor_experience]').val();
		var instructor_twitter = jQuery('input[name=instructor_twitter]').val();
		var instructor_facebook = jQuery('input[name=instructor_facebook]').val();
		var instructor_instagram = jQuery('input[name=instructor_instagram]').val();
		var instructor_whatsapp = jQuery('input[name=instructor_whatsapp]').val();
		var instructor_bio = jQuery('textarea[name=instructor_bio]').val();
		jQuery('.general_setting_formmsg').remove();
		jQuery('.gi_error').remove();
		name = name.replace(/\s+/g, '');;
		if(name == ''){
		jQuery('#Name').after('<span class="gi_error error" style="color: red;">This Field required!</span>');
		} else {
		jQuery(this).html('updating..');
		jQuery.ajax({
		url:ajaxurl,
		dataType:'json',
		method:'post',
		data:{'action':'generalinformationupdate','name':newname,'contact_phone':contact_phone,'instructor_experience':instructor_experience,'instructor_twitter':instructor_twitter,'instructor_facebook':instructor_facebook,'instructor_instagram':instructor_instagram,'instructor_whatsapp':instructor_whatsapp,'instructor_bio':instructor_bio},
		success:function(data){
		jQuery('.general_setting_form').before('<div class="alert alert-success general_setting_formmsg">General Setting Successfully Updated.</div>');
		jQuery('#general_inforupdtae').html('submit');
		}
		});
		}
	});

	jQuery('body').delegate('#change_password_update','click',function(){
		var error = 0
		var current_password = jQuery('#current_password').val();
		var new_password = jQuery('#new_password').val();
		var confirm_password = jQuery('#confirm_password').val();
		jQuery('.change_password_formmsg').remove();
		jQuery('.error').remove();
		current_password = current_password.replace(/\s+/g, '');
		new_password = new_password.replace(/\s+/g, '');
		if(current_password == ''){
			error = 1;
			jQuery('#current_password').after('<span class="cp_error error" style="color: red;">This Field required!</span>');
		}
		 if(new_password == ''){
		 	error = 1;
			jQuery('#new_password').after('<span class="cp_error error" style="color: red;">This Field required!</span>');
		}
		if(confirm_password !=new_password ) {
			error = 1;
			jQuery('#confirm_password').after('<span class="cp_error error" style="color: red;">Password not matched!</span>');
		} 
		if( error==0) {
			jQuery(this).html('updating..');
			jQuery.ajax({
				url:ajaxurl,
				dataType:'json',
				method:'post',
				data:{'action':'changepassword','current_password':current_password,'new_password':new_password},
				success:function(data){
					if(data==1){
					jQuery('.change_password_update').before('<div class="alert alert-success change_password_formmsg">Password Successfully Updated.</div>');
					jQuery('#new_password,#current_password,confirm_password').val('');
					} else {
						jQuery('.change_password_update').before('<div class="alert alert-danger change_password_formmsg">Current Password not matched!</div>');
						jQuery('#current_password').after('<span class="cp_error error" style="color: red;">Current Password not matched!</span>');
					}
					jQuery('#change_password_update').html('submit');
				}
			});
		}
	});


    $('#profile_image_uploadform').on('submit',(function(e) {

    	$('#profile_image_upload').html('Updating..');

    	$('.profile_image_uploadformmsg').remove();

        e.preventDefault();

        var formData = new FormData(this);

        formData.append("action", "profileimageupload");

        $.ajax({

            type:'POST',

            url: ajaxurl,

            data:formData,

            cache:false,

            contentType: false,

            processData: false,

            success:function(data){

                console.log("success");

                console.log(data);

                if(data==0){

                	$('#profile_image_uploadform').before('<div class="alert alert-danger profile_image_uploadformmsg">Profile Image not Updated!</div>');

                } else {

                	$('#profile_image_uploadform').before('<div class="alert alert-success profile_image_uploadformmsg">Profile Image Successfully Updated!</div>');

                }

                $('#profile_image_upload').html('Submit');	

            },

            error: function(data){

                console.log("error");

                console.log(data);

            }

        });

    }));

   $("#profile_image_upload").on("click", function() {

        $("#profile_image_uploadform").submit();

    });
   jQuery('.addtocartbtn').click(function(){

			jQuery(this).hide();

			jQuery(this).parent().append('<button type="button" id="addtocartbtnbox-button" class="btn btn-primary buynowbtn">Buy Now</button>');

			jQuery(this).remove();

			jQuery('.payment_optionbox').show(1000);

		});

		jQuery('body').delegate('.buynowbtn','click',function(){

			var payment_method_type = jQuery('.payment_method_type:checked').val();

			console.log(payment_method_type);

			if(payment_method_type == ''){

				alert('Please select payment option');

			}

			if(payment_method_type == 'paypal'){



				jQuery('#paypalbtn').trigger('click');

			} else {

				jQuery('.stripepaybtn').trigger('click');

			}

		});

		jQuery('.latest_course_single_lms .heart_icon,.course_single_lmsbox .heart_icon').click(function(e){
		e.preventDefault();
		if(jQuery(this).hasClass('heart_active')){
			jQuery(this).removeClass('heart_active');
		} else {
			jQuery(this).addClass('heart_active');
		}
		var course_id = jQuery(this).data('id');
		jQuery.ajax({
			url:ajaxurl,
			type:'POST',
			dataType:'json',
			data:{'action':'addandremovewishlist','course_id':course_id},
			success:function(data){
				console.log(data);
				if(data==1){
				jQuery('.latest_course_single_lms .heart_icon[data-id='+course_id+']').addClass('heart_active');
				} else if(data==2) {
				jQuery('.latest_course_single_lms .heart_icon[data-id='+course_id+']').removeClass('heart_active');
				}
			}
		});

	});

	$('body').delegate('.nxtbtn','click',function(){
		var thisid = $(this).parents('.tabcontent').next().attr('id');
		if(typeof jQuery('.tablinks[data-id='+thisid+']') =='undefined' || jQuery('.tablinks[data-id='+thisid+']').length<=0 ){
		$('.tb_tab.tb_tab_assesments').removeClass('disabled');
		$('.tb_tab.tb_tab_assesments').trigger('click');
		} else {
		jQuery('.tablinks[data-id='+thisid+']').trigger('click');
		}
		});

		$('body').delegate('.prevbtn','click',function(){

		var thisid = $(this).parents('.tabcontent').prev().attr('id');
		jQuery('.tablinks[data-id='+thisid+']').trigger('click');
		});

		$('body').delegate('.accordion1.activeaccordion','click',function(){
			if($(this).hasClass('active')){
			$(this).removeClass('active');
			$(this).parent().find('.panel1.main_panel').css({'display':'none'});
			} else {
			$(this).addClass('active');
			$(this).parent().find('.panel1.main_panel').css({'display':'block'});
			}
		});

		$('body').delegate('.btn-complete','click',function(){

		var dataid = $(this).data('id');

		var course_id = $(this).data('course_id');

		$(this).html('wait..');

		$.ajax({

		url:ajaxurl,

		dataType:'json',

		type:'POST',

		data:{'action':'insert_lession_data','videoid':dataid,'course_id':course_id},

		success:function(data){
		$('#tab_'+dataid+'.tabcontent .completedbtn').after('<div class="navigationbox"><div class="prevbtn">Prev</div><div class="nxtbtn" data-id="">Next</div></div>');

		$('.s_y_box').each(function(){

		var thishtml = $(this).html();

		$(this).html(thishtml);

		});

		$('.tablinks[data-id=tab_'+dataid+']').append('<i class="fa fa-check lession_completed"></i>')

		$('.btn-complete[data-id='+dataid+']').html('Completed');

		$('.btn-complete[data-id='+dataid+']').addClass('disabled');

		$('.btn-complete[data-id='+dataid+']').removeClass('btn-success');

		$('.btn-complete[data-id='+dataid+']').removeClass('btn-complete btn-success');

		var id = $('.tablinks[data-id=tab_'+dataid+']').next().attr('data-id');
		if(typeof id !='undefined'){

		$('.tablinks[data-id=tab_'+dataid+']').next().removeClass('disabled');

		$('.tablinks').removeClass('active');

		$('.tablinks[data-id=tab_'+dataid+']').next().addClass('active');



		$('#tab_'+dataid).hide();

		$('.tablinks[data-id='+id+']').addClass('active');

		$('#'+id).show();

		} else {

		$('.tb_tab.tb_tab_assesments').removeClass('disabled');

		$('.tb_tab.tb_tab_assesments').trigger('click');

		}

		}

		});

		});




		$('li.tb_tab').click(function(){
			$('.tb_tab').removeClass('active_tab');
			$(this).addClass('active_tab');
			var tab = $(this).data('tab');
			$('.tab_contents').removeClass('active_tab_content');
			$('.'+tab).addClass('active_tab_content');
		});

		$('body').delegate('#next-question,#complete-question,#skip-question,#prev-question','click',function(){
		function getspendTime(seconds) {
			var days        = Math.floor(seconds/24/60/60);
			var hoursLeft   = Math.floor((seconds) - (days*86400));
			var hours       = Math.floor(hoursLeft/3600);
			var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
			var minutes     = Math.floor(minutesLeft/60);
			var remainingSeconds = seconds % 60;
			function padnew(n) {
			return (n < 10 ? "0" + n : n);
			}
			if(days==00){
			return padnew(hours) + ":" + padnew(minutes) + ":" + padnew(remainingSeconds);
			} else {
			return padnew(days) + ":" + padnew(hours) + ":" + padnew(minutes) + ":" + padnew(remainingSeconds);
			}
		}
		var self = $(this).attr('value');
		var item_id = $(this).parents('.mainquestionbox').find('.an_checkbox_mainbox').data('item-id');
		var value = $('input[name=answer]:checked').val();
		var main_item_id = $(this).parents('.mainquestionbox').find('.an_checkbox_mainbox').data('main-item-id');
		var timespend = $('.timeremain').attr('data-timespend');
		var hhh = Number(timespend);
		var getspendTime = getspendTime(hhh);
		if(self == 'prev'){
		var progress_number_count = Number($('.progress_number_count').html());
		$('.progress_number_count').html(progress_number_count-1);
		} else if(self == 'next' || self == 'skip'){
		var progress_number_count = Number($('.progress_number_count').html());
		$('.progress_number_count').html(progress_number_count+1);
		} else if(self == 'complete'){
		clearInterval(countdownTimer);
		}
		$('.mainquestionbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
		$.ajax({
		url:ajaxurl,
		data:{'action':'updatequizdata','type':self,'value':value,'item_id':item_id,'main_item_id':main_item_id,'timespent':getspendTime},
		dataType:'html',
		method:'POST',
		success:function(data){
		$('.mainquestionbox').html(data);
		if(self == 'complete'){
		$('.title_heading.quiz_id_click[data-item_id='+main_item_id+'] .lession_completed').remove();
		$('.title_heading.quiz_id_click[data-item_id='+main_item_id+']').append('<i class="fa fa-check lession_completed"></i>');
		$('.title_heading.quiz_id_click[data-item_id='+main_item_id+']').next().addClass('active1');
		}
		}
		});
		});

		$('body').delegate('.quiz_start_btn','click',function(e){
		e.preventDefault();
		var ref_type = $(this).data('ref_type');
		var ref_id = $(this).data('ref_id');
		var item_id = $(this).data('item_id');
		var status = $(this).data('status');
		stratquiz(ref_type,ref_id,item_id,status);
		});

		function stratquiz(ref_type,ref_id,item_id,status){
		$.ajax({
		url:ajaxurl,
		type:'post',
		dataType:'html',
		data:{'action':'startquiz','ref_type':ref_type,'ref_id':ref_id,'item_id':item_id,'status':status},
		beforeSend:function(){
		$('.quiestion_rightbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
		},
		success:function(data){
		$('.quiestion_rightbox').html(data);
		}
		});
		}

		function retake_stratquiz(ref_type,ref_id,item_id,status){
		$('.title_heading.quiz_id_click[data-item_id='+item_id+'] .lession_completed').remove();
		$.ajax({
		url:ajaxurl,
		type:'post',
		dataType:'html',
		data:{'action':'retakestartquiz','ref_type':ref_type,'ref_id':ref_id,'item_id':item_id,'status':status},
		beforeSend:function(){
		$('.quiestion_rightbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
		},
		success:function(data){
		$('.quiestion_rightbox').html(data);
		}
		});
		}




		$('body').delegate('.quiz_id_click','click',function(){
		var item_id = $(this).data('item_id');
		var course_id = $(this).data('course_id')
		if($(this).hasClass('active')){
		} else {
		$('.quiz_id_click').removeClass('active');
		$(this).addClass('active');
		$.ajax({
		url:ajaxurl,
		type:'post',
		dataType:'html',
		data:{'action':'get_quiz_data','item_id':item_id,'course_id':course_id},
		beforeSend:function(){
		$('.quiestion_rightbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
		},
		success:function(data){
		$('.quiestion_rightbox').html(data);
		}
		});
		}
		});
		$('body').delegate('.btn_retake','click',function(){
			var assesment_id = jQuery(this).data('id');
			var course_id = jQuery(this).data('course_id');
			jQuery.ajax({
				url:ajaxurl,
				dataType:'json',
				data:{'action':'assetment_retake','assesment_id':assesment_id,'course_id':course_id},
				type:'POST',
				beforeSend:function(){
					$('.quiestion_rightbox').html('<div class="loading_main_box"><div class="loadingbox"></div>Please wait..</div>');
				},
				success:function(){
					var ref_type = 'lms-assesments';
					var ref_id = course_id;
					var item_id = assesment_id;
					var status = 'started';
					retake_stratquiz(ref_type,ref_id,item_id,status);
				}
			});
		});
		$('body').delegate('.navigationbox_quiz .nxt_quiz','click',function(){
		var id = $(this).data('id');
		$(this).parents('.assesments_tab').find('.quiestion_leftbox .quiz_id_click[data-item_id='+id+']').next().trigger('click');
		});
		$('body').delegate('.navigationbox_quiz .prev_quiz','click',function(){
		var id = $(this).data('id');
		if($(this).parents('.assesments_tab').find('.quiestion_leftbox .quiz_id_click[data-item_id='+id+']').prev().length>0){
			$(this).parents('.assesments_tab').find('.quiestion_leftbox .quiz_id_click[data-item_id='+id+']').prev().trigger('click');
		} else {
			$('.tb_tab_lessons').trigger('click');
			$('#lessonsec .tablinks:last-child').trigger('click');
		}
		});
		$('body').delegate('.fastaricon','click',function(){
			var fastariconid = $(this).data('id');
			$('.fastaricon').removeClass('active');
			$('.fastaricon').removeClass('fa-star').addClass('fa-star-o');
			$('.ratingbox input[name=rating]').val(fastariconid);
			if(fastariconid>0){
				for (var i = 1; i <=fastariconid; i++) {
					$('.fastaricon[data-id="'+i+'"]').removeClass('fa-star-o');
					$('.fastaricon[data-id="'+i+'"]').addClass('fa-star active');
				}
			}
		});

		function get_postreviews(post_id) {
			$.ajax({
				url:ajaxurl,
				dataType:'html',
				data:{ 'action':'getallreviewsbypostid','post_id':post_id},
				type:'POST',
				success:function(data){
					console.log(data);
					$('.allreviewss_lmsbox').html(data);
				}
			});
		}

		jQuery('body').delegate('.commentsendbtn','click',function(){
			$('.review_sendbox').remove();
			var rating = $('.ratingbox input[name=rating]').val();
			var comment = $('#rating_commentboxtextarea').val();
			var post_id = $('.rating_commentboxtextarea').data('id');
			var self = $(this);
			jQuery.ajax({
				url:ajaxurl,
				dataType:'json',
				data:{'action':'sendratingandreview','rating':rating,'comment':comment,'post_id':post_id},
				type:'POST',
				beforeSend:function(){
					self.addClass('item_send_data_rating disabled');
				},
				success:function(data){
					self.removeClass('item_send_data_rating').removeClass('disabled');
					if(data == 1){
						get_postreviews(post_id);
						jQuery('.rr_submitbtnbox').append('<div class="custom_msg_success review_sendbox">Successfully Review Submit!</div>');
						setTimeout(function(){
							$('.review_sendbox').remove();
						},2000);
					}
				}
			});
		});
		jQuery('body').delegate('.reviewpopupbtn','click',function(){
			jQuery('.reviewratingpopupbox,.rr_modal_backdrop').addClass('in');
		});
		jQuery('body').delegate('.rr_close','click',function(){
			jQuery('.reviewratingpopupbox,.rr_modal_backdrop').removeClass('in');
		});







	});