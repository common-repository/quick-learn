<div id="gsp_lms_tb-modal-choose-items" data-course_id="<?php echo esc_attr($course_id);?>" class="show">
<div class="gsp_lms_tb-choose-items">
<div class="header">
<ul class="tabs">
<?php if($type=="assesment"){?>
<li data-type="lms-assesment" class="tab active typedata" data-section-id="2"><a>Assesment</a></li>
<?php }?>
<?php if($type=="lession"){?>
<li data-type="lms-lessons" class="tab active typedata" data-section-id="1"><a>Lessions</a></li>
<?php }?>
</ul>
<a class="close"><span title="Close" class="dashicons dashicons-no-alt"></span></a>
</div>
<div class="main">
<form class="search"><input type="text" placeholder="Type here to search item" title="search" class="modal-search-input"></form>
<div class="modal-search-box">
<?php
$alldata=$alldata;
include('searchitem.php');
?>
</div>
</div>
<div class="footer">
<div class="cart">
<button type="button" disabled="disabled" class="button button-primary checkout">
<span>Add</span>
</button>
</div>
</div>
</div>
</div>