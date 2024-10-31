jQuery('.slider_image_upload').click(function(e) {
            e.preventDefault();
            var buttonID = jQuery(this).data('group');
            var custom_uploader = wp.media({
                title: 'Custom Image',
                button: {
                    text: 'Upload Image'
                },
                multiple: true  // Set this to true to allow multiple files to be selected
            })
            .on('select', function() {
                //var attachment = custom_uploader.state().get('selection');
                //console.log(attachment);
                //jQuery('.slider_image').attr('src', attachment.url);
                //jQuery('.slider_image_url').val(attachment.url);

                var attachments = custom_uploader.state().get('selection').map( 

                function( attachment ) {

                    attachment.toJSON();
                    return attachment;

            });
                var i;
            var ggg = [];
           for (i = 0; i < attachments.length; ++i) {
            ggg.push(attachments[i].attributes.url);
            //$('.slider_image_mainbox').append();
            jQuery('.slider_image_mainboxnew').append('<div class="slider_image col-sm-3"><div class="slider_image_box111"> <i class="fa fa-close removeimg"></i> <img class="slider_image" src="'+attachments[i].attributes.url+'" style="max-width: 100%;"></div></div>');
           }

           var slider_image_url = jQuery('.slider_image_url').val();

           slider_image_url = slider_image_url.split(',');
        
            //var newarray = [];
            if(slider_image_url.length>0){
                for (var ii = 0;ii<slider_image_url.length; ii++) {
                    ggg.push(slider_image_url[ii]);
                    //jQuery('.slider_image').after('<img class="slider_image" src="'+slider_image_url[ii]+'" height="100" width="100">');
                }
            } else if(strlen(slider_image_url)>0) {
                ggg.push(slider_image_url);
            }
            //console.log(ggg.join());
           // jQuery('.slider_image_url').val(ggg.join());
            //console.log(ggg.join());
           /* var allimag = '';
            console.log();
            if(ggg.length>0){
                for (var j =0; j<ggg.length;j++) {

                    allimag += ggg[j]+',';
                    console.log(allimag);
                }
console.log(allimag);
            allimag = allimag.replace(/(.+),$/, '$1');
            
            }*/
            var gggs = ggg.join(',');
            var allimag = gggs.replace(/(.+),$/, '$1');
            jQuery('.slider_image_url').val(allimag);

            })
            .open();
        });
jQuery('body').delegate('.removeimg','click',function(){
    var img_url = jQuery(this).parent().find('img').attr('src');
    var slider_image_url = jQuery('.slider_image_url').val();
    if(slider_image_url.length>10){
        var slider_image_urlarray = slider_image_url.split(',');
        var j=1;
        var hhh = [];
        for (var i = 0; i<slider_image_urlarray.length;i++) {
            if(img_url==slider_image_urlarray[i]){
                if(j == 1){

                  j++ ; 
                } else {
                    hhh.push(slider_image_urlarray[i]);
                }
            } else {
                hhh.push(slider_image_urlarray[i]);
            }
            
        }
        jQuery('.slider_image_url').val(hhh.join(','));
    }
    jQuery(this).parents('.slider_image').remove();

});
function yesnoCheck() {
    if (document.getElementById('yesCheck').checked) {
        document.getElementById('ifYes').style.visibility = 'visible';
    }
    else document.getElementById('ifYes').style.visibility = 'hidden';

}

