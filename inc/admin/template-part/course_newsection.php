<div data-section-order="0" data-section-id="<?php echo esc_attr($lastid);?>" class="section custom_section">
	<div class="section-head"><span class="movable lp-sortable-handle ui-sortable-handle"></span>
		<input type="text" title="title" placeholder="Enter the name section" class="title-input" value="<?php echo esc_attr($section_name);?>">
		<div class="section-item-counts"><span>0 Item</span></div>
		<div class="actions"><span class="collapse open"></span></div>
	</div>
	<div class="section-collapse" style="display: block;">
		<div class="section-content">
			<div class="section-list-items no-item">
				<ul class="ui-sortable">
				<?php
				$prepare_sql = $wpdb->prepare('SELECT si.*,wp.* FROM '.$wpdb->prefix.'gsplms_section_items si LEFT JOIN '.$wpdb->prefix.'posts wp ON si.item_id = wp.ID WHERE si.section_id=%s and wp.post_status=%s',$lastid,"publish");
				$get_resultsss=$wpdb->get_results($prepare_sql,ARRAY_A);

				
				if(count($get_resultsss)>0){
					foreach ($get_resultsss as $key => $value) {
						if($value['item_type']=='lms-lessons'){
							$post_type="gsp_lms_tb_lesson";
						} else {
							$post_type=$value['item_type'];
						}
						$lastid=$value['section_item_id'];
						$item_orderid=$value['item_order'];
						$title=get_the_title($value['item_id']);
						$href=get_edit_post_link($lastid);
						include('course_section_item.php');
					}
				}

				?>
				</ul>
				<!-- <div class="new-section-item section-item">
					<div class="drag gsp_lms_tb-sortable-handle"></div>
					<div class="types">
						<label title="Lesson" class="type gsp_lms_tb_lesson current">
							<input type="radio" name="gsp_lms_tb-section-item-type" value="lms-lessons">
						</label>
						<label title="Test" class="type gsp_lms_tb_assesments">
							<input type="radio" name="gsp_lms_tb-section-item-type" value="lms-assesments">
						</label>
					</div>
					<div class="title">
						<input type="text" placeholder="Create a new lesson">
					</div>
				</div> -->

			</div>
		</div>
		<div class="section-actions">
			<?php
				$args = [
			  's' => 'The searched post',
			  'post_type'=>'lms-lessons',
			  'orderby'   => 'title',
			  "posts_per_page" => "999999"
			];

			// we get an array of posts objects
			$posts = get_posts($args);

			// start our string
			$str = '<select>';
			// then we create an option for each post
			foreach($posts as $key=>$post){
			  $str .= '<option>'.esc_html($post->post_title).'</option>';
			}
			$str .= '</select>';
			echo esc_html($str);
			?>
			<button type="button" class="button button-secondary" onclick="postlist()">Select items</button>
			<div title="Delete section" class="remove"><span class="icon"><span class="dashicons dashicons-trash"></span></span>
				<div class="confirm_deletesection" data-section-id="<?php echo esc_attr($lastid);?>">Are you sure?</div>
			</div>
		</div>
	</div>

</div>
<script>
	   function postlist()
	   {
	   	     echo html_entity_decode(esc_html($str));
	   }
</script>



