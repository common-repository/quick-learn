<ul class="list-items">
<!---->
<?php if(isset($alldata) && count($alldata)>0){
foreach ($alldata as $key => $value) {
?>
<li class="section-item assementquestionlist <?php echo esc_attr($type);?>  addable"><input type="checkbox" name="selecteditems[]" data-id="<?php echo esc_attr($value['ID']);?>"> <span class="title"><?php echo esc_html($value['post_title']);?> <strong>(#<?php echo esc_html($value['ID']);?>)</strong></span></li>
<?php } } else {?>
<div>No item found.</div>
<?php }?>
</ul>