function sectionyesnoCheck() {


    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('sectiontitle').style.display = 'block';
        
    }
    else {
        document.getElementById('sectiontitle').style.display = 'none';
    }

   if (document.getElementById('yestitleCheck').checked){
        document.getElementById('sectiondesc').style.display = 'block';
        
    }
    else {
        document.getElementById('sectiondesc').style.display = 'none'; 
    }



    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('seletd_postype').style.display = 'block';
        
    }
    else {
        document.getElementById('seletd_postype').style.display = 'none';
    }


    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('selectdsection1_postnum').style.display = 'block';
        
    }
    else {
        document.getElementById('selectdsection1_postnum').style.display = 'none';
    }
    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('selectedsection1_numcol').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection1_numcol').style.display = 'none';
    }
    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('selectedsection1_norderby').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection1_norderby').style.display = 'none';
    }
    if (document.getElementById('yestitleCheck').checked){
        document.getElementById('selectedsection1_ordertype').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection1_ordertype').style.display = 'none';
    }
    
}
function section2yesnoCheck() {
    if (document.getElementById('yestitle2Check').checked){
        /*var a=document.getElementById('section2_title').value;
        alert(a);*/
        document.getElementById('section2_title').style.display = 'block';
        
    }
    else {
        document.getElementById('section2_title').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('section2_desc').style.display = 'block';
        
    }
    else {
        document.getElementById('section2_desc').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('seletdsection2_postype').style.display = 'block';
        
    }
    else {
        document.getElementById('seletdsection2_postype').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('selectdsection2_postnum').style.display = 'block';
        
    }
    else {
        document.getElementById('selectdsection2_postnum').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('selectedsection2_numcol').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection2_numcol').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('selectedsection2_norderby').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection2_norderby').style.display = 'none';
    }
    if (document.getElementById('yestitle2Check').checked){
       
        document.getElementById('selectedsection2_ordertype').style.display = 'block';
        
    }
    else {
        document.getElementById('selectedsection2_ordertype').style.display = 'none';
    }
 }
 function section3yesnoCheck() {
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_title').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_title').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_desc').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_desc').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_posttype').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_posttype').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_nofposts').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_nofposts').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_numcolumn').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_numcolumn').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_norder').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_norder').style.display = 'none';
    }
    if (document.getElementById('yestitle3Check').checked){
       
        document.getElementById('section3_norderby').style.display = 'block';
        
    }
    else {
        document.getElementById('section3_norderby').style.display = 'none';
    }
 }
 function section4yesnoCheck() {
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_title').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_title').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_desc').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_desc').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_posttype').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_posttype').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_nofposts').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_nofposts').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_numcolumn').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_numcolumn').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_norder').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_norder').style.display = 'none';
    }
    if (document.getElementById('yestitle4Check').checked){
       
        document.getElementById('section4_norderby').style.display = 'block';
        
    }
    else {
        document.getElementById('section4_norderby').style.display = 'none';
    }
 }
 function section5yesnoCheck() {
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_title').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_title').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_desc').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_desc').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_posttype').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_posttype').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_nofposts').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_nofposts').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_numcolumn').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_numcolumn').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_norder').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_norder').style.display = 'none';
    }
    if (document.getElementById('yestitle5Check').checked){
       
        document.getElementById('section5_norderby').style.display = 'block';
        
    }
    else {
        document.getElementById('section5_norderby').style.display = 'none';
    }
 }
    jQuery('.misha-upl_close').click(function(e){
        e.preventDefault();
        jQuery('.misha-upl').html('Logo Upload');
        jQuery('.logo_img').remove();
        jQuery('#gsp_certificate_logo').val('');
    });

    // on upload button click
    jQuery('body').on( 'click', '.misha-upl', function(e){

        e.preventDefault();

        var button = jQuery(this),
        custom_uploader = wp.media({
            title: 'Insert image',
            library : {
                // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                type : 'image'
            },
            button: {
                text: 'Use this image' // button label text
            },
            multiple: false
        }).on('select', function() { // it also has "open" and "close" events
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            jQuery('#gsp_certificate_logo').val(attachment.url);
            button.html('<div class="logo_img"><span class="misha-upl_close"><i class="fa fa-times"></i></span><img src="' + attachment.url + '"></div>').next().show().next().val(attachment.id);
        }).open();
    
    });

    // on remove button click
    jQuery('body').on('click', '.misha-rmv', function(e){

        e.preventDefault();

        var button = jQuery(this);
        button.next().val(''); // emptying the hidden field
        button.hide().prev().html('Upload image');
    });
  