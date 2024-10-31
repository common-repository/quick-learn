<?php
global $wpdb;
if(!function_exists('tbit_data_retrivedata')){
function tbit_data_retrivedata($meta_key){

  global $wpdb;
  $prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",$meta_key);
  $result = $wpdb->get_results($prepare_sql,ARRAY_A);

  

  if(count($result)>0){

  return $result[0]['meta_value'];

  } else {

  return '';

  }

}
}
$userdata = wp_get_current_user();

$prepare_sql = $wpdb->prepare("SELECT gui.*,guim.* FROM ".$wpdb->prefix."gsp_user_items gui LEFT JOIN ".$wpdb->prefix."gsp_user_itemmeta guim ON gui.user_item_id = guim.gsp_user_item_id WHERE gui.user_item_id = %s AND guim.meta_key = %s  GROUP BY gui.user_item_id",$user_item_id,'results');

$get_results=$wpdb->get_results($prepare_sql,ARRAY_A);
if(count($get_results)>0){
  $result = $get_results[0];

  $course_name = get_the_title($result['ref_id']);
  $assesment_name = get_the_title($result['item_id']);

  $meta_value = unserialize($result['meta_value']);

  $end_date = $result['end_time'];

  $date=date_create($end_date);

  $date_formate = date_format($date,"M d, Y");

}


$gsp_certificate_logo = tbit_data_retrivedata('gsp_certificate_logo');

?>

<style type="text/css">
<!--
    div.modal-content{background-color:#618597;border:1px solid #999;width: 100%;padding: 5mm; }
    .m_inner_body{background-color:#fff;width: 100%;padding: 5mm;}
    h2{margin: 0px auto;text-align: center;align-self: center;font-weight: normal;}
    .selfcenter{align-self: center;text-align: center;width: 180px;margin: 0px;display: -webkit-inline-box;}
    .nomargin{margin:0!important;}
    .clear{clear: both;}
    .user_namebox{
      border-bottom: 1px solid #777;
      align-self: center;
      margin: 0 auto !important;
      text-align: center;
      font-size: 20px;
      font-weight: bold;
    }
    hr{
      margin: 0 !important;
      margin-top:-20px;
      border: 0px !important;
      border-top: 0.2mm solid #777; !important;
      width: 30px;
      text-align: left;
      margin-left: -43mm;
    }
    .ttcenter{
      text-align: center;
    }
    .margintop10{
      margin-top: 10px;
    }
    .bottombox{
      margin-top: 50px;
    }
    .l_resultbox{
      width: 50%;
    }
    .r_resultbox{
      width: 50%;
      
    }
    .imgbox{
      text-align: center;
    }
    .centertext{
      line-height: 26px;
    }
-->
</style>
<page backtop="14mm" backbottom="14mm" backleft="10mm" backright="10mm" style="font-size: 12pt">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="m_inner_body">
      <?php
      if($gsp_certificate_logo !=''){
      ?>
      <div class="imgbox">
        <img src="<?php echo esc_url($gsp_certificate_logo);?>"class="selfcenter">
      </div>
      <?php } ?>
       <h2 class="nomargin"><?php echo esc_html(tbit_data_retrivedata('gsp_certificate_website_name'));  ?></h2>
       <h2 class="selfcenter1 user_namebox">
        <?php echo esc_html($userdata->first_name.' '.$userdata->last_name); ?>
       </h2>
       <hr />
       <span class="ttcenter centertext">
        <br />
        <?php
        $get_cerificate_conetnt = tbit_data_retrivedata('gsp_certificate_conetnt');
        $c_content =  str_replace("{{assesmentname}}",$assesment_name,$get_cerificate_conetnt);
        $c_content = str_replace("{{cousename}}",$course_name,$c_content);
        echo htmlspecialchars_decode(esc_html($c_content));
        ?>
      </span>
      <br />
      <br />
      <br />
      <br />
        <table class="page_footer" style="width:100%;">
            <tr>
                <td style="width: 50%; text-align: left;">
                  <span><?php echo esc_html(tbit_data_retrivedata('gsp_certificate_website_name'));  ?></span>
                  <br/>
                  <span class="c_c_score"><b>Score:</b> <?php echo esc_html(round($meta_value['result'],2));?>% </span>
                </td>
                <td style="width: 50%; text-align: right">
                  <span class="pm-credits-text block sans">Date</span>
                  <br />
                  <span class="c_c_date"><?php echo esc_attr($date_formate); ?></span>
                </td>
            </tr>
        </table>
      </div>
    </div>
  </div>
    
</page>