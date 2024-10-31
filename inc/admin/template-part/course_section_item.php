<li data-item-id="<?php if(isset($lastid)){echo esc_attr($lastid); }?>" data-item-order="<?php if(isset($item_orderid)){echo esc_attr($item_orderid); }?>" class="section-item <?php if(isset($post_type)){echo esc_attr($post_type); }?>">
	<div class="drag gsp_lms_tb-sortable-handle">
		<svg viewBox="0 0 32 32" class="svg-icon">
			<path d="M 14 5.5 a 3 3 0 1 1 -3 -3 A 3 3 0 0 1 14 5.5 Z m 7 3 a 3 3 0 1 0 -3 -3 A 3 3 0 0 0 21 8.5 Z m -10 4 a 3 3 0 1 0 3 3 A 3 3 0 0 0 11 12.5 Z m 10 0 a 3 3 0 1 0 3 3 A 3 3 0 0 0 21 12.5 Z m -10 10 a 3 3 0 1 0 3 3 A 3 3 0 0 0 11 22.5 Z m 10 0 a 3 3 0 1 0 3 3 A 3 3 0 0 0 21 22.5 Z"></path>
		</svg>
	</div>
	<div class="icon"></div>
	<div class="title">
		<input type="text" value="<?php if(isset($title)){echo esc_attr($title); }?>">
	</div>
	<div class="item-actions">
		<div class="actions">
			
			<div data-content-tip="Edit item" class="action edit-item gsp_lms_tb-title-attr-tip ready">
				<a href="<?php echo esc_url($href);?>" target="_blank" class="gsp_lms_tb-btn-icon dashicons dashicons-edit"></a>
			</div>
			<div class="action delete-item">
				<a class="gsp_lms_tb-btn-icon dashicons dashicons-trash"></a>
				<ul class="ui-sortable" style="">
					<li><a>Remove from course</a></li>
					<li><a class="delete-permanently">Move to trash</a></li>
				</ul>
			</div>
		</div>
	</div>
</li>