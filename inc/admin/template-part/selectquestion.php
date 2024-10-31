<div id="gsp_lms_tb-modal-choose-items" data-assesment_id="<?php echo esc_attr($assesment_id);?>" class="modal-assesmentbox show">
<div class="gsp_lms_tb-choose-items">
<div class="header">
<ul class="tabs">
<li data-type="lms-assesment" class="tab active typedata"><a>Questions</a></li>
</ul>
<a class="close"><span title="Close" class="dashicons dashicons-no-alt"></span></a>
</div>
<div class="main">
<form class="search"><input type="text" placeholder="Type here to search item" title="search" class="modal-search-input"></form>
<div class="modal-search-box">
<?php
$alldata=$alldata;
include('searchquestion.php');
?>
</div>
</div>
<div class="footer">
<div class="cart">
<button type="button" disabled="disabled" class="button button-primary checkout2">
<span>Add</span>
</button>
</div>
</div>
</div>
</div>