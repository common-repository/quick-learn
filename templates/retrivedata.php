<?php
if(!function_exists('tbit_data_retrivedata')){
function tbit_data_retrivedata($meta_key,$wpdb){
$prepare_sql = $wpdb->prepare("SELECT meta_value FROM ".$wpdb->prefix."gsp_lms_setting_meta WHERE meta_key=%s",$meta_key);
$result = $wpdb->get_results($prepare_sql,ARRAY_A);
if(count($result)>0){
	return $result[0]['meta_value'];
} else {
	return '';
} 
}
}

function currency_exchange_text($currency){
	$text_currency = '$ ';
	if($currency == 'USD'){
		$text_currency = '$ ';
	} else if($currency == 'EUR'){
		$text_currency = '€ ';
	} else if($currency == 'GBP'){
		$text_currency = '£ ';
	}
	return $text_currency;
}


?>