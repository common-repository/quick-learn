jQuery('.heart_icon').click(function(e){
      e.preventDefault();
      var user_id = jQuery(this).data('user_id');

      if(user_id == 0){
            alert('Please Login!');
            return false;
      }

      if(jQuery(this).hasClass('heart_active')){
      jQuery(this).removeClass('heart_active');
      } else {
      jQuery(this).addClass('heart_active');
      }
      var course_id = jQuery(this).data('id');
      jQuery.ajax({
      url:admin_url.ajax_url ,
      type:'POST',
      dataType:'json',
      data:{'action':'addandremovewishlist','course_id':course_id},
      success:function(data){
      if(data==1){
      jQuery('.heart_icon[data-id='+course_id+']').addClass('heart_active');
      } else if(data==2) {
      jQuery('.heart_icon[data-id='+course_id+']').removeClass('heart_active');
      }
      }
      });
      
      });

jQuery('#list-view').click(function(){
      
      jQuery('.btn-group button').removeClass('active');
      
      jQuery(this).addClass('active');
      
      jQuery('.product.postproduct').attr('class','product postproduct product-list col-sm-12');
      
      jQuery('.columnbox').hide();
      
      });
      
      jQuery('#grid-view').click(function(){
      
      jQuery('.btn-group button').removeClass('active');
      
      jQuery(this).addClass('active');
      
      jQuery('.product.postproduct').attr('class','product postproduct product-grid col-sm-4 col-lg-4 col-xl-4');
      
      jQuery('.columnbox').show();
      
      });
      
      jQuery('#sortingbox').change(function(){
      
      jQuery('#sortingboxform').submit();
      
      });
      
      jQuery('#column_select').on('change',function(){
      
      var gg = jQuery(this).val();
      
      if(gg==''){
      
      jQuery('.product.postproduct').attr('class','product postproduct product-grid col-sm-4 col-lg-4 col-xl-4');
      
      } else if(gg==2){
      
      jQuery('.product.postproduct').attr('class','product postproduct product-grid col-sm-6 col-lg-6 col-xl-6');
      
      } else if(gg==3){
      
      jQuery('.product.postproduct').attr('class','product postproduct product-grid col-sm-4 col-lg-4 col-xl-4');
      
      } else if(gg==4){
      
      jQuery('.product.postproduct').attr('class','product postproduct product-grid col-sm-3 col-lg-3 col-xl-3');
      
      }
      
      });
      jQuery('.heart_icon').click(function(){
      
      });